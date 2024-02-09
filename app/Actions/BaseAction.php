<?php

namespace App\Actions;

use App\Concerns\UsesCustomResponse;
use Lorisleiva\Actions\Concerns\AsAction;

abstract class BaseAction
{
    use AsAction;
    use UsesCustomResponse;
}
