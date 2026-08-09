@extends('layouts.app')

@section('title', 'Kelas XI RPL 2 — Beranda')

@section('content')
    <nav class="site-nav" id="mainNavbar">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="#beranda" class="brand"><img src="../images/logo_rounded.png" alt="logo" style="width: 3rem;"></span><span>Kelas
                    XI RPL 2<small>SMK · Rekayasa Perangkat Lunak</small></span></a>
            <div class="nav-links d-none d-lg-flex"><a href="#beranda">Beranda</a><a href="#anggota">Anggota</a><a
                    href="#jadwal">Jadwal</a><a href="#kesepakatan">Kesepakatan</a></div>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                aria-label="Buka menu"><i class="bi bi-list"></i></button>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header"><strong>Kelas XI RPL 2</strong><button type="button"
                class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button></div>
        <div class="offcanvas-body d-flex flex-column gap-3 fs-5"><a href="#beranda" data-mobile-link>Beranda</a><a
                href="#anggota" data-mobile-link>Anggota</a><a href="#jadwal" data-mobile-link>Jadwal</a><a
                href="#kesepakatan" data-mobile-link>Kesepakatan</a></div>
    </div>

    <header class="hero" id="beranda">
        <div class="hero-shade"></div>
        <div class="container position-relative hero-content">
            <div class="col-lg-8 px-0">
                <div class="eyebrow"><span></span> Hi, Visitor!</div>
                <h1><em>WELCOME</em><br>TO XI RPL 2</h1>
                <p>Ruang digital resmi Kelas XI RPL 2 — tempat kami berbagi jadwal, anggota, dan kesepakatan kelas dalam
                    satu halaman yang rapi dan mudah diakses.</p>
                <span class="year-badge"><i class="bi bi-calendar3"></i> Tahun Ajaran 2025 / 2026</span>
            </div>
            <div class="row g-3 pt-5 mt-3">
                <div class="col-md-4">
                    <div class="stat-card"><i class="bi bi-people-fill"></i>
                        <div><b>{{ count($students) }}</b><span>Jumlah Siswa</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card"><i class="bi bi-journal-bookmark-fill"></i>
                        <div><b>15</b><span>Jumlah Mapel</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card"><i class="bi bi-person-video3"></i>
                        <div><b>12</b><span>Jumlah Guru Pengajar</span></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="anggota" class="section">
        <div class="container">
            <div class="eyebrow reveal"><span></span> Anggota Kelas</div>
            <h2 class="reveal">Kenali Teman Sekelas</h2>
            <p class="lead-text reveal">36 siswa, satu tujuan. Berikut struktur inti dan daftar lengkap anggota Kelas XI RPL
                2.</p>
            <div class="org-chart reveal" aria-label="Struktur organisasi kelas">
                @foreach ($organization as $level)
                    <div class="org-level {{ count($level) === 1 ? 'org-root' : '' }}">
                        @foreach ($level as $member)
                            <article class="org-card"><b>{{ $member['name'] }}</b><span>{{ $member['role'] }}</span>
                            </article>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <h3 class="roster-heading reveal"><i class="bi bi-people-fill"></i> Seluruh Anggota</h3>
            <div class="roster reveal">
                @foreach ($students as $student)
                    <div>
                        <small>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</small><span>{{ $student }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="jadwal" class="section schedule-section">
        <div class="container">
            <div class="eyebrow reveal"><span></span> Jadwal Pelajaran & Piket</div>
            <div class="tabs reveal"><button class="active" data-tab="lessons">Pelajaran</button><i>/</i><button
                    data-tab="duties">Piket</button></div>
            <p id="tabDescription" class="lead-text reveal">Jadwal pelajaran Kelas XI RPL 2, berlaku setiap hari Senin
                hingga Jumat.</p>
            <article class="today-card reveal" id="todayCard" data-duties='@json($duties)'></article>
            <div id="lessons" class="tab-panel reveal">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Jam Ke</th>
                                <th>Senin</th>
                                <th>Selasa</th>
                                <th>Rabu</th>
                                <th>Kamis</th>
                                <th>Jumat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedule as $period)
                                <tr class="{{ $period['period'] === 'Istirahat' ? 'break-row' : '' }}">
                                    <td><strong>{{ $period['period'] }}</strong><small>{{ $period['time'] }}</small></td>
                                    @foreach ($period['days'] as $lesson)
                                        <td>{{ $lesson }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="duties" class="tab-panel d-none reveal">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Petugas Piket</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($duties as $duty)
                                <tr data-duty-day="{{ $duty['day'] }}">
                                    <td><strong>{{ $duty['day'] }}</strong></td>
                                    <td>
                                        <div class="duty-columns">
                                            @foreach (array_chunk($duty['members'], (int) ceil(count($duty['members']) / 2)) as $column)
                                                <ol class="duty-list"
                                                    start="{{ $loop->index * (int) ceil(count($duty['members']) / 2) + 1 }}">
                                                    @foreach ($column as $member)
                                                        <li>{{ $member }}</li>
                                                    @endforeach
                                                </ol>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section id="kesepakatan" class="section">
        <div class="container">
            <div class="eyebrow reveal"><span></span> Kesepakatan Kelas</div>
            <h2 class="reveal">Komitmen Bersama</h2>
            <p class="lead-text reveal">Poin-poin berikut telah disepakati dan disetujui oleh seluruh anggota Kelas XI RPL
                2.</p>
            @php($agreements = ['Hadir di kelas tepat waktu, maksimal toleransi keterlambatan 10 menit.', 'Menjaga kebersihan dan kerapian ruang kelas setiap saat.'])
            <ol class="agreements reveal">
                @foreach ($agreements as $agreement)
                    <li><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <p>{{ $agreement }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <footer>
        <div class="container footer-content">
            <div class="footer-brand"><b>KELAS XI RPL 2</b>
                <p>“RPL! Luarbiasa!”</p>
            </div><small>© 2026 Kelas XI RPL 2 <span>|</span> Di Kelola Oleh Siswa RPL 2</small><a class="instagram-link"
                href="https://instagram.com/xirpl2" target="_blank" rel="noopener noreferrer"
                aria-label="Instagram Kelas XI RPL 2"><i class="bi bi-instagram"></i> <span>@https.xirpl2</span></a>
        </div>
    </footer>
@endsection
