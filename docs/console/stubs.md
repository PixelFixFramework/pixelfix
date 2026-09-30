# Stubs

PixelFix generators use stubs as source templates for generated application artifacts.

## Publishing stubs

The framework provides the `stub:publish` command for projects that need to publish or customize generator templates.

```bash
php pixelfix stub:publish
```

The exact published set should be treated as part of the current framework's generator conventions rather than assumed to be identical across framework versions.

## Stub placeholders

Generator commands supply framework placeholders such as:

```text
{{ class }}
{{ base }}
{{ variable }}
{{ singular }}
{{ plural }}
{{ table }}
{{ namespace }}
{{ fqcn }}
```

Individual generators can add artifact-specific placeholders. For example, model-related generation may provide model and model-namespace values to factory or seeder stubs.

## Customization

Use published stubs when the desired customization is template-level. Use a custom generator or command when the desired change affects discovery, validation, planning, generation behavior, or workflow semantics.
