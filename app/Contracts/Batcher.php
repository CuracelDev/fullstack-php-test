<?php
namespace App\Contracts;

use Carbon\Carbon;

Interface Batcher {
    public function batchName(): string;
    public function fulfillOn(): Carbon;
}
