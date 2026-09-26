(() => {
    const container = document.querySelector('#support-areas');
    if (!container) return;
    const addButton = document.querySelector('#add-support-area');
    const status = document.querySelector('#support-area-status');
    let nextIndex = Math.max(...Array.from(container.children, area => Number(area.dataset.areaIndex))) + 1;
    const updateControls = () => {
        addButton.disabled = container.children.length >= 8;
        container.querySelectorAll('[data-remove-area]').forEach(button => { button.disabled = container.children.length === 1; });
        status.textContent = `${container.children.length} of 8 support areas`;
    };
    addButton.addEventListener('click', () => {
        if (container.children.length >= 8) return;
        const area = container.firstElementChild.cloneNode(true);
        area.dataset.areaIndex = nextIndex;
        area.querySelectorAll('input, textarea').forEach(input => {
            input.name = input.name.replace(/areas\[\d+\]/, `areas[${nextIndex}]`);
            input.value = '';
        });
        nextIndex++;
        container.append(area);
        updateControls();
        area.querySelector('input').focus();
    });
    container.addEventListener('click', event => {
        const button = event.target.closest('[data-remove-area]');
        if (!button || container.children.length <= 1) return;
        button.closest('.support-area').remove();
        updateControls();
        addButton.focus();
    });
    updateControls();
})();
