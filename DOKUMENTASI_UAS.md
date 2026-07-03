# Dokumentasi dan Penjelasan UAS

## 1. Tujuan Aplikasi

Aplikasi ini digunakan untuk mengelola data penjualan produk pada perusahaan e-commerce. Sistem dibangun menggunakan Laravel dengan paradigma Model View Controller agar pengolahan data, antarmuka, dan logika aplikasi dipisahkan secara jelas. Versi terbaru aplikasi sudah dilengkapi halaman login, logout, dan pembagian akses admin serta user.

## 2. Penerapan MVC

### Model

Model mewakili tabel dan relasi database:

- `User` menyimpan akun pengguna, password terenkripsi, dan role.
- `Category` menyimpan kategori produk.
- `Supplier` menyimpan data pemasok.
- `Product` menyimpan produk, harga, stok, kategori, dan supplier.
- `Transaction` menyimpan header transaksi.
- `TransactionDetail` menyimpan rincian produk yang dibeli.

### View

View berada pada folder `resources/views`. Blade digunakan untuk menampilkan halaman login, dashboard, kategori, produk, supplier, transaksi, serta invoice.

### Controller

Controller menerima request, melakukan validasi, memanggil model, lalu mengirim data ke view:

- `AuthController`
- `CategoryController`
- `SupplierController`
- `ProductController`
- `TransactionController`
- `DashboardController`

## 3. Fitur Login, Logout, dan Role

Aplikasi menggunakan autentikasi sederhana berbasis session Laravel. Setelah pengguna berhasil login, sistem menyimpan data dasar pengguna di session, yaitu id, nama, email, dan role. Logout akan menghapus session dan membuat token baru agar sesi lama tidak dapat digunakan lagi.

Hak akses dibagi menjadi dua:

1. **Admin**, yaitu pengguna yang dapat mengelola seluruh data master dan transaksi.
2. **User**, yaitu pengguna yang dapat melihat produk dan membuat transaksi, tetapi tidak dapat mengubah data master.

Middleware yang digunakan:

- `app.auth` untuk memastikan pengguna sudah login.
- `role.admin` untuk memastikan hanya admin yang dapat mengakses fitur tertentu.

## 4. Relasi Database

Relasi utama aplikasi adalah sebagai berikut:

```text
users
categories 1 --- n products n --- 1 suppliers
                         |
                         n
                         |
                         1 transaction_details n --- 1 transactions
```

Keterangan:

- Satu kategori memiliki banyak produk.
- Satu supplier memiliki banyak produk.
- Satu transaksi memiliki banyak detail transaksi.
- Satu produk dapat muncul dalam banyak detail transaksi.

## 5. Alur Transaksi

1. Pengguna login ke aplikasi.
2. Pengguna membuka halaman Transaksi Baru.
3. Pengguna memasukkan tanggal dan nama pelanggan.
4. Pengguna memilih satu atau beberapa produk serta jumlah pembelian.
5. Sistem memvalidasi bahwa produk tersedia dan jumlah tidak melebihi stok.
6. Sistem menyimpan transaksi dan detail transaksi dalam satu database transaction.
7. Stok produk dikurangi secara otomatis.
8. Sistem menampilkan invoice.
9. Bila transaksi dihapus oleh admin, stok produk dikembalikan.

Penggunaan `DB::transaction()` menjaga konsistensi data. Bila salah satu proses gagal, seluruh perubahan dibatalkan.

## 6. Fitur Tiap Halaman

### Halaman Login

- Form email dan password
- Validasi input
- Pesan error apabila email atau password salah
- Akun demo admin dan user

### Dashboard

- Total kategori
- Total produk
- Total supplier
- Total transaksi
- Total omzet
- Transaksi terbaru
- Produk dengan stok menipis

### Halaman Kategori

- Menampilkan daftar kategori
- Menambah kategori
- Mengubah kategori
- Menghapus kategori yang belum dipakai produk
- Pencarian kategori
- Hanya dapat diakses admin

### Halaman Produk

- Menampilkan daftar produk
- Filter kategori dan pencarian produk
- Admin dapat menambah, mengubah, dan menghapus produk
- User hanya dapat melihat daftar produk

### Halaman Supplier

- Menampilkan data supplier
- Menambah, mengubah, dan menghapus supplier
- Menyimpan nama, telepon, email, dan alamat
- Hanya dapat diakses admin

### Halaman Transaksi

- Membuat transaksi dengan banyak produk
- Menghitung subtotal dan total otomatis
- Mengurangi stok otomatis
- Menampilkan riwayat transaksi
- Menampilkan dan mencetak invoice
- Admin dapat menghapus transaksi dan mengembalikan stok

## 7. Validasi

Validasi dilakukan di controller menggunakan `$request->validate()`. Contohnya:

- Email login wajib berformat email.
- Nama kategori wajib dan unik.
- SKU produk wajib dan unik.
- Harga tidak boleh negatif.
- Stok tidak boleh negatif.
- Produk transaksi harus tersedia.
- Jumlah pembelian minimal satu dan tidak boleh melebihi stok.

## 8. Perbaikan Tampilan

Perbaikan tampilan dilakukan pada layout dan CSS custom:

- Sidebar desktop yang lebih profesional
- Topbar dengan informasi role dan tombol logout
- Kartu statistik dengan efek visual modern
- Tabel lebih rapi dan responsif
- Halaman login dua kolom dengan visual branding
- Warna, radius, spacing, dan shadow dibuat lebih konsisten

## 9. Demonstrasi Saat Presentasi

Urutan demonstrasi yang disarankan:

1. Buka halaman login.
2. Login sebagai admin.
3. Tampilkan dashboard.
4. Tambahkan satu kategori.
5. Tambahkan satu supplier.
6. Tambahkan satu produk dan stoknya.
7. Buat transaksi baru.
8. Tunjukkan stok produk berkurang.
9. Buka detail invoice dan gunakan tombol cetak.
10. Logout dari admin.
11. Login sebagai user.
12. Tunjukkan bahwa user dapat melihat produk dan membuat transaksi, tetapi tidak dapat mengubah data master.
13. Jelaskan struktur Model, View, Controller, migration, middleware, dan route.

## 10. Kesimpulan

Aplikasi telah memenuhi halaman utama pada soal UAS sekaligus memiliki fitur tambahan berupa login, logout, dan role pengguna. Struktur kode mengikuti pola MVC sehingga lebih mudah dikembangkan, sedangkan pembagian akses admin dan user membuat aplikasi lebih realistis untuk digunakan dalam skenario e-commerce sederhana.
