<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;

class Room extends Model
{
    protected $fillable = [
        'id', 'name', 'password', 'owner_session_id', 'created_by',
    ];

    protected $hidden = [
        'PK', 'SK', 'GSI1PK', 'GSI1SK', 'GSI2PK', 'GSI2SK', 'TYPE', 'password',
    ];

    protected static function booted()
    {
        static::creating(function ($room) {
            $uuid = Uuid::uuid6()->toString();

            // index attributes
            $room->PK = "ROOM#{$uuid}";
            $room->SK = "ROOM#{$uuid}";
            $room->GSI1PK = "ROOM#";
            $room->GSI1SK = "ROOM#{$uuid}";
            $room->TYPE = self::class;
            if (! empty($room->created_by)) {
                $room->GSI2PK = "USER#{$room->created_by}";
                $room->GSI2SK = "ROOM#{$uuid}";
            }

            // item attributes
            $room->id = $uuid;
            $room->name = empty($room->name) ? 'NO NAME': $room->name;
            $room->password = empty($room->password) ? null : $room->password;

            // ttl
            $room->ttl = time() + (env('DB_ITEM_TTL_HOURS', 1) * 60 * 60);
        });

        static::deleting(function ($room) {
            Message::deleteMessages($room->id);
        });
    }

    public static function find($id)
    {
        return parent::find(['PK' => "ROOM#{$id}", 'SK' => "ROOM#{$id}"]);
    }

    public static function getAllRooms($exclusiveStartKey = null)
    {
        $rooms = static::index('GSI1')
                       ->keyCondition('GSI1PK', '=', 'ROOM#')
                       ->keyCondition('GSI1SK', 'begins_with', 'ROOM#')
                       ->exclusiveStartKey($exclusiveStartKey)
                       ->limit(100)
                       ->query();

        return [
            'rooms' => $rooms,
            'LastEvaluatedKey' => static::extractLastEvaluatedKey($rooms->first()),
        ];
    }

    public static function getUserRooms($userUuid, $exclusiveStartKey = null)
    {
        $rooms = static::index('GSI2')
                       ->keyCondition('GSI2PK', '=', "USER#{$userUuid}")
                       ->keyCondition('GSI2SK', 'begins_with', 'ROOM#')
                       ->exclusiveStartKey($exclusiveStartKey)
                       ->limit(100)
                       ->query();

        return [
            'rooms' => $rooms,
            'LastEvaluatedKey' => static::extractLastEvaluatedKey($rooms->first()),
        ];
    }
}
