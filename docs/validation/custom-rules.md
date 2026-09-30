# Custom Validation Rules

When a field has a domain-specific constraint that does not fit the built-in rules, PixelFix's validation contracts allow custom rule objects.

## Rule contract

Custom rules implement:

```php
PixelFix\Framework\Validation\Contracts\RuleInterface
```

The exact method contract should be followed from the current interface in the framework source.

## When to create a rule object

Prefer a custom rule object when the rule:

- represents domain logic rather than simple syntax;
- is reused across multiple requests;
- needs dependencies or more structured logic;
- would become difficult to read as an inline callback.

Keep simple constraints as built-in rules:

```php
'email' => ['required', 'email', 'max:255']
```

## Discovery

PixelFix's console discovery layer includes rule discovery for application tooling. Generated or discovered rules should still be treated as application code and kept focused on validation concerns.
