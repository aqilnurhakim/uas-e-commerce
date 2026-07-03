# UAS E-Commerce Laravel

Aplikasi penjualan produk berbasis **Model View Controller (MVC)** menggunakan Laravel. Versi ini sudah diperbarui dengan tampilan yang lebih profesional, halaman login, logout, dan pembagian akses **admin** serta **user**.

## Fitur Utama

1. Login dan logout pengguna
2. Role admin dan user
3. Dashboard ringkasan penjualan
4. Manajemen kategori produk
5. Manajemen produk
6. Manajemen supplier
7. Transaksi penjualan dan invoice cetak
8. Pencarian, filter, validasi form, pagination, dan data contoh
9. Pengurangan stok otomatis saat transaksi dibuat
10. Pengembalian stok otomatis saat transaksi dihapus oleh admin

## Hak Akses

### Admin

Admin dapat mengakses seluruh fitur:

- Dashboard
- Kategori: tambah, edit, hapus
- Supplier: tambah, edit, hapus
- Produk: tambah, edit, hapus
- Transaksi: tambah, detail, cetak, hapus

### User

User dapat mengakses fitur operasional dasar:

- Dashboard
- Melihat produk
- Membuat transaksi
- Melihat detail transaksi dan invoice

User tidak dapat mengubah data master seperti kategori, supplier, dan produk.

## Akun Demo

Setelah menjalankan `php artisan migrate --seed`, gunakan akun berikut:

```text
Admin
Email    : admin@mandala.test
Password : password

User
Email    : user@mandala.test
Password : password
```

## Persyaratan

- PHP 8.2 atau lebih baru
- Composer
- Ekstensi PHP: PDO, SQLite atau MySQL, Mbstring, OpenSSL, Tokenizer, XML, Ctype, JSON

## Cara Menjalankan dengan SQLite

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Untuk Windows Command Prompt, ganti perintah salin menjadi:

```bat
copy .env.example .env
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

File `database/database.sqlite` sudah disediakan. Bila ingin mengulang database dari awal, jalankan:

```bash
php artisan migrate:fresh --seed
```

## Menggunakan MySQL/XAMPP

1. Buat database bernama `uas_ecommerce` di phpMyAdmin.
2. Ubah konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=uas_ecommerce
DB_USERNAME=root
DB_PASSWORD=
```

3. Jalankan:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

## Struktur MVC

- **Model**: `app/Models`
- **View**: `resources/views`
- **Controller**: `app/Http/Controllers`
- **Middleware**: `app/Http/Middleware`
- **Route**: `routes/web.php`
- **Database migration**: `database/migrations`
- **Seeder akun demo dan data contoh**: `database/seeders/DatabaseSeeder.php`

## Catatan Pengembangan

- Login dibuat manual menggunakan session Laravel agar ringan dan tidak perlu install Laravel Breeze.
- Password akun demo di-hash menggunakan `Hash::make()` pada seeder.
- Middleware `app.auth` digunakan untuk mewajibkan login.
- Middleware `role.admin` digunakan untuk membatasi fitur khusus admin.
- Tampilan menggunakan Bootstrap CDN dan CSS custom di `public/css/app.css`, sehingga tidak perlu `npm install`.

## Upload ke GitHub

Buat repository kosong di GitHub, lalu jalankan:

```bash
git init
git add .
git commit -m "UAS aplikasi e-commerce Laravel dengan login role"
git branch -M main
git remote add origin https://github.com/USERNAME/NAMA-REPOSITORY.git
git push -u origin main
```

Jangan mengunggah folder `vendor` dan file `.env` ke GitHub.
