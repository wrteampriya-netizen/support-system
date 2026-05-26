<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class categoryseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            ['id'=>1,
             'category'=>'Hardware',
             'created_at'=>now(),
             'updated_at'=>now()
             ],

            ['id'=>2,
             'category'=>'Software',
             'created_at'=>now(),
             'updated_at'=>now()
             ],

            ['id'=>3, 
            'category'=>'Network & Internet',
            'created_at'=>now(),
            'updated_at'=>now()
            ],

            ['id'=>4,
             'category'=>'Billing & Invoices',
             'created_at'=>now(),
             'updated_at'=>now()
             ],

            ['id'=>5,
            'category'=>'Access & Permissions',
            'created_at'=>now(),
            'updated_at'=>now()
            ],
            ['id'=>6,
            'category'=>'Other',
            'created_at'=>now(),
            'updated_at'=>now()
            ]



        ];

        
            DB::table('categories')->insert($data);
        
    }
}
