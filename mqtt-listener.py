import paho.mqtt.client as mqtt
# import mysql.connector
from mysql.connector.pooling import MySQLConnectionPool
import os
import json
import threading
import requests
import re
import hmac
import hashlib
from datetime import date, datetime
from queue import Queue
from dotenv import load_dotenv

load_dotenv()
queue = Queue()
wa_q = Queue()
broadcast_q = Queue()
db_pool = MySQLConnectionPool(
    pool_name="absensi",
    pool_size=12,
    host=os.getenv("DB_HOST"),
    user=os.getenv("DB_USERNAME"),
    password=os.getenv("DB_PASSWORD"),
    database=os.getenv("DB_DATABASE")
)

# def get_db_connection():

#     return mysql.connector.connect(
#         host= os.getenv("DB_HOST"),
#         user=os.getenv("DB_USERNAME"),
#         password=os.getenv("DB_PASSWORD"),
#         database=os.getenv("DB_DATABASE")
#     )

def get_db_connection():

    return db_pool.get_connection()

def send_wa(id_mesin, name, phone):
    conn = get_db_connection()
    try:
        with conn.cursor(buffered=True, dictionary=True) as cursor:
            cursor.execute("SELECT token_api_wa,pesan_wa FROM sekolah WHERE id_mesin = %s", (id_mesin,))
            sekolah = cursor.fetchone()
            template = json.loads(sekolah["pesan_wa"])        
            message = re.sub(r'\{nama\}', name, template["data"][0]["message"])

            payload = {
                "target":phone,
                "message": message,
                "countryCode": "62"
            }

            headers = { "Authorization":sekolah["token_api_wa"]}

            response = requests.post(
                "https://api.fonnte.com/send",
                json=payload,
                headers=headers,
                timeout=30
            )

        print(response.json())
    except requests.exceptions.RequestException as e:
        print(f"Error WA API : {e}" )
    finally:
        conn.close()

def broadcast(name, id_sekolah, id_jurusan, id_kelas, foto=""):
    try:
        payload = {
            "nama_siswa":name,
            "id_sekolah":id_sekolah,
            "id_jurusan":id_jurusan,
            "id_kelas":id_kelas,
            "foto" : foto,
        }

        response = requests.post(os.getenv("APP_URL_API"), json=payload)
        print(response.json())
    except requests.exceptions.RequestException as e:
        print(f"Erro Broadcast : {e}")

def validation_absen(data):
        conn = get_db_connection()
        date_now = date.today().strftime("%Y-%m-%d")
        time = datetime.now().time().strftime("%H:%M:%S")
        
        try:
            with conn.cursor(buffered=True, dictionary=True) as cursor:
                cursor.execute("SELECT id, id_sekolah, id_jurusan, id_kelas, nama_siswa, no_hp_ortu, foto FROM siswa WHERE rfid = %s", (data["rfid"],))            
                student = cursor.fetchone()

                if student:                  
                    cursor.execute("INSERT INTO absensi (id_siswa, tanggal, waktu, status, id_sekolah) VALUES (%s, %s, %s, %s, %s)", (student["id"], date_now,time,"hadir",student['id_sekolah'],))
                    conn.commit()

                    payload_wa = {
                            "id_mesin" : data["id_mesin"],
                            "nama_siswa" : student["nama_siswa"],
                            "no_hp_ortu": student["no_hp_ortu"]
                        }

                    payload_broadcast = {
                            "nama_siswa": student["nama_siswa"],
                            "id_sekolah": student["id_sekolah"],
                            "id_jurusan": student["id_jurusan"],
                            "id_kelas": student["id_kelas"],
                            "foto": student["foto"]
                        }

                    wa_q.put(payload_wa)
                    broadcast_q.put(payload_broadcast)

                    send_wa(data["id_mesin"],student["nama_siswa"],student["no_hp_ortu"])
                    broadcast(student["nama_siswa"], student["id_sekolah"], student["id_jurusan"], student["id_kelas"], student["foto"])
                    print("absensi berhasil")
                else:
                    print("siswa tidak terdaftar")
        
        except Exception as e:
            print("Duplicate entry / Sudah melakukan absen")
        finally:            
            if 'conn' in locals(): 
                conn.close()

def validation_signature(id_mesin, signature, data):
        conn = get_db_connection()
        try:
            with conn.cursor(buffered=True, dictionary=True) as cursor:
                cursor.execute("SELECT secret FROM sekolah WHERE id_mesin=%s",(id_mesin,))
                sekolah = cursor.fetchone()
            if sekolah:      
                expected_signature = hmac.new(
                    sekolah["secret"].encode(),
                    id_mesin.encode(),
                    hashlib.sha256
                ).hexdigest()                            
                valid = hmac.compare_digest(signature, expected_signature)
                print(f"signature : {valid}")
                if valid:
                    validation_absen(data)
                else:
                    print("Ditolak")
            else:
                print("Ditolak")
        finally:
            if 'cursor' in locals(): 
                cursor.close()
            if 'conn' in locals(): 
                conn.close()
    
def on_connect(client, userdata, flags, reason_code, properties=None):
    print("Connected")
    client.subscribe(os.getenv("TOPIC"))

def on_message(client, userdata, msg):
    required_fields = [
        "id_mesin", "rfid", "signature"
    ]

    payload = msg.payload.decode()

    try:
        data = json.loads(payload)
    
        if not all(k in data for k in required_fields):
            print("Payload tidak lengkap")
            return
    
        queue.put(data)
        print(" ")
        print(f"Topic: {msg.topic}")
        print(f"Message: {payload}")
    except json.loads(payload):
        print("payload tidak valid")
        return
    
    

def process_queue():
    while True:
        data = queue.get()
        validation_signature(data["id_mesin"], data["signature"], data)
        queue.task_done()

def proccess_queue_wa():
    while True:
        data = wa_q.get()
        send_wa(data["id_mesin"], data["nama_siswa"], data["no_hp_ortu"])
        wa_q.task_done()

def proccess_queue_broadcast():
    while True:
        data = broadcast_q.get()
        broadcast(data["nama_siswa"], data["id_sekolah"], data["id_jurusan"], data["id_kelas"],data["foto"])
        broadcast_q.task_done()
      
def main():
    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION2)

    client.on_connect = on_connect
    client.on_message = on_message   

    client.connect_async(os.getenv("BROKER"), int(os.getenv("PORT_MQTT")))

    try:        
        for _ in range(3):
            threading.Thread(target=process_queue, daemon=True).start()

        for _ in range(2):
            threading.Thread(target=proccess_queue_broadcast, daemon=True).start()
            threading.Thread(target=proccess_queue_wa, daemon=True).start()                   
        
        client.loop_forever()
    except KeyboardInterrupt:
        print("Menutup koneksi dari MQTT")
    finally:
        client.disconnect()

if __name__ == "__main__":
    main()