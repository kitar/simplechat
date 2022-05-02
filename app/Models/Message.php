<?php

namespace App\Models;

use App\Events\MessageCreated;
use App\Events\MessageDeleted;
use Ramsey\Uuid\Uuid;

class Message extends Model
{
    protected $fillable = [
        'id', 'room_id', 'username', 'message', 'owner_session_id',
    ];

    protected $hidden = [
        'PK', 'SK', 'GSI1PK', 'GSI1SK', 'TYPE',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
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

            // ttl
            $message->ttl = time() + (env('DB_ITEM_TTL_HOURS', 1) * 60 * 60);
        });

        static::created(function ($message) {
            MessageCreated::dispatch($message);
        });

        static::deleted(function ($message) {
            MessageDeleted::dispatch($message);
        });
    }

    public static function find($messageId)
    {
        return static::index('GSI1')
                     ->keyCondition('GSI1PK', '=', 'MSG#')
                     ->keyCondition('GSI1SK', '=', "MSG#{$messageId}")
                     ->query()
                     ->first();
    }

    public static function getMessages($roomId, $exclusiveStartKey = null, $sort = 'desc', $limit = 50)
    {
        $messages = static::keyCondition('PK', '=', "ROOM#{$roomId}")
                          ->keyCondition('SK', 'begins_with', 'MSG#')
                          ->exclusiveStartKey($exclusiveStartKey)
                          ->scanIndexForward($sort == 'desc' ? false : true)
                          ->limit($limit)
                          ->query();

        return [
            'messages' => $messages,
            'LastEvaluatedKey' => static::extractLastEvaluatedKey($messages->first()),
        ];
    }

    public static function getAllMessages($exclusiveStartKey = null, $sort = 'desc', $limit = 50)
    {
        $messages = static::index('GSI1')
                          ->keyCondition('GSI1PK', '=', 'MSG#')
                          ->exclusiveStartKey($exclusiveStartKey)
                          ->scanIndexForward($sort == 'desc' ? false : true)
                          ->limit($limit)
                          ->query();

        return [
            'messages' => $messages,
            'LastEvaluatedKey' => static::extractLastEvaluatedKey($messages->first()),
        ];
    }

    public static function deleteMessages($roomId)
    {
        $limit = 1000;
        $startKey = null;
        $endOfMessages = false;
        while ($endOfMessages != true) {
            $res = self::getMessages($roomId, $startKey, 'desc', $limit);
            foreach ($res['messages'] as $message) {
                $message->delete();
            }
            if (count($res['messages']) < $limit) {
                $endOfMessages = true;
            }
            $startKey = $res['LastEvaluatedKey'];
        }
    }
}
