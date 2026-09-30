/* =====================================================
   PIXELFIX SIDEBAR
   ===================================================== */

(function () {

    'use strict';


    const SELECTOR_SIDEBAR =
        '.pixelfix-sidebar';

    const SELECTOR_SIDEBAR_TOGGLE =
        '[data-pixelfix-toggle="sidebar"]';

    const SELECTOR_NAV_ITEM =
        '.pixelfix-sidebar-nav-item';

    const SELECTOR_NAV_TOGGLE =
        '.pixelfix-sidebar-nav-toggle';

    const SELECTOR_NAV_TREE =
        '.pixelfix-sidebar-nav-tree';

    const SELECTOR_NAV_LINK =
        ':scope > .pixelfix-sidebar-nav-entry > .pixelfix-sidebar-nav-link';

    const SELECTOR_SEARCH =
        '[data-pixelfix-sidebar-search]';

    const SELECTOR_MENU =
        '[data-pixelfix-sidebar-menu]';

    const SELECTOR_EMPTY =
        '[data-pixelfix-search-empty]';


    const CLASS_COLLAPSE =
        'pixelfix-sidebar-collapse';

    const CLASS_OPEN =
        'pixelfix-sidebar-open';

    const CLASS_MINI =
        'pixelfix-sidebar-mini';

    const CLASS_WITHOUT_HOVER =
        'pixelfix-sidebar-without-hover';

    const CLASS_MENU_OPEN =
        'menu-open';


    const STORAGE_KEY =
        'pixelfix.sidebar.state';


    let sidebar = null;

    let sidebarOverlay = null;

    let config = {

        breakpoint: 991.98,

        persistence: false,

        accordion: true,

        animationSpeed: 300,

        mini: false,

        withoutHover: false

    };


    let searchSnapshot = null;


    /* =====================================================
       INITIALISE
       ===================================================== */

    function init() {

        sidebar =
            document.querySelector(
                SELECTOR_SIDEBAR
            );


        if (!sidebar) {

            return;

        }


        readConfiguration();

        applyConfiguredClasses();

        createOverlay();

        initialiseToggles();

        initialiseTreeview();

        initialiseSearch();

        initialiseKeyboard();

        initialiseResponsive();

        initialisePersistence();

        openActiveParents();

    }


    /* =====================================================
       CONFIGURATION
       ===================================================== */

    function readConfiguration() {

        config.breakpoint =
            Number(
                sidebar.dataset.sidebarBreakpoint ||
                991.98
            );


        config.persistence =
            sidebar.dataset.enablePersistence === 'true';


        config.accordion =
            sidebar.dataset.sidebarAccordion !== 'false';


        config.animationSpeed =
            Number(
                sidebar.dataset.sidebarAnimationSpeed ||
                300
            );


        config.mini =
            sidebar.dataset.sidebarMini === 'true';

    }


    function applyConfiguredClasses() {

        if (config.mini) {

            document.body.classList.add(
                CLASS_MINI
            );

        }


        if (
            sidebar.classList.contains(
                CLASS_WITHOUT_HOVER
            )
        ) {

            document.body.classList.add(
                CLASS_WITHOUT_HOVER
            );

        }

    }


    /* =====================================================
       SIDEBAR OVERLAY
       ===================================================== */

    function createOverlay() {

        sidebarOverlay =
            document.querySelector(
                '.pixelfix-sidebar-overlay'
            );


        if (sidebarOverlay) {

            return;

        }


        sidebarOverlay =
            document.createElement('div');


        sidebarOverlay.className =
            'pixelfix-sidebar-overlay';


        document.body.appendChild(
            sidebarOverlay
        );


        sidebarOverlay.addEventListener(
            'click',
            function (event) {

                event.preventDefault();

                collapse();

            }
        );


        let touchMoved = false;


        sidebarOverlay.addEventListener(
            'touchstart',
            function () {

                touchMoved = false;

            },
            {
                passive: true
            }
        );


        sidebarOverlay.addEventListener(
            'touchmove',
            function () {

                touchMoved = true;

            },
            {
                passive: true
            }
        );


        sidebarOverlay.addEventListener(
            'touchend',
            function (event) {

                if (!touchMoved) {

                    event.preventDefault();

                    collapse();

                }

                touchMoved = false;

            },
            {
                passive: false
            }
        );

    }


    /* =====================================================
       BREAKPOINT
       ===================================================== */

    function isMobile() {

        return (
            window.innerWidth <=
            config.breakpoint
        );

    }


    /* =====================================================
       STATE
       ===================================================== */

    function isCollapsed() {

        return document.body.classList.contains(
            CLASS_COLLAPSE
        );

    }


    function isOpen() {

        return document.body.classList.contains(
            CLASS_OPEN
        );

    }


    function isMini() {

        return document.body.classList.contains(
            CLASS_MINI
        );

    }


    /* =====================================================
       EXPAND
       ===================================================== */

    function expand() {

        const event =
            new CustomEvent(
                'pixelfix.sidebar.open',
                {
                    cancelable: true
                }
            );


        if (
            !sidebar.dispatchEvent(
                event
            )
        ) {

            return;

        }


        document.body.classList.remove(
            CLASS_COLLAPSE
        );


        if (isMobile()) {

            document.body.classList.add(
                CLASS_OPEN
            );

        }


        syncToggleState();


        sidebar.dispatchEvent(
            new CustomEvent(
                'pixelfix.sidebar.opened'
            )
        );

    }


    /* =====================================================
       COLLAPSE
       ===================================================== */

    function collapse() {

        const event =
            new CustomEvent(
                'pixelfix.sidebar.collapse',
                {
                    cancelable: true
                }
            );


        if (
            !sidebar.dispatchEvent(
                event
            )
        ) {

            return;

        }


        document.body.classList.remove(
            CLASS_OPEN
        );


        document.body.classList.add(
            CLASS_COLLAPSE
        );


        syncToggleState();


        sidebar.dispatchEvent(
            new CustomEvent(
                'pixelfix.sidebar.collapsed'
            )
        );

    }


    /* =====================================================
       TOGGLE
       ===================================================== */

    function toggle() {

        const wasCollapsed =
            isCollapsed();


        if (wasCollapsed) {

            expand();

        } else {

            collapse();

        }


        if (config.persistence) {

            saveState(
                wasCollapsed
                    ? CLASS_OPEN
                    : CLASS_COLLAPSE
            );

        }

    }


    /* =====================================================
       EXTERNAL TOGGLE
       ===================================================== */

    function initialiseToggles() {

        document.addEventListener(
            'click',
            function (event) {

                const target =
                    event.target.closest(
                        SELECTOR_SIDEBAR_TOGGLE
                    );


                if (!target) {

                    return;

                }


                event.preventDefault();

                toggle();

            }
        );

        syncToggleState();

    }


    function syncToggleState() {

        document.querySelectorAll(
            SELECTOR_SIDEBAR_TOGGLE
        ).forEach(
            function (toggleButton) {

                const expanded =
                    isMobile()
                        ? isOpen()
                        : !isCollapsed();


                toggleButton.setAttribute(
                    'aria-expanded',
                    String(expanded)
                );


                if (
                    !toggleButton.hasAttribute(
                        'aria-controls'
                    )
                ) {

                    toggleButton.setAttribute(
                        'aria-controls',
                        sidebar.id
                    );

                }

            }
        );

    }


    /* =====================================================
       TREEVIEW
       ===================================================== */

    function initialiseTreeview() {

        sidebar.addEventListener(
            'click',
            function (event) {

                const toggleButton =
                    event.target.closest(
                        SELECTOR_NAV_TOGGLE
                    );


                if (!toggleButton) {

                    return;

                }


                event.preventDefault();


                const item =
                    toggleButton.closest(
                        SELECTOR_NAV_ITEM
                    );


                if (!item) {

                    return;

                }


                toggleTreeItem(
                    item
                );

            }
        );

    }


    function toggleTreeItem(item) {

        if (
            item.classList.contains(
                CLASS_MENU_OPEN
            )
        ) {

            closeTreeItem(
                item
            );

            return;

        }


        openTreeItem(
            item
        );

    }


    function openTreeItem(item) {

        const submenu =
            item.querySelector(
                SELECTOR_NAV_TREE
            );


        if (!submenu) {

            return;

        }


        if (config.accordion) {

            closeSiblingTreeItems(
                item
            );

        }


        item.classList.add(
            CLASS_MENU_OPEN
        );


        setAriaExpanded(
            item,
            true
        );


        slideDown(
            submenu,
            config.animationSpeed
        );

    }


    function closeTreeItem(item) {

        const submenu =
            item.querySelector(
                SELECTOR_NAV_TREE
            );


        item.classList.remove(
            CLASS_MENU_OPEN
        );


        setAriaExpanded(
            item,
            false
        );


        if (submenu) {

            slideUp(
                submenu,
                config.animationSpeed
            );

        }

    }


    function closeSiblingTreeItems(item) {

        const parent =
            item.parentElement;


        if (!parent) {

            return;

        }


        Array.from(
            parent.children
        ).forEach(
            function (sibling) {

                if (
                    sibling === item ||
                    !sibling.classList.contains(
                        SELECTOR_NAV_ITEM.slice(1)
                    )
                ) {

                    return;

                }


                closeTreeItem(
                    sibling
                );

            }
        );

    }


    function setAriaExpanded(
        item,
        expanded
    ) {

        const toggle =
            item.querySelector(
                SELECTOR_NAV_TOGGLE
            );


        if (toggle) {

            toggle.setAttribute(
                'aria-expanded',
                String(expanded)
            );

        }


        const link =
            item.querySelector(
                SELECTOR_NAV_LINK
            );


        if (
            link &&
            item.querySelector(
                SELECTOR_NAV_TREE
            )
        ) {

            link.setAttribute(
                'aria-expanded',
                String(expanded)
            );

        }

    }


    /* =====================================================
       TREE ANIMATION
       ===================================================== */

    function slideDown(
        element,
        duration
    ) {

        element.hidden = false;

        element.style.display =
            'block';

        const height =
            element.scrollHeight;


        element.style.overflow =
            'hidden';

        element.style.height =
            '0px';


        requestAnimationFrame(
            function () {

                element.style.transition =
                    `height ${duration}ms ease`;

                element.style.height =
                    `${height}px`;

            }
        );


        window.setTimeout(
            function () {

                element.style.height =
                    '';

                element.style.overflow =
                    '';

                element.style.transition =
                    '';

            },
            duration
        );

    }


    function slideUp(
        element,
        duration
    ) {

        element.style.overflow =
            'hidden';

        element.style.height =
            `${element.scrollHeight}px`;


        requestAnimationFrame(
            function () {

                element.style.transition =
                    `height ${duration}ms ease`;

                element.style.height =
                    '0px';

            }
        );


        window.setTimeout(
            function () {

                element.style.display =
                    'none';

                element.style.height =
                    '';

                element.style.overflow =
                    '';

                element.style.transition =
                    '';

            },
            duration
        );

    }


    /* =====================================================
       ACTIVE PARENTS
       ===================================================== */

    function openActiveParents() {

        const activeLink =
            sidebar.querySelector(
                '.pixelfix-sidebar-nav-link.active'
            );


        if (!activeLink) {

            return;

        }


        let item =
            activeLink.closest(
                SELECTOR_NAV_ITEM
            );


        while (item) {

            const submenu =
                item.querySelector(
                    SELECTOR_NAV_TREE
                );


            if (submenu) {

                item.classList.add(
                    CLASS_MENU_OPEN
                );


                setAriaExpanded(
                    item,
                    true
                );


                submenu.style.display =
                    'block';

            }


            item =
                item.parentElement
                    ?.closest(
                        SELECTOR_NAV_ITEM
                    );

        }

    }


    /* =====================================================
       SEARCH
       ===================================================== */

    function initialiseSearch() {

        sidebar.querySelectorAll(
            SELECTOR_SEARCH
        ).forEach(
            function (input) {

                input.addEventListener(
                    'input',
                    function () {

                        filterMenu(
                            input
                        );

                    }
                );


                input.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Escape'
                        ) {

                            input.value = '';

                            clearMenuSearch(
                                input
                            );

                        }

                    }
                );

            }
        );

    }


    function filterMenu(input) {

        const query =
            input.value
                .trim()
                .toLowerCase();


        const targetSelector =
            input.dataset.pixelfixTarget;


        const menu =
            targetSelector
                ? document.querySelector(
                    targetSelector
                )
                : sidebar.querySelector(
                    SELECTOR_MENU
                );


        if (!menu) {

            return;

        }


        if (!query) {

            clearMenuSearch(
                input
            );

            return;

        }


        if (!searchSnapshot) {

            searchSnapshot =
                takeSearchSnapshot(
                    menu
                );

        }


        const items =
            Array.from(
                menu.querySelectorAll(
                    SELECTOR_NAV_ITEM
                )
            );


        const matched =
            new Set();


        /* =================================================
           FIND DIRECT MATCHES
           ================================================= */

        items.forEach(
            function (item) {

                const link =
                    item.querySelector(
                        SELECTOR_NAV_LINK
                    );


                const label =
                    link
                        ?.textContent
                        ?.replace(
                            /\s+/g,
                            ' '
                        )
                        .trim()
                        .toLowerCase() || '';


                if (
                    label.includes(query)
                ) {

                    matched.add(item);

                }

            }
        );


        /* =================================================
           INITIAL VISIBILITY
           ================================================= */

        items.forEach(
            function (item) {

                item.hidden = true;

            }
        );


        /* =================================================
           MATCHED ITEMS + DESCENDANTS
           ================================================= */

        matched.forEach(
            function (item) {

                item.hidden =
                    false;


                item.querySelectorAll(
                    SELECTOR_NAV_ITEM
                ).forEach(
                    function (descendant) {

                        descendant.hidden =
                            false;

                    }
                );

            }
        );


        /* =================================================
           REVEAL PARENTS
           ================================================= */

        for (
            let index = items.length - 1;
            index >= 0;
            index--
        ) {

            const item =
                items[index];


            const childVisible =
                item.querySelector(
                    `${SELECTOR_NAV_ITEM}:not([hidden])`
                );


            if (
                matched.has(item) ||
                childVisible
            ) {

                item.hidden =
                    false;

            }

        }


        /* =================================================
           EXPAND MATCHING BRANCHES
           ================================================= */

        let visibleCount = 0;


        items.forEach(
            function (item) {

                if (!item.hidden) {

                    visibleCount++;

                }


                const submenu =
                    item.querySelector(
                        SELECTOR_NAV_TREE
                    );


                if (!submenu) {

                    return;

                }


                const childVisible =
                    Boolean(
                        item.querySelector(
                            `${SELECTOR_NAV_ITEM}:not([hidden])`
                        )
                    );


                const shouldOpen =
                    !item.hidden &&
                    childVisible;


                item.classList.toggle(
                    CLASS_MENU_OPEN,
                    shouldOpen
                );


                setAriaExpanded(
                    item,
                    shouldOpen
                );


                submenu.style.display =
                    shouldOpen
                        ? 'block'
                        : 'none';

            }
        );


        /* =================================================
           HIDE HEADERS DURING SEARCH
           ================================================= */

        menu.querySelectorAll(
            '.pixelfix-sidebar-nav-header'
        ).forEach(
            function (header) {

                header.hidden =
                    true;

            }
        );


        /* =================================================
           EMPTY STATE
           ================================================= */

        const empty =
            sidebar.querySelector(
                SELECTOR_EMPTY
            );


        if (empty) {

            empty.hidden =
                visibleCount > 0;

        }

    }


    function clearMenuSearch(input) {

        const targetSelector =
            input.dataset.pixelfixTarget;


        const menu =
            targetSelector
                ? document.querySelector(
                    targetSelector
                )
                : sidebar.querySelector(
                    SELECTOR_MENU
                );


        if (!menu) {

            return;

        }


        menu.querySelectorAll(
            `${SELECTOR_NAV_ITEM}, .pixelfix-sidebar-nav-header`
        ).forEach(
            function (item) {

                item.hidden =
                    false;

            }
        );


        if (searchSnapshot) {

            searchSnapshot.forEach(
                function (state, item) {

                    const submenu =
                        item.querySelector(
                            SELECTOR_NAV_TREE
                        );


                    item.classList.toggle(
                        CLASS_MENU_OPEN,
                        state.open
                    );


                    setAriaExpanded(
                        item,
                        state.open
                    );


                    if (submenu) {

                        submenu.style.display =
                            state.display;

                    }

                }
            );


            searchSnapshot =
                null;

        }


        const empty =
            sidebar.querySelector(
                SELECTOR_EMPTY
            );


        if (empty) {

            empty.hidden =
                true;

        }

    }


    function takeSearchSnapshot(menu) {

        const snapshot =
            new Map();


        menu.querySelectorAll(
            SELECTOR_NAV_ITEM
        ).forEach(
            function (item) {

                const submenu =
                    item.querySelector(
                        SELECTOR_NAV_TREE
                    );


                if (!submenu) {

                    return;

                }


                snapshot.set(
                    item,
                    {
                        open:
                            item.classList.contains(
                                CLASS_MENU_OPEN
                            ),

                        display:
                            submenu.style.display ||
                            ''
                    }
                );

            }
        );


        return snapshot;

    }


    /* =====================================================
       KEYBOARD
       ===================================================== */

    function initialiseKeyboard() {

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key !== 'Escape'
                ) {

                    return;

                }


                if (isMobile() && isOpen()) {

                    collapse();

                }

            }
        );

    }


    /* =====================================================
       RESPONSIVE
       ===================================================== */

    function initialiseResponsive() {

        const mediaQuery =
            window.matchMedia(
                `(max-width: ${config.breakpoint}px)`
            );


        updateResponsiveState();


        if (
            mediaQuery.addEventListener
        ) {

            mediaQuery.addEventListener(
                'change',
                function () {

                    updateResponsiveState();

                }
            );

        }

    }


    function updateResponsiveState() {

        if (isMobile()) {

            if (!isOpen()) {

                collapse();

            }

            return;

        }


        document.body.classList.remove(
            CLASS_OPEN
        );


        if (
            isMini() &&
            isCollapsed()
        ) {

            return;

        }


        expand();

    }


    /* =====================================================
       PERSISTENCE
       ===================================================== */

    function initialisePersistence() {

        if (!config.persistence) {

            return;

        }


        if (isMobile()) {

            return;

        }


        loadState();

    }


    function saveState(state) {

        if (!config.persistence) {

            return;

        }


        try {

            localStorage.setItem(
                STORAGE_KEY,
                state
            );

        } catch (error) {

            // localStorage may be unavailable.

        }

    }


    function loadState() {

        try {

            const state =
                localStorage.getItem(
                    STORAGE_KEY
                );


            if (
                state === CLASS_COLLAPSE
            ) {

                collapse();

                return;

            }


            if (
                state === CLASS_OPEN
            ) {

                expand();

                return;

            }


            updateResponsiveState();

        } catch (error) {

            updateResponsiveState();

        }

    }


    /* =====================================================
       START
       ===================================================== */

    document.addEventListener(
        'DOMContentLoaded',
        init
    );

})();