# Mythic Games - Laravel Game Store

Mythic Games adalah aplikasi web toko game yang dibangun menggunakan Laravel dengan fitur lengkap untuk user dan admin. Aplikasi ini menggunakan Tailwind CSS untuk desain modern dan sistem autentikasi Laravel Breeze.

## Cara Penggunaan

1. **Clone repository** dan install dependencies:

```bash
git clone 
cd mythic-games
composer install
npm install
```

2. **Konfigurasi environment**:

```bash
cp .env.example .env
php artisan key:generate
```

3. **Atur konfigurasi database** di file `.env`.

4. **Jalankan migrasi dan seeder**:

```bash
php artisan migrate
php artisan db:seed
```

5. **Jalankan Vite development server** untuk compile Tailwind CSS:

```bash
npm run dev
```

6. **Jalankan Laravel server** di terminal lain:

```bash
php artisan serve
```

> **Penting:** Pastikan `npm run dev` berjalan bersamaan dengan `php artisan serve` agar Tailwind CSS dan asset lainnya tercompile dan aplikasi berjalan dengan baik.

7. **Akses aplikasi** di `http://localhost:8000`.

## Fitur Utama

- Dashboard user dengan game terbaru, featured, dan bestsellers
- Halaman discovery dengan filter game
- Detail game lengkap
- Sistem keranjang belanja dan checkout
- Panel admin untuk CRUD game

## Lisensi

MIT License

[1] https://laravel.com
[2] https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg
