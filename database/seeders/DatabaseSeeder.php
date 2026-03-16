<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('rahasia123'); // Password default untuk semua: password123
        $kodeSekolah = 'ARN001';
        $namaSekolah = 'SDN Arunika 1';

        // ==========================================
        // 1. BUAT AKUN ADMIN SEKOLAH
        // ==========================================
        User::create([
            'name' => 'Bapak Kepala Sekolah',
            'email' => 'admin@arunika.com',
            'password' => $password,
            'role' => 'admin',
            'school_code' => $kodeSekolah,
            'school_name' => $namaSekolah,
        ]);

        // ==========================================
        // 2. BUAT MATA PELAJARAN (SUBJECTS)
        // ==========================================
        $mapelMatematika = Subject::create(['name' => 'Matematika', 'type' => 'peminatan', 'icon' => '🧮', 'color' => 'bg-blue-100']);
        $mapelSains = Subject::create(['name' => 'Sains Alam', 'type' => 'peminatan', 'icon' => '🔬', 'color' => 'bg-green-100']);
        $mapelInggris = Subject::create(['name' => 'Bahasa Inggris', 'type' => 'lainnya', 'icon' => '🔤', 'color' => 'bg-yellow-100']);
        $mapelSeni = Subject::create(['name' => 'Seni Budaya', 'type' => 'lainnya', 'icon' => '🎨', 'color' => 'bg-pink-100']);
        $mapelOlahraga = Subject::create(['name' => 'Pendidikan Jasmani', 'type' => 'lainnya', 'icon' => '⚽', 'color' => 'bg-orange-100']);

        // ==========================================
        // 3. BUAT AKUN GURU
        // ==========================================
        $guruRina = User::create([
            'name' => 'Rina Permata',
            'email' => 'rina@arunika.com',
            'password' => $password,
            'role' => 'guru',
            'school_code' => $kodeSekolah,
            'school_name' => $namaSekolah,
        ]);

        $guruAhmad = User::create([
            'name' => 'Ahmad Maulana',
            'email' => 'ahmad@arunika.com',
            'password' => $password,
            'role' => 'guru',
            'school_code' => $kodeSekolah,
            'school_name' => $namaSekolah,
        ]);

        $guruSiti = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@arunika.com',
            'password' => $password,
            'role' => 'guru',
            'school_code' => $kodeSekolah,
            'school_name' => $namaSekolah,
        ]);

        // ==========================================
        // 4. BUAT RUANG KELAS & TETAPKAN WALI KELAS
        // ==========================================
        $kelas4B = Classroom::create([
            'name' => '4B',
            'school_code' => $kodeSekolah,
            'homeroom_teacher_id' => $guruRina->id, // Bu Rina jadi Wali Kelas 4B
        ]);

        $kelas2A = Classroom::create([
            'name' => '2A',
            'school_code' => $kodeSekolah,
            'homeroom_teacher_id' => $guruAhmad->id, // Pak Ahmad jadi Wali Kelas 2A
        ]);

        // ==========================================
        // 5. TETAPKAN GURU MAPEL KE KELAS (TABEL PIVOT)
        // ==========================================
        // Di Kelas 4B:
        DB::table('classroom_teachers')->insert([
            ['classroom_id' => $kelas4B->id, 'teacher_id' => $guruRina->id, 'subject_id' => $mapelMatematika->id], // Rina ngajar MTK
            ['classroom_id' => $kelas4B->id, 'teacher_id' => $guruRina->id, 'subject_id' => $mapelSains->id],      // Rina ngajar Sains
            ['classroom_id' => $kelas4B->id, 'teacher_id' => $guruSiti->id, 'subject_id' => $mapelInggris->id],    // Siti ngajar B. Inggris
        ]);

        // Di Kelas 2A:
        DB::table('classroom_teachers')->insert([
            ['classroom_id' => $kelas2A->id, 'teacher_id' => $guruAhmad->id, 'subject_id' => $mapelOlahraga->id],  // Ahmad ngajar Olahraga
            ['classroom_id' => $kelas2A->id, 'teacher_id' => $guruSiti->id, 'subject_id' => $mapelSeni->id],       // Siti ngajar Seni
        ]);

        // ==========================================
        // 6. BUAT ORANG TUA & ANAK-ANAKNYA
        // ==========================================
        $ortu = User::create([
            'name' => 'Fahmi Putra',
            'email' => 'fahmi@gmail.com',
            'password' => $password,
            'role' => 'parent',
            'school_code' => $kodeSekolah,
            'school_name' => $namaSekolah,
        ]);

        // Anak 1 (Budi) - Masuk Kelas 4B
        User::create([
            'name' => 'Hanni Camellya',
            'username' => 'hanni123',
            'password' => $password,
            'role' => 'student',
            'parent_id' => $ortu->id,
            'school_code' => $kodeSekolah,
            'school_name' => $namaSekolah,
            'kelas' => '4B',
            'xp' => 120,
            'streak' => 7,
        ]);

        // Anak 2 (Elisa) - Masuk Kelas 2A
        User::create([
            'name' => 'Hannah Camellya',
            'username' => 'hannah123',
            'password' => $password,
            'role' => 'student',
            'parent_id' => $ortu->id,
            'school_code' => $kodeSekolah,
            'school_name' => $namaSekolah,
            'kelas' => '2A',
            'xp' => 200,
            'streak' => 4,
        ]);
    }
}
