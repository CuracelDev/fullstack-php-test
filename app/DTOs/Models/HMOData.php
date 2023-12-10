<?php

namespace App\DTOs\Models;

use Spatie\DataTransferObject\DataTransferObject;

class HMOData extends DataTransferObject
{
    public $id;

    public $name;

    public $code;

    public $batchRequirement;
}
