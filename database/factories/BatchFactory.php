<?php

namespace Database\Factories;

use App\Enums\HmoBatchCriteria;
use App\Models\Batch;
use App\Models\Hmo;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Batch>
 */
class BatchFactory extends Factory
{
    protected $model = Batch::class;

    public function definition()
    {
        $month = $this->faker->dateTimeBetween('-2 years', 'now')->format('F Y');
        $criteria = Arr::random(HmoBatchCriteria::cases());

        return [
            'provider_id' => Provider::factory(),
            'hmo_id' => Hmo::factory(),
            'month' => $month,
            'criteria' => $criteria->value,
        ];
    }
}
