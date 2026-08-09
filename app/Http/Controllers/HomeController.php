<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $students = [
            'Abdul Halim',
            'Abu Samah Abdul D.',
            'Adli Maulana',
            'Ahmad Ibnul Qoyyim',
            'Alisa Maulida',
            'Anggi Apriliansyah',
            'Asyarafa Dzikrillah',
            'Avreza Fendi Pratama',
            'Bayu Pratama',
            'Chaidir Al Pasha',
            'Cristina Sandi Dely S.',
            'Depita Kalyani',
            'Dian Ayu Oktavia',
            'Furqon',
            'Kurnia',
            'M. Kosim Padli',
            'Medisa Martin',
            'M. Eko Saputra',
            'M. Iqbal Maulana',
            'M. Al Farizzi',
            'M. Farhan Fadillah',
            'M. Haqqin Nazil',
            'M. Naasiq Al Ahsani',
            'M. Raziq Farras',
            'Nabiya Fredella',
            'Nathan Harith Arrarya',
            'Naufal Azfar Riffatin',
            'Nur Abdul Rozak',
            'Raffa Alif Afrilian',
            'Regina Artha Novia',
            'Reza Aditya Gunawan',
            'Riza Akbar Suwarno',
            'Rizky Dwiraya',
            'Sam Rusli',
            'Susilo Agustian',
            'Wisnu Ramadhan',
        ];

        $coreTeam = [
            ['initials' => 'DN', 'name' => 'Dyah Nur Renanda, S.Kom', 'role' => 'Wali Kelas'],
            ['initials' => 'AS', 'name' => 'Abu Samah Abdul Dzohir', 'role' => 'Ketua Kelas'],
            ['initials' => 'RA', 'name' => 'Raffa Alif Afrilian', 'role' => 'Wakil Ketua Kelas'],
            ['initials' => 'DA', 'name' => 'Dian Ayu Oktavia', 'role' => 'Sekretaris'],
            ['initials' => 'NA', 'name' => 'Naufal Azfar Riffatin', 'role' => 'Wakil Sekretaris'],
            ['initials' => 'MM', 'name' => 'Medisa Martin', 'role' => 'Bendahara'],
            ['initials' => 'RA', 'name' => 'Regina Artha Novia', 'role' => 'Wakil Bendahara'],
            ['initials' => 'KU', 'name' => 'Kurnia', 'role' => 'Kebersihan 1'],
            ['initials' => 'DK', 'name' => 'Depita Kalyani', 'role' => 'Kebersihan 2'],
            ['initials' => 'BP', 'name' => 'Bayu Pratama', 'role' => 'Keamanan 1'],
            ['initials' => 'NA', 'name' => 'Naasiq Al Ahsani', 'role' => 'Keamanan 2'],
            ['initials' => 'MR', 'name' => 'Muhammad Raziq Farras', 'role' => 'Kesehatan 1'],
            ['initials' => 'MK', 'name' => 'M. Kosim Fadli', 'role' => 'Kesehatan 2'],
            ['initials' => 'CA', 'name' => 'Chaidir Al Pasha', 'role' => 'Olahraga 1'],
            ['initials' => 'MH', 'name' => 'Muhammad Haqin Nazili', 'role' => 'Olahraga 2'],
        ];

        $organization = [
            [$coreTeam[0]],
            array_slice($coreTeam, 1, 2),
            array_slice($coreTeam, 3, 2),
            array_slice($coreTeam, 5, 2),
            array_slice($coreTeam, 7, 2),
            array_slice($coreTeam, 9, 2),
            array_slice($coreTeam, 11, 2),
            array_slice($coreTeam, 13, 2),
        ];

        $schedule = [
            ['period' => '1 – 2', 'time' => '07.20–08.30', 'days' => ['—', '—', '—', '—', '—']],
            ['period' => '3 – 4', 'time' => '08.30–10.00', 'days' => ['—', '—', '—', '—', '—']],
            ['period' => 'Istirahat', 'time' => '10.00–10.15', 'days' => ['Istirahat', 'Istirahat', 'Istirahat', 'Istirahat', 'Istirahat']],
            ['period' => '5 – 6', 'time' => '10.15–11.45', 'days' => ['—', '—', '—', '—', '—']],
            ['period' => '7 – 8', 'time' => '11.45–13.15', 'days' => ['—', '—', '—', '—', '—']],
        ];

        $duties = [
            ['day' => 'Senin', 'members' => ['Abdul Halim', 'Anggi Apriliansyah', 'Depita Kalyani', 'M. Kosim Padli', 'M. Naasiq Al Ahsani', 'Raffa Alif Afrilian', 'Sam Rusli']],
            ['day' => 'Selasa', 'members' => ['Ahmad Ibnul Qoyyim', 'Chaidir Al Pasha', 'Kurnia', 'M. Iqbal Maulana', 'M. Haqqin Nazili', 'Nathan Harith Arrarya', 'Susilo Agustian', 'Wisnu Ramadhan']],
            ['day' => 'Rabu', 'members' => ['Abu Samah Abdul D.', 'Bayu Prtama', 'Dian Ayu Oktavia', 'M. Al Farizzi', 'Nabiya Fradella', 'Naufal Azfar Riffatin', 'Reza Aditya Gunawan']],
            ['day' => 'Kamis', 'members' => ['Alisa Maulida', 'Avreza Fendi Pratama', 'Furqon', 'M. Eko Saputra', 'M. Farhan Fadillah', 'Regina Artha Novia', 'Rizky Dwiarya']],
            ['day' => 'Jumat', 'members' => ['Adli Maulana', 'Asyarafa Dzikrillah', 'Christina Sandi Dely S.', 'Medisa Martin', 'M. Raziq Farras', 'Nur Abdul Rozak', 'Riza Akbar Suwarno']],
        ];

        return view('home', compact('students', 'organization', 'schedule', 'duties'));
    }
}
