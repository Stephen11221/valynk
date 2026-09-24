document.querySelectorAll('[data-dialog]').forEach((button) => {
    button.addEventListener('click', () => document.getElementById(button.dataset.dialog).showModal());
});
document.querySelectorAll('[data-close-dialog]').forEach((button) => {
    button.addEventListener('click', () => button.closest('dialog').close());
});
document.querySelector('dialog[data-reopen]')?.showModal();
document.querySelectorAll('[data-delete-document]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(`Delete “${form.dataset.deleteDocument}”? This permanently removes the document.`)) {
            event.preventDefault();
        }
    });
});
document.querySelector('#upload-file')?.addEventListener('change', (event) => {
    const input = event.target;
    input.setCustomValidity(input.files[0]?.size > Number(input.dataset.maxBytes) ? 'This document exceeds the upload limit shown below.' : '');
    input.reportValidity();
});
