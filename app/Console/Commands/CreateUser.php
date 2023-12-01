<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Http\Controllers\UserController;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = new User();
        $controllerUser = new UserController();
        // $controllerUser->cekAbsensi();

            while (true) {
                $rfid = $this->ask('Masukkan RFID');
                $username = $this->ask('Masukkan username');
                $name= $this->ask('Masukkan nama lengkap');

                if($rfid == null && $username == null && $name == null){
                    $this->info('data tidak boleh kosong');
                }
                
                $getUser = $user->updateUser($rfid, $username, $name);
            
                if($getUser == null){
                    $this->info('data gagal ditambahkan');
                }else{
                    $this->info('data berhasil ditambahkan');
                }
            }
                
    }
}
