---
version: alpha
name: ClientShortName
description: Unique local-business homepage. Replace every token from this client's logo and layout pick.
colors:
  primary: "#1A1C1E"
  secondary: "#6C7278"
  tertiary: "#B8422E"
  neutral: "#F7F5F2"
  on-primary: "#F7F5F2"
  on-tertiary: "#FFFFFF"
typography:
  h1:
    fontFamily: Source Serif 4
    fontSize: 3rem
    fontWeight: 600
    lineHeight: 1.15
  h2:
    fontFamily: Source Serif 4
    fontSize: 2rem
    fontWeight: 600
    lineHeight: 1.2
  body-md:
    fontFamily: Source Sans 3
    fontSize: 1rem
    fontWeight: 400
    lineHeight: 1.6
  label-caps:
    fontFamily: Source Sans 3
    fontSize: 0.75rem
    fontWeight: 600
    letterSpacing: 0.08em
rounded:
  sm: 4px
  md: 8px
spacing:
  sm: 8px
  md: 16px
  lg: 32px
  xl: 64px
components:
  button-primary:
    backgroundColor: "{colors.tertiary}"
    textColor: "{colors.on-tertiary}"
    rounded: "{rounded.sm}"
    padding: 12px
  button-secondary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.on-primary}"
    rounded: "{rounded.sm}"
    padding: 12px
---

## Overview

[One paragraph: mood, audience, feel.] Uniqueness: not [existing project A], not [existing project B]. Hero: [split | full-bleed | editorial | collage]. Cards: [lanes | flip | numbered stack | photo tiles — not the same as A/B]. Style: [Pro Max style name]. Pattern: [Pro Max landing pattern name].

## Colors

Palette sampled from `logo.png`. Name each hex and where it is used (ink, paper, sole CTA). Do not add colors that are not in the logo or a necessary contrast pair (on-primary / on-tertiary).

## Typography

One display family + one body family. Explain hierarchy. Do not reuse the type pairing of the uniqueness-line projects.

## Layout

- Hero pattern: …
- Photography: hero still + one section still (found / mixed / generated). Niche-accurate; never type-only.
- Section rhythm: …
- Card model: …
- IA follows vibe-localbiz section order; structure must not clone another `projects/*/index.html`.

## Elevation & Depth

Quiet section washes (grain or faded photo). CSS motion 400–700ms, once, `prefers-reduced-motion: reduce` disables. One soft float on a single accent. Card hover lift only. No WebGL, no GSAP, no Lottie JSON.

## Shapes

Radius and divider language. Keep Elementor-portable (no canvas, no 3D mesh).

## Components

Header, hero facts, service card, review quote, form, footer, mobile dock — map to the YAML `components` tokens.

## Do's and Don'ts

- Do use only sanitized facts from `_scrape.json`.
- Do keep text contrast on textures.
- Don't invent teal/gold or catalog-brand tokens.
- Don't ship a recolor of Slidell / Patriot / Olsen / another repo project.
