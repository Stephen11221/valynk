(() => {
    const accountReady = document.getElementById('account-ready');
    if (accountReady) {
        accountReady.showModal();
        document.documentElement.classList.add('account-ready-open');
        accountReady.querySelector('[data-account-ready-continue]')?.addEventListener('click', () => accountReady.close());
        accountReady.addEventListener('close', () => {
            document.documentElement.classList.remove('account-ready-open');
            document.querySelector('#assessment-form input:not([type="hidden"]), #assessment-form textarea')?.focus({ preventScroll: true });
        });
    }

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
    const focusedForm = document.querySelector('[data-focused-assessment]');
    if (focusedForm) {
        const questions = [...focusedForm.querySelectorAll('.focus-question')];
        const next = focusedForm.querySelector('[data-focus-next]');
        const back = focusedForm.querySelector('[data-focus-back]');
        const message = focusedForm.querySelector('[data-focus-validation]');
        let current = 0;
        focusedForm.noValidate = true;
        const answered = question => Boolean(question.querySelector('input:checked'));
        const updateProgress = () => {
            const count = questions.filter(answered).length;
            document.querySelector('[data-focus-progress]').value = count;
            document.querySelector('[data-focus-progress-label]').textContent = `${count} of ${questions.length} answered`;
        };
        const showQuestion = (index, focus = true) => {
            current = index;
            questions.forEach((question, i) => { question.hidden = i !== index; });
            focusedForm.querySelector('[data-focus-count]').textContent = `Question ${index + 1} of ${questions.length}`;
            next.firstChild.textContent = index === questions.length - 1 ? 'Continue Assessment ' : 'Next Question ';
            message.hidden = true;
            if (focus) {
                const title = questions[index].querySelector('legend');
                title.tabIndex = -1;
                title.focus({ preventScroll: true });
                focusedForm.scrollIntoView({ behavior: 'instant', block: 'start' });
            }
        };
        const validate = question => {
            if (!answered(question)) {
                message.hidden = false;
                question.querySelector('input:not(:disabled)')?.focus();
                return false;
            }
            const invalid = [...question.querySelectorAll('input, textarea')].find(input => !input.checkValidity());
            if (invalid) {
                invalid.reportValidity();
                return false;
            }
            return true;
        };
        focusedForm.addEventListener('change', updateProgress);
        back.addEventListener('click', event => {
            if (current > 0) {
                event.preventDefault();
                showQuestion(current - 1);
            }
        });
        focusedForm.addEventListener('submit', event => {
            if (!validate(questions[current])) {
                event.preventDefault();
                return;
            }
            if (current < questions.length - 1) {
                event.preventDefault();
                showQuestion(current + 1);
                return;
            }
            const invalidIndex = questions.findIndex(question => !answered(question) || [...question.querySelectorAll('input, textarea')].some(input => !input.checkValidity()));
            if (invalidIndex !== -1) {
                event.preventDefault();
                showQuestion(invalidIndex);
                validate(questions[invalidIndex]);
            }
        });
        showQuestion(0, false);
        updateProgress();
    }
    document.querySelector('.connection-errors')?.focus();
})();
