# Messages Header Component

Renders PixelFix's Messages dropdown in the application header, including the unread count, message previews, avatars or initials, and an optional footer link.

**Component:** `components/layout/header/messages.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `messages` | `[]` | Collection of message objects. |
| `message_count` | `messages\|length` | Number shown in the unread badge. |
| `show` | `true` | Whether to render the whole header item. Explicit `false` hides it. |
| `id` | `pixelfix-messages-toggle` | ID of the dropdown trigger button. |
| `menu_id` | `pixelfix-messages-dropdown` | ID of the dropdown menu. |
| `aria_label` | `Messages: {count} unread` | Accessible name for the trigger; the default includes the count. |
| `title` | `''` | Optional trigger title. |
| `icon` | `chat-left-text` | Bootstrap Icon name or class. Set to `''` to omit it. |
| `control_class` | `''` | Additional class for the trigger. `link_class` is accepted as an alias. |
| `class` | `''` | Additional trigger class, appended to `control_class` / `link_class`. |
| `item_class` | `pixelfix-nav-item dropdown` | Classes on the outer list item. |
| `menu_class` | `''` | Additional dropdown-menu class. |
| `badge_class` | `''` | Additional unread-badge class. |
| `show_footer` | `true` | Whether the footer may be rendered. A destination is still required. |
| `messages_url` | `''` | Direct URL for the footer. `messages_footer_url` is an alias. |
| `messages_route` | `''` | Named route for the footer; takes precedence over direct URLs. `messages_footer_route` and `messages_url_route` are aliases. |
| `messages_route_parameters` | `[]` | Parameters passed to the named footer route. Footer route parameter aliases are also supported. |
| `messages_footer_text` | `See All Messages` | Footer link text. |
| `messages_footer_target` | `''` | Optional footer target. |
| `messages_footer_rel` | automatic for `_blank` | Optional footer relationship. The Button component supplies `noopener noreferrer` for `_blank` if no `rel` is provided. |
| `footer_class` | `''` | Additional class for the footer link. |
| `empty_text` | `No messages` | Text shown when the collection is empty. |

## Message object

| Property | Default | Description |
|---|---|---|
| `id` | — | Optional identifier, rendered as `pixelfix-message-{id}` on linked messages. |
| `name` | `Unknown User` | Sender name. |
| `preview` | `''` | Message preview. |
| `time` | `''` | Relative or formatted message time. |
| `avatar` | `null` | Avatar image URL. When omitted, initials are rendered using the Badge component. |
| `avatar_alt` | sender name | Alternative text for the avatar. |
| `initials` | First character of sender name | Text shown in the Badge when there is no avatar. |
| `badge_type` | Random supported type | Badge color for initials: `primary`, `secondary`, `success`, `danger`, `warning`, `info`, or `dark`. |
| `star_type` | `text-secondary` | CSS class controlling the star color. |
| `url` | `''` | Direct destination for a message. `href` is an alias. No `#` fallback is generated. |
| `route` | `''` | Named route for the message. Takes precedence over `url` / `href`. `url_route` and `route_name` are aliases. |
| `route_parameters` | `[]` | Parameters passed to the named route. `url_route_parameters` and `parameters` are aliases. |
| `target` | `''` | Optional link target. |
| `rel` | automatic for `_blank` | Optional relationship; defaults to `noopener noreferrer` for `_blank`. |
| `aria_label` | `''` | Optional accessible name for a linked message. |
| `title` | `''` | Optional link title. |
| `item_class` | `''` | Additional class on a message item. |

If a message has no URL or named route, it is displayed as a non-link item to preserve the dropdown's layout without producing a dead link. Named routes are generated through PixelFix's `route()` helper. Route names and parameters must match routes registered by the application.

## Basic usage with direct URLs

```twig
{% set messages = [
    {
        id: 1,
        name: 'Brad Diesel',
        preview: 'Call me whenever you can...',
        time: '4 Hours Ago',
        avatar: 'https://example.test/avatars/brad.png',
        initials: 'BD',
        star_type: 'text-danger',
        url: '/messages/1',
    },
    {
        id: 2,
        name: 'John Pierce',
        preview: 'I got your message bro',
        time: '4 Hours Ago',
        initials: 'JP',
        url: '/messages/2',
    },
] %}

{% include
    'components/layout/header/messages.twig'
    with {
        messages: messages,
        message_count: messages|length,
        messages_url: '/messages',
        messages_footer_text: 'See All Messages',
    }
    only
%}
```

## Named routes for message items

Each message can use a named route and parameter map instead of a URL. The route takes precedence when both are supplied.

```twig
{% set messages = [
    {
        id: 42,
        name: 'Nora Silvester',
        preview: 'The subject goes here',
        time: 'Just now',
        initials: 'NS',
        url: '/messages/fallback',
        route: 'messages.show',
        route_parameters: {
            id: 42,
        },
    },
] %}
```

The example uses illustrative route names. `route: 'messages.show'` will override `url: '/messages/fallback'` and generate the URL through `route('messages.show', {'id': 42})`.

## Named route for the footer

```twig
{% include
    'components/layout/header/messages.twig'
    with {
        messages: messages,
        message_count: messages|length,
        messages_route: 'messages.index',
        messages_route_parameters: {
            folder: 'inbox',
        },
        messages_footer_text: 'View All Messages',
    }
    only
%}
```

The footer is omitted unless a direct URL or named route resolves to a non-empty destination. Set `show_footer: false` to suppress it even when a destination is supplied. The route takes precedence over `messages_url` when both are configured.

## Empty state and optional footer

```twig
{% include
    'components/layout/header/messages.twig'
    with {
        messages: [],
        message_count: 0,
        show_footer: false,
        empty_text: 'You are all caught up',
    }
    only
%}
```

## Customization

```twig
{% include
    'components/layout/header/messages.twig'
    with {
        messages: messages,
        messages_url: '/messages',
        messages_footer_text: 'Open inbox',
        aria_label: 'Open messages inbox',
        title: 'Messages',
        icon: 'envelope',
        id: 'header-messages-toggle',
        menu_id: 'header-messages-menu',
        control_class: 'px-2',
        menu_class: 'shadow-sm',
        badge_class: 'rounded-pill',
        footer_class: 'fw-semibold',
    }
    only
%}
```

All Twig hash examples use trailing commas, including after the final entry.
