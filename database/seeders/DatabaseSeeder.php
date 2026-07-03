<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mandala.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@mandala.test'],
            [
                'name' => 'User Penjualan',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        $electronics = Category::firstOrCreate(
            ['name' => 'Elektronik'],
            ['description' => 'Perangkat elektronik dan aksesori digital.']
        );

        $fashion = Category::firstOrCreate(
            ['name' => 'Fashion'],
            ['description' => 'Pakaian dan aksesori penunjang penampilan.']
        );

        $stationery = Category::firstOrCreate(
            ['name' => 'Alat Tulis'],
            ['description' => 'Perlengkapan sekolah, kuliah, dan kantor.']
        );

        $supplierA = Supplier::firstOrCreate(
            ['email' => 'digital@nusantara.test'],
            [
                'name' => 'PT Digital Nusantara',
                'phone' => '0812-1111-2222',
                'address' => 'Jl. Teknologi No. 10, Bandung',
            ]
        );

        $supplierB = Supplier::firstOrCreate(
            ['email' => 'sinar@mandala.test'],
            [
                'name' => 'CV Sinar Mandala',
                'phone' => '0813-3333-4444',
                'address' => 'Jl. Merdeka No. 22, Bandung',
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'ELK-001'],
            [
                'category_id' => $electronics->id,
                'supplier_id' => $supplierA->id,
                'name' => 'Keyboard Mechanical',
                'price' => 375000,
                'stock' => 15,
                'description' => 'Keyboard mechanical dengan lampu RGB dan koneksi USB.',
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'ELK-002'],
            [
                'category_id' => $electronics->id,
                'supplier_id' => $supplierA->id,
                'name' => 'Mouse Wireless',
                'price' => 145000,
                'stock' => 20,
                'description' => 'Mouse nirkabel ergonomis untuk kegiatan kerja dan belajar.',
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'FSH-001'],
            [
                'category_id' => $fashion->id,
                'supplier_id' => $supplierB->id,
                'name' => 'Tas Ransel Kampus',
                'price' => 225000,
                'stock' => 8,
                'description' => 'Tas ransel dengan kompartemen laptop 15 inci.',
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'ATK-001'],
            [
                'category_id' => $stationery->id,
                'supplier_id' => $supplierB->id,
                'name' => 'Buku Catatan A5',
                'price' => 28000,
                'stock' => 35,
                'description' => 'Buku catatan ukuran A5 dengan 100 lembar.',
            ]
        );
    }
}
