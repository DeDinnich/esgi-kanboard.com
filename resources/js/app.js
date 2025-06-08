// resources/js/app.js

import '../css/app.css';
import 'bootstrap';
import 'aos/dist/aos.css';

import initEcho        from './modules/echo';
import initAOS         from './modules/aos';
import monitorReverb   from './modules/reverbStatus';

import initDropdownHover from './components/dropdownHover.js';
import initBannerHoverVideo from './components/bannerHoverVideo.js';
import initKeyNumberCounters from './components/counter.js';
import initStripePayment from './components/stripe.js';
import initSidebarToggle from './components/sidebarToggle';
import { renderBarChart, renderPieChart } from './components/adminCharts.js';
import initCalendarView from './components/calendarView';


initEcho();      // initialise Echo
initAOS();       // initialise AOS
monitorReverb(); // monitoring sans réinitialiser Echo

if (['/', '/about', '/prices'].includes(window.location.pathname)) {
    document.addEventListener('DOMContentLoaded', () => {
        initDropdownHover();
    });
}

if (['/'].includes(window.location.pathname)) {
    document.addEventListener('DOMContentLoaded', () => {
        initBannerHoverVideo();
        initKeyNumberCounters();
    });
}

if (['/prices'].includes(window.location.pathname)) {
    document.addEventListener('DOMContentLoaded', () => {
        initStripePayment();
    });
}

if (window.location.pathname.startsWith('/admin') || window.location.pathname === '/dashboard') {
    document.addEventListener('DOMContentLoaded', () => {
        console.log('Initialisation du toggle de la sidebar');
        initSidebarToggle();
    });
}

if (['/admin'].includes(window.location.pathname)) {
    document.addEventListener('DOMContentLoaded', () => {
        renderBarChart('userChart', userLabels, userData, 'Utilisateurs');
        renderBarChart('projectChart', projectLabels, projectData, 'Projets');
        renderBarChart('taskChart', taskLabels, taskData, 'Tâches');
        renderPieChart('subscriptionChart', subLabels, subData);
        renderPieChart('completionChart', completionLabels, completionData);
    });
}

if (window.location.pathname.includes('/calendar')) {
    document.addEventListener('DOMContentLoaded', () => {
        console.log('Init calendrier'); // ← ajoute ceci pour débug
        initCalendarView();
    });
}
