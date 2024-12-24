# Bandar Lampung Market & Health - GIS

<p align="center">
  <img src="public/images/logo.jpeg" alt="Logo Proyek" width="200">
</p>

## 📄 Deskripsi Proyek
Sistem Informasi Geografis (SIG) ini dirancang untuk membantu pengguna mencari informasi lokasi fasilitas umum khususnya Rumah Sakit dan Pasar yang ada di Bandar Lampung. Sistem ini memanfaatkan peta interaktif berbasis **Leaflet.js**

### Fitur Utama:
1. **Peta Interaktif**  
   Menampilkan marker fasilitas berdasarkan kategori dengan ikon unik.
2. **Routing Otomatis**  
   Menampilkan rute dari lokasi pengguna ke fasilitas tujuan menggunakan **Leaflet Routing Machine**.
3. **Filter Data**  
   Pengguna dapat memfilter:
   - Rumah Sakit
   - Pasar
   - Jalan
   - Polygon
4. **Pencarian Fasilitas**  
   Fungsi pencarian cepat berdasarkan nama atau alamat fasilitas.
5. **Tampilan Responsif**  
   Antarmuka yang dirancang responsif dan user-friendly.

---

## 🛠 Teknologi yang Digunakan
- **Frontend**: HTML, CSS, JavaScript, Leaflet.js
- **Backend**: Laravel
- **Database**: XAMPP
- **Peta**: OpenStreetMap Tiles

---

## 🚀 Instalasi dan Penggunaan

## Clone Repositori
Jalankan perintah berikut untuk mengunduh repositori:
```bash
git clone https://github.com/username/repo-name.git
cd repo-name

-) Edit konfigurasi database pada file .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gis-app
DB_USERNAME=root
DB_PASSWORD=

-) Migrasi dan Seeder Database
Jalankan perintah berikut untuk membuat tabel dan mengisi data awal:
php artisan migrate --seed

-) Jalankan Aplikasi
Gunakan perintah berikut untuk menjalankan server:
php artisan serve
