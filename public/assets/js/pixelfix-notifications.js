/*
 * PixelFix generic live-notification client.
 *
 * Listens for notification-shaped broadcast payloads on the channel declared by
 * a notification component's `data-pixelfix-broadcast-channel` attribute. No
 * application event class, route, action vocabulary, or business domain is
 * hard-coded here.
 */
(function (root, document) {
    'use strict';

    var triggerSelector = '[data-pixelfix-broadcast-channel]';

    function cleanString(value) {
        return typeof value === 'string' ? value.trim() : '';
    }

    function readCount(trigger, header) {
        var rawCount = trigger.getAttribute('data-pixelfix-notification-count');
        var dataCount = Number(rawCount);
        var badge = trigger.querySelector('.pixelfix-navbar-badge');
        var match;

        if (rawCount !== null && rawCount !== '' && Number.isFinite(dataCount) && dataCount >= 0) {
            return Math.floor(dataCount);
        }
        if (badge) {
            match = cleanString(badge.textContent).match(/\d+/);
            if (match) {
                return parseInt(match[0], 10) || 0;
            }
        }
        if (header) {
            match = cleanString(header.textContent).match(/\d+/);
            if (match) {
                return parseInt(match[0], 10) || 0;
            }
        }
        match = cleanString(trigger.getAttribute('aria-label')).match(/(\d+)\s+unread/i);
        return match ? (parseInt(match[1], 10) || 0) : 0;
    }

    function getMenu(trigger) {
        var menuId = cleanString(trigger.getAttribute('aria-controls'));
        if (menuId) {
            var controlledMenu = document.getElementById(menuId);
            if (controlledMenu) {
                return controlledMenu;
            }
        }
        return trigger.parentElement
            ? trigger.parentElement.querySelector('.dropdown-menu')
            : null;
    }

    function normalizeUrl(value) {
        var candidate = cleanString(value);
        var parsed;

        if (!candidate || candidate.charAt(0) === '#' || candidate.indexOf('\\') !== -1) {
            return '';
        }
        try {
            parsed = new URL(candidate, root.location && root.location.origin ? root.location.origin : undefined);
        } catch (error) {
            return '';
        }
        if (parsed.protocol !== 'http:' && parsed.protocol !== 'https:') {
            return '';
        }
        if (root.location && root.location.origin && parsed.origin === root.location.origin) {
            return parsed.pathname + parsed.search + parsed.hash;
        }
        return parsed.href;
    }

    function normalizedIcon(value) {
        var icon = cleanString(value);
        if (!icon) {
            return 'bi bi-bell';
        }
        if (icon.indexOf('bi ') === 0 || /\s/.test(icon)) {
            return icon;
        }
        if (icon.indexOf('bi-') === 0) {
            return 'bi ' + icon;
        }
        return 'bi bi-' + icon;
    }

    function normalizeNotificationPayload(payload) {
        var candidate = payload;
        var title;
        var message;

        if (!candidate || typeof candidate !== 'object' || Array.isArray(candidate)) {
            return null;
        }

        // Some event serializers wrap the notification's own payload in `data`.
        if (candidate.data && typeof candidate.data === 'object' && !Array.isArray(candidate.data)
            && !cleanString(candidate.title) && !cleanString(candidate.text)
            && !cleanString(candidate.message) && !cleanString(candidate.subject)) {
            candidate = candidate.data;
        }

        title = cleanString(candidate.title)
            || cleanString(candidate.text)
            || cleanString(candidate.subject)
            || cleanString(candidate.message);
        message = cleanString(candidate.message)
            || cleanString(candidate.text)
            || cleanString(candidate.title)
            || title;

        // Do not treat arbitrary broadcast events as user-facing notifications.
        if (!title && !message) {
            return null;
        }

        return {
            source: candidate,
            title: title || 'Notification',
            message: message || title || 'You have a new notification.',
            url: normalizeUrl(candidate.url || candidate.href || candidate.link),
            icon: normalizedIcon(candidate.icon),
            time: cleanString(candidate.time) || cleanString(candidate.created_at) || 'Just now',
            eventId: cleanString(candidate.event_id || candidate.notification_id),
            target: cleanString(candidate.target),
            rel: cleanString(candidate.rel),
            unread: candidate.unread !== false
        };
    }

    function alreadyDisplayed(menu, eventId) {
        var rows;
        var index;
        if (!eventId) {
            return false;
        }
        rows = menu.querySelectorAll('[data-pixelfix-notification-event]');
        for (index = 0; index < rows.length; index += 1) {
            if (cleanString(rows[index].getAttribute('data-pixelfix-notification-event')) === eventId) {
                return true;
            }
        }
        return false;
    }

    function updateCount(trigger, header, count) {
        var badge = trigger.querySelector('.pixelfix-navbar-badge');
        var baseLabel = cleanString(trigger.getAttribute('data-pixelfix-notifications-label')) || 'Notifications';

        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'pixelfix-navbar-badge badge text-bg-warning';
            trigger.appendChild(badge);
        }
        badge.textContent = String(count);
        badge.setAttribute('aria-hidden', 'true');
        trigger.setAttribute('data-pixelfix-notification-count', String(count));
        trigger.setAttribute('aria-label', baseLabel + ': ' + count + ' unread');

        if (header) {
            var headerFormat = cleanString(header.getAttribute('data-pixelfix-notifications-header-format')) || 'count-prefix';
            var headerText = cleanString(header.getAttribute('data-pixelfix-notifications-header-text')) || 'Notifications';
            if (headerFormat === 'unread-suffix') {
                header.textContent = headerText + ' (' + count + ' unread)';
            } else {
                header.textContent = count + ' ' + headerText;
            }
        }
    }

    function createNotificationItem(notification) {
        var item = document.createElement(notification.url ? 'a' : 'div');
        var content = document.createElement('span');
        var icon = document.createElement('i');
        var title = document.createElement('span');
        var time = document.createElement('span');

        item.className = 'dropdown-item' + (notification.unread ? ' fw-semibold' : '');
        if (notification.url) {
            item.href = notification.url;
            item.setAttribute('aria-label', 'Open notification: ' + notification.title);
            if (notification.target) {
                item.target = notification.target;
                if (notification.target === '_blank') {
                    item.rel = notification.rel || 'noopener noreferrer';
                } else if (notification.rel) {
                    item.rel = notification.rel;
                }
            } else if (notification.rel) {
                item.rel = notification.rel;
            }
        } else {
            item.setAttribute('role', 'status');
        }

        content.className = 'pixelfix-notification-preview-content';
        if (notification.eventId) {
            content.setAttribute('data-pixelfix-notification-event', notification.eventId);
        }
        icon.className = notification.icon + ' pixelfix-notification-preview-icon me-2';
        icon.setAttribute('aria-hidden', 'true');
        title.className = 'pixelfix-notification-preview-title';
        title.textContent = notification.title;
        time.className = 'pixelfix-notification-preview-time text-secondary fs-7';
        time.textContent = notification.time;

        content.appendChild(icon);
        content.appendChild(title);
        content.appendChild(time);
        item.appendChild(content);

        return item;
    }

    function addNotification(trigger, rawPayload, envelope, seenBroadcastIds, seenEventIds) {
        var menu = getMenu(trigger);
        var header = menu ? menu.querySelector('.dropdown-header') : null;
        var notification = normalizeNotificationPayload(rawPayload);
        var broadcastId = envelope && cleanString(envelope.broadcast_id);
        var eventId;
        var emptyState;
        var firstDivider;
        var item;
        var insertBefore;
        var separator;
        var count;

        if (!menu || !header || !notification) {
            return;
        }

        eventId = notification.eventId;
        if (broadcastId && seenBroadcastIds[broadcastId]) {
            return;
        }
        if (eventId && (seenEventIds[eventId] || alreadyDisplayed(menu, eventId))) {
            return;
        }
        if (broadcastId) {
            seenBroadcastIds[broadcastId] = true;
        }
        if (eventId) {
            seenEventIds[eventId] = true;
        }

        emptyState = menu.querySelector('[data-pixelfix-notifications-empty-state]');
        if (emptyState) {
            emptyState.remove();
        }

        firstDivider = header.nextElementSibling;
        if (firstDivider && firstDivider.classList && firstDivider.classList.contains('dropdown-divider')) {
            insertBefore = firstDivider.nextElementSibling;
        } else {
            firstDivider = document.createElement('div');
            firstDivider.className = 'dropdown-divider';
            header.insertAdjacentElement('afterend', firstDivider);
            insertBefore = firstDivider.nextElementSibling;
        }

        item = createNotificationItem(notification);
        if (insertBefore) {
            menu.insertBefore(item, insertBefore);
        } else {
            menu.appendChild(item);
        }

        separator = document.createElement('div');
        separator.className = 'dropdown-divider';
        menu.insertBefore(separator, item.nextSibling);

        count = readCount(trigger, header) + 1;
        updateCount(trigger, header, count);

        if (root.toastr && typeof root.toastr.info === 'function') {
            root.toastr.info(notification.message, notification.title);
        }
    }

    function startTrigger(trigger) {
        var channel = cleanString(trigger.getAttribute('data-pixelfix-broadcast-channel'));
        var client;
        var seenBroadcastIds = Object.create(null);
        var seenEventIds = Object.create(null);

        if (!channel) {
            return;
        }
        if (!root.PixelFixBroadcasting || typeof root.PixelFixBroadcasting.create !== 'function') {
            if (root.console && typeof root.console.warn === 'function') {
                root.console.warn('PixelFix live notifications are configured, but the browser broadcasting client is unavailable.');
            }
            trigger.setAttribute('data-pixelfix-broadcast-status', 'unavailable');
            return;
        }

        client = root.PixelFixBroadcasting.create({ reconnect: true });
        client.on('websocket.subscription_succeeded', function (payload) {
            if (payload && payload.channel === channel) {
                trigger.setAttribute('data-pixelfix-broadcast-status', 'connected');
            }
        });
        client.on('websocket.subscription_error', function (payload) {
            if (payload && payload.channel === channel) {
                trigger.setAttribute('data-pixelfix-broadcast-status', 'error');
            }
            if (root.console && typeof root.console.error === 'function') {
                root.console.error('PixelFix notification channel subscription failed.', payload);
            }
        });
        client.on('close', function () {
            trigger.setAttribute('data-pixelfix-broadcast-status', 'disconnected');
        });
        client.onAny(function (eventName, payload, envelope) {
            addNotification(trigger, payload, envelope, seenBroadcastIds, seenEventIds);
        });

        client.subscribe(channel);
        try {
            client.connect();
        } catch (error) {
            trigger.setAttribute('data-pixelfix-broadcast-status', 'error');
            if (root.console && typeof root.console.error === 'function') {
                root.console.error('PixelFix live notifications could not connect.', error);
            }
        }
    }

    function start() {
        var triggers = document.querySelectorAll(triggerSelector);
        var index;
        for (index = 0; index < triggers.length; index += 1) {
            startTrigger(triggers[index]);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start, { once: true });
    } else {
        start();
    }
}(window, document));
