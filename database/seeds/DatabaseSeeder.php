<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        $this->call(CategoriesTableSeeder::class); 
        $this->call(ConsumableTableSeeder::class);
        $this->call(NonconsumableTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(EquipmentTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(ProperinventoryTableSeeder::class);
//        $this->call(TruncateBorrowTableSeeder::class);

    }
}
