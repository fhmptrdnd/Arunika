<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacementQuestionSeeder extends Seeder
{
    /**
     * 8 mapel × 2 soal tiap mapel × 6 kls = 96 soal
     */
    public function run(): void
    {
        $now = now();
        $questions = [];

        // KELAS 1
        // KELAS 1
        // KELAS 1

        $k1 = [
            // agama
            ['subject'=>'agama','order'=>1,
             'question'=>'Siapa yang menciptakan kita dan seluruh alam semesta?',
             'option_a'=>'Manusia','option_b'=>'Tuhan Yang Maha Esa',
             'option_c'=>'Hewan','option_d'=>'Tumbuhan','correct_answer'=>'b'],
            ['subject'=>'agama','order'=>2,
             'question'=>'Apa yang kita ucapkan saat memulai kegiatan yang baik?',
             'option_a'=>'Terima kasih','option_b'=>'Selamat pagi',
             'option_c'=>'Bismillah / Doa pembuka','option_d'=>'Halo','correct_answer'=>'c'],

            // pancasila
            ['subject'=>'pancasila','order'=>3,
             'question'=>'Berapa jumlah sila dalam Pancasila?',
             'option_a'=>'3','option_b'=>'4','option_c'=>'5','option_d'=>'6','correct_answer'=>'c'],
            ['subject'=>'pancasila','order'=>4,
             'question'=>'Lambang negara Indonesia adalah...',
             'option_a'=>'Singa','option_b'=>'Garuda Pancasila',
             'option_c'=>'Naga','option_d'=>'Harimau','correct_answer'=>'b'],

            // b. indo
            ['subject'=>'bahasa_indonesia','order'=>5,
             'question'=>'Manakah penulisan nama yang benar?',
             'option_a'=>'budi','option_b'=>'BUDI','option_c'=>'Budi','option_d'=>'bUDI','correct_answer'=>'c'],
            ['subject'=>'bahasa_indonesia','order'=>6,
             'question'=>'"Ani pergi ke sekolah." Siapa yang pergi ke sekolah?',
             'option_a'=>'Ibu','option_b'=>'Ani','option_c'=>'Budi','option_d'=>'Guru','correct_answer'=>'b'],

            // matematika
            ['subject'=>'matematika','order'=>7,
             'question'=>'Berapakah 3 + 4?',
             'option_a'=>'6','option_b'=>'7','option_c'=>'8','option_d'=>'9','correct_answer'=>'b'],
            ['subject'=>'matematika','order'=>8,
             'question'=>'Ada 10 apel, dimakan 3. Sisa berapa?',
             'option_a'=>'5','option_b'=>'6','option_c'=>'7','option_d'=>'8','correct_answer'=>'c'],

            // pjok
            ['subject'=>'pjok','order'=>9,
             'question'=>'Olahraga yang baik dilakukan berapa kali seminggu?',
             'option_a'=>'Tidak perlu','option_b'=>'1 kali sebulan',
             'option_c'=>'Setiap hari / rutin','option_d'=>'Setahun sekali','correct_answer'=>'c'],
            ['subject'=>'pjok','order'=>10,
             'question'=>'Apa manfaat berolahraga untuk tubuh kita?',
             'option_a'=>'Membuat ngantuk','option_b'=>'Badan jadi sehat dan kuat',
             'option_c'=>'Membuat sakit','option_d'=>'Tidak ada manfaatnya','correct_answer'=>'b'],

            // seni budaya
            ['subject'=>'seni_budaya','order'=>11,
             'question'=>'Warna apa yang dihasilkan jika kita mencampur merah dan kuning?',
             'option_a'=>'Hijau','option_b'=>'Ungu','option_c'=>'Oranye','option_d'=>'Biru','correct_answer'=>'c'],
            ['subject'=>'seni_budaya','order'=>12,
             'question'=>'Alat musik yang dipukul adalah...',
             'option_a'=>'Seruling','option_b'=>'Gitar','option_c'=>'Drum / Gendang','option_d'=>'Biola','correct_answer'=>'c'],

            // b. inggris
            ['subject'=>'bahasa_inggris','order'=>13,
             'question'=>'"Cat" dalam bahasa Indonesia artinya...',
             'option_a'=>'Anjing','option_b'=>'Kucing','option_c'=>'Ikan','option_d'=>'Burung','correct_answer'=>'b'],
            ['subject'=>'bahasa_inggris','order'=>14,
             'question'=>'How do you say "Selamat pagi" in English?',
             'option_a'=>'Good night','option_b'=>'Good afternoon',
             'option_c'=>'Good morning','option_d'=>'Good evening','correct_answer'=>'c'],

            // mulok
            ['subject'=>'muatan_lokal','order'=>15,
             'question'=>'Pakaian adat yang dikenakan pada acara pernikahan di daerahmu adalah bentuk...',
             'option_a'=>'Budaya asing','option_b'=>'Budaya lokal / daerah',
             'option_c'=>'Mode internasional','option_d'=>'Pakaian olahraga','correct_answer'=>'b'],
            ['subject'=>'muatan_lokal','order'=>16,
             'question'=>'Menjaga kebersihan lingkungan sekitar rumah adalah kewajiban...',
             'option_a'=>'Pemerintah saja','option_b'=>'Orang dewasa saja',
             'option_c'=>'Semua warga termasuk anak-anak','option_d'=>'Petugas kebersihan saja','correct_answer'=>'c'],
        ];
        foreach ($k1 as &$q) { $q['kelas']='Kelas 1'; $q['created_at']=$now; $q['updated_at']=$now; }
        $questions = array_merge($questions, $k1);

        // KELAS 2
        // KELAS 2
        // KELAS 2

        $k2 = [
            ['subject'=>'agama','order'=>1,
             'question'=>'Bagaimana cara kita mensyukuri nikmat Tuhan?',
             'option_a'=>'Dengan mengeluh','option_b'=>'Dengan berterima kasih dan berdoa',
             'option_c'=>'Dengan marah-marah','option_d'=>'Dengan diam saja','correct_answer'=>'b'],
            ['subject'=>'agama','order'=>2,
             'question'=>'Berbuat baik kepada sesama manusia termasuk pengamalan ajaran...',
             'option_a'=>'Budi pekerti yang baik','option_b'=>'Budi pekerti yang buruk',
             'option_c'=>'Tidak ada hubungannya','option_d'=>'Hanya untuk orang dewasa','correct_answer'=>'a'],

            ['subject'=>'pancasila','order'=>3,
             'question'=>'Bersikap adil kepada teman tanpa membeda-bedakan adalah pengamalan Pancasila sila ke...',
             'option_a'=>'1','option_b'=>'2','option_c'=>'3','option_d'=>'4','correct_answer'=>'b'],
            ['subject'=>'pancasila','order'=>4,
             'question'=>'Bendera Indonesia berwarna...',
             'option_a'=>'Biru Putih','option_b'=>'Merah Putih',
             'option_c'=>'Merah Kuning','option_d'=>'Hijau Putih','correct_answer'=>'b'],

            ['subject'=>'bahasa_indonesia','order'=>5,
             'question'=>'Lawan kata "rajin" adalah...',
             'option_a'=>'Cerdas','option_b'=>'Malas','option_c'=>'Baik','option_d'=>'Cepat','correct_answer'=>'b'],
            ['subject'=>'bahasa_indonesia','order'=>6,
             'question'=>'Kalimat tanya yang tepat adalah...',
             'option_a'=>'Dia pergi ke pasar.','option_b'=>'Tolong ambilkan buku!',
             'option_c'=>'Di mana kamu tinggal?','option_d'=>'Saya suka makan nasi.','correct_answer'=>'c'],

            ['subject'=>'matematika','order'=>7,
             'question'=>'25 + 37 = ...',
             'option_a'=>'52','option_b'=>'61','option_c'=>'62','option_d'=>'63','correct_answer'=>'c'],
            ['subject'=>'matematika','order'=>8,
             'question'=>'Setengah dari 40 adalah...',
             'option_a'=>'15','option_b'=>'20','option_c'=>'25','option_d'=>'10','correct_answer'=>'b'],

            ['subject'=>'pjok','order'=>9,
             'question'=>'Sebelum berolahraga, kita harus melakukan...',
             'option_a'=>'Langsung berlari kencang','option_b'=>'Pemanasan / stretching',
             'option_c'=>'Tidur dulu','option_d'=>'Makan banyak','correct_answer'=>'b'],
            ['subject'=>'pjok','order'=>10,
             'question'=>'Renang adalah olahraga yang dilakukan di...',
             'option_a'=>'Lapangan','option_b'=>'Hutan','option_c'=>'Air / kolam renang','option_d'=>'Gunung','correct_answer'=>'c'],

            ['subject'=>'seni_budaya','order'=>11,
             'question'=>'Tari Saman berasal dari daerah...',
             'option_a'=>'Jawa','option_b'=>'Bali','option_c'=>'Aceh','option_d'=>'Sulawesi','correct_answer'=>'c'],
            ['subject'=>'seni_budaya','order'=>12,
             'question'=>'Menggambar pemandangan alam menggunakan...',
             'option_a'=>'Gunting','option_b'=>'Pensil dan krayon / cat','option_c'=>'Penggaris','option_d'=>'Penghapus saja','correct_answer'=>'b'],

            ['subject'=>'bahasa_inggris','order'=>13,
             'question'=>'What is the English word for "buku"?',
             'option_a'=>'Pen','option_b'=>'Bag','option_c'=>'Book','option_d'=>'Table','correct_answer'=>'c'],
            ['subject'=>'bahasa_inggris','order'=>14,
             'question'=>'Complete: "She ___ a student."',
             'option_a'=>'am','option_b'=>'are','option_c'=>'is','option_d'=>'be','correct_answer'=>'c'],

            ['subject'=>'muatan_lokal','order'=>15,
             'question'=>'Makanan tradisional daerahmu merupakan bagian dari...',
             'option_a'=>'Kebudayaan lokal yang perlu dilestarikan','option_b'=>'Makanan yang tidak enak',
             'option_c'=>'Budaya asing','option_d'=>'Tidak penting','correct_answer'=>'a'],
            ['subject'=>'muatan_lokal','order'=>16,
             'question'=>'Gotong royong membersihkan lingkungan adalah contoh sikap...',
             'option_a'=>'Egois','option_b'=>'Malas','option_c'=>'Peduli dan saling membantu','option_d'=>'Tidak mau tahu','correct_answer'=>'c'],
        ];
        foreach ($k2 as &$q) { $q['kelas']='Kelas 2'; $q['created_at']=$now; $q['updated_at']=$now; }
        $questions = array_merge($questions, $k2);

        // KELAS 3
        // KELAS 3
        // KELAS 3

        $k3 = [
            ['subject'=>'agama','order'=>1,
             'question'=>'Sikap jujur dan tidak bohong termasuk akhlak...',
             'option_a'=>'Buruk','option_b'=>'Biasa saja','option_c'=>'Mulia / Terpuji','option_d'=>'Tercela','correct_answer'=>'c'],
            ['subject'=>'agama','order'=>2,
             'question'=>'Menolong teman yang kesulitan adalah perbuatan yang...',
             'option_a'=>'Rugi','option_b'=>'Tidak perlu','option_c'=>'Terpuji dan dianjurkan','option_d'=>'Berbahaya','correct_answer'=>'c'],

            ['subject'=>'pancasila','order'=>3,
             'question'=>'Musyawarah untuk mencapai mufakat merupakan pengamalan Pancasila sila ke...',
             'option_a'=>'2','option_b'=>'3','option_c'=>'4','option_d'=>'5','correct_answer'=>'c'],
            ['subject'=>'pancasila','order'=>4,
             'question'=>'Hari Kemerdekaan Indonesia diperingati setiap tanggal...',
             'option_a'=>'1 Juni','option_b'=>'17 Agustus','option_c'=>'28 Oktober','option_d'=>'10 November','correct_answer'=>'b'],

            ['subject'=>'bahasa_indonesia','order'=>5,
             'question'=>'Kata "berlari" mendapat awalan ber-. Apa makna awalan ber- tersebut?',
             'option_a'=>'Melakukan pekerjaan','option_b'=>'Mempunyai sesuatu',
             'option_c'=>'Menjadi sesuatu','option_d'=>'Membuat sesuatu','correct_answer'=>'a'],
            ['subject'=>'bahasa_indonesia','order'=>6,
             'question'=>'"Ani adalah siswa yang rajin." Apa sifat Ani?',
             'option_a'=>'Pemberani','option_b'=>'Disiplin','option_c'=>'Pemalu','option_d'=>'Penurut','correct_answer'=>'b'],

            ['subject'=>'matematika','order'=>7,
             'question'=>'Budi punya 248 kelereng, memberikan 96. Sisa kelereng Budi?',
             'option_a'=>'142','option_b'=>'152','option_c'=>'162','option_d'=>'132','correct_answer'=>'b'],
            ['subject'=>'matematika','order'=>8,
             'question'=>'Sebuah kotak berisi 12 pensil. Ada 7 kotak. Berapa total pensil?',
             'option_a'=>'74','option_b'=>'82','option_c'=>'84','option_d'=>'92','correct_answer'=>'c'],

            ['subject'=>'pjok','order'=>9,
             'question'=>'Dalam permainan sepak bola, bola dimasukkan ke...',
             'option_a'=>'Keranjang','option_b'=>'Gawang','option_c'=>'Kolam','option_d'=>'Ring','correct_answer'=>'b'],
            ['subject'=>'pjok','order'=>10,
             'question'=>'Posisi badan yang benar saat duduk belajar adalah...',
             'option_a'=>'Membungkuk','option_b'=>'Miring ke kanan','option_c'=>'Tegak dan tidak membungkuk','option_d'=>'Rebahan','correct_answer'=>'c'],

            ['subject'=>'seni_budaya','order'=>11,
             'question'=>'Batik adalah kain tradisional yang berasal dari...',
             'option_a'=>'Malaysia','option_b'=>'Thailand','option_c'=>'Indonesia','option_d'=>'India','correct_answer'=>'c'],
            ['subject'=>'seni_budaya','order'=>12,
             'question'=>'Angklung adalah alat musik yang dimainkan dengan cara...',
             'option_a'=>'Dipukul','option_b'=>'Ditiup','option_c'=>'Digoyang / digoyangkan','option_d'=>'Dipetik','correct_answer'=>'c'],

            ['subject'=>'bahasa_inggris','order'=>13,
             'question'=>'What is the English word for "kucing"?',
             'option_a'=>'Dog','option_b'=>'Cat','option_c'=>'Bird','option_d'=>'Fish','correct_answer'=>'b'],
            ['subject'=>'bahasa_inggris','order'=>14,
             'question'=>'How do you say "Selamat pagi" in English?',
             'option_a'=>'Good night','option_b'=>'Good afternoon',
             'option_c'=>'Good evening','option_d'=>'Good morning','correct_answer'=>'d'],

            ['subject'=>'muatan_lokal','order'=>15,
             'question'=>'Permainan tradisional seperti congklak dan petak umpet perlu dilestarikan karena...',
             'option_a'=>'Sudah ketinggalan zaman','option_b'=>'Tidak menarik',
             'option_c'=>'Merupakan warisan budaya bangsa','option_d'=>'Hanya untuk orang tua','correct_answer'=>'c'],
            ['subject'=>'muatan_lokal','order'=>16,
             'question'=>'Menggunakan bahasa daerah di rumah adalah cara untuk...',
             'option_a'=>'Melupakan budaya','option_b'=>'Melestarikan bahasa dan budaya daerah',
             'option_c'=>'Mempersulit komunikasi','option_d'=>'Hal yang tidak penting','correct_answer'=>'b'],
        ];
        foreach ($k3 as &$q) { $q['kelas']='Kelas 3'; $q['created_at']=$now; $q['updated_at']=$now; }
        $questions = array_merge($questions, $k3);

        // KELAS 4
        // KELAS 4
        // KELAS 4

        $k4 = [
            ['subject'=>'agama','order'=>1,
             'question'=>'Memaafkan kesalahan orang lain mencerminkan sifat...',
             'option_a'=>'Pemarah','option_b'=>'Pemaaf dan penyabar','option_c'=>'Sombong','option_d'=>'Dengki','correct_answer'=>'b'],
            ['subject'=>'agama','order'=>2,
             'question'=>'Larangan berbuat curang dalam ujian merupakan ajaran dari...',
             'option_a'=>'Guru saja','option_b'=>'Orang tua saja',
             'option_c'=>'Semua agama dan nilai budi pekerti','option_d'=>'Tidak ada yang melarang','correct_answer'=>'c'],

            ['subject'=>'pancasila','order'=>3,
             'question'=>'Kerajaan Hindu pertama di Indonesia adalah...',
             'option_a'=>'Majapahit','option_b'=>'Sriwijaya','option_c'=>'Kutai','option_d'=>'Tarumanagara','correct_answer'=>'c'],
            ['subject'=>'pancasila','order'=>4,
             'question'=>'Sila ke-3 Pancasila berbunyi...',
             'option_a'=>'Kemanusiaan yang adil dan beradab','option_b'=>'Persatuan Indonesia',
             'option_c'=>'Keadilan sosial','option_d'=>'Ketuhanan Yang Maha Esa','correct_answer'=>'b'],

            ['subject'=>'bahasa_indonesia','order'=>5,
             'question'=>'Sinonim kata "berani" adalah...',
             'option_a'=>'Penakut','option_b'=>'Gagah / pemberani','option_c'=>'Lemah','option_d'=>'Pemalu','correct_answer'=>'b'],
            ['subject'=>'bahasa_indonesia','order'=>6,
             'question'=>'Jenis kalimat "Tolong tutup pintunya!" adalah kalimat...',
             'option_a'=>'Berita','option_b'=>'Tanya','option_c'=>'Perintah','option_d'=>'Seru','correct_answer'=>'c'],

            ['subject'=>'matematika','order'=>7,
             'question'=>'KPK dari 4 dan 6 adalah...',
             'option_a'=>'8','option_b'=>'12','option_c'=>'24','option_d'=>'6','correct_answer'=>'b'],
            ['subject'=>'matematika','order'=>8,
             'question'=>'Luas persegi panjang panjang 12 cm, lebar 5 cm adalah...',
             'option_a'=>'34 cm²','option_b'=>'60 cm²','option_c'=>'17 cm²','option_d'=>'55 cm²','correct_answer'=>'b'],

            ['subject'=>'pjok','order'=>9,
             'question'=>'Dalam bulu tangkis, alat yang digunakan untuk memukul kok adalah...',
             'option_a'=>'Bat','option_b'=>'Raket','option_c'=>'Tongkat','option_d'=>'Kayu','correct_answer'=>'b'],
            ['subject'=>'pjok','order'=>10,
             'question'=>'Menjaga pola makan yang sehat berguna untuk...',
             'option_a'=>'Membuat gemuk saja','option_b'=>'Menjaga kesehatan dan stamina tubuh',
             'option_c'=>'Tidak ada gunanya','option_d'=>'Supaya mengantuk','correct_answer'=>'b'],

            ['subject'=>'seni_budaya','order'=>11,
             'question'=>'Tari Pendet berasal dari daerah...',
             'option_a'=>'Jawa','option_b'=>'Sumatera','option_c'=>'Bali','option_d'=>'Kalimantan','correct_answer'=>'c'],
            ['subject'=>'seni_budaya','order'=>12,
             'question'=>'Unsur seni rupa yang menentukan terang gelapnya warna adalah...',
             'option_a'=>'Garis','option_b'=>'Bentuk','option_c'=>'Gelap terang / value','option_d'=>'Tekstur','correct_answer'=>'c'],

            ['subject'=>'bahasa_inggris','order'=>13,
             'question'=>'What do you say when you meet someone for the first time?',
             'option_a'=>'Goodbye','option_b'=>'Nice to meet you','option_c'=>'See you later','option_d'=>'Thank you','correct_answer'=>'b'],
            ['subject'=>'bahasa_inggris','order'=>14,
             'question'=>'What is the plural of "child"?',
             'option_a'=>'Childs','option_b'=>'Childes','option_c'=>'Children','option_d'=>'Childrens','correct_answer'=>'c'],

            ['subject'=>'muatan_lokal','order'=>15,
             'question'=>'Produk kerajinan khas daerah dapat dijual untuk meningkatkan...',
             'option_a'=>'Kemiskinan daerah','option_b'=>'Perekonomian dan kebanggaan daerah',
             'option_c'=>'Polusi lingkungan','option_d'=>'Persaingan antar daerah','correct_answer'=>'b'],
            ['subject'=>'muatan_lokal','order'=>16,
             'question'=>'Upacara adat di daerah biasanya diselenggarakan untuk...',
             'option_a'=>'Membuang waktu','option_b'=>'Menakut-nakuti anak',
             'option_c'=>'Menjaga tradisi dan nilai luhur budaya lokal','option_d'=>'Menghabiskan uang','correct_answer'=>'c'],
        ];
        foreach ($k4 as &$q) { $q['kelas']='Kelas 4'; $q['created_at']=$now; $q['updated_at']=$now; }
        $questions = array_merge($questions, $k4);

        // KELAS 5
        // KELAS 5
        // KELAS 5

        $k5 = [
            ['subject'=>'agama','order'=>1,
             'question'=>'Sikap tidak mudah putus asa dan terus berusaha disebut...',
             'option_a'=>'Malas','option_b'=>'Ikhtiar dan tawakal','option_c'=>'Sombong','option_d'=>'Serakah','correct_answer'=>'b'],
            ['subject'=>'agama','order'=>2,
             'question'=>'Menjaga amanah yang diberikan orang lain adalah contoh perilaku...',
             'option_a'=>'Khianat','option_b'=>'Jujur dan bertanggung jawab','option_c'=>'Curang','option_d'=>'Tidak peduli','correct_answer'=>'b'],

            ['subject'=>'pancasila','order'=>3,
             'question'=>'Proklamasi kemerdekaan Indonesia dibacakan pada tanggal...',
             'option_a'=>'15 Agustus 1945','option_b'=>'17 Agustus 1945',
             'option_c'=>'18 Agustus 1945','option_d'=>'20 Agustus 1945','correct_answer'=>'b'],
            ['subject'=>'pancasila','order'=>4,
             'question'=>'Kegiatan ekonomi yang menghasilkan barang dari bahan mentah disebut...',
             'option_a'=>'Konsumsi','option_b'=>'Distribusi','option_c'=>'Produksi','option_d'=>'Investasi','correct_answer'=>'c'],

            ['subject'=>'bahasa_indonesia','order'=>5,
             'question'=>'Penggunaan tanda koma yang benar adalah...',
             'option_a'=>'Saya membeli buku, pensil, dan penghapus','option_b'=>'Saya membeli buku pensil dan penghapus',
             'option_c'=>'Saya, membeli buku pensil dan penghapus','option_d'=>'Saya membeli, buku, pensil dan penghapus','correct_answer'=>'a'],
            ['subject'=>'bahasa_indonesia','order'=>6,
             'question'=>'Kalimat "Hutan Indonesia harus dijaga kelestariannya." termasuk jenis paragraf...',
             'option_a'=>'Narasi','option_b'=>'Deskripsi','option_c'=>'Argumentasi','option_d'=>'Eksposisi','correct_answer'=>'c'],

            ['subject'=>'matematika','order'=>7,
             'question'=>'FPB dari 24 dan 36 adalah...',
             'option_a'=>'6','option_b'=>'12','option_c'=>'18','option_d'=>'72','correct_answer'=>'b'],
            ['subject'=>'matematika','order'=>8,
             'question'=>'3/4 × 8 = ...',
             'option_a'=>'4','option_b'=>'5','option_c'=>'6','option_d'=>'24/4','correct_answer'=>'c'],

            ['subject'=>'pjok','order'=>9,
             'question'=>'Dalam atletik, nomor lompat jauh bertujuan untuk...',
             'option_a'=>'Berlari sejauh mungkin','option_b'=>'Melompat setinggi mungkin',
             'option_c'=>'Melompat sejauh mungkin','option_d'=>'Melempar sejauh mungkin','correct_answer'=>'c'],
            ['subject'=>'pjok','order'=>10,
             'question'=>'Istirahat yang cukup bagi anak-anak adalah tidur selama...',
             'option_a'=>'4 jam','option_b'=>'6 jam','option_c'=>'8–10 jam','option_d'=>'12–14 jam','correct_answer'=>'c'],

            ['subject'=>'seni_budaya','order'=>11,
             'question'=>'Gamelan adalah alat musik tradisional dari daerah...',
             'option_a'=>'Aceh','option_b'=>'Jawa dan Bali','option_c'=>'Kalimantan','option_d'=>'Sulawesi','correct_answer'=>'b'],
            ['subject'=>'seni_budaya','order'=>12,
             'question'=>'Prinsip keseimbangan dalam karya seni rupa berarti...',
             'option_a'=>'Semua warna sama','option_b'=>'Susunan elemen terasa stabil dan seimbang',
             'option_c'=>'Hanya satu warna saja','option_d'=>'Tidak ada aturan','correct_answer'=>'b'],

            ['subject'=>'bahasa_inggris','order'=>13,
             'question'=>'"Yesterday, I ___ to the library."',
             'option_a'=>'go','option_b'=>'goes','option_c'=>'went','option_d'=>'gone','correct_answer'=>'c'],
            ['subject'=>'bahasa_inggris','order'=>14,
             'question'=>'Which sentence is correct?',
             'option_a'=>"She don't like apples.",'option_b'=>"She doesn't like apples.",
             'option_c'=>"She doesn't likes apples.",'option_d'=>"She not like apples.",'correct_answer'=>'b'],

            ['subject'=>'muatan_lokal','order'=>15,
             'question'=>'Rumah adat Joglo berasal dari daerah...',
             'option_a'=>'Sumatera Barat','option_b'=>'Jawa Tengah dan Jawa Timur',
             'option_c'=>'Kalimantan','option_d'=>'Sulawesi','correct_answer'=>'b'],
            ['subject'=>'muatan_lokal','order'=>16,
             'question'=>'Usaha melestarikan lingkungan alam di sekitar kita adalah tanggung jawab...',
             'option_a'=>'Pemerintah saja','option_b'=>'Orang kaya saja',
             'option_c'=>'Semua lapisan masyarakat','option_d'=>'Ilmuwan saja','correct_answer'=>'c'],
        ];
        foreach ($k5 as &$q) { $q['kelas']='Kelas 5'; $q['created_at']=$now; $q['updated_at']=$now; }
        $questions = array_merge($questions, $k5);

        // KELAS 6
        // KELAS 6
        // KELAS 6

        $k6 = [
            ['subject'=>'agama','order'=>1,
             'question'=>'Toleransi antar umat beragama berarti...',
             'option_a'=>'Semua agama harus sama','option_b'=>'Menghormati dan menghargai perbedaan keyakinan',
             'option_c'=>'Tidak perlu beragama','option_d'=>'Melarang agama lain','correct_answer'=>'b'],
            ['subject'=>'agama','order'=>2,
             'question'=>'Berderma dan membantu fakir miskin adalah wujud kepedulian yang diajarkan...',
             'option_a'=>'Hanya satu agama','option_b'=>'Semua agama dan nilai kemanusiaan',
             'option_c'=>'Tidak ada yang mengajarkan','option_d'=>'Hanya pemerintah','correct_answer'=>'b'],

            ['subject'=>'pancasila','order'=>3,
             'question'=>'Organisasi ASEAN didirikan pada tahun...',
             'option_a'=>'1945','option_b'=>'1955','option_c'=>'1967','option_d'=>'1975','correct_answer'=>'c'],
            ['subject'=>'pancasila','order'=>4,
             'question'=>'Hak asasi manusia dilindungi oleh...',
             'option_a'=>'Perusahaan','option_b'=>'Undang-undang dasar / negara',
             'option_c'=>'Sekolah','option_d'=>'Pasar','correct_answer'=>'b'],

            ['subject'=>'bahasa_indonesia','order'=>5,
             'question'=>'Majas dalam kalimat "Angin berbisik lembut di telingaku" adalah...',
             'option_a'=>'Hiperbola','option_b'=>'Personifikasi','option_c'=>'Metafora','option_d'=>'Simile','correct_answer'=>'b'],
            ['subject'=>'bahasa_indonesia','order'=>6,
             'question'=>'Paragraf yang kalimat utamanya ada di akhir disebut paragraf...',
             'option_a'=>'Deduktif','option_b'=>'Campuran','option_c'=>'Induktif','option_d'=>'Deskriptif','correct_answer'=>'c'],

            ['subject'=>'matematika','order'=>7,
             'question'=>'Volume kubus dengan panjang sisi 5 cm adalah...',
             'option_a'=>'25 cm³','option_b'=>'75 cm³','option_c'=>'125 cm³','option_d'=>'150 cm³','correct_answer'=>'c'],
            ['subject'=>'matematika','order'=>8,
             'question'=>'30% dari 200 adalah...',
             'option_a'=>'30','option_b'=>'60','option_c'=>'90','option_d'=>'120','correct_answer'=>'b'],

            ['subject'=>'pjok','order'=>9,
             'question'=>'Senam lantai seperti roll depan termasuk cabang olahraga...',
             'option_a'=>'Atletik','option_b'=>'Renang','option_c'=>'Senam artistik / lantai','option_d'=>'Bola voli','correct_answer'=>'c'],
            ['subject'=>'pjok','order'=>10,
             'question'=>'Bahaya merokok bagi kesehatan adalah...',
             'option_a'=>'Menyehatkan paru-paru','option_b'=>'Meningkatkan stamina',
             'option_c'=>'Merusak paru-paru dan organ tubuh','option_d'=>'Tidak ada efeknya','correct_answer'=>'c'],

            ['subject'=>'seni_budaya','order'=>11,
             'question'=>'Karya seni tiga dimensi adalah karya yang memiliki...',
             'option_a'=>'Panjang dan lebar saja','option_b'=>'Panjang, lebar, dan tinggi / kedalaman',
             'option_c'=>'Hanya tinggi','option_d'=>'Tidak memiliki ukuran','correct_answer'=>'b'],
            ['subject'=>'seni_budaya','order'=>12,
             'question'=>'Wayang kulit adalah seni pertunjukan yang berasal dari...',
             'option_a'=>'Eropa','option_b'=>'Cina','option_c'=>'Jawa / Indonesia','option_d'=>'India','correct_answer'=>'c'],

            ['subject'=>'bahasa_inggris','order'=>13,
             'question'=>'"The students ___ studying when the teacher came in."',
             'option_a'=>'were','option_b'=>'was','option_c'=>'are','option_d'=>'is','correct_answer'=>'a'],
            ['subject'=>'bahasa_inggris','order'=>14,
             'question'=>'Choose the correct passive voice: "They built this house in 1990."',
             'option_a'=>'This house built in 1990.','option_b'=>'This house was built in 1990.',
             'option_c'=>'This house is built in 1990.','option_d'=>'This house were built in 1990.','correct_answer'=>'b'],

            ['subject'=>'muatan_lokal','order'=>15,
             'question'=>'Dampak positif globalisasi bagi budaya lokal yang perlu diwaspadai adalah...',
             'option_a'=>'Budaya lokal semakin kuat','option_b'=>'Masuknya budaya asing yang tidak sesuai nilai bangsa',
             'option_c'=>'Tidak ada dampaknya','option_d'=>'Semua budaya asing baik','correct_answer'=>'b'],
            ['subject'=>'muatan_lokal','order'=>16,
             'question'=>'Cara terbaik untuk melestarikan seni budaya daerah adalah...',
             'option_a'=>'Membiarkannya hilang','option_b'=>'Hanya menonton di TV',
             'option_c'=>'Mempelajari, mempraktikkan, dan memperkenalkan ke generasi muda',
             'option_d'=>'Menyimpan buku saja','correct_answer'=>'c'],
        ];
        foreach ($k6 as &$q) { $q['kelas']='Kelas 6'; $q['created_at']=$now; $q['updated_at']=$now; }
        $questions = array_merge($questions, $k6);

        DB::table('placement_questions')->insert($questions);

        $this->command->info(count($questions) . ' soal placement berhasil diseed');
    }
}
