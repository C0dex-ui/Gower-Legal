# Project Guidelines — Website Homepage Generator

Pipeline: URL, Google Sheet, or brand name → mockup → one preview. Unattended except **generated logos must be approved** before DESIGN.md/HTML.

## Skills

1. Read `.agents/skills/homepage-generator/SKILL.md`.
2. At understand time, **must Read** `.agents/skills/homepage-generator/references/photography.md` (hero + section stills; generate niche AI if photos are missing or low quality).
3. At design time, **must Read** `.agents/skills/design-md/SKILL.md`, then `.agents/skills/ui-ux-pro-max/HOUSE.md` (style / type / pattern only; logo colors).
4. At build time, **must Read** `.agents/skills/motion-design/HOUSE.md` (CSS easing/stagger only).
5. SEO: repo `seo-system.md` **mockup column only**.
6. **Never** GSAP.js or GSAP skills. **Never** Lottie JSON / Lottie player / Lottie MCP.

## Deployed — do not touch

- `casertas-land-services` — Caserta's Land Services (live)
- `davids-tree-service` — David's Tree Service (live)
- `gordons-tree-service` — Gordon's Tree Service (live)
- `johntilly-tree-services` — Johntilly Tree Services (live: https://johntilly-tree-services.vercel.app/)
- `jjs-tree-removal` — JJ’s Tree Removal (live: https://jjs-tree-removal.vercel.app/)
- `tammany-tree-service` — Tammany Tree Service (live: https://tammany-tree-service.vercel.app/)
- `lagniappe-tree-works` — Lagniappe Tree Works (live: https://lagniappe-tree-works.vercel.app/)
- `stricklands-tree-removal` — Strickland's Tree Removal (live: https://stricklands-tree-removal.vercel.app/)

Skip those sheet rows. Do not restyle, rebuild, or re-push unless the user names that project.

## Quality bar

Deployed craft: `slidell-fences`, `patriot-title-la`, `fabulous-tax-chic`, `geaux-tax-resolution`, `vja-llc`, `olsen-law-office`. Unique layout. Colors from `logo.png` only. Facts only. Fail QA → fix → then ping.

## Interrupt only

Blocked · **generated-logo approval** · preview ready · push if asked. No facts approval. No design-card menus. Found logos do not wait.

## Project layout

```
projects/<slug>/
  _scrape.json
  DESIGN.md
  logo.png
  assets/
  index.html
  styles.css
```

## Modes

- **URL** — fetch site → logo ladder → (approve if generated) → photography ladder → DESIGN.md → build → QA → `http://127.0.0.1:3000/projects/<slug>/`
- **Sheets** — viewable link; queue URL and/or name rows; one site at a time; skip dead rows
- **Brand-only** — web/GBP search; never invent NAP; same logo ladder
- **Layout revision** — keep facts/colors; rewrite layout
- **Copy-only** — keep layout
- **Push** — export `projects/<slug>/` to the client remote only

## Local business

Phone/email/areas in header + footer when known. Real reviews and cities only. Mobile call dock when a phone exists. Mockup form does not send. Generated mark + HTML wordmark; not claimed as official brand.
