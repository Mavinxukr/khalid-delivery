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
         $this->call(CategoriesTableSeeder::class);
         $this->call(CompanyTableSeeder::class);
         $this->call(UsersTableDataSeeder::class);
         $this->call(RolesAndPermissionsSeeder::class);
         $this->call(TemplateSeeder::class);
         $this->call(LanguageTableSeeder::class);
         $this->call(ProductCategoryTableSeeder::class);
         $this->call(ProductTableSeeder::class);
         $this->call(CompanySettingTableSeeder::class);
         $this->call(FeesTableSeeder::class);
         $this->call(InvoiceTemplateTableSeeder::class);
         $this->call(QueryTableSeeder::class);
         $this->call(AnswerTableSeeder::class);
         $this->call(PlaceTableSeeder::class);
         $this->call(OrderStatusTableSeeder::class);
    }
}
