(() => {
    document.querySelectorAll('[data-password-toggle]').forEach(button => {
        const input = document.getElementById(button.dataset.passwordToggle);
        const label = button.getAttribute('aria-label');
        button.addEventListener('click', () => {
            const visible = input.type === 'password';
            input.type = visible ? 'text' : 'password';
            button.setAttribute('aria-pressed', String(visible));
            button.setAttribute('aria-label', visible ? label.replace('Show', 'Hide') : label);
            button.querySelector('i').className = `fa-solid fa-eye${visible ? '' : '-slash'}`;
        });
    });
    const status = document.querySelector('#pwd_status');
    const details = document.querySelector('#pwd_details');
    const updateStatus = () => { details.disabled = status.value !== 'yes'; };
    status.addEventListener('change', updateStatus);
    updateStatus();
    const notes = document.querySelector('#support_notes');
    const updateCounter = () => { document.querySelector('#notes-counter').textContent = `${Array.from(notes.value).length}/500`; };
    notes.addEventListener('input', updateCounter);
    updateCounter();
    document.querySelector('.connection-errors')?.focus();
})();
