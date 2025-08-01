# KWT Sales - Sistem Penjualan Koperasi Wanita Tani

Sistem informasi penjualan untuk Koperasi Wanita Tani berbasis web.

## Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- Composer
- Database (MySQL/MariaDB)
- Web Server (Apache/Nginx)

## Langkah Instalasi

### 1. Clone Repository
```bash
git clone <url-repository>
cd kwt-sales
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp env .env
```

Edit file `.env` dan sesuaikan konfigurasi database:
```env
database.default.hostname = localhost
database.default.database = kwt_sales
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

### 4. Generate Encryption Key
```bash
php spark key:generate
```

### 5. Migrasi Database
Jalankan migrasi untuk membuat tabel-tabel yang diperlukan:
```bash
php spark migrate
```

### 6. Menjalankan Seeder (Opsional)
Untuk menambahkan data awal pengguna:
```bash
php spark db:seed UserSeeder
```

### 7. Menjalankan Aplikasi
```bash
php spark serve
```

Akses aplikasi di browser melalui alamat: http://localhost:8080

## Struktur Direktori Utama

- `app/` - Berisi logika aplikasi (controllers, models, views)
- `public/` - Direktori public yang dapat diakses web
- `app/Database/Migrations/` - File migrasi database
- `app/Database/Seeds/` - File seeder untuk data awal

## Pengguna Default (jika menggunakan seeder)

- Username: admin
- Password: admin123

## Lisensi

Project ini dilisensikan di bawah MIT License.
