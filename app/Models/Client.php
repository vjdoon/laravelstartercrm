<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
     protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'remarks'
    ];
}
