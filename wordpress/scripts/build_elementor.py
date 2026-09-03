#!/usr/bin/env python3
"""Build Gower Legal Elementor JSON from the static homepage."""
from __future__ import annotations

import json
import secrets
from pathlib import Path

OUT = Path(__file__).resolve().parents[1] / "elementor"
OUT.mkdir(parents=True, exist_ok=True)

INK = "#1c1c1c"
MUTE = "#4f554f"
TEAL = "#2f4a3c"
TEAL_DEEP = "#22372d"
SAND = "#c4a46a"
BRICK = "#8b3a2f"
PAPER = "#f6f1e8"
WHITE = "#fffdf8"
HAIRLINE = "#d8cdbb"
ON_TEAL = "#ffffff"
PHONE = "tel:+13402772799"
WRAP = 1200
HEAD = "Libre Baskerville"
BODY = "PT Sans"


def uid() -> str:
    return secrets.token_hex(4)[:7]


def dim(t, r, b, l, linked=False):
    return {"unit": "px", "top": str(t), "right": str(r), "bottom": str(b), "left": str(l), "isLinked": linked}


def slider(size, unit="px"):
    return {"unit": unit, "size": size}


def gap(n):
    return {"column": str(n), "row": str(n), "isLinked": True, "unit": "px"}


def container(settings, elements, inner=False):
    s = dict(settings)
    if "css_id" in s and "_element_id" not in s:
        s["_element_id"] = s["css_id"]
    cls = s.get("css_classes") or s.get("_css_classes")
    if cls:
        s["css_classes"] = cls
        s["_css_classes"] = cls
    s.setdefault("content_width", "full")
    s.setdefault("flex_direction", "column")
    s.setdefault("padding", dim(0, 0, 0, 0, True))
    return {"id": uid(), "elType": "container", "isInner": inner, "settings": s, "elements": elements}


def widget(wtype, settings):
    s = dict(settings)
    s.setdefault("_margin", dim(0, 0, 0, 0, True))
    return {"id": uid(), "elType": "widget", "widgetType": wtype, "isInner": False, "settings": s, "elements": []}


def ty(family=BODY, size=16, weight="400", transform="", lh=None, ls=None, extra=None, prefix=""):
    p = prefix
    out = {
        f"{p}typography_typography": "custom",
        f"{p}typography_font_family": family,
        f"{p}typography_font_size": slider(size),
        f"{p}typography_font_weight": str(weight),
    }
    if transform:
        out[f"{p}typography_text_transform"] = transform
    if lh is not None:
        out[f"{p}typography_line_height"] = slider(lh, "em")
    if ls is not None:
        out[f"{p}typography_letter_spacing"] = slider(ls)
    if extra:
        out.update(extra)
    return out


def heading(title, tag, color, size, center=False, weight="700", transform="", extra=None, family=HEAD):
    s = {
        "title": title,
        "header_size": tag,
        "title_color": color,
        "align": "center" if center else "left",
        **ty(family=family, size=size, weight=weight, transform=transform, lh=1.18),
    }
    if extra:
        s.update(extra)
    return widget("heading", s)


def text(html, color=MUTE, size=17, center=False, extra=None, weight="400"):
    s = {
        "editor": html,
        "text_color": color,
        "align": "center" if center else "left",
        **ty(size=size, weight=weight, lh=1.5),
    }
    if extra:
        s.update(extra)
    return widget("text-editor", s)


def btn(label, url, fill=TEAL, color=ON_TEAL, hover_fill=SAND, hover_color=INK, extra=None, css="gower-btn gower-btn-primary"):
    s = {
        "text": label,
        "link": {"url": url, "is_external": "", "nofollow": ""},
        "background_color": fill,
        "button_text_color": color,
        "hover_color": hover_color,
        "background_hover_color": hover_fill,
        "border_radius": dim(2, 2, 2, 2, True),
        "text_padding": dim(14, 22, 14, 22, False),
        **ty(family=BODY, size=12, weight="700", transform="uppercase", ls=0.6),
        "_css_classes": css,
        "_element_width": "auto",
    }
    if extra:
        s.update(extra)
    return widget("button", s)


