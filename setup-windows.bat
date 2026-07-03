@echo off
setlocal

echo ==========================================
echo Setup UAS E-Commerce Laravel
echo ==========================================

where php >nul 2>nul || (
  echo PHP tidak ditemukan. Pastikan PHP/XAMPP sudah masuk PATH.
  pause
  exit /b 1
)

where composer >nul 2>nul || (
  echo Composer tidak ditemukan. Instal Composer terlebih dahulu.
  pause
  exit /b 1
)

if not exist .env copy .env.example .env
if not exist database\database.sqlite type nul > database\database.sqlite

call composer install
if errorlevel 1 goto :error

php artisan key:generate
if errorlevel 1 goto :error

php artisan migrate:fresh --seed
if errorlevel 1 goto :error

echo.
echo Setup selesai. Jalankan: php artisan serve
echo Lalu buka http://127.0.0.1:8000
pause
exit /b 0

:error
echo.
echo Setup gagal. Periksa pesan error di atas.
pause
exit /b 1
