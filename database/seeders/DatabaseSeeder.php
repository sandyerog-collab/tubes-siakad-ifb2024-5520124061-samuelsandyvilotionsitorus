<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
    {
        public function run(): void
        {
            DB::transaction(function (): void {
                $now = now();

                DB::table('users')->updateOrInsert(
                    ['email' => 'admin@siakad.test'],
                    [
                        'name' => 'Admin SIAKAD',
                        'password' => Hash::make('Admin12345!'),
                        'role' => 'admin',
                        'npm' => null,
                        'updated_at' => $now,
                        'created_at' => $now,
                    ]
                );

                $dosen = [
                    ['nidn' => '0401019001', 'nama' => 'Dr. Andi Pratama, M.Kom.'],
                    ['nidn' => '0402028802', 'nama' => 'Rina Oktaviani, M.T.'],
                    ['nidn' => '0403038703', 'nama' => 'Dedi Kurniawan, M.Kom.'],
                    ['nidn' => '0404049104', 'nama' => 'Siti Rahmawati, M.T.'],
                    ['nidn' => '0405058605', 'nama' => 'Budi Santoso, M.Kom.'],
                ];

                foreach ($dosen as $item) {
                    DB::table('dosen')->updateOrInsert(
                        ['nidn' => $item['nidn']],
                        [
                            'nama' => $item['nama'],
                            'updated_at' => $now,
                            'created_at' => $now,
                        ]
                    );
                }

                $mahasiswa = [
                    ['npm' => '5520124001', 'nama' => 'Ahmad Fajar Nugraha'],
                    ['npm' => '5520124002', 'nama' => 'Nabila Putri Azzahra'],
                    ['npm' => '5520124003', 'nama' => 'Rizky Maulana'],
                    ['npm' => '5520124004', 'nama' => 'Aulia Rahman'],
                    ['npm' => '5520124005', 'nama' => 'Dinda Maharani'],
                    ['npm' => '5520124006', 'nama' => 'Fikri Ramadhan'],
                    ['npm' => '5520124007', 'nama' => 'Salsa Nurhaliza'],
                    ['npm' => '5520124008', 'nama' => 'Bagas Aditya'],
                    ['npm' => '5520124009', 'nama' => 'Putri Amelia'],
                    ['npm' => '5520124010', 'nama' => 'Reza Firmansyah'],
                    ['npm' => '5520124011', 'nama' => 'Surya Pratama'],
                ];

                foreach ($mahasiswa as $index => $item) {
                    DB::table('mahasiswa')->updateOrInsert(
                        ['npm' => $item['npm']],
                        [
                            'nama' => $item['nama'],
                            'updated_at' => $now,
                            'created_at' => $now,
                        ]
                    );

                    // Semua mahasiswa juga dibuatkan akun login.
                    $email = $item['npm'] === '5520124011'
                        ? 'mahasiswa@siakad.test'
                        : 'mahasiswa' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . '@siakad.test';

                    DB::table('users')->updateOrInsert(
                        ['email' => $email],
                        [
                            'name' => $item['nama'],
                            'password' => Hash::make('Mahasiswa12345!'),
                            'role' => 'mahasiswa',
                            'npm' => $item['npm'],
                            'updated_at' => $now,
                            'created_at' => $now,
                        ]
                    );
                }

                // =========================
                // 4. DATA MATA KULIAH
                // =========================
                $matakuliah = [
                    ['kode_matakuliah' => 'IFB2401', 'nama_matakuliah' => 'Pemrograman Web Lanjut', 'sks' => 3],
                    ['kode_matakuliah' => 'IFB2402', 'nama_matakuliah' => 'Basis Data Lanjut', 'sks' => 3],
                    ['kode_matakuliah' => 'IFB2403', 'nama_matakuliah' => 'Struktur Data', 'sks' => 3],
                    ['kode_matakuliah' => 'IFB2404', 'nama_matakuliah' => 'Jaringan Komputer', 'sks' => 3],
                    ['kode_matakuliah' => 'IFB2405', 'nama_matakuliah' => 'Rekayasa Perangkat Lunak', 'sks' => 3],
                    ['kode_matakuliah' => 'IFB2406', 'nama_matakuliah' => 'Multimedia', 'sks' => 2],
                    ['kode_matakuliah' => 'IFB2407', 'nama_matakuliah' => 'Sistem Operasi', 'sks' => 3],
                    ['kode_matakuliah' => 'IFB2408', 'nama_matakuliah' => 'Teori Bahasa dan Otomata', 'sks' => 3],
                    ['kode_matakuliah' => 'IFB2409', 'nama_matakuliah' => 'Strategi Algoritma', 'sks' => 3],
                    ['kode_matakuliah' => 'IFB2410', 'nama_matakuliah' => 'Interaksi Manusia dan Komputer', 'sks' => 2],
                ];

                foreach ($matakuliah as $item) {
                    DB::table('matakuliah')->updateOrInsert(
                        ['kode_matakuliah' => $item['kode_matakuliah']],
                        [
                            'nama_matakuliah' => $item['nama_matakuliah'],
                            'sks' => $item['sks'],
                            'updated_at' => $now,
                            'created_at' => $now,
                        ]
                    );
                }

                // =========================
                // 5. DATA JADWAL
                // =========================
                $jadwal = [
                    ['kode_matakuliah' => 'IFB2401', 'nidn' => '0401019001', 'kelas' => 'IFB-24A', 'hari' => 'Senin',  'jam' => '08:00:00'],
                    ['kode_matakuliah' => 'IFB2402', 'nidn' => '0402028802', 'kelas' => 'IFB-24A', 'hari' => 'Senin',  'jam' => '10:30:00'],
                    ['kode_matakuliah' => 'IFB2403', 'nidn' => '0403038703', 'kelas' => 'IFB-24A', 'hari' => 'Selasa', 'jam' => '08:00:00'],
                    ['kode_matakuliah' => 'IFB2404', 'nidn' => '0404049104', 'kelas' => 'IFB-24A', 'hari' => 'Selasa', 'jam' => '13:00:00'],
                    ['kode_matakuliah' => 'IFB2405', 'nidn' => '0405058605', 'kelas' => 'IFB-24A', 'hari' => 'Rabu',   'jam' => '08:00:00'],
                    ['kode_matakuliah' => 'IFB2406', 'nidn' => '0401019001', 'kelas' => 'IFB-24A', 'hari' => 'Rabu',   'jam' => '10:30:00'],
                    ['kode_matakuliah' => 'IFB2407', 'nidn' => '0402028802', 'kelas' => 'IFB-24A', 'hari' => 'Kamis',  'jam' => '08:00:00'],
                    ['kode_matakuliah' => 'IFB2408', 'nidn' => '0403038703', 'kelas' => 'IFB-24A', 'hari' => 'Kamis',  'jam' => '13:00:00'],
                    ['kode_matakuliah' => 'IFB2409', 'nidn' => '0404049104', 'kelas' => 'IFB-24A', 'hari' => 'Jumat',  'jam' => '08:00:00'],
                    ['kode_matakuliah' => 'IFB2410', 'nidn' => '0405058605', 'kelas' => 'IFB-24A', 'hari' => 'Jumat',  'jam' => '10:30:00'],
                ];

                foreach ($jadwal as $item) {
                    DB::table('jadwal')->updateOrInsert(
                        [
                            'kode_matakuliah' => $item['kode_matakuliah'],
                            'kelas' => $item['kelas'],
                        ],
                        [
                            'nidn' => $item['nidn'],
                            'hari' => $item['hari'],
                            'jam' => $item['jam'],
                            'updated_at' => $now,
                            'created_at' => $now,
                        ]
                    );
                }

                $paketKrs = [
                    ['IFB2401', 'IFB2402', 'IFB2403', 'IFB2404'],
                    ['IFB2401', 'IFB2403', 'IFB2405', 'IFB2406'],
                    ['IFB2402', 'IFB2404', 'IFB2407', 'IFB2408'],
                    ['IFB2401', 'IFB2405', 'IFB2408', 'IFB2409'],
                    ['IFB2402', 'IFB2403', 'IFB2406', 'IFB2410'],
                    ['IFB2401', 'IFB2404', 'IFB2407', 'IFB2409'],
                    ['IFB2403', 'IFB2405', 'IFB2408', 'IFB2410'],
                    ['IFB2402', 'IFB2404', 'IFB2406', 'IFB2409'],
                    ['IFB2401', 'IFB2403', 'IFB2407', 'IFB2410'],
                    ['IFB2402', 'IFB2405', 'IFB2408', 'IFB2409'],
                    ['IFB2401', 'IFB2402', 'IFB2405', 'IFB2406', 'IFB2410'],
                ];

                foreach ($mahasiswa as $index => $mhs) {
                    foreach ($paketKrs[$index] as $kodeMatakuliah) {
                        DB::table('krs')->updateOrInsert(
                            [
                                'npm' => $mhs['npm'],
                                'kode_matakuliah' => $kodeMatakuliah,
                            ],
                            [
                                'updated_at' => $now,
                                'created_at' => $now,
                            ]
                        );
                    }
                }
            });

            $this->command?->info('Data berhasil ditambahkan.');
        }
    }