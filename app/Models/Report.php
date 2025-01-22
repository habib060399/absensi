<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'report';
    protected $fillable = ['id', 'device', 'target', 'message', 'stateid', 'status', 'state'];
    public $timestamps = false;
}
