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

if (['/dashboard'].includes(window.location.pathname)) {
    document.addEventListener('DOMContentLoaded', () => {
        initSidebarToggle();
    });
}
