<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
// use Faker\Generator as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Address::factory(1)->create();
        // \App\Models\User::factory(1)->create();
        \App\Models\User::factory()->create([
            'name' => 'DR. PATRICIO P. PARAMI JR.',
            'role' => 1,
            'address_id' => 1,
            'contactnumber' => '639878976331',
            'email' => 'drpatricioparami@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'MS. RIEL BAGARES',
            'role' => 2,
            'address_id' => 1,
            'contactnumber' => '639878976332',
            'email' => 'msrielbagares@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'MS. GEOLITA YURONG',
            'role' => 2,
            'address_id' => 1,
            'contactnumber' => '639878976332',
            'email' => 'msgeolitayurong@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory(9)->create();
        \App\Models\Services::factory()->create([
            'service_name' => 'BURIAL',
        ]);
        \App\Models\Services::factory()->create([
            'service_name' => 'TRANSFER OF BONE/CADAVER',
        ]);
        \App\Models\Services::factory()->create([
            'service_name' => 'EXHUME OF BONE/CADAVER',
        ]);
        \App\Models\Services::factory()->create([
            'service_name' => 'NICHES FOR CREMATED REMAINS',
        ]);
        \App\Models\Services::factory()->create([
            'service_name' => 'COMMON BONE DEPOSITORY',
        ]);
        \App\Models\Deceased::factory(20)->create();
        \App\Models\ContactPerson::factory()->count(10)->create();
        \App\Models\Block::factory()->create([
            'section_name' => 'PHASE I MEMORIAL PARK PRIVATE LOT',
            'block_cost' => 5000,
            'slot' => random_int(500, 1000),
            'validity' => random_int(3, 6),
            'image' => "5.png",
        ]);
        \App\Models\Block::factory()->create([
            'section_name' => 'PHASE II MEMORIAL PARK PRIVATE LOT',
            'block_cost' => 4000,
            'slot' => random_int(500, 1000),
            'validity' => random_int(3, 6),
            'image' => "4.png",
        ]);
        \App\Models\Block::factory()->create([
            'section_name' => 'PERIMETER CONCRETE NICHES (APARTMENT TYPE)',
            'block_cost' => 4000,
            'slot' => random_int(500, 1000),
            'validity' => random_int(3, 6),
            'image' => "3.png",
        ]);
        \App\Models\Block::factory()->create([
            'section_name' => 'PHASE I MEMORIAL GROUND NON-CONCRETE (INDIGENT SECTION)',
            'block_cost' => 2000,
            'slot' => random_int(500, 1000),
            'validity' => random_int(3, 6),
            'image' => "6.png",
        ]);
        \App\Models\Block::factory()->create([
            'section_name' => 'PHASE II MEMORIAL GROUND NON-CONCRETE (INDIGENT SECTION)',
            'block_cost' => 2000,
            'slot' => random_int(500, 1000),
            'validity' => random_int(3, 6),
            'image' => "7.png",
        ]);
        \App\Models\Block::factory()->create([
            'section_name' => 'MEMORIAL GROUND CONCRETE',
            'block_cost' => 2000,
            'slot' => random_int(500, 1000),
            'validity' => random_int(3, 6),
            'image' => "1.png",
        ]);
        \App\Models\Block::factory()->create([
            'section_name' => 'PERPETUAL BONE NICHES',
            'block_cost' => 5000,
            'slot' => random_int(500, 1000),
            'validity' => random_int(3, 6),
            'image' => "8.png",
        ]);
    }
}
