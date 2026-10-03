# Messages Header Item

Renders the messages dropdown in the application header.

The component accepts a collection of message objects and renders the
messages in the application header.

**Component:** `components/layout/header/messages.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `messages` | `[]` | Array of message objects displayed in the dropdown. |
| `message_count` | `messages\|length` | Number of unread messages displayed in the badge. |
| `messages_url` | `#` | URL used by the Messages footer. |
| `messages_footer_text` | `See All Messages` | Text displayed by the Messages footer. |

---

## Message Object

Each item in `messages` represents one message.

| Property | Default | Description |
|---|---|---|
| `id` | — | Unique message identifier. |
| `name` | `Unknown User` | Name of the message sender. |
| `preview` | `''` | Message preview text. |
| `time` | `''` | Relative or formatted message time. |
| `avatar` | `null` | Avatar image URL. |
| `initials` | Derived | Initials displayed when an avatar is unavailable. |
| `badge_type` | Random | Badge type used for the initials fallback. |
| `star_type` | `text-secondary` | CSS class controlling the star color. |
| `url` | `#` | URL opened when the message is selected. |

---

# Usage

The Messages component is included using Twig's `include` statement.

Before including the component, create a `messages` collection.

For example:

```twig
{% set messages = [
    {
        id: 1,
        name: 'Brad Diesel',
        preview: 'Call me whenever you can...',
        time: '4 Hours Ago',
        avatar: 'https://i.pravatar.cc/96?img=12',
        initials: 'BD',
        star_type: 'text-danger',
        url: '#'
    },
    {
        id: 2,
        name: 'John Pierce',
        preview: 'I got your message bro',
        time: '4 Hours Ago',
        avatar: 'https://i.pravatar.cc/96?img=11',
        initials: 'JP',
        star_type: 'text-secondary',
        url: '#'
    },
    {
        id: 3,
        name: 'Nora Silvester',
        preview: 'The subject goes here',
        time: '4 Hours Ago',
        avatar: null,
        initials: 'NS',
        badge_type: 'warning',
        star_type: 'text-warning',
        url: '#'
    }
] %}

{% include
    'components/layout/header/messages.twig'
    with {
        messages:
            messages,

        message_count:
            messages|length,

        messages_url:
            '#',

        messages_footer_text:
            'See All the new Messages'
    }
    only
%}
```

---

## Message Count

When `message_count` is not supplied, the component uses:

```twig
messages|length
```

The value is displayed as the unread message count in the header badge.

An explicit count can also be supplied:

```twig
{% include
    'components/layout/header/messages.twig'
    with {
        messages:
            messages,

        message_count:
            5,

        messages_url:
            '#',

        messages_footer_text:
            'See All Messages'
    }
    only
%}
```

---

## Avatar

When `avatar` is supplied, the component displays the avatar image.

```twig
{
    id: 1,
    name: 'Brad Diesel',
    avatar: 'https://i.pravatar.cc/96?img=12',
    initials: 'BD'
}
```

When `avatar` is not supplied, the component displays the message initials using the reusable Badge component.

---

## Initials

The component uses `initials` when an avatar is unavailable.

```twig
{
    id: 3,
    name: 'Nora Silvester',
    avatar: null,
    initials: 'NS'
}
```

When `initials` is not supplied, the component derives the value from the first character of `name`.

---

## Badge Type

The `badge_type` property controls the Badge used when an avatar is unavailable.

```twig
{
    id: 3,
    name: 'Nora Silvester',
    avatar: null,
    initials: 'NS',
    badge_type: 'warning'
}
```

Supported badge types are:

- `primary`
- `secondary`
- `success`
- `danger`
- `warning`
- `info`
- `dark`

When `badge_type` is not supplied, the component selects a supported badge type automatically.

---

## Message Link

The `url` property determines where the user is taken when a message is selected.

```twig
{
    id: 1,
    name: 'Brad Diesel',
    preview: 'Call me whenever you can...',
    time: '4 Hours Ago',
    url: '/messages/1'
}
```

When `url` is not supplied, the component uses `#`.

---

## Empty State

When the `messages` collection is empty, the component displays:

```text
No messages
```

Example:

```twig
{% include
    'components/layout/header/messages.twig'
    with {
        messages:
            [],

        message_count:
            0,

        messages_url:
            '#',

        messages_footer_text:
            'See All Messages'
    }
    only
%}
```

---

## Footer

The Messages footer uses the reusable Button component.

The footer URL is controlled by `messages_url`.

The footer text is controlled by `messages_footer_text`.

Example:

```twig
{% include
    'components/layout/header/messages.twig'
    with {
        messages:
            messages,

        message_count:
            messages|length,

        messages_url:
            '/messages',

        messages_footer_text:
            'View All Messages'
    }
    only
%}
```

Default values:

| Parameter | Default |
|---|---|
| `messages_url` | `#` |
| `messages_footer_text` | `See All Messages` |

---

## Complete Example

```twig
{% set messages = [
    {
        id: 1,
        name: 'Brad Diesel',
        preview: 'Call me whenever you can...',
        time: '4 Hours Ago',
        avatar: 'https://i.pravatar.cc/96?img=12',
        initials: 'BD',
        star_type: 'text-danger',
        url: '#'
    },
    {
        id: 2,
        name: 'John Pierce',
        preview: 'I got your message bro',
        time: '4 Hours Ago',
        avatar: 'https://i.pravatar.cc/96?img=11',
        initials: 'JP',
        star_type: 'text-secondary',
        url: '#'
    },
    {
        id: 3,
        name: 'Nora Silvester',
        preview: 'The subject goes here',
        time: '4 Hours Ago',
        avatar: null,
        initials: 'NS',
        badge_type: 'warning',
        star_type: 'text-warning',
        url: '#'
    }
] %}

{% include
    'components/layout/header/messages.twig'
    with {
        messages:
            messages,

        message_count:
            messages|length,

        messages_url:
            '#',

        messages_footer_text:
            'See All the new Messages'
    }
    only
%}
```

---

## Integration With Default Header

The Default Header component passes the Messages configuration to the Messages component.

The supported parameters are:

| Parameter | Default | Description |
|---|---|---|
| `messages` | `[]` | Message collection. |
| `message_count` | `messages\|length` | Unread message count. |
| `messages_url` | `#` | Messages footer URL. |
| `messages_footer_text` | `See All Messages` | Messages footer text. |

Example:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        messages:
            messages,

        message_count:
            messages|length,

        messages_url:
            '/messages',

        messages_footer_text:
            'View All Messages'
    }
    only
%}
```
