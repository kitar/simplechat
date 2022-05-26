<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $fillable = [
        'id', 'username',
    ];
}
