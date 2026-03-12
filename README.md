# 🎓 Arunika - Platform Belajar Interaktif

Arunika adalah sebuah platform edukasi berbasis web (EduGame) yang dirancang khusus untuk anak-anak Sekolah Dasar (SD). Aplikasi ini menggabungkan pengalaman belajar yang menyenangkan (gamifikasi) dengan sistem manajemen kelas yang rapi untuk Guru/Admin dan pantauan yang mudah bagi Orang Tua.

## ✨ Fitur Utama

- **Sistem Multi-Pengguna (Multi-Role):** Akses yang disesuaikan untuk **Admin/Guru** dan **Orang Tua**.
- **Sistem Kode Sekolah Pintar:** Admin dapat membuat kelas dengan Kode Sekolah unik (otomatis ter-generate). Orang tua cukup memasukkan kode tersebut saat mendaftar agar anak langsung masuk ke kelas yang tepat.
- **Manajemen Kelas:** Admin dapat melihat daftar seluruh murid di sekolahnya, melihat detail profil murid, dan mengeluarkan murid jika terjadi kesalahan pendaftaran.
- **Profil Cerdas:** Orang tua yang belum memiliki kelas (atau dikeluarkan) dapat memasukkan ulang Kode Sekolah melalui halaman profil mereka.
- **Peta Belajar Gamifikasi:** Mata pelajaran dibagi menjadi **Mapel Peminatan** (berdasarkan bakat/placement test) dan **Mapel Lainnya**. Setiap mata pelajaran memiliki visualisasi Peta Level bergaya permainan.
- **UI/UX Ramah Anak:** Antarmuka yang ceria, penuh warna, menggunakan efek *glassmorphism*, *custom pop-up* untuk notifikasi peringatan, dan desain yang responsif di berbagai perangkat.

## 🛠️ Teknologi yang Digunakan

- **Framework Backend:** [Laravel](https://laravel.com/) (PHP)
- **Framework Frontend:** [Tailwind CSS](https://tailwindcss.com/)
- **Templating Engine:** Blade
- **Database:** MySQL

## 🚀 Panduan Instalasi (Lokal)

Ikuti langkah-langkah berikut untuk menjalankan Arunika di komputer lokalmu.

### Persyaratan Sistem
Pastikan kamu sudah menginstal:
- PHP (versi 8.1 atau lebih baru)
- Composer
- Node.js & NPM
- MySQL / MariaDB (bisa menggunakan Laragon atau XAMPP)

### Langkah Instalasi

1. **Clone repositori ini:**
   ```bash
   git clone [https://github.com/username-kamu/arunika.git](https://github.com/username-kamu/arunika.git)
   cd arunika
