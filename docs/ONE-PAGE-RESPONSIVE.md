# PhoneX — One page responsive architecture

Production rule: one route/function = one `index.html`.

- No `desktop.html`, `tablet.html`, or `mobile.html` runtime files.
- No iframe or responsive redirect/loader.
- Desktop, tablet, and mobile behavior lives in the same HTML DOM using responsive Tailwind classes and `assets/css/runtime-responsive.css`.
- Shared behavior lives under `assets/js/` and shared design assets/components remain under `assets/` and `components/`.
- The original Stitch exports are intentionally excluded from this production ZIP to keep runtime source clean.

Breakpoints follow the project's responsive CSS/Tailwind rules. Always test the same URL by resizing the viewport rather than opening a different HTML file.
