<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTimer extends Model
{
    use HasFactory;
    public $fillable = ['time', 'name_client', 'service_owner', 'minutes_price', 'price'];
}
