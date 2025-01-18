<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Enums\AuthorizationEnum;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sekolah()
    {
        return AuthorizationEnum::SEKOLAH->value;
    }

    public function kelas()
    {
        return AuthorizationEnum::KELAS->value;
    }

    public function jurusan()
    {
        return AuthorizationEnum::JURUSAN->value;
    }

    public function pSms()
    {
        return AuthorizationEnum::SMS->value;
    }

    public function pMessageWa()
    {
        return AuthorizationEnum::MESSAGEWA->value;
    }
}
