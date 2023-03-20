<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $customer = new Customer();
        // $customer->role = 'Customer';
        // $customer->username = 'Sarwidad';
        // $customer->email = 'Sarwidad';
        // $customer->password = 'Sarwidad';
        // $customer->no_hp = '0895370009681';
        // $customer->alamat = 'Siantan';
        // $customer->tanggal_lahir = '5 April 2004';
        // $customer->fotoprofile = 'hai';
        // $customer->save();
        Customer::factory()->count(8)->create();
    }
}
