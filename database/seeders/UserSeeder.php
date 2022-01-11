<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    private $users = [
        [
            'name' => 'Emmanuel Maduka',
            'email' => 'e.maduka@msoftconsult.com',
            'taxed' => 'Yes',
            'tax_percentage' => 4,
            'balance' => 1000000,
            'age' => 40,
        ],

        [
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'taxed' => 'No',
            'tax_percentage' => 0,
            'balance' => 0,
            'age' => 20,
        ],

        [
            'name' => 'Jane Doe',
            'email' => 'Janedoe@gmail.com',
            'taxed' => 'Yes',
            'tax_percentage' => 7,
            'balance' => 1000000,
            'age' => 15,
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = $this->users;
        foreach ($users as $user) {
            if (!User::where('email', $user['email'])->exists()) {
                $user['id'] = Str::uuid();
                $user['password'] = Hash::make('123456');
                User::create($user);
            }
        }
    }
}