def img(key, alt, extra=None):
    s = {
        "image": {"url": f"{{{{media_url:{key}}}}}", "id": f"{{{{media:{key}}}}}", "alt": alt, "source": "library"},
        "image_size": "full",
        "alt_text": alt,
    }
    if extra:
        s.update(extra)
    return widget("image", s)


def media(key):
    return {"url": f"{{{{media_url:{key}}}}}", "id": f"{{{{media:{key}}}}}", "source": "library"}


def boxed(width=WRAP, **kwargs):
    s = {
        "content_width": "boxed",
        "boxed_width": slider(width),
        "padding": dim(0, 24, 0, 24, False),
    }
    s.update(kwargs)
    return s


def col(pct, extra=None):
    s = {
        "content_width": "full",
        "width": slider(pct, "%"),
        "width_tablet": slider(100, "%"),
        "width_mobile": slider(100, "%"),
    }
    if extra:
        s.update(extra)
    return s


def save(name, title, typ, content, page_settings=None):
    payload = {
        "content": content,
        "page_settings": page_settings or {"hide_title": "yes"},
        "version": "0.4",
        "title": title,
        "type": typ,
    }
    path = OUT / f"{name}.json"
    path.write_text(json.dumps(payload, indent=2), encoding="utf-8")
    print(f"wrote {path}")


def section_head(title, sub, dark=False):
    return container({
        "content_width": "full",
        "_css_classes": "gower-section-head",
    }, [
        heading(title, "h2", "#FFFFFF" if dark else INK, 36, True),
        text(f"<p>{sub}</p>", "rgba(255,233,206,0.8)" if dark else MUTE, 15, True, extra={"_css_classes": "gower-sub"}),
    ], True)


def build_header():
    brand_html = '<a class="gower-wordmark" href="/"><span>Gower Legal</span><small>Pine Street, Uptown</small></a>'
    bar = container({
        **boxed(WRAP, padding=dim(8, 24, 8, 24, False)),
        "flex_direction": "row",
        "flex_justify_content": "space-between",
        "flex_align_items": "center",
        "flex_wrap": "nowrap",
        "flex_gap": gap(22),
        "min_height": slider(88),
        "background_background": "classic",
        "background_color": PAPER,
        "_css_classes": "gower-header-bar",
    }, [
        container({"content_width": "full", "width": slider("auto"), "_element_width": "auto", "_css_classes": "gower-header-logo"}, [
            widget("html", {"html": brand_html}),
        ], True),
        container({"content_width": "full", "width": slider("auto"), "_element_width": "auto", "_css_classes": "gower-header-nav"}, [
            widget("ha-navigation-menu", {
                "nav_menu_list": "primary",
                "nav_menu_position": "flex-end",
                "nav_menu_item_color": TEAL,
                "nav_menu_item_hover_color": BRICK,
                "nav_menu_item_active_color": BRICK,
                "hamburger_icon": {"value": "fas fa-bars", "library": "fa-solid"},
                "hamburger_close_icon": {"value": "fas fa-times", "library": "fa-solid"},
                "nav_menu_res_icon_color": TEAL,
                "nav_menu_item_typography_typography": "custom",
                "nav_menu_item_typography_font_family": BODY,
                "nav_menu_item_typography_font_size": slider(15),
                "nav_menu_item_typography_font_weight": "700",
            }),
        ], True),
        container({"content_width": "full", "width": slider("auto"), "_element_width": "auto", "_css_classes": "gower-header-cta"}, [
            btn("Call Now", PHONE),
        ], True),
    ], True)

    root = container({
        "content_width": "full",
        "flex_direction": "column",
        "flex_gap": gap(0),
        "background_background": "classic",
        "background_color": PAPER,
        "_css_classes": "gower-header",
    }, [bar])
    save("header", "Site Header", "header", [root])


