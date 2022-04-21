<?php

namespace App\Models;

use Kitar\Dynamodb\Model\Model as BaseModel;

class Model extends BaseModel
{
    protected $primaryKey = 'PK';

    protected $sortKey = 'SK';

    public function getTable()
    {
        return env('DB_DEFAULT_TABLE');
    }

    public static function extractLastEvaluatedKey($item)
    {
        if (empty($item)) {
            return null;
        }

        return $item->meta()['LastEvaluatedKey'] ?? null;
    }
}
