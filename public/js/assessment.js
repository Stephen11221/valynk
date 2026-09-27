(() => {
    document.querySelectorAll('[data-question]').forEach(group => {
        const choices = [...group.querySelectorAll('.assessment-option input')];
        const other = group.querySelector('[data-other-field]');
        const update = () => {
            const selected = choices.filter(input => input.checked);
            const maximum = Number(group.dataset.max || 0);
            if (maximum) {
                choices.forEach(input => { input.disabled = !input.checked && selected.length >= maximum; });
                group.querySelector('[data-selection-count]').textContent = `${selected.length} of ${maximum} goals selected${selected.length >= maximum ? ' — deselect a goal to choose another.' : ''}`;
            }
            if (other) {
                const show = selected.some(input => input.value === 'Other');
                other.hidden = !show;
                other.querySelector('textarea').disabled = !show;
                other.querySelector('textarea').required = show;
            }
        };
        choices.forEach(input => input.addEventListener('change', () => {
            if (input.type === 'checkbox' && input.checked) {
                if (input.value === 'None') choices.forEach(choice => { if (choice !== input) choice.checked = false; });
                else choices.filter(choice => choice.value === 'None').forEach(choice => { choice.checked = false; });
            }
            update();
        }));
        update();
    });
    document.querySelectorAll('[data-counter]').forEach(input => {
        const update = () => { document.getElementById(input.getAttribute('aria-describedby')).textContent = `${Array.from(input.value).length}/500`; };
        input.addEventListener('input', update);
        update();
    });
    document.querySelector('.connection-errors')?.focus();
})();
