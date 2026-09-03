---
version: beta
name: Gower Legal
description: Neighborly Uptown New Orleans injury homepage. Cream masthead, type on a porch still, four indexed sand-ringed practice circles, an ink testimonials band breaking the cream sheet, split columns that match the side image.
colors:
  primary: "#013447"
  secondary: "#3D5560"
  tertiary: "#027FA4"
  teal: "#027FA4"
  teal-deep: "#01607C"
  sand: "#EEAB5A"
  paper: "#FFE9CE"
  white: "#FFF6EA"
  ink: "#013447"
  mute: "#3D5560"
  hairline: "#F0CFA3"
  on-primary: "#FFE9CE"
  on-tertiary: "#FFFFFF"
typography:
  h1:
    fontFamily: Libre Baskerville
    fontSize: clamp(2.15rem, 5.2vw, 3.85rem)
    fontWeight: 700
    lineHeight: 1.12
    letterSpacing: -0.02em
  h2:
    fontFamily: Libre Baskerville
    fontSize: clamp(1.55rem, 2.6vw, 2.15rem)
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: -0.015em
  h3:
    fontFamily: Libre Baskerville
    fontSize: clamp(1rem, 1.4vw, 1.2rem)
    fontWeight: 700
    lineHeight: 1.25
  body-md:
    fontFamily: PT Sans
    fontSize: 1.0625rem
    fontWeight: 400
    lineHeight: 1.5
  label-caps:
    fontFamily: PT Sans
    fontSize: 0.7rem
    fontWeight: 700
    letterSpacing: 0.14em
    textTransform: uppercase
rounded:
  sm: 2px
  md: 2px
  pill: 999px
spacing:
  sm: 8px
  md: 16px
  lg: 32px
  xl: 88px
motion:
  personality: Neighborly
  ease: cubic-bezier(0.22, 0.1, 0.15, 1)
  quick: 180ms
  standard: 520ms
  slow: 680ms
  stagger: 70ms
components:
  button-primary:
    backgroundColor: "{colors.tertiary}"
    textColor: "{colors.on-tertiary}"
    rounded: "{rounded.sm}"
    minHeight: 50px
  button-secondary:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.on-primary}"
    rounded: "{rounded.sm}"
    minHeight: 50px
  card-practice:
    shape: circle
    mediaInset: false
---

## Overview

An Uptown porch, not a marble lobby. The page uses the blueprint palette — teal `#027FA4`, sand `#EEAB5A`, cream `#FFE9CE` — with a deep teal ink for type. **Libre Baskerville** carries the headlines; **PT Sans** does the talking. The fold is **type in the lower third of the porch photograph** behind a bottom-weighted veil — no paper card. Practice areas are **four circular stills with a label only**. Split columns stay centered to the square image.

Uniqueness: **Libre Baskerville + PT Sans and the blueprint three-color field, type in the lower third of a full-bleed porch still (no card) with the italic span in sand, four indexed circular Uptown stills ringed in sand with labels only, image-height splits with About set as fact rows, four quote squares on an ink band between two cream sections, overlay masthead with a large white mark, cream grain bar and original logo after the fold, sand rules under the section heads, uneven padding rhythm.** Not the prior Cormorant + Nunito cream-card / teal-plate / quote-stationery page. Not Gordon’s Inter Tight gold field / ten-up specimen, not Lagniappe’s Anton red plate / red-masthead sheets, not Johntilly’s Fraunces ink slab, not JJ’s Bricolage lower-right paper card, not Tammany’s Lora forest + callback form, not ACE’s Lexend door film, not Theriot’s dusk rail, not the house reference’s period-stopped declaratives / featured-compact tier / five-stage process.

Hero: **lower-third type on a full-bleed porch portrait with a bottom-weighted veil.**

Cards: **four circular Uptown stills with a label under each. Quote tiles are square stills with type on the photo.**

Style: **Warm Minimalism** (Pro Max consult skipped — Python not installed). Pattern: **Hero + Features + Social Proof**.

## Colors

Colors from the client blueprint swatch. Deep teal ink is a contrast pair of `#027FA4` so body type stays readable on cream.

| Token | Hex | Use |
|---|---|---|
| `--teal` | `#027FA4` | CTA, eyebrows, links |
| `--teal-deep` | `#01607C` | Pressed CTA, storm band, header/footer ink family |
| `--sand` | `#EEAB5A` | Labels on dark photo, H1 italic span, section rules, circle rings, hovers, About mat line |
| `--paper` | `#FFE9CE` | Masthead and the whole sheet after the hero |
| `--ink` | `#013447` | Headings, nav, footer |
| `--mute` | `#3D5560` | Body on cream |
| `--white` | `#FFF6EA` | Type on photos |
| `--hairline` | `#F0CFA3` | Joins between paper sections |

