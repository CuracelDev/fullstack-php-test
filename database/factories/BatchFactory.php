<?php

namespace Database\Factories;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Factories\Factory;

class BatchFactory extends Factory
{
    protected $model = Batch::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'identifier' => 'Mojeed JAN 2021',
            'order_id' => 1,
            'hmo_id' => 1,
            'process_batch_at',
            'status'
        ];
    }
}
