# Portal Kerja Sama Perpustakaan Nasional RI

Aplikasi web untuk mengelola dan menampilkan informasi kerja sama Perpustakaan Nasional Republik Indonesia dengan berbagai mitra institusi dalam dan luar negeri.

## 🏛️ Tentang Aplikasi

Portal Kerja Sama Perpustakaan Nasional RI adalah sistem informasi yang dikembangkan untuk Sub Bidang Kerja Sama Perpustakaan, Perpustakaan Nasional RI. Aplikasi ini berfungsi sebagai platform digital untuk:

- Mengelola data kerja sama dengan berbagai mitra
- Memonitor progress dan implementasi kerja sama
- Menampilkan informasi publik mengenai aktivitas kerja sama
- Memfasilitasi pengajuan permohonan kerja sama baru
- Visualisasi peta sebaran kerja sama di Indonesia

## 🚀 Fitur Utama

### Portal Publik
- **Beranda**: Informasi umum dan statistik kerja sama
- **Data Kerja Sama**: Daftar lengkap kerja sama aktif dan yang akan berakhir
- **Implementasi**: Status pelaksanaan kerja sama
- **Progress**: Monitoring perkembangan kerja sama
- **Pengajuan**: Form permohonan kerja sama baru
- **Peta Kerja Sama**: Visualisasi sebaran mitra di Indonesia
- **Aktivitas**: Berita dan kegiatan terkait kerja sama
- **Tentang**: Informasi tugas dan fungsi sub bidang
- **Kontak**: Informasi kontak dan lokasi

### Panel Admin
- **Dashboard**: Overview dan statistik admin
- **Kelola Kerja Sama**:
  - Data master kerja sama
  - Implementasi kerja sama
  - Progress monitoring
  - Kerja sama yang akan berakhir
  - Pengajuan permohonan
- **Kelola Users** (Khusus Superadmin):
  - Manajemen hak akses
  - CRUD pengguna
- **Kelola Berita**: Manajemen konten aktivitas
- **Pengaturan**: Konfigurasi sistem

## 🛠️ Teknologi yang Digunakan

- **Framework**: CodeIgniter 4
- **Database**: MySQL
- **Frontend**: Bootstrap 5.2.3, jQuery, Font Awesome
- **Maps**: Google Maps API
- **Animation**: AOS (Animate On Scroll)
- **Icons**: Bootstrap Icons, Font Awesome

## 📋 Persyaratan Sistem

- PHP 8.1 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache/Nginx Web Server
- Ekstensi PHP yang diperlukan:
  - intl
  - mbstring
  - json
  - mysqlnd
  - libcurl
  - gd (untuk manipulasi gambar)

## 🔧 Instalasi

### 1. Clone Repository
```bash
git clone [repository-url]
cd kerjasama_perpusnas
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
```bash
cp env .env
```

edit file .env sesuai konfigurasi server Anda:
```bash
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/kerjasama_perpusnas'
app.appTimezone = 'Asia/Jakarta'

database.default.hostname = localhost
database.default.database = kerjasama_perpusnas
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```
### 4. Setup Database
```bash
# Buat database
mysql -u root -p -e "CREATE DATABASE kerjasama_perpusnas"

# Jalankan migrasi
php spark migrate

# Jalankan seeder untuk data dummy
php spark db:seed KerjasamaSeeder
php spark db:seed ImplementasiKerjasamaSeeder
php spark db:seed PermohonanKerjasamaSeeder
php spark db:seed BeritaSeeder
php spark db:seed UserSeeder
```

### 5. Konfigurasi Web Server
Pastikan document root mengarah ke folder public

## 📁 Struktur Folder
```bash
app/
├── Config/           # Konfigurasi aplikasi
├── Controllers/      # Controller MVC
│   ├── Admin/        # Controller admin
│   ├── Auth/         # Controller autentikasi
│   └── Public/       # Controller publik
├── Database/         # Database migrations & seeders
├── Models/           # Model data
├── Views/            # Template tampilan
│   ├── admin/        # Template admin
│   ├── auth/         # Template login
│   ├── layouts/      # Layout template
│   └── public/       # Template publik
└── Helpers/          # Helper functions

public/
├── css/              # File CSS
├── js/               # File JavaScript
├── assets/           # Gambar dan media
└── uploads/          # File upload
```

## 🔐 Sistem Hak Akses

### Superadmin
- Akses penuh ke semua fitur
- Kelola users dan hak akses
- Kelola kerja sama dan berita

### Admin
- Kelola kerja sama (jika diberi akses)
- Kelola berita (jika diberi akses)
- Tidak bisa kelola users

### Staff
- Akses terbatas sesuai permission
- Biasanya hanya kelola berita

## 📊 Database Schema
Tabel Utama
- kerjasama: Data master kerja sama
- implementasi_kerjasama: Data implementasi
- permohonan_kerjasama: Pengajuan kerja sama baru
- peta_kerjasama: Koordinat lokasi mitra
- progress_kerjasama: Monitoring progress
- berita: Konten aktivitas
- users: Data pengguna sistem

## 🌐 API Endpoints

### Public API
- GET /api/kerjasama - Data kerja sama untuk publik
- POST /permohonan/submit - Submit pengajuan kerja sama

### Admin API
- POST /admin/kerjasama/store - Tambah kerja sama
- PUT /admin/kerjasama/update/{id} - Update kerja sama
- DELETE /admin/kerjasama/delete/{id} - Hapus kerja sama
- POST /admin/implementasi/store - Tambah implementasi
- POST /admin/progress/store - Tambah progress

## 🚀 Deployment

### Production Setup
1. Set environment ke production dalam .env
2. Disable debug mode
3. Konfigurasi SSL certificate
4. Setup backup database otomatis
4. Konfigurasi file permissions yang tepat

### Performance Optimization
- Enable caching di CodeIgniter
- Optimize database queries
- Compress CSS/JS files
- Setup CDN untuk static assets

## 📝 Maintenance

### Update Data
```bash
# Update data dummy
php spark db:seed KerjasamaSeeder

# Reset database (hati-hati!)
php spark migrate:rollback
php spark migrate
```
File log tersimpan di logs

## 🤝 Kontribusi
Aplikasi ini dikembangkan untuk Perpustakaan Nasional RI. Untuk kontribusi atau bug report, silakan hubungi tim pengembang.

## 📞 Kontak
Sub Bidang Kerja Sama Perpustakaan
Perpustakaan Nasional RI
Gedung Layanan, Lantai 5
Jl. Medan Merdeka Selatan No. 11
Jakarta Pusat 10110

Email: kerjasama@perpusnas.go.id
Telepon: (021) 3927685

## 📄 Lisensi
Aplikasi ini dikembangkan khusus untuk Perpustakaan Nasional Republik Indonesia.