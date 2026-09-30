(function () {

    'use strict';


    /* =====================================================
       COLOR MODE
       ===================================================== */

    const THEME_STORAGE_KEY = 'pixelfix-theme';


    const getStoredTheme = function () {

        try {

            const storedTheme = localStorage.getItem(
                THEME_STORAGE_KEY
            );

            if (
                storedTheme === 'light' ||
                storedTheme === 'dark' ||
                storedTheme === 'auto'
            ) {

                return storedTheme;

            }

        } catch (error) {

            /* localStorage may be unavailable. */

        }

        return 'auto';

    };


    const resolveTheme = function (theme) {

        if (theme === 'dark') {

            return 'dark';

        }

        if (theme === 'light') {

            return 'light';

        }

        return window.matchMedia(
            '(prefers-color-scheme: dark)'
        ).matches
            ? 'dark'
            : 'light';

    };


    const updateThemeControls = function (theme) {

        document
            .querySelectorAll(
                '[data-pixelfix-theme-value]'
            )
            .forEach(function (button) {

                const buttonTheme =
                    button.getAttribute(
                        'data-pixelfix-theme-value'
                    );

                const active =
                    buttonTheme === theme;

                button.classList.toggle(
                    'active',
                    active
                );

                button.setAttribute(
                    'aria-pressed',
                    active ? 'true' : 'false'
                );

                const checkIcon = button.querySelector(
                    '.bi-check-lg'
                );

                if (checkIcon) {

                    checkIcon.classList.toggle(
                        'd-none',
                        !active
                    );

                }

            });

        document
            .querySelectorAll(
                '[data-pixelfix-theme-icon]'
            )
            .forEach(function (icon) {

                icon.classList.toggle(
                    'd-none',
                    icon.getAttribute(
                        'data-pixelfix-theme-icon'
                    ) !== theme
                );

            });

    };


    const applyTheme = function (theme) {

        const resolvedTheme = resolveTheme(theme);

        document.documentElement.setAttribute(
            'data-bs-theme',
            resolvedTheme
        );

        document.documentElement.style.colorScheme =
            resolvedTheme;

        document.documentElement.setAttribute(
            'data-pixelfix-theme',
            theme
        );

        try {

            localStorage.setItem(
                THEME_STORAGE_KEY,
                theme
            );

        } catch (error) {

            /* localStorage may be unavailable. */

        }

        updateThemeControls(theme);

    };


    const initializeColorMode = function () {

        const currentTheme = getStoredTheme();

        applyTheme(currentTheme);

        const mediaQuery = window.matchMedia(
            '(prefers-color-scheme: dark)'
        );

        const handleSystemThemeChange = function () {

            if (getStoredTheme() === 'auto') {

                applyTheme('auto');

            }

        };

        if (typeof mediaQuery.addEventListener === 'function') {

            mediaQuery.addEventListener(
                'change',
                handleSystemThemeChange
            );

        } else if (
            typeof mediaQuery.addListener === 'function'
        ) {

            mediaQuery.addListener(
                handleSystemThemeChange
            );

        }

        document.addEventListener(
            'click',
            function (event) {

                const button =
                    event.target.closest(
                        '[data-pixelfix-theme-value]'
                    );

                if (!button) {

                    return;

                }

                event.preventDefault();

                const theme = button.getAttribute(
                    'data-pixelfix-theme-value'
                );

                if (
                    theme === 'light' ||
                    theme === 'dark' ||
                    theme === 'auto'
                ) {

                    applyTheme(theme);

                }

            }
        );

    };


    /* =====================================================
       FULLSCREEN
       ===================================================== */

    const updateFullscreenControls = function () {

        const isFullscreen = Boolean(
            document.fullscreenElement
        );

        document
            .querySelectorAll(
                '[data-pixelfix-icon="maximize"]'
            )
            .forEach(function (icon) {

                icon.classList.toggle(
                    'd-none',
                    isFullscreen
                );

            });

        document
            .querySelectorAll(
                '[data-pixelfix-icon="minimize"]'
            )
            .forEach(function (icon) {

                icon.classList.toggle(
                    'd-none',
                    !isFullscreen
                );

            });

    };


    const initializeFullscreen = function () {

        document.addEventListener(
            'click',
            function (event) {

                const toggle =
                    event.target.closest(
                        '[data-pixelfix-toggle="fullscreen"]'
                    );

                if (!toggle) {

                    return;

                }

                event.preventDefault();

                if (!document.fullscreenElement) {

                    if (
                        document.documentElement
                            .requestFullscreen
                    ) {

                        document.documentElement
                            .requestFullscreen()
                            .catch(function () {});

                    }

                } else if (
                    document.exitFullscreen
                ) {

                    document.exitFullscreen()
                        .catch(function () {});

                }

            }
        );

        document.addEventListener(
            'fullscreenchange',
            updateFullscreenControls
        );

        updateFullscreenControls();

    };


    /* =====================================================
       INITIALIZE
       ===================================================== */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            initializeColorMode();

            initializeFullscreen();

        }
    );

})();
