---
name: design-md
description: >
  Write a Google-format DESIGN.md for a local-business homepage: logo colors,
  unique hero/type/cards, CSS motion tokens. Used at homepage-generator step 2
  and layout revision. Triggers: DESIGN.md, getdesign.md, designmd.ai,
  designmd.co, design direction, restyle.
---

# DESIGN.md for local business mockups

Homepage-generator **must Read this file** before writing `projects/<slug>/DESIGN.md`. Copy-adapt [references/template.md](references/template.md). Do not invent a different schema.

Format: [Google DESIGN.md](https://github.com/google-labs-code/design.md) (same idea as [getdesign.md](https://getdesign.md/)) — YAML tokens + Overview, Colors, Typography, Layout, Elevation & Depth, Shapes, Components, Do's and Don'ts.

## Rules

- **Colors from this client's `logo.png` only** (found or **user-approved generated** mark). Sample 3–6 hex. No invented teal/gold. No Nike/Tesla/Stripe catalog tokens on a local business. If `logo` is `generated` and the user has not approved, **do not write DESIGN.md**.
- **Layout is first-class.** Lock hero pattern (split / full-bleed / editorial / collage), section rhythm, card model. Recolor-only is a fail. Every mockup needs a **couple of photographs** (hero + one section still). If the prospect has no usable photos, the homepage-generator photography ladder generates niche AI stills — record that in Layout, do not design a type-only page.
- **Era is set by the house reference.** Read [`../homepage-generator/references/modern-standard.md`](../homepage-generator/references/modern-standard.md) and state the density/type/surfacing target. Register only — never the reference's composition.
- **Six claim slots.** Run the gate in [`../homepage-generator/references/unique-templates.md`](../homepage-generator/references/unique-templates.md): display family, hero composition, card model, section separation, signature shape, accent role. 3+ collisions with any existing project → change the composition.
- **Auto-pick one direction.** No A/B cards unless the user asked to see options.
- **Uniqueness line required** in Overview: `not X, not Y` vs existing `projects/*/DESIGN.md` (and those heroes) **and** vs the house reference. Examples of already-used language: Slidell service cards + Outfit, Patriot framed bands, Olsen editorial serif + bronze, David's bleeding hero panel + pill everything.
- **getdesign.md / designmd.ai / designmd.co link** (if the user pasted one): layout/motion **vibe only**. Remap every color to the logo tokens.
- **Motion:** CSS only; 400–700ms; play once; honor `prefers-reduced-motion`; one soft float max; no infinite bounce; no WebGL/Three.js. Read [`../motion-design/HOUSE.md`](../motion-design/HOUSE.md) then [`../motion-design/SKILL.md`](../motion-design/SKILL.md) for easing/stagger only. No GSAP, no Lottie JSON.
- **Pro Max consult (step 2):** Read [`../ui-ux-pro-max/HOUSE.md`](../ui-ux-pro-max/HOUSE.md) then run a `--design-system` search. Keep **style name**, **font pairing**, and **landing pattern name**. Discard catalog palettes, stacks, charts, GSAP. Record `Style:` and `Pattern:` on the uniqueness line. If that pair is already used, pick another style.

## Write

`projects/<slug>/DESIGN.md` with tokens that `index.html` / `styles.css` will actually use (`{colors.primary}` style refs in components).

On **layout revision**: keep color tokens; rewrite Layout, Typography, Elevation; replace the uniqueness line; do not fetch a new palette.

If the brief is "looks too classic / dated", the cause is almost always devices rather than fonts. Fix in this order before changing the type stack: display letter-spacing (positive → negative), drawn band rules, hard photo frames, caption plates over photos, stroked numerals.