def build_footer():
    inner = container({
        **boxed(WRAP, padding=dim(28, 24, 28, 24, False)),
        "flex_direction": "column",
        "flex_align_items": "center",
        "flex_gap": gap(0),
        "_css_classes": "gower-footer-inner",
    }, [
        text(
            '<p><strong>Gower Legal</strong> · 1919 Pine Street, Uptown New Orleans · '
            '<a href="tel:+13402772799">340-277-2799</a></p>',
            PAPER, 14, True,
        ),
    ], True)
    root = container({
        "content_width": "full",
        "background_background": "classic",
        "background_color": INK,
        "flex_gap": gap(0),
        "_css_classes": "gower-footer",
    }, [inner])
    save("footer", "Site Footer", "footer", [root])


def circle(key, label, alt):
    return container({
        "content_width": "full",
        "_css_classes": "gower-circle",
        "flex_direction": "column",
        "flex_align_items": "center",
        "flex_gap": gap(12),
    }, [
        img(key, alt),
        heading(label, "h3", INK, 17, True, family=BODY, extra={"typography_font_weight": "700"}),
    ], True)


def result_tile(key, title, alt, large=False):
    cls = "gower-result gower-result-lg" if large else "gower-result"
    return container({
        "content_width": "full",
        "_css_classes": cls,
        "flex_direction": "column",
        "flex_justify_content": "flex-end",
        "min_height": slider(280 if large else 220),
    }, [
        img(key, alt),
        container({"content_width": "full", "_css_classes": "gower-result-body"}, [
            heading(title, "h3", "#FFFFFF", 22 if large else 16, False),
        ], True),
    ], True)


