/* PixelFix authentication form enhancements. Form submission remains server-driven. */
(function () {
    'use strict';
    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-pw-toggle]');
        if (!button) return;
        const input = document.getElementById(button.getAttribute('aria-controls'));
        if (!input) return;
        const showing = input.type === 'password';
        input.type = showing ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(showing));
        button.setAttribute('aria-label', showing ? 'Hide password' : 'Show password');
    });
})();
