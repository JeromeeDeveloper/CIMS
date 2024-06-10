<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['region_no', 'region', 'province_no', 'province', 'city_no', 'city', 'barangay_no', 'barangay'];
}
