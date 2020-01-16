<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableDataSeeder::class);
         $this->call(CategoriesTableSeeder::class);
         $this->call(RolesAndPermissionsSeeder::class);
         $this->call(TemplateSeeder::class);
         $this->call(LanguageTableSeeder::class);
         $this->call(CompanyTableSeeder::class);
    }
}
