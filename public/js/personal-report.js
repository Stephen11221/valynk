(() => {
    if (new URLSearchParams(window.location.search).get('print') !== '1') return;
    window.addEventListener('load', async () => {
        await document.fonts.ready;
        window.print();
    }, { once: true });
})();
