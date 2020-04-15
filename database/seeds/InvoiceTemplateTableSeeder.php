<?php

use Illuminate\Database\Seeder;

class InvoiceTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoices = [
            [
                'title' => 'Description',
                'key'   => 'description',
                'value' => 'Description',
            ],
            [
                'title' => 'Quantity',
                'key'   => 'quantity',
                'value' => 'Quantity',
            ],
            [
                'title' => 'Rate',
                'key'   => 'rate',
                'value' => 'Rate',
            ],
            [
                'title' => 'Per',
                'key'   => 'per',
                'value' => 'Per',
            ],
            [
                'title' => 'Amount',
                'key'   => 'amount',
                'value' => 'Amount',
            ],
            [
                'title' => 'Discount',
                'key'   => 'discount',
                'value' => 'Discount',
            ],
            [
                'title' => 'Taxable Value (AED)',
                'key'   => 'tax_value',
                'value' => 'Taxable Value (AED)',
            ],
            [
                'title' => 'VAT',
                'key'   => 'vat',
                'value' => 'VAT Rate',
            ],
            [
                'title' => 'VAT Amount (AED)',
                'key'   => 'vat_amount',
                'value' => 'VAT Amount (AED)',
            ],
        ];

        foreach ($invoices as $invoice){
            \App\Models\Invoice\InvoiceTemplate::create($invoice);
        }
    }
}
