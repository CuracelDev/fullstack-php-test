<?php

namespace App\DTOs\Models;

use Spatie\DataTransferObject\DataTransferObject;

class ProviderData extends DataTransferObject
{
    public $name;

    public $slug;
}
