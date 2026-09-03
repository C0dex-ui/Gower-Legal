---
version: 3.0
name: Gower Legal homepage
description: Wireframe-faithful Uptown New Orleans legal homepage with restrained neighborhood character.
colors:
  ivory: "#F6F1E8"
  live-oak: "#2F4A3C"
  live-oak-dark: "#22372D"
  brick: "#8B3A2F"
  wrought-iron: "#1C1C1C"
  brass: "#C4A46A"
typography:
  headlines: Libre Baskerville
  body: PT Sans
---

# Gower Legal homepage

## Direction

Premium but neighborly: Pine Street, Magazine Street, St. Charles oaks, porches, raised houses, and a real neighborhood office. Avoid tourist shorthand, courthouse-column branding, and downtown billboard-firm styling.

## Fixed section order

1. Header — text logo left; Practice Areas, About, and Call Now right.
2. Hero — centered heading, lede, and one Call Now button on warm ivory. No hero photograph.
3. Storm Claims — left copy/CTA and two stacked square images on the right. The WordPress option `gower_storm_mode` toggles this section (`on` by default).
4. Practice Areas — centered introduction and four circles: Car Wrecks, Slip and Fall, Rideshare, Trucking Accidents.
5. About / Who You Are — copy and facts left, one square portrait right.
6. Testimonials — centered heading, four review cards, previous/next arrows.
7. Results — one tall lead tile left and four tiles in a 2×2 mosaic right.
8. Footer — one simple full-width bar.

No additional pages or homepage sections.

## Visual system

- Warm ivory is the page ground.
- Live-oak green carries major dark bands and primary brand color.
- Brick marks the hero italic, buttons, and short rules.
- Wrought iron is used for strong text and the footer.
- Brass is limited to hairlines, image rings, and controls.
- Libre Baskerville is the editorial display face; PT Sans is the humanist body and interface face.

## Motion

- Sections fade and rise once as they enter the viewport.
- Storm images use a gentler eased entrance.
- Practice circles stagger.
- The About portrait moves only a few pixels.
- Results reveal in sequence with a shallow clip.
- No scroll-jacking, snap scrolling, 3D tilt, or particles.
- `prefers-reduced-motion: reduce` disables all reveal transforms and transitions.

## Source of truth

- Static preview: `index.html` + `styles.css`
- Elementor builders: `wordpress/scripts/build_elementor.ps1` and `build_elementor.py`
- WordPress chrome and motion: `wordpress/novamira-sandbox/gower-chrome.php`
- Generated templates: `wordpress/elementor/*.json`
