<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;

class Room extends Model
{
    protected $fillable = [
        'id', 'name', 'password',
    ];

    protected $hidden = [
        'PK', 'SK', 'GSI1PK', 'GSI1SK', 'TYPE', 'password',
    ];

    protected static function booted()
    {
        static::creating(function ($room) {
            $uuid = Uuid::uuid4()->toString();

            // index attributes
            $room->PK = "ROOM#{$uuid}";
            $room->SK = "ROOM#{$uuid}";
            $room->GSI1PK = "ROOM#";
            $room->GSI1SK = "ROOM#{$uuid}";
            $room->TYPE = self::class;

            // item attributes
            $room->id = $uuid;
            $room->name = empty($room->name) ?? 'NO NAME';
            $room->password = empty($room->password) ?? null;
        });
    }

    public static function find($id)
    {
        return parent::find(['PK' => "ROOM#{$id}", 'SK' => "ROOM#{$id}"]);
    }

    public static function getRooms($exclusiveStartKey = null)
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
}
