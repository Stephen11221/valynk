(() => {
    document.querySelectorAll('[data-support-chat]').forEach(chat => {
        const panel = chat.querySelector('.support-chat-panel');
        const toggle = chat.querySelector('.support-chat-toggle');
        const log = chat.querySelector('.support-chat-log');
        const status = chat.querySelector('.support-chat-status');
        const form = chat.querySelector('form');
        const input = form.querySelector('textarea');
        const send = form.querySelector('[type=submit]');
        const isSupport = chat.dataset.isSupport === 'true';
        let loading = false;
        let lastId = null;
        const load = async () => {
            if (loading || panel.hidden || document.hidden) return;
            loading = true;
            try {
                const response = await fetch(chat.dataset.feedUrl, { headers: { Accept: 'application/json' }, cache: 'no-store', signal: AbortSignal.timeout(12000) });
                if (!response.ok) throw new Error('Unable to load chat. Please try again.');
                const data = await response.json();
                const nextId = data.messages.at(-1)?.id ?? 0;
                if (nextId !== lastId) {
                    const atBottom = log.scrollHeight - log.scrollTop - log.clientHeight < 50;
                    if (data.messages.length) log.replaceChildren();
                    data.messages.forEach(message => {
                        const bubble = document.createElement('article');
                        bubble.className = 'support-chat-bubble';
                        bubble.classList.toggle('is-own', message.from_support === isSupport);
                        const sender = document.createElement('strong');
                        sender.textContent = message.from_support ? 'VALYNK Support' : (isSupport ? 'Member' : 'You');
                        const body = document.createElement('p');
                        body.textContent = message.body;
                        const time = document.createElement('time');
                        time.dateTime = message.sent_at;
                        time.textContent = new Date(message.sent_at).toLocaleString([], { dateStyle: 'short', timeStyle: 'short' });
                        bubble.append(sender, body, time);
                        log.append(bubble);
                    });
                    if (atBottom || lastId === null) log.scrollTop = log.scrollHeight;
                    lastId = nextId;
                }
                if (status.dataset.errorType === 'load') {
                    status.textContent = '';
                    delete status.dataset.errorType;
                }
            } catch (error) {
                status.textContent = 'Unable to refresh chat. Check your connection or sign in again.';
                status.dataset.errorType = 'load';
            } finally {
                loading = false;
            }
        };
        const close = () => {
            panel.hidden = true;
            toggle?.setAttribute('aria-expanded', 'false');
            toggle?.focus();
        };
        toggle?.addEventListener('click', () => {
            panel.hidden = !panel.hidden;
            toggle.setAttribute('aria-expanded', String(!panel.hidden));
            if (!panel.hidden) { load(); input.focus(); }
        });
        chat.querySelector('[data-chat-close]')?.addEventListener('click', close);
        chat.addEventListener('keydown', event => { if (event.key === 'Escape' && toggle && !panel.hidden) close(); });
        form.addEventListener('submit', async event => {
            event.preventDefault();
            const body = input.value.trim();
            if (!body || send.disabled) return;
            send.disabled = true;
            status.textContent = 'Sending…';
            delete status.dataset.errorType;
            try {
                const response = await fetch(chat.dataset.sendUrl, {
                    method: 'POST',
                    headers: { Accept: 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': form.querySelector('[name=_token]').value },
                    body: JSON.stringify({ body }),
                    signal: AbortSignal.timeout(15000),
                });
                if (!response.ok) {
                    const data = await response.json().catch(() => ({}));
                    throw new Error(data.errors?.body?.[0] || (response.status === 429 ? 'Please wait a moment before sending again.' : 'Unable to send. Check your connection or sign in again.'));
                }
                if (input.value.trim() === body) input.value = '';
                status.textContent = 'Sent. Replies will appear here.';
                await load();
            } catch (error) {
                status.textContent = error.name === 'TimeoutError' ? 'Sending timed out. Check the conversation before trying again.' : error.message;
                status.dataset.errorType = 'send';
            } finally {
                send.disabled = false;
                input.focus();
            }
        });
        setInterval(load, 5000);
        document.addEventListener('visibilitychange', () => { if (!document.hidden) load(); });
        load();
    });
})();
