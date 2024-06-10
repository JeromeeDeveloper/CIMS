<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deceased extends Model
{
    use HasFactory;
    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'suffix',
        'civilstatus',
        'address_id',
        'causeofdeath',
        'sex',
        'dateofbirth',
        'dateof_death',
        'dateof_burial',
        'burial_time',
    ];
}
