<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@foodhouse.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create sample inventory
        DB::table('inventory')->insert([
            [
                'name' => 'Chicken',
                'quantity' => 50,
                'price' => 150.00,
                'min_stock_level' => 10,
                'category' => 'Meat',
                'unit' => 'kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rice',
                'quantity' => 100,
                'price' => 50.00,
                'min_stock_level' => 20,
                'category' => 'Grains',
                'unit' => 'kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Coke',
                'quantity' => 3,
                'price' => 25.00,
                'min_stock_level' => 10,
                'category' => 'Beverages',
                'unit' => 'bottles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pork',
                'quantity' => 15,
                'price' => 180.00,
                'min_stock_level' => 10,
                'category' => 'Meat',
                'unit' => 'kg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Create sample orders
        DB::table('orders')->insert([
            [
                'order_number' => 'ORD-001',
                'table_number' => 1,
                'status' => 'completed',
                'total_amount' => 350.00,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_number' => 'ORD-002',
                'table_number' => 3,
                'status' => 'preparing',
                'total_amount' => 225.00,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_number' => 'ORD-003',
                'table_number' => 5,
                'status' => 'pending',
                'total_amount' => 180.00,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        echo "Database seeded successfully!\n";
    }
}