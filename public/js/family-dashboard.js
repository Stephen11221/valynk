(() => {
    const sidebar = document.getElementById('family-sidebar');
    const menu = document.querySelector('.family-menu-toggle');
    if (!sidebar || !menu) return;
    const closeMenu = () => {
        sidebar.classList.remove('is-open');
        menu.setAttribute('aria-expanded', 'false');
    };
    menu.addEventListener('click', () => {
        const expanded = sidebar.classList.toggle('is-open');
        menu.setAttribute('aria-expanded', String(expanded));
    });
    document.addEventListener('click', event => {
        if (!sidebar.contains(event.target) && !menu.contains(event.target)) closeMenu();
    });
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && sidebar.classList.contains('is-open')) {
            closeMenu();
            menu.focus();
        }
    });
    const tabs = [...document.querySelectorAll('[data-family-tab]')];
    const activate = (id, focus = false) => {
        const activeTab = tabs.find(tab => tab.dataset.familyTab === id);
        if (!activeTab) return;
        tabs.forEach(tab => {
            const selected = tab === activeTab;
            tab.setAttribute('aria-selected', String(selected));
            tab.tabIndex = selected ? 0 : -1;
            document.getElementById(tab.dataset.familyTab).hidden = !selected;
        });
        if (focus) activeTab.focus();
    };
    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => activate(tab.dataset.familyTab));
        tab.addEventListener('keydown', event => {
            let next;
            if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
            if (event.key === 'ArrowLeft') next = (index - 1 + tabs.length) % tabs.length;
            if (event.key === 'Home') next = 0;
            if (event.key === 'End') next = tabs.length - 1;
            if (next !== undefined) {
                event.preventDefault();
                activate(tabs[next].dataset.familyTab, true);
            }
        });
    });
    const showHashPanel = () => activate(location.hash.slice(1));
    window.addEventListener('hashchange', showHashPanel);
    showHashPanel();
    sidebar.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
        activate(link.hash.slice(1));
        closeMenu();
    }));
})();
