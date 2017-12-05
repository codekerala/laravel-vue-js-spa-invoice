<?php

use Illuminate\Database\Seeder;
use App\Invoice;
use App\InvoiceItem;
use Faker\Factory;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Invoice::truncate();
        InvoiceItem::truncate();

        foreach(range(1, 25) as $i) {
            $invoice = Invoice::create([
                'number' => 'INV-2000'.$i,
                'customer_id' => $i,
                'date' => '2017-12-'.$i,
                'due_date' => '2018-01-'.$i,
                'reference' => 'LPO #'.$i,
                'terms_and_conditions' => $faker->text,
                'discount' => mt_rand(0, 100),
                'sub_total' => mt_rand(1000, 2000)
            ]);

            foreach(range(1, mt_rand(2, 4)) as $j) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => mt_rand(1, 40),
                    'unit_price' => mt_rand(100, 500),
                    'qty' => mt_rand(1, 6)
                ]);
            }
        }
    }
}
