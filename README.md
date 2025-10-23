# Buku Tamu Digital Diskominfo Kabupaten Karimun

## Deskripsi Proyek

Aplikasi Buku Tamu Digital yang dibuat untuk Diskominfo Kabupaten Karimun. Sistem ini dirancang untuk mengelola data tamu yang berkunjung ke Diskominfo Kabupaten Karimun dengan fitur-fitur modern dan antarmuka yang user-friendly.

## Tujuan

- Membuat buku tamu dengan sistem digital
- Memudahkan pengelolaan Data tamu & Instansi
- Meningkatkan efisiensi administrasi
- Menyediakan akses mudah untuk monitoring dan pelaporan tamu & instansi

## Fitur Utama

### Halaman Publik
- **Profil Web Diskominfostaper Kabupaten Karimun**: Halaman informasi lengkap tentang Diskominfo Kabupaten Karimun dengan:
  - Profil organisasi dan visi misi
  - Layanan yang diberikan berdasarkan bidang
  - Galeri dokumentasi kegiatan
  - Informasi kontak dan alamat
  - Media sosial

### Sistem Admin
- **Dashboard Admin**: Overview dengan statistik jumlah tamu dan instansi
- **Manajemen Data Tamu & Instansi**:
  - Tambah data tamu baru dengan bidang tujuan
  - Edit data tamu
  - Hapus data tamu
  - View data tamu dengan tabel interaktif menggunakan DataTables
- **Sistem Laporan**:
  - Laporan tamu per minggu dengan filter bidang
  - Laporan tamu per bulan dengan filter bidang
  - Laporan tamu per tahun dengan filter bidang
  - Export laporan ke PDF menggunakan DomPDF
- **Manajemen User Admin**:
  - Registrasi akun admin baru
  - Login/logout sistem dengan session management
  - Edit profil admin dengan upload foto profil
  - Change password
  - View data user admin

## Teknologi yang Digunakan

- **Backend**: PHP 7.x+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Bootstrap 5.3.0
- **Library JavaScript**:
  - jQuery 3.6.0
  - DataTables 1.13.4
  - Font Awesome 6.0.0
- **PDF Generation**: DomPDF (via Composer)
- **Server**: Apache/XAMPP

## Struktur Database

### Tabel `tb_tamu`
- `id` (INT, Primary Key, Auto Increment)
- `tanggal` (DATE)
- `nama` (VARCHAR 50)
- `alamat` (VARCHAR 50) - digunakan untuk nomor HP/WA
- `instansi` (VARCHAR 50)
- `tujuan` (VARCHAR 100)
- `perihal` (VARCHAR 50)
- `bidang` (VARCHAR 100) - bidang tujuan kunjungan
- `bukti` (VARCHAR 100) - path file bukti (opsional)
- `foto_profil` (VARCHAR 100) - path file foto profil (opsional)

### Tabel `user`
- `username` (VARCHAR 25, Primary Key)
- `paswd` (VARCHAR 50) - MD5 hash
- `email` (VARCHAR 50)
- `nama` (VARCHAR 50)
- `level` (INT 1) - 1 untuk admin
- `ket` (VARCHAR 50) - keterangan posisi/jabatan
- `last_activity` (TIMESTAMP) - waktu aktivitas terakhir
- `foto_profil` (VARCHAR 100) - path file foto profil

### Tabel `tb_instansi`
- `no` (INT 5, Primary Key, Auto Increment)
- `tanggal` (DATE)
- `nama` (VARCHAR 50)
- `alamat` (VARCHAR 50)

## Instalasi dan Setup

### Persyaratan Sistem
- PHP 7.0 atau lebih tinggi
- MySQL
- Apache Web Server (XAMPP/WAMP)
- Composer (untuk dependency management)

### Langkah Instalasi

1. **Clone atau Download Project**
   ```bash
   git clone [repository-url]
   # atau download ZIP dan ekstrak
   ```

2. **Setup Database**
   - Buat database baru di MySQL/MariaDB dengan nama `bukutamu`
   - Import file `db/bukutamu.sql` ke database yang baru dibuat

3. **Konfigurasi Koneksi Database**
   - Edit file `config/koneksi.php`
   - Sesuaikan parameter koneksi database:
     ```php
     $koneksi = mysqli_connect("localhost","root","","bukutamu");
     ```

4. **Install Dependencies**
   ```bash
   composer install
   ```

5. **Setup Web Server**
   - Pastikan folder project berada di dalam direktori web server (htdocs untuk XAMPP)
   - Akses aplikasi melalui browser: `http://localhost/nama-folder-project`

6. **Konfigurasi Awal**
   - Akses halaman login: `http://localhost/nama-folder-project/login.php`
   - Gunakan akun default atau daftar akun baru

