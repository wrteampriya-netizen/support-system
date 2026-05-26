<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

      DB::table('tickets')->insert([

                ['customer_id'=>11,
                'subject' => 'Laptop Not Starting',
                'description' => 'My office laptop is not turning on.',
                'priority' => 'High',
                'category' => 'Hardware',
                'status' => 'Open',
                'attachment' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
              [
                'customer_id' => 11,
                'subject' => 'Email Login Problem',
                'description' => 'Unable to login into email account.',
                'priority' => 'Medium',
                'category' => 'Software',
                'status' => 'Open',
                'attachment' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'customer_id' => 11,
                'subject' => 'Email Problem',
                'description' => 'Unable to login into email account.',
                'priority' => 'High',
                'category' => 'Software',
                'status' => 'Open',
                'attachment' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'customer_id' => 11,
                'subject' => 'route problem ',
                'description' => 'route is not redirect .',
                'priority' => 'Critical',
                'category' => 'Software',
                'status' => 'Open',
                'attachment' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

      ]);
    }
}
