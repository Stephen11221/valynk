(() => {
    let opener = null;
    document.addEventListener('click', event => {
        const button = event.target.closest('[data-solution-open]');
        if (button) {
            const dialog = document.getElementById(button.dataset.solutionOpen);
            if (!dialog) return;
            opener = button;
            dialog.showModal();
            dialog.scrollTop = 0;
            document.documentElement.classList.add('solution-modal-open');
        }
        if (event.target.closest('[data-solution-close]')) {
            event.target.closest('dialog').close();
        }
    });
    document.querySelectorAll('.solution-dialog').forEach(dialog => {
        let backdropPointerDown = false;
        dialog.addEventListener('pointerdown', event => {
            backdropPointerDown = event.target === dialog && outsideDialog(event, dialog);
        });
        dialog.addEventListener('click', event => {
            if (backdropPointerDown && event.target === dialog && outsideDialog(event, dialog)) dialog.close();
            backdropPointerDown = false;
        });
        dialog.addEventListener('close', () => {
            document.documentElement.classList.remove('solution-modal-open');
            opener?.focus({ preventScroll: true });
        });
    });
    function outsideDialog(event, dialog) {
        const bounds = dialog.getBoundingClientRect();
        return event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom;
    }
})();
