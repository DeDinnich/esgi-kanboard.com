export default function initSidebarToggle() {
    const aside = document.getElementById('dashboard-aside');
    const toggleBtn = () => aside.querySelector('#toggle-sidebar');
    const expandBtn = () => aside.querySelector('#expand-sidebar');
    const asideTitle = aside.querySelector('#aside-title');
    const projectList = aside.querySelector('#project-list');
    const asideFooter = aside.querySelector('#aside-footer');
    const asideExpand = aside.querySelector('#aside-expand');

    const collapseSidebar = () => {
        console.log('Collapsing sidebar...');
        aside.classList.add('collapsed');
        asideTitle.textContent = 'KB';
        projectList.style.display = 'none';
        asideFooter.classList.add('d-none');
        asideExpand.classList.remove('d-none');
        localStorage.setItem('kanboard_sidebar_state', 'collapsed');
        console.log('Sidebar collapsed. Current state:', localStorage.getItem('kanboard_sidebar_state'));
    };

    const expandSidebar = () => {
        console.log('Expanding sidebar...');
        aside.classList.remove('collapsed');
        asideTitle.textContent = 'KANBOARD';
        projectList.style.display = 'block';
        asideFooter.classList.remove('d-none');
        asideExpand.classList.add('d-none');
        localStorage.setItem('kanboard_sidebar_state', 'expanded');
        console.log('Sidebar expanded. Current state:', localStorage.getItem('kanboard_sidebar_state'));
    };

    // Initialisation avec état sauvegardé
    const savedState = localStorage.getItem('kanboard_sidebar_state');
    console.log('Saved state:', savedState);
    if (savedState === 'collapsed') {
        collapseSidebar();
    } else {
        expandSidebar();
    }

    // Délai pour s'assurer que les boutons sont présents dans le DOM
    setTimeout(() => {
        const toggleButton = toggleBtn();
        const expandButton = expandBtn();
        console.log('Toggle button:', toggleButton);
        console.log('Expand button:', expandButton);

        toggleButton?.addEventListener('click', collapseSidebar);
        expandButton?.addEventListener('click', expandSidebar);
    }, 0);

    const subMenus = document.querySelectorAll('.dropdown-menu .dropstart');

    subMenus.forEach(menu => {
        menu.addEventListener('mouseenter', () => {
            const sub = menu.querySelector('.dropdown-menu');
            if (sub) sub.classList.add('show');
        });

        menu.addEventListener('mouseleave', () => {
            const sub = menu.querySelector('.dropdown-menu');
            if (sub) sub.classList.remove('show');
        });
    });
}
