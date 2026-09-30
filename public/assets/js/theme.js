/* =====================================================
   PIXELFIX COLOR MODE
   ===================================================== */

(() => {

    'use strict';


    /* =====================================================
       CONFIGURATION
       ===================================================== */

    const STORAGE_KEY = 'pixelfix-theme';

    const MODES = [
        'light',
        'dark',
        'auto'
    ];


    /* =====================================================
       ROOT
       ===================================================== */

    const root = document.documentElement;


    /* =====================================================
       SYSTEM PREFERENCE
       ===================================================== */

    const mediaQuery = window.matchMedia(
        '(prefers-color-scheme: dark)'
    );


    /* =====================================================
       STORAGE
       ===================================================== */

    const readStoredMode = () => {

        try {

            const stored = localStorage.getItem(
                STORAGE_KEY
            );

            if (MODES.includes(stored)) {

                return stored;

            }

        } catch (error) {

            /*
             * localStorage may be unavailable.
             */

        }

        return 'auto';

    };


    const writeStoredMode = (mode) => {

        try {

            localStorage.setItem(
                STORAGE_KEY,
                mode
            );

        } catch (error) {

            /*
             * localStorage may be unavailable.
             */

        }

    };


    /* =====================================================
       RESOLVE MODE
       ===================================================== */

    const resolveMode = (mode) => {

        if (mode === 'dark') {

            return 'dark';

        }

        if (mode === 'light') {

            return 'light';

        }

        return mediaQuery.matches
            ? 'dark'
            : 'light';

    };


    /* =====================================================
       APPLY MODE
       ===================================================== */

    const applyMode = (mode) => {

        const resolvedMode = resolveMode(mode);

        root.setAttribute(
            'data-bs-theme',
            resolvedMode
        );

        root.style.colorScheme = resolvedMode;

        root.setAttribute(
            'data-pixelfix-theme',
            mode
        );


        /* =================================================
           UPDATE THEME CONTROLS
           ================================================= */

        document
            .querySelectorAll(
                '[data-pixelfix-theme-value], [data-bs-theme-value]'
            )
            .forEach((control) => {

                const value =
                    control.getAttribute(
                        'data-pixelfix-theme-value'
                    )
                    ?? control.getAttribute(
                        'data-bs-theme-value'
                    );

                const active =
                    value === mode;

                control.classList.toggle(
                    'active',
                    active
                );

                control.setAttribute(
                    'aria-pressed',
                    active
                        ? 'true'
                        : 'false'
                );

                if (active) {

                    control.setAttribute(
                        'aria-current',
                        'true'
                    );

                } else {

                    control.removeAttribute(
                        'aria-current'
                    );

                }

            });


        /* =================================================
           UPDATE THEME LABEL
           ================================================= */

        document
            .querySelectorAll(
                '[data-pixelfix-theme-label]'
            )
            .forEach((element) => {

                element.textContent = mode;

            });


        /* =================================================
           UPDATE THEME ICON
           ================================================= */

        document
            .querySelectorAll(
                '[data-pixelfix-theme-icon]'
            )
            .forEach((element) => {

                element.classList.toggle(
                    'bi-sun',
                    mode === 'light'
                );

                element.classList.toggle(
                    'bi-moon',
                    mode === 'dark'
                );

                element.classList.toggle(
                    'bi-circle-half',
                    mode === 'auto'
                );

            });

    };


    /* =====================================================
       SET MODE
       ===================================================== */

    const setMode = (mode) => {

        if (!MODES.includes(mode)) {

            return;

        }

        writeStoredMode(mode);

        applyMode(mode);

        document.dispatchEvent(
            new CustomEvent(
                'pixelfix:theme-changed',
                {
                    detail: {
                        mode: mode,
                        resolvedMode: resolveMode(mode)
                    }
                }
            )
        );

    };


    /* =====================================================
       CONTROL BINDING
       ===================================================== */

    const bindControls = () => {

        document
            .querySelectorAll(
                '[data-pixelfix-theme-value], [data-bs-theme-value]'
            )
            .forEach((control) => {

                if (
                    control.dataset.pixelfixThemeBound === 'true'
                ) {

                    return;

                }

                control.dataset.pixelfixThemeBound = 'true';

                control.addEventListener(
                    'click',
                    (event) => {

                        const value =
                            control.getAttribute(
                                'data-pixelfix-theme-value'
                            )
                            ?? control.getAttribute(
                                'data-bs-theme-value'
                            );

                        if (!MODES.includes(value)) {

                            return;

                        }

                        event.preventDefault();

                        setMode(value);

                    }
                );

            });

    };


    /* =====================================================
       SYSTEM THEME CHANGES
       ===================================================== */

    const handleSystemThemeChange = () => {

        const currentMode = readStoredMode();

        if (currentMode !== 'auto') {

            return;

        }

        applyMode('auto');

        document.dispatchEvent(
            new CustomEvent(
                'pixelfix:theme-changed',
                {
                    detail: {
                        mode: 'auto',
                        resolvedMode: resolveMode('auto')
                    }
                }
            )
        );

    };


    /* =====================================================
       SYSTEM THEME LISTENER
       ===================================================== */

    mediaQuery.addEventListener(
        'change',
        handleSystemThemeChange
    );


    /* =====================================================
       PUBLIC API
       ===================================================== */

    window.PixelFixTheme = {

        getMode: () => {

            return readStoredMode();

        },

        getResolvedMode: () => {

            return resolveMode(
                readStoredMode()
            );

        },

        setMode,

        applyMode,

        bindControls

    };


    /* =====================================================
       INITIALIZE
       ===================================================== */

    const initialMode = readStoredMode();

    applyMode(initialMode);


    if (
        document.readyState === 'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            () => {

                bindControls();

                applyMode(
                    readStoredMode()
                );

            },
            {
                once: true
            }
        );

    } else {

        bindControls();

    }

})();