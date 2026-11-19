# daisy-gutenberg

A collection of reusable Gutenberg blocks built on [daisyUI](https://daisyui.com/) and Tailwind CSS.

> **Status:** early development. Block names, attributes, and APIs may change before 1.0.

> **Disclaimer:** This project is not affiliated with, endorsed by, or sponsored by daisyUI or Tailwind Labs. daisyUI and Tailwind CSS are used under their respective licenses.

## Why

daisyUI provides well-designed, semantic components as pure CSS classes. This plugin turns them into native WordPress blocks, so editors can build polished pages in the block editor without writing code, and developers get a consistent, extensible component set.

## Features

- Native Gutenberg blocks mapped to daisyUI components (Button, Badge, Alert, Card, and more)
- Visual controls for variant, size, and style in the block sidebar
- Server-side rendering, so markup improvements reach existing content without breaking posts
- Prefixed CSS classes (`[dg-]`) to avoid collisions with themes and other plugins
- Per-block asset loading: styles load only on pages that use the blocks
- daisyUI theme support, with a bridge to `theme.json`
- Accessible by default, using native elements (`<dialog>`, `<details>`) where possible
- Translation-ready

## Requirements

| | Minimum | Tested up to |
|---|---|---|
| WordPress | 6.7 | latest |
| PHP | [8.1] | 8.5 |

## Installation

- **WordPress.org:** search for "[plugin name]" under Plugins → Add New, then activate.
- **Manual:** download the latest release zip from the [Releases](#) page, then upload it via Plugins → Add New → Upload Plugin.

## Blocks

| Block | Status |
|---|---|
| Button | Planned (first block) |
| Badge, Alert, Divider, Avatar | Planned |
| Card, Hero, Stats | Planned |
| Modal, Collapse, Tabs | Planned |

## Roadmap

1. Tooling, build pipeline, and the Button block
2. Shared class builders and Inspector controls
3. Simple leaf blocks
4. Compound blocks with InnerBlocks
5. Interactive blocks
6. Theming, settings, patterns, and docs

## Development

Setup instructions will be added once the scaffold lands. The stack:

- `@wordpress/scripts` build pipeline
- TypeScript and React (provided by WordPress)
- Tailwind CSS v4 with daisyUI v5
- `wp-env` for local development
- Jest and Playwright for tests

## Contributing

Issues and pull requests are welcome. Please open an issue to discuss larger changes first. A full contributing guide will follow.

## License

MIT License. See [LICENSE](LICENSE).
