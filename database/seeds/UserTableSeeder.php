<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // buyer 
        $buyer = new User();
        $buyer->name = 'Buyer Name';
        $buyer->email = 'buyer@example.com';
        $buyer->password = Hash::make('buyer');
        $buyer->role_id = 1;
        $buyer->save();

        // sales 
        $sales = new User();
        $sales->name = 'Sales Name';
        $sales->email = 'sales@example.com';
        $sales->password = Hash::make('sales');
        $sales->role_id = 2;
        $sales->save();


        // supplier 
        $supplier = new User();
        $supplier->name = 'Supplier Name';
        $supplier->email = 'supplier@example.com';
        $supplier->password = Hash::make('supplier');
        $supplier->role_id = 3;
        $supplier->save();

    }
}
