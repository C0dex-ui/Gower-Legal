# House filter — UI UX Pro Max (this repo)

Read this **before** running `scripts/search.py` or applying any Pro Max row.

This generator builds **vanilla HTML + CSS** local-business mockups. Pro Max is a consult, not autopilot.

## Allow

- One named **UI style** (uniqueness-gated)
- One **font pairing** from typography search (uniqueness-gated)
- One **landing pattern name** — IA still from `homepage-generator/references/vibe-localbiz-layout.md`
- **UX anti-patterns** and checklist: contrast 4.5:1, reflow, 375 / 768 / 1024 / 1440, focus, `prefers-reduced-motion`

## Discard

- Catalog **color palettes** — colors from this client's `logo.png` only
- All **JS stacks** (React, Next, Tailwind, shadcn, Vue, Three.js, Flutter, …)
- **Charts**, dashboards, SaaS/product rules
- **GSAP presets** — no GSAP.js
- Glass / clay / neu / AI-purple as defaults
- A/B option dumps
- Repo-root `design-system/MASTER.md` — fold one short note into `projects/<slug>/DESIGN.md` only

## Query

`"{trade} {city} local service homepage"` plus logo hex as a hint in the query text, not as a palette override from the CSV.

On Windows: `python .agents/skills/ui-ux-pro-max/scripts/search.py "..." --design-system`

Never pass `--motion`. That flag attaches a GSAP snippet.

If the result repeats a style+pattern already on the uniqueness ledger, search once more or pick the next distinct style. 3+ slot collisions still fail.
