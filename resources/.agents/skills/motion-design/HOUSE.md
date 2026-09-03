# House filter — motion-design (this repo)

Read this **before** applying LottieFiles timing, easing, or choreography.

Motion on mockups is **CSS only**. This skill improves easing, stagger, and duration — it does not add a new engine.

## Allow

- Duration / easing / stagger judgment for existing house motion
- Entrance reveals 400–700ms, play once
- One soft float max
- Card hover / button press
- `prefers-reduced-motion: reduce` kills motion

## Forbidden

- GSAP, Framer Motion, Spring, WebGL
- **Lottie JSON**, Lottie player, Lottie Creator MCP
- Scroll-triggered page plays, pinning, scrub
- Infinite bounce / loop recipes
- Page-transition libraries
- Extra decorative illustration animation beyond one float

House motion tokens live in `projects/<slug>/DESIGN.md` and `build-flow.md`. If this skill conflicts with those, house wins.
