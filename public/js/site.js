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

    const allNavLinks = document.querySelectorAll(
    '.nav-links a, [data-mobile-link]'
);

const sectionTitles = {
    beranda: 'Beranda',
    anggota: 'Anggota',
    jadwal: 'Jadwal',
    kesepakatan: 'Kesepakatan'
};

const updateSection = () => {
    let current = 'beranda';

    document.querySelectorAll('header[id], section[id]').forEach((section) => {
        const sectionTop = section.offsetTop - 150;

        if (window.scrollY >= sectionTop) {
            current = section.id;
        }
    });

    allNavLinks.forEach((link) => {
        link.classList.toggle(
            'active',
            link.getAttribute('href') === `#${current}`
        );
    });

    document.title = `Kelas XI RPL 2 — ${
        sectionTitles[current] || 'Beranda'
    }`;

    const newHash = current === 'beranda' ? '' : `#${current}`;

    if (window.location.hash !== newHash) {
        history.replaceState(null, '', `${window.location.pathname}${newHash}`);
    }
};

window.addEventListener('scroll', updateSection);
updateSection();

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
const schedule = JSON.parse(card.dataset.schedule);

const days = [
    'Minggu',
    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu'
];

const highlightTodaySchedule = () => {
    const now = new Date();
    const today = days[now.getDay()];

    const table = document.querySelector('#lessons table');

    if (!table) return;

    const headers = table.querySelectorAll('thead th');
    const rows = table.querySelectorAll('tbody tr');

    let todayIndex = -1;

    headers.forEach((header, index) => {
        const isToday = header.dataset.day === today;

        header.classList.toggle('today-column', isToday);

        if (isToday) {
            todayIndex = index;
        }
    });

    rows.forEach((row) => {
        row.querySelectorAll('td').forEach((cell, index) => {
            cell.classList.toggle(
                'today-column',
                index === todayIndex
            );
        });
    });
};

highlightTodaySchedule();

setInterval(highlightTodaySchedule, 60000);

const renderToday = () => {
    const now = new Date();

    const day = days[now.getDay()];

    const duty = duties.find((item) => item.day === day);

    const date = now.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });

    const clock = now.toLocaleTimeString('id-ID', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
});

    const todayLessons = schedule
        .map((period) => {
            const dayIndex = days.indexOf(day);

            if (dayIndex === -1 || !period.days) {
                return null;
            }

            return {
                period: period.period,
                time: period.time,
                lesson: period.days[dayIndex]
            };
        })
        .filter((item) => item && item.lesson && item.lesson !== '-');

    card.innerHTML = `
        <header class="today-header">
            <div>
                <small>
                    <span class="live-dot"></span>
                    Jadwal hari ini
                </small>

                <h3>
                    ${day}
                    <span class="text-white-50 fw-normal fs-6">
                        ${date}
                    </span>
                </h3>
            </div>

            <span class="live" id="realtimeClock">
    <i class="bi bi-clock-history"></i> 00:00:00
</span>
        </header>

        <div class="mt-3">
            <small class="text-uppercase text-white-50">
                Piket hari ini
            </small>

            ${
                duty
                    ? `
                        <div class="duty-chips">
                            ${duty.members
                                .map(
                                    (name, index) =>
                                        `<span>${index + 1}. ${name}</span>`
                                )
                                .join('')}
                        </div>
                    `
                    : `
                        <p class="mb-0 mt-2 text-white-50">
                            Tidak ada jadwal piket hari ini.
                        </p>
                    `
            }
        </div>

        <div class="today-schedule-dropdown">

    <button type="button" class="today-schedule-toggle">
        <span>
            <i class="bi bi-journal-bookmark-fill"></i>
            Jadwal Pelajaran Hari Ini
        </span>

        <i class="bi bi-chevron-down"></i>
    </button>

    <div class="today-schedule-content">

        <div class="table-wrap">

            <table class="today-schedule-table">

                <thead>
                    <tr>
                        <th>Jam</th>
                        <th>Mata Pelajaran</th>
                    </tr>
                </thead>

                <tbody>
    ${todayLessons.map(item => `
        <tr>
            <td>
                <strong>${item.period}</strong>
                <small>${item.time}</small>
            </td>

            <td>
                ${item.lesson}
            </td>
        </tr>
    `).join('')}
</tbody>

            </table>

        </div>

    </div>

</div>
    `;

const scheduleToggle = document.querySelector('.today-schedule-toggle');
const scheduleContent = document.querySelector('.today-schedule-content');
const scheduleClose = document.querySelector('.today-schedule-close');

scheduleToggle?.addEventListener('click', () => {
    scheduleContent.classList.add('open');
    scheduleToggle.classList.add('open');
});

scheduleClose?.addEventListener('click', () => {
    scheduleContent.classList.remove('open');
    scheduleToggle.classList.remove('open');
});

    document
        .querySelectorAll('[data-duty-day]')
        .forEach((row) =>
            row.classList.toggle(
                'today-row',
                row.dataset.dutyDay === day
            )
        );
};

renderToday();

const updateClock = () => {
    const now = new Date();

    const clock = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });

    const clockElement = document.getElementById('realtimeClock');

    if (clockElement) {
        clockElement.innerHTML = `
            <i class="bi bi-clock-history"></i> ${clock}
        `;
    }
};

updateClock();
window.setInterval(updateClock, 1000);
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

window.addEventListener('load', () => {
    if (window.location.hash) {
        history.replaceState(null, '', window.location.pathname);
        document.title = 'Kelas XI RPL 2 — Beranda';
    }

    window.scrollTo(0, 0);
});
