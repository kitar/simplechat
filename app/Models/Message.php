<?php

namespace App\Models;

use App\Events\MessageCreated;
use Ramsey\Uuid\Uuid;

class Message extends Model
{
    protected $fillable = [
        'id', 'room_id', 'username', 'message',
    ];

    protected $hidden = [
        'PK', 'SK', 'GSI1PK', 'GSI1SK', 'TYPE',
    ];

    protected static function booted()
    {
        static::creating(function ($message) {
            foreach (['room_id', 'username', 'message'] as $key) {
                if (empty($message->$key)) {
                    abort(400, "{$key} is required.");
                }
            }
            $uuid = Uuid::uuid6()->toString();

            // index attributes
            $message->PK = "ROOM#{$message->room_id}";
            $message->SK = "MSG#{$uuid}";
            $message->GSI1PK = "MSG#";
            $message->GSI1SK = "MSG#{$uuid}";
            $message->TYPE = self::class;

            // item attributes
            $message->id = $uuid;
        });

        static::created(function ($message) {
            MessageCreated::dispatch($message);
        });
    }

    public static function find($messageId)
    {
        return parent::find(['PK' => "MSG#", 'SK' => "MSG#{$messageId}"]);
    }

    public static function getMessages($roomId, $exclusiveStartKey = null, $sort = 'desc')
    {
        $messages = static::keyCondition('PK', '=', "ROOM#{$roomId}")
                          ->keyCondition('SK', 'begins_with', 'MSG#')
                          ->exclusiveStartKey($exclusiveStartKey)
                          ->scanIndexForward($sort == 'desc' ? false : true)
                          ->limit(100)
                          ->query();

        return [
            'messages' => $messages,
            'LastEvaluatedKey' => static::extractLastEvaluatedKey($messages->first()),
        ];
    }
}
