<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable, HasFactory, Notifiable;

    protected $fillable = [
        'id', 'name', 'email', 'password',
    ];

    protected $hidden = [
        'PK', 'SK', 'GSI1PK', 'GSI1SK', 'GSI2PK', 'GSI2SK', 'TYPE', 'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function booted()
    {
        static::creating(function ($user) {
            $uuid = Uuid::uuid4()->toString();

            // index attributes
            $user->PK = "USER#{$user->email}";
            $user->SK = "USER#{$user->email}";
            $user->GSI1PK = 'USER#';
            $user->GSI1SK = "USER#{$uuid}";
            $user->TYPE = self::class;

            // item attributes
            $user->uuid = $uuid;
        });
    }

    public static function find($email)
    {
        return parent::find(['PK' => "USER#{$email}", 'SK' => "USER#{$email}"]);
    }

    public static function findByUuid($uuid)
    {
        return static::index('GSI1')
                     ->keyCondition('GSI1PK', '=', 'USER#')
                     ->keyCondition('GSI1SK', '=', "USER#{$uuid}")
                     ->query()
                     ->first();
    }

    public static function getUsers($exclusiveStartKey = null, $sort = 'desc', $limit = 50)
    {
        $users = static::index('GSI1')
                       ->keyCondition('GSI1PK', '=', 'USER#')
                       ->exclusiveStartKey($exclusiveStartKey)
                       ->scanIndexForward($sort == 'desc' ? false : true)
                       ->limit($limit)
                       ->query();

        return [
            'users' => $users,
            'LastEvaluatedKey' => static::extractLastEvaluatedKey($users->first()),
        ];
    }

    public function getAuthIdentifierName()
    {
        return 'email';
    }
}
