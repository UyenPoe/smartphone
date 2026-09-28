# PhoneX Full Frontend Build

- 46 page entries converted to direct HTML runtime.
- Runtime no longer uses iframe or responsive-loader.
- Desktop Stitch markup is the canonical DOM and its Tailwind responsive classes are retained.
- `assets/css/runtime-responsive.css` removes Stitch fixed-canvas constraints and adds mobile safeguards.
- `assets/js/route-resolver.js` resolves common Stitch `data-path` navigation to project routes.
- `desktop.html`, `tablet.html`, `mobile.html` remain as design references only.
- `dev-pages.html` keeps the development page directory.

## Known design-reference exception
Some Stitch groups contain variants; the first desktop variant is used as canonical runtime where a standard desktop.html is absent.
