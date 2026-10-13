(() => {
    const ready = document.querySelector('.parent-ready-preview #account-ready');
    if (ready) {
        ready.showModal();
        document.querySelector('[data-open-ready]')?.addEventListener('click', () => ready.showModal());
    }
    document.querySelectorAll('[data-journey-tabs]').forEach(group => {
        const tabs = [...group.querySelectorAll('[role="tab"]')];
        const select = tab => {
            tabs.forEach(item => {
                const active = item === tab;
                item.setAttribute('aria-selected', String(active));
                item.tabIndex = active ? 0 : -1;
                const panel = document.getElementById(item.getAttribute('aria-controls'));
                if (panel) panel.hidden = !active;
            });
        };
        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => select(tab));
            tab.addEventListener('keydown', event => {
                let next;
                if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
                if (event.key === 'ArrowLeft') next = (index - 1 + tabs.length) % tabs.length;
                if (event.key === 'Home') next = 0;
                if (event.key === 'End') next = tabs.length - 1;
                if (next === undefined) return;
                event.preventDefault();
                select(tabs[next]);
                tabs[next].focus();
            });
        });
    });
    document.querySelectorAll('[data-parent-show-tab]').forEach(link => link.addEventListener('click', event => {
        event.preventDefault();
        const tab = document.getElementById('progress-tab-' + link.dataset.parentShowTab);
        tab?.click();
        document.getElementById(tab?.getAttribute('aria-controls'))?.scrollIntoView({ block: 'start' });
    }));
    const note = document.querySelector('[data-parent-note]');
    if (note) {
        try { note.value = localStorage.getItem('valynk-sample-parent-note') || ''; } catch {}
        document.querySelector('[data-parent-save-note]')?.addEventListener('click', () => {
            const status = document.querySelector('[data-parent-note-status]');
            try {
                localStorage.setItem('valynk-sample-parent-note', note.value);
                status.textContent = 'Sample note saved on this device.';
            } catch { status.textContent = 'Saving is unavailable in this browser.'; }
        });
    }
    const update = () => {
        const option = document.querySelector('input[name="payment_option"]:checked');
        const amount = option?.dataset.amount;
        if (amount) document.querySelectorAll('[data-selected-amount]').forEach(node => node.textContent = Number(amount).toLocaleString('en-KE'));
        const programme = document.querySelector('input[name="programme"]:checked');
        if (programme) {
            const card = programme.closest('.parent-programme-option');
            const title = document.querySelector('[data-selection-title]');
            const image = document.querySelector('[data-selection-image]');
            if (title) title.textContent = card.querySelector('h3').textContent;
            if (image) image.src = card.querySelector('img').src;
        }
    };
    document.querySelectorAll('input[name="payment_option"], input[name="programme"]').forEach(input => input.addEventListener('change', update));
    update();
    document.querySelectorAll('[data-parent-print]').forEach(button => button.addEventListener('click', () => window.print()));
})();