def build_home():
    hero = container({
        "content_width": "full",
        "flex_direction": "column",
        "flex_justify_content": "flex-end",
        "flex_align_items": "center",
        "min_height": {"unit": "vh", "size": 100},
        "background_background": "classic",
        "background_image": media("hero"),
        "background_position": "center top",
        "background_size": "cover",
        "background_color": INK,
        "css_id": "top",
        "_css_classes": "gower-hero",
    }, [
        widget("html", {"html": '<div class="gower-hero-veil" aria-hidden="true"></div>'}),
        container({
            **boxed(800, padding=dim(0, 16, 88, 16, False)),
            "flex_direction": "column",
            "flex_align_items": "center",
            "flex_gap": gap(12),
            "_css_classes": "gower-hero-copy",
        }, [
            text("<p>Uptown · 1919 Pine Street</p>", SAND, 11, True, extra={"_css_classes": "gower-label gower-label-chip"}),
            heading(
                "A New Orleans personal injury lawyer <em>who still sits on the porch.</em>",
                "h1", "#FFFFFF", 52, True,
                extra={
                    "typography_font_size_tablet": slider(36),
                    "typography_font_size_mobile": slider(26),
                    "typography_line_height": slider(1.12, "em"),
                },
            ),
            text(
                "<p>Gower Legal is Jacob Gower’s boutique on Pine Street in Uptown — call a neighbor, not a billboard.</p>",
                "rgba(246,241,232,0.9)", 17, True, extra={"_css_classes": "gower-lede"},
            ),
            btn("Call Now", PHONE),
        ], True),
    ])

    storm = container({
        "content_width": "full",
        "background_background": "classic",
        "background_color": TEAL_DEEP,
        "css_id": "storm",
        "_css_classes": "gower-storm",
        "padding": dim(72, 0, 72, 0, False),
    }, [
        container({
            **boxed(WRAP),
            "flex_direction": "row",
            "flex_align_items": "center",
            "flex_gap": gap(48),
            "flex_direction_tablet": "column",
            "flex_direction_mobile": "column",
            "_css_classes": "gower-split",
        }, [
            container({**col(50), "_css_classes": "gower-split-copy gower-storm-copy", "flex_justify_content": "center", "flex_gap": gap(14)}, [
                text("<p>Southern Louisiana · after the storm</p>", SAND, 11, False, extra={"_css_classes": "gower-label"}),
                heading("Storm Claims", "h2", "#FFFFFF", 40),
                text(
                    "<p>When a hurricane hits the Gulf, this band comes on so you do not have to hunt. Jacob handles storm and hurricane property claims across Southern Louisiana.</p>",
                    "rgba(255,233,206,0.94)", 17,
                ),
                btn("Call Now", PHONE, fill=PAPER, color=TEAL_DEEP, css="gower-btn gower-btn-paper"),
            ], True),
            container({**col(50), "_css_classes": "gower-storm-gallery", "flex_gap": gap(16)}, [
                img("storm", "Wet Uptown New Orleans porch and oak limbs after a Gulf storm"),
                img("result-hurricane", "Blue tarp on an Uptown roof after a storm"),
            ], True),
        ], True),
    ])

    practice = container({
        "content_width": "full",
        "background_background": "classic",
        "background_color": PAPER,
        "css_id": "practice",
        "_css_classes": "gower-practice",
        "padding": dim(56, 0, 56, 0, False),
    }, [
        container({**boxed(WRAP), "flex_gap": gap(28)}, [
            section_head("Practice Areas", "The same streets you drive. These are the matters we take in New Orleans."),
            container({
                "content_width": "full",
                "flex_direction": "row",
                "flex_gap": gap(28),
                "_css_classes": "gower-circles",
            }, [
                circle("practice-car", "Car Wrecks", "Cars along an oak-lined Uptown New Orleans avenue after a wreck"),
                circle("practice-slip", "Slip and Fall", "Wet cracked Uptown sidewalk under live oaks after rain"),
                circle("practice-rideshare", "Rideshare", "Rideshare sedan at the curb on a leafy Uptown residential street"),
                circle("practice-truck", "Trucking Accidents", "Box truck on a wet New Orleans street near oak-lined blocks"),
            ], True),
        ], True),
    ])

    facts = (
        '<dl class="gower-facts">'
        '<div class="gower-fact"><dt>Office</dt><dd>1919 Pine Street, Uptown New Orleans</dd></div>'
        '<div class="gower-fact"><dt>Education</dt><dd>LSU Law, 2012 — Magna Cum Laude, Order of the Coif</dd></div>'
        '<div class="gower-fact"><dt>Recognition</dt><dd>Rising Star, 2018–2025</dd></div>'
        "</dl>"
        '<p class="gower-about-close">You talk to the lawyer who handles the file.</p>'
    )

    about = container({
        "content_width": "full",
        "background_background": "classic",
        "background_color": PAPER,
        "css_id": "about",
        "_css_classes": "gower-about",
        "padding": dim(72, 0, 72, 0, False),
    }, [
        container({
            **boxed(WRAP),
            "flex_direction": "row",
            "flex_align_items": "stretch",
            "flex_gap": gap(40),
            "flex_direction_tablet": "column",
            "flex_direction_mobile": "column",
            "_css_classes": "gower-split",
        }, [
            container({**col(50), "_css_classes": "gower-split-copy", "flex_justify_content": "center", "flex_gap": gap(14)}, [
                text("<p>Who you are calling</p>", TEAL, 11, False, extra={"_css_classes": "gower-label"}),
                heading("About / Who You Are", "h2", INK, 36),
                widget("html", {"html": facts}),
                btn("Learn More", "/#about", fill=INK, color=PAPER, hover_fill=TEAL_DEEP, hover_color=PAPER, css="gower-btn gower-btn-ink"),
            ], True),
            container({**col(50), "_css_classes": "gower-split-media gower-about-media"}, [
                img("headshot", "C. Jacob Gower, New Orleans personal injury lawyer"),
            ], True),
        ], True),
    ])

    quotes_html = (
        '<div class="gower-carousel" data-gower-carousel>'
        '<button class="gower-chevron prev" type="button" aria-label="Previous testimonials">&lsaquo;</button>'
        '<div class="gower-carousel-track" tabindex="0">'
        '<article class="gower-quote"><div class="gower-quote-body"><span aria-hidden="true">&ldquo;</span>'
        "<p>He called me back the same afternoon and talked like a neighbor, not a commercial.</p>"
        '<p class="gower-attr">Sample - Uptown resident</p></div></article>'
        '<article class="gower-quote"><div class="gower-quote-body"><span aria-hidden="true">&ldquo;</span>'
        "<p>I did not want a downtown firm. I wanted someone who knew the street I wrecked on.</p>"
        '<p class="gower-attr">Sample - Carrollton</p></div></article>'
        '<article class="gower-quote"><div class="gower-quote-body"><span aria-hidden="true">&ldquo;</span>'
        "<p>The insurance emails stopped landing on me. That was the whole point of hiring him.</p>"
        '<p class="gower-attr">Sample - Mid-City</p></div></article>'
        '<article class="gower-quote"><div class="gower-quote-body"><span aria-hidden="true">&ldquo;</span>'
        "<p>After the storm he told us what to photograph before we pulled a single board.</p>"
        '<p class="gower-attr">Sample - Southern Louisiana</p></div></article>'
        "</div>"
        '<button class="gower-chevron next" type="button" aria-label="Next testimonials">&rsaquo;</button>'
        "</div>"
    )

    quotes = container({
        "content_width": "full",
        "background_background": "classic",
        "background_color": INK,
        "css_id": "testimonials",
        "_css_classes": "gower-quotes",
        "padding": dim(88, 0, 88, 0, False),
    }, [
        container({**boxed(WRAP), "flex_gap": gap(28)}, [
            section_head("Testimonials", "Placeholder quotes for homepage review. They are not real client reviews.", dark=True),
            widget("html", {"html": quotes_html}),
        ], True),
    ])

    results = container({
        "content_width": "full",
        "background_background": "classic",
        "background_color": PAPER,
        "css_id": "results",
        "_css_classes": "gower-results",
        "padding": dim(72, 0, 72, 0, False),
    }, [
        container({**boxed(WRAP), "flex_gap": gap(28)}, [
            section_head("Results", "Sample case notes for layout — not published verdicts on this page."),
            container({
                "content_width": "full",
                "flex_direction": "row",
                "flex_gap": gap(8),
                "flex_direction_tablet": "column",
                "flex_direction_mobile": "column",
                "_css_classes": "gower-result-grid",
            }, [
                result_tile("practice-car", "$500,000 Recovered Following Auto Injury", "Uptown avenue still for a sample auto-injury result", True),
                container({
                    "content_width": "full",
                    "width": slider(50, "%"),
                    "width_tablet": slider(100, "%"),
                    "width_mobile": slider(100, "%"),
                    "_css_classes": "gower-result-quad",
                    "flex_direction": "row",
                    "flex_wrap": "wrap",
                    "flex_gap": gap(8),
                }, [
                    result_tile("result-hurricane", "$650,000 Recovered from Hurricane Damage", "Blue tarp on an Uptown roof after a storm"),
                    result_tile("practice-slip", "$275,000 Slip and Fall", "Wet Uptown sidewalk used as a sample premises result"),
                    result_tile("result-streetcar", "$180,000 Rideshare Collision", "St. Charles streetcar under live oaks"),
                    result_tile("practice-truck", "$420,000 Trucking Crash", "Box truck on a New Orleans street for a sample trucking result"),
                ], True),
            ], True),
        ], True),
    ])

    save("home", "Home", "wp-page", [hero, storm, practice, about, quotes, results])


if __name__ == "__main__":
    build_header()
    build_footer()
    build_home()
