# Messages Header Item

Renders the messages dropdown in the application header.

The component supports a configurable message collection, unread message count, message links, configurable footer text, user avatars, badge fallbacks, message previews, timestamps, and star styling.

**Component:** `components/layout/header/messages.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `messages` | `[]` | Array of message objects displayed in the dropdown. |
| `message_count` | `messages|length` | Number of unread messages displayed in the header badge and accessible label. |
| `messages_url` | `#` | URL used by the "See All Messages" footer button. |
| `messages_footer_text` | `See All Messages` | Text displayed by the messages footer button. |

## Message Object Parameters

Each item in the `messages` array may contain the following properties:

| Property | Default | Description |
|---|---|---|
| `id` | — | Unique identifier for the message. |
| `name` | `Unknown User` | Name of the message sender. |
| `preview` | `''` | Short preview of the message content. |
| `time` | `''` | Relative or formatted message time. |
| `avatar` | `null` | Avatar image URL. |
| `initials` | First character of name | Initials displayed when no avatar is available. |
| `badge_type` | Random Bootstrap badge type | Badge type used for the initials fallback. |
| `star_type` | `text-secondary` | CSS text color class applied to the star icon. |
| `url` | `#` | URL opened when the message is selected. |

## Avatar Behavior

When `avatar` is provided, the component renders the image:

```twig
{% if message.avatar|default(null) %}

    <img
        src="{{ message.avatar }}"
        alt="{{ message.name|default('User') }}"
    >

{% endif %}