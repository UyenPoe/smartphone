# PhoneX frontend structure

## Runtime
Each functional page exposes one public `index.html`. The shared responsive loader selects the Stitch desktop/tablet/mobile view at 600px and 1024px breakpoints without redirecting the browser URL.

## Shared assets
- `assets/css/app.css`: project-level tokens and shell styles
- `assets/js/responsive-loader.js`: shared responsive view loader
- `components/`: extraction target for header/footer/product cards during WordPress theme conversion

## Preserved design source
Desktop/tablet/mobile HTML and PNG files remain beside each page, and original Stitch exports remain under `stitch-source/` for visual comparison.

## Variant defaults / fallback
- `account/addresses`: variant 1 is the runtime default; variant 2 is preserved.
- `trade-in/tradein-detail`: variant 1 is the runtime default; variant 2 is preserved.
- `trade-in/tradein-tracking`: available standard mobile is preserved; desktop/tablet default to variant 1.
- `stores/find-store-stock`: the Stitch export has no dedicated mobile HTML; tablet is used as a temporary mobile fallback. This page should receive a dedicated mobile pass before production.
