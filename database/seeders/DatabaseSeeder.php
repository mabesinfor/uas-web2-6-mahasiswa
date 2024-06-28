<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProgramStudi;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            ['name' => 'Alice', 'email' => 'alice@example.com', 'email_verified_at' => now(), 'password' => Hash::make('password')],
            ['name' => 'Bob', 'email' => 'bob@example.com', 'email_verified_at' => now(), 'password' => Hash::make('password')],
        ]);

        ProgramStudi::insert([
            ['nama' => 'Teknik Sipil'],
            ['nama' => 'Informatika'],
            ['nama' => 'Teknik Mesin'],
            ['nama' => 'Teknik Elektro'],
            ['nama' => 'Kimia'],
            ['nama' => 'Fisika'],
            ['nama' => 'Biologi'],
            ['nama' => 'Matematika'],
            ['nama' => 'Manajemen'],
            ['nama' => 'Akuntansi'],
            ['nama' => 'Ekonomi'],
            ['nama' => 'Psikologi'],
            ['nama' => 'Hukum'],
            ['nama' => 'Kedokteran Gigi'],
            ['nama' => 'Teknik Geologi'],
        ]);

        Mahasiswa::insert([
            ['nama' => 'Alice', 'nim' => 'A001', 'program_studi_id' => 1],
            ['nama' => 'Bob', 'nim' => 'A002', 'program_studi_id' => 1],
            ['nama' => 'Charlie', 'nim' => 'A003', 'program_studi_id' => 1],
            ['nama' => 'David', 'nim' => 'A004', 'program_studi_id' => 2],
            ['nama' => 'Eve', 'nim' => 'A005', 'program_studi_id' => 2],
            ['nama' => 'Frank', 'nim' => 'A006', 'program_studi_id' => 2],
            ['nama' => 'Grace', 'nim' => 'A007', 'program_studi_id' => 3],
            ['nama' => 'Henry', 'nim' => 'A008', 'program_studi_id' => 3],
            ['nama' => 'Ivy', 'nim' => 'A009', 'program_studi_id' => 3],
            ['nama' => 'Jack', 'nim' => 'A010', 'program_studi_id' => 4],
            ['nama' => 'Kate', 'nim' => 'A011', 'program_studi_id' => 4],
            ['nama' => 'Luke', 'nim' => 'A012', 'program_studi_id' => 4],
            ['nama' => 'Mary', 'nim' => 'A013', 'program_studi_id' => 5],
            ['nama' => 'Nancy', 'nim' => 'A014', 'program_studi_id' => 5],
            ['nama' => 'Oliver', 'nim' => 'A015', 'program_studi_id' => 5],
            ['nama' => 'Peter', 'nim' => 'A016', 'program_studi_id' => 6],
            ['nama' => 'Queen', 'nim' => 'A017', 'program_studi_id' => 6],
            ['nama' => 'Robert', 'nim' => 'A018', 'program_studi_id' => 6],
            ['nama' => 'Sarah', 'nim' => 'A019', 'program_studi_id' => 7],
            ['nama' => 'Tom', 'nim' => 'A020', 'program_studi_id' => 7],
            ['nama' => 'Ursula', 'nim' => 'A021', 'program_studi_id' => 7],
            ['nama' => 'Victor', 'nim' => 'A022', 'program_studi_id' => 8],
            ['nama' => 'Wendy', 'nim' => 'A023', 'program_studi_id' => 8],
            ['nama' => 'Xavier', 'nim' => 'A024', 'program_studi_id' => 8],
            ['nama' => 'Yuri', 'nim' => 'A025', 'program_studi_id' => 9],
            ['nama' => 'Zoe', 'nim' => 'A026', 'program_studi_id' => 9],
            ['nama' => 'Alpha', 'nim' => 'A027', 'program_studi_id' => 9],
            ['nama' => 'Bravo', 'nim' => 'A028', 'program_studi_id' => 10],
            ['nama' => 'Charlie', 'nim' => 'A029', 'program_studi_id' => 10],
            ['nama' => 'Delta', 'nim' => 'A030', 'program_studi_id' => 10],
            ['nama' => 'Echo', 'nim' => 'A031', 'program_studi_id' => 11],
            ['nama' => 'Foxtrot', 'nim' => 'A032', 'program_studi_id' => 11],
            ['nama' => 'Golf', 'nim' => 'A033', 'program_studi_id' => 11],
            ['nama' => 'Hotel', 'nim' => 'A034', 'program_studi_id' => 12],
            ['nama' => 'India', 'nim' => 'A035', 'program_studi_id' => 12],
            ['nama' => 'Juliet', 'nim' => 'A036', 'program_studi_id' => 12],
            ['nama' => 'Kilo', 'nim' => 'A037', 'program_studi_id' => 13],
            ['nama' => 'Lima', 'nim' => 'A038', 'program_studi_id' => 13],
            ['nama' => 'Mike', 'nim' => 'A039', 'program_studi_id' => 13],
            ['nama' => 'November', 'nim' => 'A040', 'program_studi_id' => 14],
            ['nama' => 'Oscar', 'nim' => 'A041', 'program_studi_id' => 14],
            ['nama' => 'Papa', 'nim' => 'A042', 'program_studi_id' => 14],
            ['nama' => 'Quebec', 'nim' => 'A043', 'program_studi_id' => 15],
            ['nama' => 'Romeo', 'nim' => 'A044', 'program_studi_id' => 15],
            ['nama' => 'Sierra', 'nim' => 'A045', 'program_studi_id' => 15],
        ]);

        MataKuliah::insert([
            ['kode' => 'K001', 'nama' => 'Arsitektur', 'sks' => 3],
            ['kode' => 'K002', 'nama' => 'Pemrograman Dasar', 'sks' => 3],
            ['kode' => 'K003', 'nama' => 'Pemrograman Web', 'sks' => 3],
            ['kode' => 'K004', 'nama' => 'Mesin Cerdas', 'sks' => 3],
            ['kode' => 'K005', 'nama' => 'Kalkulus', 'sks' => 3],
            ['kode' => 'K006', 'nama' => 'Kimia Dasar', 'sks' => 3],
            ['kode' => 'K007', 'nama' => 'Fisika Dasar', 'sks' => 3],
            ['kode' => 'K008', 'nama' => 'Biologi Molekuler', 'sks' => 3],
            ['kode' => 'K009', 'nama' => 'Aljabar', 'sks' => 3],
            ['kode' => 'K010', 'nama' => 'Manajemen Keuangan', 'sks' => 3],
            ['kode' => 'K011', 'nama' => 'Akuntansi Keuangan', 'sks' => 3],
            ['kode' => 'K012', 'nama' => 'Ekonomi Syariah', 'sks' => 3],
            ['kode' => 'K013', 'nama' => 'Sifat Manusia', 'sks' => 3],
            ['kode' => 'K014', 'nama' => 'Kewarganegaraan', 'sks' => 3],
            ['kode' => 'K015', 'nama' => 'Teknik Cabut Gigi', 'sks' => 3],
            ['kode' => 'K016', 'nama' => 'Geologi Dasar', 'sks' => 3],
        ]);

        Nilai::insert([
            ['mahasiswa_id' => 1, 'mata_kuliah_id' => 1, 'nilai' => 90],
            ['mahasiswa_id' => 1, 'mata_kuliah_id' => 2, 'nilai' => 80],
            ['mahasiswa_id' => 1, 'mata_kuliah_id' => 3, 'nilai' => 70],
            ['mahasiswa_id' => 2, 'mata_kuliah_id' => 4, 'nilai' => 60],
            ['mahasiswa_id' => 2, 'mata_kuliah_id' => 5, 'nilai' => 50],
            ['mahasiswa_id' => 2, 'mata_kuliah_id' => 6, 'nilai' => 40],
            ['mahasiswa_id' => 3, 'mata_kuliah_id' => 7, 'nilai' => 30],
            ['mahasiswa_id' => 3, 'mata_kuliah_id' => 8, 'nilai' => 20],
            ['mahasiswa_id' => 3, 'mata_kuliah_id' => 9, 'nilai' => 10],
            ['mahasiswa_id' => 4, 'mata_kuliah_id' => 1, 'nilai' => 90],
            ['mahasiswa_id' => 4, 'mata_kuliah_id' => 2, 'nilai' => 80],
            ['mahasiswa_id' => 4, 'mata_kuliah_id' => 3, 'nilai' => 70],
            ['mahasiswa_id' => 5, 'mata_kuliah_id' => 4, 'nilai' => 60],
            ['mahasiswa_id' => 5, 'mata_kuliah_id' => 5, 'nilai' => 50],
            ['mahasiswa_id' => 5, 'mata_kuliah_id' => 6, 'nilai' => 40],
            ['mahasiswa_id' => 6, 'mata_kuliah_id' => 7, 'nilai' => 30],
            ['mahasiswa_id' => 6, 'mata_kuliah_id' => 8, 'nilai' => 20],
            ['mahasiswa_id' => 6, 'mata_kuliah_id' => 9, 'nilai' => 10],
            ['mahasiswa_id' => 7, 'mata_kuliah_id' => 1, 'nilai' => 90],
            ['mahasiswa_id' => 7, 'mata_kuliah_id' => 2, 'nilai' => 80],
            ['mahasiswa_id' => 7, 'mata_kuliah_id' => 3, 'nilai' => 70],
            ['mahasiswa_id' => 8, 'mata_kuliah_id' => 4, 'nilai' => 60],
            ['mahasiswa_id' => 8, 'mata_kuliah_id' => 5, 'nilai' => 50],
            ['mahasiswa_id' => 8, 'mata_kuliah_id' => 6, 'nilai' => 40],
            ['mahasiswa_id' => 9, 'mata_kuliah_id' => 7, 'nilai' => 30],
            ['mahasiswa_id' => 9, 'mata_kuliah_id' => 8, 'nilai' => 20],
            ['mahasiswa_id' => 9, 'mata_kuliah_id' => 9, 'nilai' => 10],
            ['mahasiswa_id' => 10, 'mata_kuliah_id' => 1, 'nilai' => 90],
            ['mahasiswa_id' => 10, 'mata_kuliah_id' => 2, 'nilai' => 80],
            ['mahasiswa_id' => 10, 'mata_kuliah_id' => 3, 'nilai' => 70],
            ['mahasiswa_id' => 11, 'mata_kuliah_id' => 4, 'nilai' => 60],
        ]);
    }
}
