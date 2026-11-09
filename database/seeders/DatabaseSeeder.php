<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CustomerDetail;
use App\Models\ProductDetail;
use App\Models\TransactionDetail;
use App\Models\OrderDetail;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. PRODUCTS
        // =============================================
        $products = [
            ['sku_id' => 'SKU-001', 'category' => 'Electronics', 'brand' => 'Samsung', 'product' => 'Smartphone', 'variant' => '128GB Black', 'sku_name' => 'Samsung Galaxy A54 128GB Black', 'price' => 4999000, 'cogs' => 3500000],
            ['sku_id' => 'SKU-002', 'category' => 'Electronics', 'brand' => 'Apple', 'product' => 'Earbuds', 'variant' => 'White', 'sku_name' => 'AirPods Pro 2nd Gen', 'price' => 3799000, 'cogs' => 2800000],
            ['sku_id' => 'SKU-003', 'category' => 'Fashion', 'brand' => 'Nike', 'product' => 'Running Shoes', 'variant' => 'Size 42', 'sku_name' => 'Nike Air Max 90 Size 42', 'price' => 1899000, 'cogs' => 950000],
            ['sku_id' => 'SKU-004', 'category' => 'Home', 'brand' => 'Philips', 'product' => 'Air Fryer', 'variant' => '4.1L', 'sku_name' => 'Philips Air Fryer HD9200', 'price' => 1299000, 'cogs' => 750000],
            ['sku_id' => 'SKU-005', 'category' => 'Beauty', 'brand' => 'Somethinc', 'product' => 'Serum', 'variant' => '20ml', 'sku_name' => 'Somethinc Niacinamide Serum 20ml', 'price' => 89000, 'cogs' => 25000],
        ];
        foreach ($products as $product) {
            ProductDetail::create($product);
        }

        // =============================================
        // 2. CUSTOMERS (PII will be auto-encrypted by model mutators)
        // =============================================
        $customers = [
            ['customer_id' => 'CUST-001', 'registration_date' => '2024-01-15', 'customer_name' => 'Budi Santoso', 'customer_type' => 'Premium', 'dob' => '1990-05-20', 'province' => 'DKI Jakarta', 'registration_channel' => 'Website'],
            ['customer_id' => 'CUST-002', 'registration_date' => '2024-02-10', 'customer_name' => 'Siti Nurhaliza', 'customer_type' => 'Regular', 'dob' => '1985-11-30', 'province' => 'Jawa Barat', 'registration_channel' => 'Mobile App'],
            ['customer_id' => 'CUST-003', 'registration_date' => '2024-03-05', 'customer_name' => 'Ahmad Rizky', 'customer_type' => 'VIP', 'dob' => '1992-08-14', 'province' => 'Jawa Timur', 'registration_channel' => 'Store'],
            ['customer_id' => 'CUST-004', 'registration_date' => '2024-03-20', 'customer_name' => 'Dewi Lestari', 'customer_type' => 'Regular', 'dob' => '1998-02-28', 'province' => 'Bali', 'registration_channel' => 'Social Media'],
            ['customer_id' => 'CUST-005', 'registration_date' => '2024-04-01', 'customer_name' => 'Rafi Pratama', 'customer_type' => 'Premium', 'dob' => '1995-12-10', 'province' => 'DKI Jakarta', 'registration_channel' => 'Website'],
        ];
        foreach ($customers as $customer) {
            CustomerDetail::create($customer);
        }

        // =============================================
        // 3. CREATE DEMO USERS (4 roles: Admin, Analyst, Auditor, Customer)
        // =============================================
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kdb.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Data Analyst',
            'email' => 'analyst@kdb.test',
            'password' => Hash::make('password'),
            'role' => 'data_analyst',
        ]);

        User::create([
            'name' => 'Security Auditor',
            'email' => 'auditor@kdb.test',
            'password' => Hash::make('password'),
            'role' => 'auditor',
        ]);

        // Customer user linked to CUST-001 (Budi Santoso)
        User::create([
            'name' => 'Budi Santoso (Customer)',
            'email' => 'customer@kdb.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'customer_id' => 'CUST-001',
        ]);

        // =============================================
        // 4. TRANSACTIONS & ORDER DETAILS
        // =============================================
        $transactions = [
            [
                'trx' => ['transaction_id' => 'TRX-001', 'transaction_date' => '2024-04-10', 'customer_id' => 'CUST-001', 'payment_method' => 'Credit Card', 'before_tax' => 4999000, 'tax' => 549890, 'after_tax' => 5548890, 'shipping_cost' => 15000, 'transaction_discount' => 200000, 'total_paid' => 5363890],
                'order' => ['order_id' => 'ORD-001', 'sku_id' => 'SKU-001', 'quantity' => 1, 'price' => 4999000, 'before_discount' => 4999000, 'discount_item' => 200000, 'after_discount' => 4799000],
            ],
            [
                'trx' => ['transaction_id' => 'TRX-002', 'transaction_date' => '2024-04-12', 'customer_id' => 'CUST-002', 'payment_method' => 'E-Wallet', 'before_tax' => 1899000, 'tax' => 208890, 'after_tax' => 2107890, 'shipping_cost' => 10000, 'transaction_discount' => 50000, 'total_paid' => 2067890],
                'order' => ['order_id' => 'ORD-002', 'sku_id' => 'SKU-003', 'quantity' => 1, 'price' => 1899000, 'before_discount' => 1899000, 'discount_item' => 50000, 'after_discount' => 1849000],
            ],
            [
                'trx' => ['transaction_id' => 'TRX-003', 'transaction_date' => '2024-04-15', 'customer_id' => 'CUST-003', 'payment_method' => 'Bank Transfer', 'before_tax' => 8798000, 'tax' => 967780, 'after_tax' => 9765780, 'shipping_cost' => 0, 'transaction_discount' => 500000, 'total_paid' => 9265780],
                'order' => ['order_id' => 'ORD-003', 'sku_id' => 'SKU-001', 'quantity' => 1, 'price' => 4999000, 'before_discount' => 4999000, 'discount_item' => 0, 'after_discount' => 4999000],
            ],
            [
                'trx' => ['transaction_id' => 'TRX-004', 'transaction_date' => '2024-04-18', 'customer_id' => 'CUST-004', 'payment_method' => 'COD', 'before_tax' => 89000, 'tax' => 9790, 'after_tax' => 98790, 'shipping_cost' => 12000, 'transaction_discount' => 0, 'total_paid' => 110790],
                'order' => ['order_id' => 'ORD-004', 'sku_id' => 'SKU-005', 'quantity' => 1, 'price' => 89000, 'before_discount' => 89000, 'discount_item' => 0, 'after_discount' => 89000],
            ],
            [
                'trx' => ['transaction_id' => 'TRX-005', 'transaction_date' => '2024-04-20', 'customer_id' => 'CUST-005', 'payment_method' => 'QRIS', 'before_tax' => 1299000, 'tax' => 142890, 'after_tax' => 1441890, 'shipping_cost' => 8000, 'transaction_discount' => 100000, 'total_paid' => 1349890],
                'order' => ['order_id' => 'ORD-005', 'sku_id' => 'SKU-004', 'quantity' => 1, 'price' => 1299000, 'before_discount' => 1299000, 'discount_item' => 100000, 'after_discount' => 1199000],
            ],
        ];

        foreach ($transactions as $data) {
            TransactionDetail::create($data['trx']);

            OrderDetail::create([
                'order_id'        => $data['order']['order_id'],
                'transaction_id'  => $data['trx']['transaction_id'],
                'customer_id'     => $data['trx']['customer_id'],
                'order_date'      => $data['trx']['transaction_date'],
                'channel_type'    => 'Website',
                'sku_id'          => $data['order']['sku_id'],
                'quantity'        => $data['order']['quantity'],
                'price'           => $data['order']['price'],
                'before_discount' => $data['order']['before_discount'],
                'discount_item'   => $data['order']['discount_item'],
                'after_discount'  => $data['order']['after_discount'],
                'is_gross'        => true,
                'is_valid'        => true,
                'is_net'          => true,
            ]);
        }
    }
}
