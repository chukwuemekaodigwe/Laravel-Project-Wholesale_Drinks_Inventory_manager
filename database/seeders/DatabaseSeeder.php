<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Faker\Provider\bg_BG\PhoneNumber;
use Faker\Provider\cs_CZ\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone' => PhoneNumber::randomDigitNotNull(),
            'password' => Hash::make('password'),
            'company_id' => DB::insert(DB::table('companies')->insert([
                'name' => Company::companySuffix(10),
                'admin_id' => PhoneNumber::randomDigit(),
            ]))
        ]);

        
    }
}
