<?php

namespace Tests;

use Database\Seeders\HmoSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Faker\Factory;
use Faker\Generator;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;
    protected Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        Artisan::call('migrate:fresh');
        $this->faker = Factory::create();

        $this->seed(HmoSeeder::class);
    }
}