Teal buttons use white text. Nav uses `--teal-deep` rather than `--teal` so bold 15px links clear AA on cream (`#027FA4` on cream is only 3.8:1). Sand is not used for small type on cream (contrast), and sand caps never sit straight on the photo — the hero eyebrow gets an ink chip, because sand over the sunlit column is about 1.3:1 no matter how hard the veil or shadow works. No navy or courthouse maroon.

## Typography

**Libre Baskerville** 700 for H1/H2/H3, italic allowed only on a single H1 span. **PT Sans** 400/700 for body, labels, nav. Pairing comes from the client blueprint font page. Eyebrows are `.label` spans, never headings. Body line-height stays tight (`1.5`) so split columns do not outrun the square image.

## Layout

- **Hero pattern:** full-viewport (`100svh`) porch still; stack pinned to the lower third (eyebrow, H1, one lede, Call Now) on a bottom-weighted veil. The veil stays near-clear over the top third so the oak and the street read, then ramps from 46% down so the whole copy band sits on a darker field. No floating paper card.
- **Photography:** mixed. Found logo and temporary headshot. Generated porch hero, storm still, four practice stills, results stills.
- **Section rhythm:** overlay masthead on the photo hero → **teal storm split** → cream practice → cream about → **ink testimonials** → cream results → ink footer. The ink band is deliberate: four cream sections in a row read as one flat sheet, so Testimonials carries the ground break. Results stays cream because an ink Results would merge into the ink footer. Hairlines join the cream sections; the ink band needs none. A 56px sand rule sits under each centered section head.
- **Vertical rhythm:** three padding tokens instead of one, so the page does not scan as equal slabs — `--pad-tight` for practice, `--pad` for about and results, `--pad-loose` for the ink band so it reads as a gallery room.
- **Card model:** large flush circles filling the row, name under, indexed `01`–`04`, no prose slab. Storm and About are 50/50 splits; copy stretches to the square (`align-items: stretch`, button at the foot). About carries its facts as hairline-separated `dl` rows on a `--white` wash so the column fills to the portrait with structure rather than air. Quotes: four square stills in one desktop row. Results: equal 1fr + 1fr so the large tile matches the 2×2, at a `0.5rem` gap so the five tiles read as one composition.
- **Mobile:** splits stack, practice stays 2-up, quotes go one tile at a time, results stack so titles stay readable, Storm still shortens to 4:3, the in-hero Call Now yields to the dock, and the dock respects the iPhone safe area.
- IA follows the attached homepage wireframe. No extra vibe sections.

## Elevation & Depth

No card shadows on hero or About. Circles carry a hairline sand ring on a cream gap — no drop shadow, no plate. Quote and result tiles are the photograph. Hero type carries a soft ink glow so the veil can stay light enough to read the porch; the eyebrow chip is the one opaque pad on the photo, sized to the caps so it reads as a tag and not a card. Every band including the masthead and footer carries paper grain plus a slower fiber blotch. Cream grain is stronger (12%) than the dark bands (5%) so the sheet has tooth without muddying ink type. Motion is neighborly: 520ms standard, 680ms fold, 70ms stagger, 16px travel, play once. `prefers-reduced-motion: reduce` removes it. One soft ken-burns on the hero still. Buttons press to `.98`. No GSAP, no Lottie, no WebGL.

## Shapes

`2px` on buttons. `999px` on practice circles and the mobile dock. The repeated form is the **circle** — practice stills only. Storm is the only loud rectangle. Split images are flush squares.

## Components

- Header: fixed overlay on the porch — large white mark, cream Practice / About / Menu, teal Call Now. After the fold it becomes the cream grain bar, original-size teal-and-ink mark, deep teal links.
- Hero: veil + primary button, type on the photo, italic span in sand, address eyebrow as a sand-on-ink dateline chip
- Storm: teal-deep ground, paper type, inverted Call Now; short copy
- Practice circle: circular still + PT Sans label + ink index numeral on a sand rule
- About: paper split, `dl` fact rows on a `--white` wash with hairlines (same mat as the portrait), italic closing line, flush square portrait, ink Learn More
- Quote square: still + one line + sample attr, thin sand frame on the ink band
- Results tile: still + short sand rule + blog-post title; the large tile steps its caption up
- Footer: ink, large cream wordmark on a sand rule, contact as the one strong line, sand links
- Mobile dock: teal pill, cream caps

## Do's and Don'ts

- Do keep the blueprint trio: teal `#027FA4`, sand `#EEAB5A`, cream `#FFE9CE`.
- Do let sand carry the accents — hovers, rules, rings, the H1 italic — and never small type on cream.
- Do keep split-column copy shorter than the side image.
- Do use only `_scrape.json` facts. Mark testimonials and results as samples.
- Don't invent ratings, hours, or “20 years.”
- Don't use VI body copy except the footer link.
- Don't render Miro comment dots.
- Don't ship gavels, Bourbon Street, or a marble lobby.
- Don't bring back the cream hero card, the teal About plate, or a practice prose slab.
- Don't flatten the page back to one continuous cream sheet — the ink Testimonials band is what keeps it from reading plain.
