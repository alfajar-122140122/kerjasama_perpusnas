# Dokumentasi Fitur Keamanan Login - Kerjasama Perpusnas

## Fitur Keamanan yang Diimplementasikan

### 1. Enkripsi Password
- **Algoritma**: Argon2ID (algoritma hashing terkuat saat ini)
- **Konfigurasi**: 
  - Memory cost: 64MB
  - Time cost: 4 iterasi
  - Threads: 3
- **Keuntungan**: Tahan terhadap serangan brute force dan rainbow table

### 2. Validasi Kekuatan Password
Password harus memenuhi kriteria berikut:
- ✅ Minimal 8 karakter
- ✅ Mengandung huruf kecil (a-z)
- ✅ Mengandung huruf besar (A-Z) 
- ✅ Mengandung angka (0-9)
- ✅ Mengandung karakter khusus (@#$%^&*()[]{})
- ✅ Tidak boleh menggunakan password umum yang mudah ditebak
- ✅ Tidak boleh sama dengan username

### 3. Fitur Tampilan Password
- **Hide/Show Toggle**: Password disembunyikan secara default
- **Security**: Password otomatis disembunyikan saat form di-submit
- **Real-time Indicator**: Indikator kekuatan password real-time dengan:
  - Bar progress berwarna (merah = lemah, hijau = kuat)
  - Checklist requirements yang dipenuhi
  - Skor kekuatan password (1-5)

### 4. Proteksi Brute Force
- **Login Attempts**: Maksimal 5 percobaan login gagal
- **Account Lockout**: Akun dikunci selama 15 menit setelah 5x gagal
- **IP Tracking**: Pelacakan berdasarkan IP address
- **Auto Reset**: Counter reset otomatis setelah login berhasil

### 5. Session Security
- **Session Timeout**: 30 menit inaktivitas
- **Auto Extend**: Session diperpanjang pada aktivitas user
- **Secure Cookies**: Remember me dengan token terenkripsi
- **Session Destroy**: Pembersihan session saat logout

### 6. Audit & Logging
- **Login Activity**: Log semua percobaan login (berhasil/gagal)
- **User Activity**: Track aktivitas user di admin panel
- **IP Address**: Pencatatan IP address untuk setiap aktivitas
- **Security Alerts**: Alert untuk aktivitas mencurigakan

### 7. Authorization & Access Control
- **Role-based Access**: Admin dan User dengan hak akses berbeda
- **Filter Protection**: Auth filter untuk protect admin routes
- **CSRF Protection**: Token CSRF untuk form submission
- **Input Sanitization**: Sanitasi semua input user

## Cara Penggunaan

### Admin Default
Setelah setup awal:
```
Username: admin
Password: Admin123@
```
**⚠️ PENTING**: Ubah password default setelah login pertama!

### Menambah User Baru
1. Login sebagai admin
2. Masuk ke menu "Manajemen User"
3. Klik "Tambah User"
4. Isi form dengan password yang memenuhi kriteria keamanan
5. Pilih role (Admin/User)
6. Simpan

### Generate Password Otomatis
- Tersedia tombol "Generate Password Aman" 
- Menghasilkan password 12 karakter yang memenuhi semua kriteria
- Password langsung diisi ke form dan confirm password

### Indikator Kekuatan Password
- **Sangat Lemah** (Merah): 0-1 kriteria terpenuhi
- **Lemah** (Orange): 2 kriteria terpenuhi  
- **Sedang** (Kuning): 3 kriteria terpenuhi
- **Kuat** (Hijau Muda): 4 kriteria terpenuhi
- **Sangat Kuat** (Hijau Tua): 5 kriteria terpenuhi

## Setup Database

### Jalankan Migration
```bash
php spark migrate
```

### Jalankan Seeder (User Admin Default)
```bash
php spark db:seed UserSeeder
```

## Konfigurasi Keamanan

### Environment Variables (.env)
```env
# Session Configuration
app.sessionDriver = 'files'
app.sessionCookieName = 'kerjasama_session'
app.sessionExpiration = 1800
app.sessionSavePath = WRITEPATH . 'session'
app.sessionMatchIP = true
app.sessionTimeToUpdate = 300
app.sessionRegenerateDestroy = true

# Security
app.CSRFProtection = true
app.CSRFTokenName = 'csrf_token'
app.CSRFHeaderName = 'X-CSRF-TOKEN'
app.CSRFExpire = 7200

# Encryption
encryption.key = [generated-key]
```

### Security Headers
Aplikasi mengimplementasikan security headers:
- X-Frame-Options: DENY
- X-Content-Type-Options: nosniff  
- X-XSS-Protection: 1; mode=block
- Referrer-Policy: strict-origin-when-cross-origin

## Testing & Validasi

### Test Password Strength
```php
// Example penggunaan
helper('PasswordHelper');
$result = validatePasswordStrength('MySecure123@');
var_dump($result);
```

### Test Login Protection
1. Coba login dengan password salah 5x
2. Pastikan akun terkunci 15 menit
3. Coba login lagi setelah 15 menit

### Test Session Timeout
1. Login dan biarkan idle 30 menit
2. Coba akses halaman admin
3. Pastikan redirect ke login dengan pesan timeout

## File-file Terkait

### Controllers
- `app/Controllers/Auth.php` - Authentication logic
- `app/Controllers/UserController.php` - User management
- `app/Controllers/Admin.php` - Admin dashboard

### Models  
- `app/Models/UserModel.php` - User data management

### Views
- `app/Views/auth/login.php` - Login form
- `app/Views/admin/users/` - User management views

### Helpers
- `app/Helpers/PasswordHelper.php` - Password utilities

### Filters
- `app/Filters/AuthFilter.php` - Authentication protection

### Validation
- `app/Validation/CustomRules.php` - Custom validation rules

## Troubleshooting

### "Password tidak memenuhi kriteria"
Pastikan password mengandung:
- Minimal 8 karakter
- Huruf besar dan kecil
- Angka dan karakter khusus
- Bukan password umum

### "Akun terkunci"
Tunggu 15 menit atau restart session untuk reset lockout

### "Session timeout"
Login ulang, session otomatis expire setelah 30 menit inactive

### Error database
Pastikan migration dan seeder sudah dijalankan:
```bash
php spark migrate
php spark db:seed UserSeeder
```

## Security Best Practices

1. **Ganti password default** setelah setup
2. **Gunakan HTTPS** di production
3. **Backup database** secara berkala
4. **Monitor log** untuk aktivitas mencurigakan
5. **Update framework** secara berkala
6. **Limit akses** hanya dari IP yang dipercaya
7. **Enable firewall** dan security tools
