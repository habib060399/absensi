import paho.mqtt.client as mqtt
import mysql.connector
import os
import json
import threading
import requests
import re
import hmac
import hashlib
from datetime import date, datetime
from queue import Queue
from dotenv import load_doenv

BROKER = "192.168.100.61"
PORT = 1883
TOPIC = "absensi/rfid"
queue = Queue()
valid = False

def get_db_connection():

    return mysql.connector.connect(
        host= os.getenv("DB_HOST"),
        user=os.getenv("DB_USERNAME"),
        password=os.getenv("DB_PASSWORD"),
        database=os.getenv("DB_DATABASE")
    )

def send_wa(id_mesin, name, phone):
    conn = get_db_connection()
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

def validation_absen(data):
        conn = get_db_connection()
        with conn.cursor(buffered=True, dictionary=True) as cursor:
            cursor.execute("SELECT nama_siswa, no_hp_ortu FROM siswa WHERE rfid = %s", (data["rfid"],))
            # cursor.execute("SELECT absensi.*, siswa.nama_siswa, siswa.no_hp_ortu FROM absensi JOIN siswa ON absensi.id_siswa = siswa.id WHERE absensi.id_siswa = %s", (data["rfid"],))
            student = cursor.fetchone()
            date_now = date.today()
            time = datetime.now().time().strftime("%H:%M:%S")
            print(student)

            if student:
                cursor.execute("SELECT * FROM absensi WHERE id_siswa = %s AND tanggal = %s", (student["id"],date_now,))
                date_before = cursor.fetchone()        
                if date_before:
                    print("anda sudah melakukan absen")
                else:
                    send_wa(data["id_mesin"],student["nama_siswa"],student["no_hp_ortu"])
                    cursor.execute("INSERT INTO absensi (id_siswa, tanggal, waktu, status) VALUES (%s, %s, %s, %s)", (data["rfid"], date_now,time,"hadir",))
                    conn.commit()
                    print("sedang proses absen")
            else:
                print("siswa tidak terdaftar") 

def validation_signature(id_mesin, signature, data):
        conn = get_db_connection()
        cursor = conn.cursor(buffered=True, dictionary=True)
        cursor.execute("SELECT secret FROM sekolah WHERE id_mesin=%s",(id_mesin,))
        sekolah = cursor.fetchone()
        if sekolah:      
            expected_signature = hmac.new(
                sekolah["secret"].encode(),
                id_mesin.encode(),
                hashlib.sha256
            ).hexdigest()
            print(signature)
            print(expected_signature)
            cursor.close()
            valid = hmac.compare_digest(signature, expected_signature)
            print(valid)
            if valid:
                validation_absen(data)
            else:
                print("hello")
        else:
            print("hello")
    
def on_connect(client, userdata, flags, reason_code, properties=None):
    print("Connected")
    client.subscribe(os.getenv("TOPIC"))

def on_message(client, userdata, msg):
    payload = msg.payload.decode()
    data = json.loads(payload)
    queue.put(data)

    print(f"Topic: {msg.topic}")
    print(f"Message: {payload}")

def process_queue():
    while True:
        data = queue.get()
        validation_signature(data["id_mesin"], data["signature"], data)
        queue.task_done()
      
def main():
    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION2)

    client.on_connect = on_connect
    client.on_message = on_message   

    client.connect_async(os.getenv("BROKER"), os.getenv("PORT_MQTT"))

    try:
        threading.Thread(target=process_queue, daemon=True).start()
        client.loop_forever()
    except KeyboardInterrupt:
        print("Menutup koneksi dari MQTT")
    finally:
        client.disconnect()

if __name__ == "__main__":
    main()