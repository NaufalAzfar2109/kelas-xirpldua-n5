if (window.location.hash) {
    history.replaceState(null, '', window.location.pathname);
}

if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
}

window.addEventListener('beforeunload', () => {
    window.scrollTo(0, 0);
});

window.addEventListener('load', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('mainNavbar');
    const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 30);
    window.addEventListener('scroll', onScroll);
    onScroll();

const revealObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            } else {
                entry.target.classList.remove('visible');
            }
        });
    },
    {
        threshold: 0.15
    }
);

document.querySelectorAll('.reveal').forEach((element) => {
    revealObserver.observe(element);
});

    const descriptions = {
        lessons: 'Jadwal pelajaran Kelas XI RPL 2, berlaku setiap hari Senin hingga Jumat.',
        duties: 'Jadwal piket kebersihan kelas, bergiliran setiap hari Senin hingga Jumat.',
    };
    document.querySelectorAll('[data-tab]').forEach((button) => button.addEventListener('click', () => {
        const tab = button.dataset.tab;
        document.querySelectorAll('[data-tab]').forEach((item) => item.classList.toggle('active', item === button));
        document.querySelectorAll('.tab-panel').forEach((panel) => panel.classList.toggle('d-none', panel.id !== tab));
        document.getElementById('tabDescription').textContent = descriptions[tab];
    }));

    const card = document.getElementById('todayCard');
    const duties = JSON.parse(card.dataset.duties);
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const renderToday = () => {
        const now = new Date();
        const day = days[now.getDay()];
        const duty = duties.find((item) => item.day === day);
        const date = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        const clock = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        card.innerHTML = `<header><div><small><i class="bi bi-broadcast-pin"></i> Jadwal hari ini · Real-time</small><h3>${day} <span class="text-white-50 fw-normal fs-6">${date}</span></h3></div><span class="live"><i class="bi bi-clock-history"></i> ${clock}</span></header>${duty ? `<div class="mt-3"><small class="text-uppercase text-white-50">Piket hari ini</small><div class="duty-chips">${duty.members.map((name, index) => `<span>${index + 1}. ${name}</span>`).join('')}</div></div>` : '<p class="mb-0 mt-3 text-white-50">Tidak ada jadwal piket hari ini. Selamat beristirahat!</p>'}`;
        document.querySelectorAll('[data-duty-day]').forEach((row) => row.classList.toggle('today-row', row.dataset.dutyDay === day));
    };
    renderToday();
    window.setInterval(renderToday, 1000);
});
    document.querySelectorAll('[data-mobile-link]').forEach((link) => link.addEventListener('click', () => {
        const menu = document.getElementById('mobileMenu');
        window.bootstrap?.Offcanvas.getOrCreateInstance(menu).hide();
    }));

const sectionTitles = {
    beranda: 'Beranda',
    anggota: 'Anggota',
    jadwal: 'Jadwal',
    struktur: 'Struktur',
    kesepakatan: 'Kesepakatan'
};

const updateTitle = () => {
    const section = window.location.hash.substring(1) || 'beranda';
    document.title = `Kelas XI RPL 2 — ${
        sectionTitles[section] || 'Beranda'
    }`;
};

updateTitle();

window.addEventListener('hashchange', updateTitle);

window.addEventListener('load', () => {
    if (window.location.hash) {
        history.replaceState(null, '', window.location.pathname);
        document.title = 'Kelas XI RPL 2 — Beranda';
    }

    window.scrollTo(0, 0);
});
