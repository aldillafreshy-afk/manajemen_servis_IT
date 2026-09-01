=========== Sistem Manajemen Servis Perangkat IT ===========
========================= FIXLY ============================

README Made by: aldilla_Freshy

DEVELOPER : 
aldilla_freshy -> Database Architect, Web Developer
annisa_maharani_azzahra ->  Web Architect, Backend, Frontend
raihan_aqil_masti -> Editor, Frontend

<=========== Deskripsi Singkat ===========>
aplikasi ini merupakan sistem pelaporan kerusakan yang digunakan untuk mencatat, mengelola, dan memantau Status perangkat IT di sekolah. website ini juga di desain untuk menampung seluruh data perangkat it yang ada di sekolah untuk memudahkan interaksi antar pengguna dengan teknisi.

<< TEKNOLOGI YANG DI GUNAKAN >>
1. laravel (v13)
2. PHP (v8.4.24)
3. MySQL (v8.4.3)
4. Tailwind CSS
5. JavaScript
6. Composer (v2.8.4)
7. Node.js & NPM
8. Git
9. laragon (v8.3.0)
10. Visual Studio Code

<< PERSYARATAN UMUM >>
untuk menjalankan program ini. anda harus memastikan hal-hal berikut ini:
1. pastikan perangkat anda memiliki : PHP , Composer , Node.js & NPM , Mysql , git 
2. pastikan php anda berada di versi 8.4. jika berada di bawahnya. akan terdapat error terhadap rendahnya versi php.
3. pastikan juga versi node anda berada di versi v22.12.0

<< CARA INSTALASI>>

1. Clone Repository
Buka terminal kemudian jalankan:
https://github.com/aldillafreshy-afk/manajemen_servis_IT/tree/fix_test

Masuk ke folder project: cd manajemen_servis_it

2. Install Dependency Laravel
Jalankan:
composer install

3. Install Dependency Frontend
Jalankan:
npm install

4. Buat File .env
Salin file .env.example menjadi .env.

Linux/macOS:
cp .env.example .env

Windows:
copy .env.example .env

5. Konfigurasi Database
Buka file .env kemudian sesuaikan konfigurasi database:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=servis_it
DB_USERNAME=root
DB_PASSWORD=

6. Generate Application Key
Jalankan:
php artisan key:generate

7. Jalankan Migration
Untuk membuat tabel database:
php artisan migrate --seed

8. Jalankan Vite
Buka terminal baru dan jalankan:
npm run dev

9. Jalankan Laravel
Buka terminal baru kemudian jalankan:
php artisan serve

Setelah itu buka browser dan akses:
http://127.0.0.1:8000

<< AKUN DEMO UNTUK PENGEMBANGAN WEBSITE >>
1.  name: admin
    email: admin@gmail.com
    pass: admin123

2.  name: teknisi
    email: teknisi@gmail.com
    pass: teknisi123

3.  name: pelapor
    email: pelapor@gmail.com
    pass: pelapor123

👥 Role User
Project memiliki beberapa role pengguna.

Admin
Admin memiliki akses untuk mengelola data dan manajemen role akun. serta melakukan penugasan dan menonaktifkan teknisi. 

Teknisi
Teknisi memiliki akses untuk melakukan perubahan status dan perbaikan pada perangkat it. serta, dapat melakukan penambahan data perangkat it

Pelapor
pelapor memiliki akses untuk membuat laporan kerusakan pada perangkat it. melihat status pengerjaannya. dan juga melihat riwayat pengerjaan teknisi

⚠️ Catatan
Jangan mengupload file .env ke repository karena file tersebut dapat berisi informasi konfigurasi dan kredensial database.
Gunakan .env.example sebagai template konfigurasi.

📄 License
Project ini dibuat untuk keperluan pembelajaran/pengembangan dan dapat disesuaikan dengan kebutuhan.