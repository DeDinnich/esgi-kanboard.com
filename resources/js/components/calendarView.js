import { format, startOfMonth, endOfMonth, startOfWeek, endOfWeek, addDays, isSameMonth } from 'date-fns';
import fr from 'date-fns/locale/fr';

export default function initCalendarView() {

    const syncBtn = document.querySelector('#calendar-sync-btn');
    if (!syncBtn) return;

    syncBtn.addEventListener('click', () => {
        const match = window.location.pathname.match(/\/projects\/([^\/]+)\//);
        const projectId = match ? match[1] : null;
        if (!projectId) return alert("ID de projet introuvable dans l'URL");

        const link = document.createElement('a');
        link.href = `/projects/${projectId}/calendar/ical`;
        link.download = `kanboard-${projectId}.ics`;
        link.click();
    });

    const container = document.getElementById('calendar-container');
    const monthLabel = document.getElementById('calendar-month-label');
    const viewMode = document.getElementById('calendar-view-mode');
    const btnPrev = document.getElementById('calendar-prev');
    const btnNext = document.getElementById('calendar-next');

    if (!container || !monthLabel || !viewMode || !btnPrev || !btnNext) return;

    let currentDate = new Date();
    let currentView = localStorage.getItem('calendarView') || 'month';
    viewMode.value = currentView;

    function fetchTasks(start, end) {
        const match = window.location.pathname.match(/\/projects\/([^\/]+)\//);
        const projectId = match ? match[1] : null;

        if (!projectId) {
            console.error('❌ Impossible de récupérer l’ID du projet depuis l’URL.');
            return;
        }

        fetch(`/projects/${projectId}/tasks?start=${start}&end=${end}`)
            .then(res => res.json())
            .then(data => {
                console.log('📦 Tâches chargées', data);
                // TODO: afficher les tâches
            })
            .catch(err => console.error('Erreur fetch tasks:', err));
    }

    function renderMonthView() {
        console.log('📅 Rendu de la vue mois');

        container.innerHTML = '';

        const start = startOfWeek(startOfMonth(currentDate), { locale: fr });
        const end = endOfWeek(endOfMonth(currentDate), { locale: fr });
        fetchTasks(start.toISOString(), end.toISOString());

        let day = start;

        // Titres des jours de la semaine
        const daysRow = document.createElement('div');
        daysRow.className = 'row fw-bold text-center mb-2';
        const daysOfWeek = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        for (let d = 0; d < 7; d++) {
            const dayCol = document.createElement('div');
            dayCol.className = 'col text-center';
            dayCol.textContent = daysOfWeek[d];
            daysRow.appendChild(dayCol);
        }
        container.appendChild(daysRow);

        while (day <= end) {
            const row = document.createElement('div');
            row.className = 'row g-1 mb-1';

            for (let i = 0; i < 7; i++) {
                const col = document.createElement('div');
                col.className = 'col text-center';

                const card = document.createElement('div');
                card.className = 'border rounded p-2 h-100';
                card.style.minHeight = '100px';

                if (!isSameMonth(day, currentDate)) {
                    card.classList.add('bg-light', 'text-muted');
                }

                const dateLabel = document.createElement('div');
                dateLabel.className = 'fw-bold small';
                dateLabel.textContent = format(day, 'd', { locale: fr });

                card.appendChild(dateLabel);
                col.appendChild(card);
                row.appendChild(col);

                day = addDays(day, 1);
            }

            container.appendChild(row);
        }

        console.log('✅ Vue mois affichée');
    }

    function renderWeekView() {
        console.log('📆 Rendu de la vue semaine');
        container.innerHTML = '';

        const start = startOfWeek(currentDate, { locale: fr });
        const end = endOfWeek(currentDate, { locale: fr });
        fetchTasks(start.toISOString(), end.toISOString());
        let day = start;

        const label = `Semaine du ${format(start, 'd')} au ${format(end, 'd MMMM yyyy', { locale: fr })}`;
        monthLabel.textContent = label;

        const daysRow = document.createElement('div');
        daysRow.className = 'row fw-bold text-center mb-2';
        const daysOfWeek = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        for (let d = 0; d < 7; d++) {
            const dayCol = document.createElement('div');
            dayCol.className = 'col text-center';
            dayCol.textContent = daysOfWeek[d];
            daysRow.appendChild(dayCol);
        }
        container.appendChild(daysRow);

        const row = document.createElement('div');
        row.className = 'row g-1 align-items-stretch'; // ⚠️

        for (let i = 0; i < 7; i++) {
            const col = document.createElement('div');
            col.className = 'col text-center d-flex flex-column'; // ⚠️

            const card = document.createElement('div');
            card.className = 'border rounded p-2 flex-fill bg-white'; // ⚠️
            card.style.minHeight = '72vh';

            const dateLabel = document.createElement('div');
            dateLabel.className = 'fw-bold small';
            dateLabel.textContent = format(day, 'd', { locale: fr });

            card.appendChild(dateLabel);
            col.appendChild(card);
            row.appendChild(col);

            day = addDays(day, 1);
        }

        container.appendChild(row);

        console.log('✅ Vue semaine affichée');
    }

    function renderThreeDayView() {
        console.log('🗓️ Rendu de la vue 3 jours');
        container.innerHTML = '';

        // Calcul des 3 jours à afficher
        const center = currentDate;
        const start = addDays(center, -1);
        const end = addDays(center, 2);
        fetchTasks(start.toISOString(), end.toISOString());
        const days = [start, addDays(start, 1), addDays(start, 2)];

        // Label en haut
        const label = `Du ${format(start, 'd')} au ${format(addDays(start, 2), 'd MMMM yyyy', { locale: fr })}`;
        monthLabel.textContent = label;

        const row = document.createElement('div');
        row.className = 'row g-1 align-items-stretch';

        // --- Mini calendrier sur 4 colonnes
        const calendarCol = document.createElement('div');
        calendarCol.className = 'col-12 col-md-4';

        const calendarCard = document.createElement('div');
        calendarCard.className = 'border rounded p-2';

        const calTitle = document.createElement('div');
        calTitle.className = 'fw-bold mb-2';
        calTitle.textContent = format(currentDate, 'MMMM yyyy', { locale: fr });
        calendarCard.appendChild(calTitle);

        // Titres des jours
        const daysRow = document.createElement('div');
        daysRow.className = 'd-flex mb-1 gap-1 fw-bold text-center';
        const daysOfWeek = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        for (let d = 0; d < 7; d++) {
            const dayCol = document.createElement('div');
            dayCol.className = 'flex-fill small text-center';
            dayCol.textContent = daysOfWeek[d];
            daysRow.appendChild(dayCol);
        }
        calendarCard.appendChild(daysRow);

        // Mini calendrier
        const startMonth = startOfWeek(startOfMonth(currentDate), { locale: fr });
        const endMonth = endOfWeek(endOfMonth(currentDate), { locale: fr });

        let calDay = startMonth;
        while (calDay <= endMonth) {
            const weekRow = document.createElement('div');
            weekRow.className = 'd-flex mb-1 gap-1';

            for (let i = 0; i < 7; i++) {
                const dayDiv = document.createElement('div');
                dayDiv.className = 'text-center border rounded flex-fill py-1 small';

                if (isSameMonth(calDay, currentDate)) {
                    dayDiv.textContent = format(calDay, 'd', { locale: fr });
                } else {
                    dayDiv.classList.add('invisible'); // Ne pas afficher les jours hors mois
                    dayDiv.textContent = '.'; // nécessaire pour la hauteur
                }

                weekRow.appendChild(dayDiv);
                calDay = addDays(calDay, 1);
            }

            calendarCard.appendChild(weekRow);
        }

        calendarCol.appendChild(calendarCard);
        row.appendChild(calendarCol);

        // --- 3 colonnes : jours détaillés
        for (let i = 0; i < 3; i++) {
            const col = document.createElement('div');
            col.className = 'col text-center d-flex flex-column';

            const card = document.createElement('div');
            card.className = 'border rounded p-2 flex-fill bg-white';
            card.style.minHeight = '72vh';

            const dateLabel = document.createElement('div');
            dateLabel.className = 'fw-bold small mb-2';
            dateLabel.textContent = format(days[i], 'EEEE d', { locale: fr });

            card.appendChild(dateLabel);
            col.appendChild(card);
            row.appendChild(col);
        }

        container.appendChild(row);

        console.log('✅ Vue 3 jours affichée');
    }

    function renderDayView() {
        console.log('📆 Rendu de la vue jour');
        container.innerHTML = '';

        const start = currentDate;
        const end = currentDate;
        fetchTasks(start.toISOString(), end.toISOString());

        // Label global
        monthLabel.textContent = `Jour du ${format(currentDate, 'd MMMM yyyy', { locale: fr })}`;

        const row = document.createElement('div');
        row.className = 'row g-1 align-items-stretch';

        // --- Mini calendrier sur 4 colonnes
        const calendarCol = document.createElement('div');
        calendarCol.className = 'col-12 col-md-4';

        const calendarCard = document.createElement('div');
        calendarCard.className = 'border rounded p-2';

        const calTitle = document.createElement('div');
        calTitle.className = 'fw-bold mb-2';
        calTitle.textContent = format(currentDate, 'MMMM yyyy', { locale: fr });
        calendarCard.appendChild(calTitle);

        // Mini calendrier
        const startMonth = startOfWeek(startOfMonth(currentDate), { locale: fr });
        const endMonth = endOfWeek(endOfMonth(currentDate), { locale: fr });

        let calDay = startMonth;
        while (calDay <= endMonth) {
            const weekRow = document.createElement('div');
            weekRow.className = 'd-flex mb-1 gap-1';

            for (let i = 0; i < 7; i++) {
                const dayDiv = document.createElement('div');
                dayDiv.className = 'text-center border rounded flex-fill py-1 small';

                if (isSameMonth(calDay, currentDate)) {
                    dayDiv.textContent = format(calDay, 'd', { locale: fr });
                } else {
                    dayDiv.classList.add('invisible'); // Ne pas afficher les jours hors mois
                    dayDiv.textContent = '.'; // nécessaire pour la hauteur
                }

                weekRow.appendChild(dayDiv);
                calDay = addDays(calDay, 1);
            }

            calendarCard.appendChild(weekRow);
        }

        calendarCol.appendChild(calendarCard);
        row.appendChild(calendarCol);

        // --- Détail du jour sur 3 colonnes
        const detailCol = document.createElement('div');
        detailCol.className = 'col-12 col-md-8 d-flex flex-column';

        const dayCard = document.createElement('div');
        dayCard.className = 'border rounded p-3 flex-fill bg-white';
        dayCard.style.minHeight = '72vh';

        const dateLabel = document.createElement('div');
        dateLabel.className = 'fw-bold mb-2';
        dateLabel.textContent = format(currentDate, 'EEEE d MMMM yyyy', { locale: fr });

        dayCard.appendChild(dateLabel);
        detailCol.appendChild(dayCard);
        row.appendChild(detailCol);

        container.appendChild(row);

        console.log('✅ Vue jour affichée');
    }

    function renderCalendar() {
        if (currentView === 'month') {
            monthLabel.textContent = format(currentDate, 'MMMM yyyy', { locale: fr });
            renderMonthView();
        } else if (currentView === 'week') {
            renderWeekView();
        } else if (currentView === '3days') {
            renderThreeDayView();
        }
        else if (currentView === 'day') {
            renderDayView();
        }
    }

    btnPrev.addEventListener('click', () => {
        if (currentView === 'month') {
            currentDate.setMonth(currentDate.getMonth() - 1);
        } else if (currentView === 'week') {
            currentDate.setDate(currentDate.getDate() - 7);
        } else if (currentView === '3days') {
            currentDate.setDate(currentDate.getDate() - 3);
        } else if (currentView === 'day') {
            currentDate.setDate(currentDate.getDate() - 1);
        }
        renderCalendar();
    });

    btnNext.addEventListener('click', () => {
        if (currentView === 'month') {
            currentDate.setMonth(currentDate.getMonth() + 1);
        } else if (currentView === 'week') {
            currentDate.setDate(currentDate.getDate() + 7);
        } else if (currentView === '3days') {
            currentDate.setDate(currentDate.getDate() + 3);
        } else if (currentView === 'day') {
            currentDate.setDate(currentDate.getDate() + 1);
        }
        renderCalendar();
    });

    viewMode.addEventListener('change', (e) => {
        currentView = e.target.value;
        localStorage.setItem('calendarView', currentView); // 💾 Enregistrer dans le stockage
        renderCalendar();
    });

    renderCalendar();
}
