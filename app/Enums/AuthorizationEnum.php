<?php

namespace App\Enums;

enum AuthorizationEnum:string 
{
    // case ROLE = 'sekolah';
    // case PERMISSION1 = 'admin sekolah';
    // case PERMISSION2 = 'jurusan sekolah';
    // case PERMISSION3 = 'kelas';
    case SEKOLAH = 'sekolah';
    case KELAS = 'kelas';
    case JURUSAN = 'jurusan';
    case SMS = 'sms';
    case MESSAGEWA = 'message wa';
}