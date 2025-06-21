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

    let loadedTasks = [];

    const taskByDate = (date) => {
        const dayStr = format(date, 'yyyy-MM-dd');
        return loadedTasks.filter(t => t.date_limite?.startsWith(dayStr));
    };

    function fetchTasks(start, end) {
        const match = window.location.pathname.match(/\/projects\/([^\/]+)\//);
        const projectId = match ? match[1] : null;

        if (!projectId) return console.error('❌ Impossible de récupérer l’ID du projet depuis l’URL.');

        return fetch(`/projects/${projectId}/tasks?start=${start}&end=${end}`)
            .then(res => res.json())
            .then(data => {
                loadedTasks = data;
            })
            .catch(err => console.error('Erreur fetch tasks:', err));
    }

        function buildTaskModal(date, tasks) {
        const id = `modal-tasks-${format(date, 'yyyy-MM-dd')}`;
        if (document.getElementById(id)) return; // Déjà existant

        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = id;
        modal.tabIndex = -1;

        modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tâches du ${format(date, 'dd/MM/yyyy')}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        ${tasks.length === 0 ? '<p class="text-muted">Aucune tâche.</p>' : `
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead><tr><th>Nom</th><th>Priorité</th><th>Collaborateurs</th></tr></thead>
                                    <tbody>
                                        ${tasks.map(t => `
                                            <tr>
                                                <td>${t.nom}</td>
                                                <td>${t.priority ?? '—'}</td>
                                                <td>${t.collaborateurs?.map(c => `${c.first_name} ${c.last_name}`).join(', ')}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        `}
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
    }

    function renderMonthView() {
        console.log('📅 Rendu de la vue mois');
        container.innerHTML = '';

        const start = startOfWeek(startOfMonth(currentDate), { locale: fr });
        const end = endOfWeek(endOfMonth(currentDate), { locale: fr });

        fetchTasks(start.toISOString(), end.toISOString()).then(() => {
            monthLabel.textContent = format(currentDate, 'MMMM yyyy', { locale: fr });

            let day = start;

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

                    const tasks = taskByDate(day);
                    if (tasks.length > 0) {
                        const btn = document.createElement('button');
                        btn.className = 'btn btn-sm btn-outline-primary mt-2';
                        btn.textContent = `${tasks.length} tâche(s)`;
                        btn.dataset.bsToggle = 'modal';
                        btn.dataset.bsTarget = `#modal-tasks-${format(day, 'yyyy-MM-dd')}`;

                        card.appendChild(btn);
                        buildTaskModal(day, tasks);
                    }

                    col.appendChild(card);
                    row.appendChild(col);

                    day = addDays(day, 1);
                }

                container.appendChild(row);
            }

            console.log('✅ Vue mois affichée');
        });
    }

    // --- renderWeekView ---
    function renderWeekView() {
        console.log('📆 Rendu de la vue semaine');
        container.innerHTML = '';

        const start = startOfWeek(currentDate, { locale: fr });
        const end = endOfWeek(currentDate, { locale: fr });

        fetchTasks(start.toISOString(), end.toISOString()).then(() => {
            monthLabel.textContent = `Semaine du ${format(start, 'd')} au ${format(end, 'd MMMM yyyy', { locale: fr })}`;

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
            row.className = 'row g-1 align-items-stretch';

            let day = start;
            for (let i = 0; i < 7; i++) {
                const col = document.createElement('div');
                col.className = 'col text-center d-flex flex-column';

                const card = document.createElement('div');
                card.className = 'border rounded p-2 flex-fill bg-white';
                card.style.minHeight = '72vh';

                const dateLabel = document.createElement('div');
                dateLabel.className = 'fw-bold small';
                dateLabel.textContent = format(day, 'd', { locale: fr });

                card.appendChild(dateLabel);

                const tasks = taskByDate(day);
                tasks.forEach(task => {
                    const taskDiv = document.createElement('div');
                    taskDiv.className = 'task-card p-2 border rounded bg-light text-start mb-2';
                    taskDiv.innerHTML = `<strong>${task.nom}</strong><br><small>${task.priority}</small>`;
                    taskDiv.dataset.bsToggle = 'modal';
                    taskDiv.dataset.bsTarget = `#modal-tasks-${format(day,'yyyy-MM-dd')}`;
                    card.appendChild(taskDiv);
                });

                if (tasks.length > 0) buildTaskModal(day, tasks);

                col.appendChild(card);
                row.appendChild(col);
                day = addDays(day, 1);
            }

            container.appendChild(row);
            console.log('✅ Vue semaine affichée');
        });
    }

    // --- renderThreeDayView ---
    function renderThreeDayView() {
        console.log('🗓️ Rendu de la vue 3 jours');
        container.innerHTML = '';

        const center = currentDate;
        const start = addDays(center, -1);
        const end = addDays(center, 2);
        const days = [start, addDays(start, 1), addDays(start, 2)];

        fetchTasks(start.toISOString(), end.toISOString()).then(() => {
            monthLabel.textContent = `Du ${format(start, 'd')} au ${format(end, 'd MMMM yyyy', { locale: fr })}`;

            const row = document.createElement('div');
            row.className = 'row g-1 align-items-stretch';

            const calendarCol = document.createElement('div');
            calendarCol.className = 'col-12 col-md-4';
            const calendarCard = document.createElement('div');
            calendarCard.className = 'border rounded p-2';

            const calTitle = document.createElement('div');
            calTitle.className = 'fw-bold mb-2';
            calTitle.textContent = format(currentDate, 'MMMM yyyy', { locale: fr });
            calendarCard.appendChild(calTitle);

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

            let calDay = startOfWeek(startOfMonth(currentDate), { locale: fr });
            const endCalDay = endOfWeek(endOfMonth(currentDate), { locale: fr });

            while (calDay <= endCalDay) {
                const weekRow = document.createElement('div');
                weekRow.className = 'd-flex mb-1 gap-1';

                for (let i = 0; i < 7; i++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.className = 'text-center border rounded flex-fill py-1 small';
                    if (isSameMonth(calDay, currentDate)) {
                        dayDiv.textContent = format(calDay, 'd', { locale: fr });
                        const count = taskByDate(calDay).length;
                        if (count > 0) {
                            const badge = document.createElement('span');
                            badge.className = 'badge bg-primary ms-1';
                            badge.textContent = count;
                            dayDiv.appendChild(badge);
                        }
                    } else {
                        dayDiv.classList.add('invisible');
                        dayDiv.textContent = '.';
                    }
                    weekRow.appendChild(dayDiv);
                    calDay = addDays(calDay, 1);
                }

                calendarCard.appendChild(weekRow);
            }

            calendarCol.appendChild(calendarCard);
            row.appendChild(calendarCol);

            days.forEach(date => {
                const col = document.createElement('div');
                col.className = 'col text-center d-flex flex-column';

                const card = document.createElement('div');
                card.className = 'border rounded p-2 flex-fill bg-white';
                card.style.minHeight = '72vh';

                const dateLabel = document.createElement('div');
                dateLabel.className = 'fw-bold small mb-2';
                dateLabel.textContent = format(date, 'EEEE d', { locale: fr });

                card.appendChild(dateLabel);

                const tasks = taskByDate(date);
                tasks.forEach(task => {
                    const taskDiv = document.createElement('div');
                    taskDiv.className = 'task-card p-2 border rounded bg-light text-start mb-2';
                    taskDiv.innerHTML = `<strong>${task.nom}</strong><br><small>${task.priority}</small>`;
                    taskDiv.dataset.bsToggle = 'modal';
                    taskDiv.dataset.bsTarget = `#modal-tasks-${format(date,'yyyy-MM-dd')}`;
                    card.appendChild(taskDiv);
                });

                if (tasks.length > 0) {
                    buildTaskModal(date, tasks);
                }

                col.appendChild(card);
                row.appendChild(col);
            });

            container.appendChild(row);
            console.log('✅ Vue 3 jours affichée');
        });
    }

    // --- renderDayView ---
    function renderDayView() {
        console.log('📆 Rendu de la vue jour');
        container.innerHTML = '';

        const startMonth = startOfWeek(startOfMonth(currentDate), { locale: fr });
        const endMonth = endOfWeek(endOfMonth(currentDate), { locale: fr });

        fetchTasks(startMonth.toISOString(), endMonth.toISOString()).then(() => {
            monthLabel.textContent = `Jour du ${format(currentDate, 'd MMMM yyyy', { locale: fr })}`;

            const row = document.createElement('div');
            row.className = 'row g-1 align-items-stretch';

            const calendarCol = document.createElement('div');
            calendarCol.className = 'col-12 col-md-4';
            const calendarCard = document.createElement('div');
            calendarCard.className = 'border rounded p-2';

            const calTitle = document.createElement('div');
            calTitle.className = 'fw-bold mb-2';
            calTitle.textContent = format(currentDate, 'MMMM yyyy', { locale: fr });
            calendarCard.appendChild(calTitle);

            let calDay = startMonth;
            while (calDay <= endMonth) {
                const weekRow = document.createElement('div');
                weekRow.className = 'd-flex mb-1 gap-1';

                for (let i = 0; i < 7; i++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.className = 'text-center border rounded flex-fill py-1 small';
                    if (isSameMonth(calDay, currentDate)) {
                        dayDiv.textContent = format(calDay, 'd', { locale: fr });
                        const taskCount = taskByDate(calDay).length;
                        if (taskCount > 0) {
                            const badge = document.createElement('span');
                            badge.className = 'badge bg-primary ms-1';
                            badge.textContent = taskCount;
                            dayDiv.appendChild(badge);
                        }
                    } else {
                        dayDiv.classList.add('invisible');
                        dayDiv.textContent = '.';
                    }
                    weekRow.appendChild(dayDiv);
                    calDay = addDays(calDay, 1);
                }

                calendarCard.appendChild(weekRow);
            }

            calendarCol.appendChild(calendarCard);
            row.appendChild(calendarCol);

            const detailCol = document.createElement('div');
            detailCol.className = 'col-12 col-md-8 d-flex flex-column';

            const dayCard = document.createElement('div');
            dayCard.className = 'border rounded p-3 flex-fill bg-white';
            dayCard.style.minHeight = '72vh';

            const dateLabel = document.createElement('div');
            dateLabel.className = 'fw-bold mb-2';
            dateLabel.textContent = format(currentDate, 'EEEE d MMMM yyyy', { locale: fr });

            dayCard.appendChild(dateLabel);

            const tasks = taskByDate(currentDate);
            tasks.forEach(task => {
                const taskDiv = document.createElement('div');
                taskDiv.className = 'task-card p-2 border rounded bg-light text-start mb-2';
                taskDiv.innerHTML = `<strong>${task.nom}</strong><br><small>${task.priority}</small>`;
                taskDiv.dataset.bsToggle = 'modal';
                taskDiv.dataset.bsTarget = `#modal-tasks-${format(currentDate,'yyyy-MM-dd')}`;
                dayCard.appendChild(taskDiv);
            });

            if (tasks.length > 0) buildTaskModal(currentDate, tasks);

            detailCol.appendChild(dayCard);
            row.appendChild(detailCol);

            container.appendChild(row);
            console.log('✅ Vue jour affichée');
        });
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