## Struktur Folder

```
bukutamudigitaldiskominfo/
├── config/
│   └── koneksi.php          # Konfigurasi database
├── css/
│   ├── dashboard.css        # Styling dashboard
│   ├── data_tamu.css        # Styling halaman data tamu
│   ├── data_laporan.css     # Styling halaman laporan
│   ├── data_user.css        # Styling halaman user
│   ├── edit_profile.css     # Styling edit profil
│   ├── edit_tamu.css        # Styling edit tamu
│   ├── login.css            # Styling halaman login
│   ├── profilweb.css        # Styling profil web
│   ├── register.css         # Styling halaman register
│   └── tambah_tamu.css      # Styling tambah tamu
├── db/
│   └── bukutamu.sql         # File database
├── img/
│   ├── diskominfotbk.jpg    # Logo Diskominfo
│   ├── dokumentasidiskominfo1.jpeg  # Dokumentasi kegiatan 1
│   ├── dokumentasidiskominfo2.jpeg  # Dokumentasi kegiatan 2
│   ├── dokumentasidiskominfo3.jpeg  # Dokumentasi kegiatan 3
│   ├── dokumentasidiskominfo4.jpeg  # Dokumentasi kegiatan 4
│   ├── dokumentasidiskominfo5.jpeg  # Dokumentasi kegiatan 5
│   └── dokumentasidiskominfo6.jpeg  # Dokumentasi kegiatan 6
├── uploads/                 # Folder untuk upload foto profil
├── composer.json            # Dependency management
├── composer.lock            # Lock file composer
├── README.md                # Dokumentasi project
├── cek_login.php            # Proses login
├── change_password.php      # Form ubah password
├── dashboard.php            # Dashboard admin
├── data_laporan.php         # Halaman laporan dengan filter
├── data_master.php          # (File tambahan)
├── data_tamu.php            # Manajemen data tamu & instansi
├── data_user.php            # Manajemen user admin
├── edit_profile.php         # Form edit profil
├── edit_tamu.php            # Form edit tamu
├── edit_user.php            # Form edit user
├── hapus_tamu.php           # Proses hapus tamu
├── hapus_user.php           # Proses hapus user
├── login.php                # Halaman login
├── logout.php               # Proses logout
├── preview_laporan.php      # Preview dan export PDF laporan
├── proses_register.php      # Proses registrasi
├── profilweb.php            # Profil web publik
├── register.php             # Halaman register
└── tambah_tamu.php          # Form tambah tamu
```

## Cara Penggunaan

### Untuk Admin
1. **Login**: Akses `login.php` dan masukkan kredensial
2. **Dashboard**: Melihat overview statistik jumlah tamu dan instansi
3. **Kelola Tamu & Instansi**:
    - Tambah tamu baru via "Data Master" > "Data Tamu & Instansi" > "+ Tambah Tamu & Instansi"
    - Edit/Hapus tamu dari tabel data tamu
    - Pilih bidang tujuan kunjungan
4. **Laporan**:
    - Pilih jenis laporan (minggu/bulan/tahun) dari menu "Data Laporan"
    - Filter berdasarkan bidang jika diperlukan
    - Export laporan ke PDF
5. **Manajemen User**: Kelola akun admin via "Data User Admin"
6. **Profil**: Edit informasi profil, upload foto, dan ubah password

### Untuk Publik
- Akses `profilweb.php` untuk melihat informasi Diskominfo Kabupaten Karimun

## Fitur Keamanan

- Session-based authentication dengan pemeriksaan session di setiap halaman
- Password hashing dengan MD5
- Input validation dan sanitasi menggunakan mysqli_real_escape_string
- SQL injection protection dengan prepared statements (mysqli)
- File upload validation untuk foto profil dengan validasi tipe file dan ukuran
- CSRF protection pada form submission
- Access control untuk halaman admin

## Developer

Dibuat oleh mahasiswa praktek magang untuk Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Karimun

## Lisensi

Internal use only - Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Karimun

## Kontak

**Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Karimun**

- **Telepon**: +628 123 456 789
- **Email**: diskominfostaperkarimun@gmail.com
- **Website**: https://diskominfostaper.karimunkab.go.id
- **Alamat**: Jl. Jend. Sudirman, Poros RT 004 RW 001, Kelurahan Darussaalam, Kecamatan Meral Barat, Kabupaten Karimun, Provinsi Kepulauan Riau
- **Media Sosial**:
  - Instagram: [@diskominfo_karimun](https://www.instagram.com/diskominfo_karimun/)
  - YouTube: [@DiskominfoKarimun](https://www.youtube.com/@DiskominfoKarimun)
