<?php

namespace App\DTOs\Models;

use Spatie\DataTransferObject\DataTransferObject;

class HMOData extends DataTransferObject
{
    public $id;

    public $name;

    public $code;

    public $batch_requirement;

    public $created_at;

    public $updated_at;
}
