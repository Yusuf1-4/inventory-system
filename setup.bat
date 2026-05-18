@echo off
echo ============================================
echo  Inventory System - Setup Script
echo ============================================
echo.
echo This will create the database and run migrations.
echo Make sure Laragon is RUNNING before continuing.
echo.
pause

set PHP=C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe
set MYSQL=C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysql.exe
set APP=C:\laragon\www\inventory-system

echo [1/3] Creating database...
"%MYSQL%" -u root -e "CREATE DATABASE IF NOT EXISTS inventory_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if %errorlevel% neq 0 (
    echo ERROR: Could not create database. Is Laragon MySQL running?
    pause
    exit /b 1
)
echo Database created OK.

echo.
echo [2/3] Running migrations...
cd /d "%APP%"
"%PHP%" artisan migrate --force
if %errorlevel% neq 0 (
    echo ERROR: Migration failed.
    pause
    exit /b 1
)
echo Migrations OK.

echo.
echo [3/3] Generating app key (if needed)...
"%PHP%" artisan key:generate --no-interaction

echo.
echo ============================================
echo  SETUP COMPLETE!
echo  Open: http://inventory-system.test
echo  or:   http://localhost/inventory-system/public
echo ============================================
pause
