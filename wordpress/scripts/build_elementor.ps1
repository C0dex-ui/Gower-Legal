$ErrorActionPreference = "Stop"
$Out = Join-Path (Split-Path $PSScriptRoot -Parent) "elementor"
New-Item -ItemType Directory -Force -Path $Out | Out-Null

$INK = "#1c1c1c"
$MUTE = "#4f554f"
$TEAL = "#2f4a3c"
$TEAL_DEEP = "#22372d"
$SAND = "#c4a46a"
$BRICK = "#8b3a2f"
$PAPER = "#f6f1e8"
$WHITE = "#fffdf8"
$PHONE = "tel:+13402772799"
$HEAD = "Libre Baskerville"
$BODY = "PT Sans"
$MIDDOT = [char]0x00B7

function New-Uid { -join ((1..7) | ForEach-Object { "{0:x}" -f (Get-Random -Max 16) }) }
function Dim($t,$r,$b,$l,$linked=$false) {
  [ordered]@{ unit="px"; top="$t"; right="$r"; bottom="$b"; left="$l"; isLinked=[bool]$linked }
}
function Slider($size, $unit="px") { [ordered]@{ unit=$unit; size=$size } }
function Gap($n) { [ordered]@{ column="$n"; row="$n"; isLinked=$true; unit="px" } }

function New-Container($settings, $elements, $inner=$false) {
  $s = [ordered]@{}
  foreach ($k in $settings.Keys) { $s[$k] = $settings[$k] }
  if ($s.Contains("css_id") -and -not $s.Contains("_element_id")) { $s["_element_id"] = $s["css_id"] }
  $cls = if ($s.Contains("css_classes")) { $s["css_classes"] } elseif ($s.Contains("_css_classes")) { $s["_css_classes"] } else { $null }
  if ($cls) { $s["css_classes"] = $cls; $s["_css_classes"] = $cls }
  if (-not $s.Contains("content_width")) { $s["content_width"] = "full" }
  if (-not $s.Contains("flex_direction")) { $s["flex_direction"] = "column" }
  if (-not $s.Contains("padding")) { $s["padding"] = Dim 0 0 0 0 $true }
  [ordered]@{ id=(New-Uid); elType="container"; isInner=[bool]$inner; settings=$s; elements=@($elements) }
}

function New-Widget($wtype, $settings) {
  $s = [ordered]@{}
  foreach ($k in $settings.Keys) { $s[$k] = $settings[$k] }
  if (-not $s.Contains("_margin")) { $s["_margin"] = Dim 0 0 0 0 $true }
  [ordered]@{ id=(New-Uid); elType="widget"; widgetType=$wtype; isInner=$false; settings=$s; elements=@() }
}

function Ty($family=$BODY, $size=16, $weight="400", $transform="", $lh=$null, $ls=$null) {
  $out = [ordered]@{
    typography_typography="custom"
    typography_font_family=$family
    typography_font_size=(Slider $size)
    typography_font_weight="$weight"
  }
  if ($transform) { $out["typography_text_transform"] = $transform }
  if ($null -ne $lh) { $out["typography_line_height"] = (Slider $lh "em") }
  if ($null -ne $ls) { $out["typography_letter_spacing"] = (Slider $ls) }
  $out
}

function New-Heading($title, $tag, $color, $size, $center=$false, $family=$HEAD, $extra=$null) {
  $s = [ordered]@{
    title=$title; header_size=$tag; title_color=$color
    align=$(if ($center) { "center" } else { "left" })
  }
  (Ty $family $size "700" "" 1.18).GetEnumerator() | ForEach-Object { $s[$_.Key] = $_.Value }
  if ($extra) { $extra.GetEnumerator() | ForEach-Object { $s[$_.Key] = $_.Value } }
  New-Widget "heading" $s
}

function New-Text($html, $color=$MUTE, $size=17, $center=$false, $extra=$null) {
  $s = [ordered]@{ editor=$html; text_color=$color; align=$(if ($center) { "center" } else { "left" }) }
  (Ty $BODY $size "400" "" 1.5).GetEnumerator() | ForEach-Object { $s[$_.Key] = $_.Value }
  if ($extra) { $extra.GetEnumerator() | ForEach-Object { $s[$_.Key] = $_.Value } }
  New-Widget "text-editor" $s
}

function New-Btn($label, $url, $fill=$TEAL, $color="#ffffff", $hoverFill=$SAND, $hoverColor=$INK, $css="gower-btn gower-btn-primary") {
  $s = [ordered]@{
    text=$label
    link=[ordered]@{ url=$url; is_external=""; nofollow="" }
    background_color=$fill
    button_text_color=$color
    hover_color=$hoverColor
    background_hover_color=$hoverFill
    border_radius=(Dim 2 2 2 2 $true)
    text_padding=(Dim 14 22 14 22 $false)
    _css_classes=$css
    _element_width="auto"
  }
  (Ty $BODY 12 "700" "uppercase" $null 0.6).GetEnumerator() | ForEach-Object { $s[$_.Key] = $_.Value }
  New-Widget "button" $s
}

function Media($key) {
  [ordered]@{ url="{{media_url:$key}}"; id="{{media:$key}}"; source="library" }
}

function New-Img($key, $alt, $extra=$null) {
  $s = [ordered]@{
    image=[ordered]@{ url="{{media_url:$key}}"; id="{{media:$key}}"; alt=$alt; source="library" }
    image_size="full"
    alt_text=$alt
  }
  if ($extra) { $extra.GetEnumerator() | ForEach-Object { $s[$_.Key] = $_.Value } }
  New-Widget "image" $s
}

function Boxed($width=1200, $padding=$null) {
  $s = [ordered]@{
    content_width="boxed"
    boxed_width=(Slider $width)
    padding=$(if ($padding) { $padding } else { Dim 0 24 0 24 $false })
  }
  $s
}

function Col($pct) {
  [ordered]@{
    content_width="full"
    width=(Slider $pct "%")
    width_tablet=(Slider 100 "%")
    width_mobile=(Slider 100 "%")
  }
}

function Save-El($name, $title, $typ, $content) {
  $payload = [ordered]@{
    content=$content
    page_settings=[ordered]@{ hide_title="yes" }
    version="0.4"
    title=$title
    type=$typ
  }
  $path = Join-Path $Out "$name.json"
  $payload | ConvertTo-Json -Depth 100 | Set-Content -Path $path -Encoding UTF8
  Write-Host "wrote $path"
}

function Merge($a, $b) {
  $o = [ordered]@{}
  foreach ($k in $a.Keys) { $o[$k] = $a[$k] }
  foreach ($k in $b.Keys) { $o[$k] = $b[$k] }
  $o
}

function Section-Head($title, $sub, $dark=$false) {
  New-Container (@{ content_width="full"; _css_classes="gower-section-head" }) @(
    (New-Heading $title "h2" $(if ($dark) { "#FFFFFF" } else { $INK }) 36 $true)
    (New-Text "<p>$sub</p>" $(if ($dark) { "rgba(255,233,206,0.8)" } else { $MUTE }) 15 $true @{ _css_classes="gower-sub" })
  ) $true
}

function New-Circle($key, $label, $alt) {
  New-Container (@{ content_width="full"; _css_classes="gower-circle"; flex_direction="column"; flex_align_items="center"; flex_gap=(Gap 12) }) @(
    (New-Img $key $alt)
    (New-Heading $label "h3" $INK 17 $true $BODY)
  ) $true
}

function New-Result($key, $title, $alt, $large=$false) {
  $cls = if ($large) { "gower-result gower-result-lg" } else { "gower-result" }
  New-Container (@{
    content_width="full"; _css_classes=$cls; flex_direction="column"
    flex_justify_content="flex-end"; min_height=(Slider $(if ($large) { 280 } else { 220 }))
  }) @(
    (New-Img $key $alt)
    (New-Container (@{ content_width="full"; _css_classes="gower-result-body" }) @(
      (New-Heading $title "h3" "#FFFFFF" $(if ($large) { 22 } else { 16 }) $false)
    ) $true)
  ) $true
}

# Header
$brandHtml = '<a class="gower-wordmark" href="/"><span>Gower Legal</span><small>Pine Street, Uptown</small></a>'
$barSettings = Merge (Boxed 1200 (Dim 8 24 8 24 $false)) @{
  flex_direction="row"; flex_justify_content="space-between"; flex_align_items="center"
  flex_wrap="nowrap"; flex_gap=(Gap 22); min_height=(Slider 88)
  background_background="classic"; background_color=$PAPER; _css_classes="gower-header-bar"
}
$bar = New-Container $barSettings @(
  (New-Container @{ content_width="full"; width=(Slider "auto"); _element_width="auto"; _css_classes="gower-header-logo" } @(
    (New-Widget "html" @{ html=$brandHtml })
  ) $true)
  (New-Container @{ content_width="full"; width=(Slider "auto"); _element_width="auto"; _css_classes="gower-header-nav" } @(
    (New-Widget "ha-navigation-menu" @{
      nav_menu_list="primary"; nav_menu_position="flex-end"
      nav_menu_item_color=$TEAL; nav_menu_item_hover_color=$BRICK; nav_menu_item_active_color=$BRICK
      hamburger_icon=@{ value="fas fa-bars"; library="fa-solid" }
      hamburger_close_icon=@{ value="fas fa-times"; library="fa-solid" }
      nav_menu_res_icon_color=$TEAL
      nav_menu_item_typography_typography="custom"
      nav_menu_item_typography_font_family=$BODY
      nav_menu_item_typography_font_size=(Slider 15)
      nav_menu_item_typography_font_weight="700"
    })
  ) $true)
  (New-Container @{ content_width="full"; width=(Slider "auto"); _element_width="auto"; _css_classes="gower-header-cta" } @(
    (New-Btn "Call Now" $PHONE)
  ) $true)
) $true
$header = New-Container @{
  content_width="full"; flex_direction="column"; flex_gap=(Gap 0)
  background_background="classic"; background_color=$PAPER; _css_classes="gower-header"
} @($bar)
Save-El "header" "Site Header" "header" @($header)

# Footer
$footerInner = New-Container (Merge (Boxed 1200 (Dim 28 24 28 24 $false)) @{
  flex_direction="column"; flex_align_items="center"; flex_gap=(Gap 0); _css_classes="gower-footer-inner"
}) @(
  (New-Text "<p><strong>Gower Legal</strong> $MIDDOT 1919 Pine Street, Uptown New Orleans $MIDDOT <a href=`"tel:+13402772799`">340-277-2799</a></p>" $PAPER 14 $true)
) $true
$footer = New-Container @{
  content_width="full"; background_background="classic"; background_color=$INK
  flex_gap=(Gap 0); _css_classes="gower-footer"
} @($footerInner)
Save-El "footer" "Site Footer" "footer" @($footer)

# Home
$heroCopy = New-Container (Merge (Boxed 800 (Dim 0 16 88 16 $false)) @{
  flex_direction="column"; flex_align_items="center"; flex_gap=(Gap 12); _css_classes="gower-hero-copy"
}) @(
  (New-Text "<p>Uptown $MIDDOT 1919 Pine Street</p>" $SAND 11 $true @{ _css_classes="gower-label gower-label-chip" })
  (New-Heading "A New Orleans personal injury lawyer <em>who still sits on the porch.</em>" "h1" "#FFFFFF" 52 $true $HEAD @{
    typography_font_size_tablet=(Slider 36); typography_font_size_mobile=(Slider 26); typography_line_height=(Slider 1.12 "em")
  })
  (New-Text "<p>Gower Legal is Jacob Gower's boutique on Pine Street in Uptown - call a neighbor, not a billboard.</p>" "rgba(246,241,232,0.9)" 17 $true @{ _css_classes="gower-lede" })
  (New-Btn "Call Now" $PHONE)
) $true
$hero = New-Container @{
  content_width="full"; flex_direction="column"; flex_justify_content="flex-end"; flex_align_items="center"
  min_height=@{ unit="vh"; size=100 }
  background_background="classic"; background_image=(Media "hero"); background_position="center top"
  background_size="cover"; background_color=$INK; css_id="top"; _css_classes="gower-hero"
} @(
  (New-Widget "html" @{ html='<div class="gower-hero-veil" aria-hidden="true"></div>' })
  $heroCopy
)

$storm = New-Container @{
  content_width="full"; background_background="classic"; background_color=$TEAL_DEEP
  css_id="storm"; _css_classes="gower-storm"; padding=(Dim 72 0 72 0 $false)
} @(
  (New-Container (Merge (Boxed) @{
    flex_direction="row"; flex_align_items="center"; flex_gap=(Gap 48)
    flex_direction_tablet="column"; flex_direction_mobile="column"; _css_classes="gower-split"
  }) @(
    (New-Container (Merge (Col 50) @{ _css_classes="gower-split-copy gower-storm-copy"; flex_justify_content="center"; flex_gap=(Gap 14) }) @(
      (New-Text "<p>Southern Louisiana $MIDDOT after the storm</p>" $SAND 11 $false @{ _css_classes="gower-label" })
      (New-Heading "Storm Claims" "h2" "#FFFFFF" 40)
      (New-Text "<p>When a hurricane hits the Gulf, this band comes on so you do not have to hunt. Jacob handles storm and hurricane property claims across Southern Louisiana.</p>" "rgba(255,233,206,0.94)" 17)
      (New-Btn "Call Now" $PHONE $PAPER $TEAL_DEEP $SAND $INK "gower-btn gower-btn-paper")
    ) $true)
    (New-Container (Merge (Col 50) @{ _css_classes="gower-storm-gallery"; flex_gap=(Gap 16) }) @(
      (New-Img "storm" "Wet Uptown New Orleans porch and oak limbs after a Gulf storm")
      (New-Img "result-hurricane" "Blue tarp on an Uptown roof after a storm")
    ) $true)
  ) $true)
)

$practice = New-Container @{
  content_width="full"; background_background="classic"; background_color=$PAPER
  css_id="practice"; _css_classes="gower-practice"; padding=(Dim 56 0 56 0 $false)
} @(
  (New-Container (Merge (Boxed) @{ flex_gap=(Gap 28) }) @(
    (Section-Head "Practice Areas" "The same streets you drive. These are the matters we take in New Orleans.")
    (New-Container @{
      content_width="full"; flex_direction="row"; flex_gap=(Gap 28); _css_classes="gower-circles"
    } @(
      (New-Circle "practice-car" "Car Wrecks" "Cars along an oak-lined Uptown New Orleans avenue after a wreck")
      (New-Circle "practice-slip" "Slip and Fall" "Wet cracked Uptown sidewalk under live oaks after rain")
      (New-Circle "practice-rideshare" "Rideshare" "Rideshare sedan at the curb on a leafy Uptown residential street")
      (New-Circle "practice-truck" "Trucking Accidents" "Box truck on a wet New Orleans street near oak-lined blocks")
    ) $true)
  ) $true)
)

$facts = '<dl class="gower-facts"><div class="gower-fact"><dt>Office</dt><dd>1919 Pine Street, Uptown New Orleans</dd></div><div class="gower-fact"><dt>Education</dt><dd>LSU Law, 2012 - Magna Cum Laude, Order of the Coif</dd></div><div class="gower-fact"><dt>Recognition</dt><dd>Rising Star, 2018-2025</dd></div></dl><p class="gower-about-close">You talk to the lawyer who handles the file.</p>'

$about = New-Container @{
  content_width="full"; background_background="classic"; background_color=$PAPER
  css_id="about"; _css_classes="gower-about"; padding=(Dim 72 0 72 0 $false)
} @(
  (New-Container (Merge (Boxed) @{
    flex_direction="row"; flex_align_items="stretch"; flex_gap=(Gap 40)
    flex_direction_tablet="column"; flex_direction_mobile="column"; _css_classes="gower-split"
  }) @(
    (New-Container (Merge (Col 50) @{ _css_classes="gower-split-copy"; flex_justify_content="center"; flex_gap=(Gap 14) }) @(
      (New-Text "<p>Who you are calling</p>" $TEAL 11 $false @{ _css_classes="gower-label" })
      (New-Heading "About / Who You Are" "h2" $INK 36)
      (New-Widget "html" @{ html=$facts })
      (New-Btn "Learn More" "/#about" $INK $PAPER $TEAL_DEEP $PAPER "gower-btn gower-btn-ink")
    ) $true)
    (New-Container (Merge (Col 50) @{ _css_classes="gower-split-media gower-about-media" }) @(
      (New-Img "headshot" "C. Jacob Gower, New Orleans personal injury lawyer")
    ) $true)
  ) $true)
)

$quotesHtml = '<div class="gower-carousel" data-gower-carousel><button class="gower-chevron prev" type="button" aria-label="Previous testimonials">&lsaquo;</button><div class="gower-carousel-track" tabindex="0"><article class="gower-quote"><div class="gower-quote-body"><span aria-hidden="true">&ldquo;</span><p>He called me back the same afternoon and talked like a neighbor, not a commercial.</p><p class="gower-attr">Sample - Uptown resident</p></div></article><article class="gower-quote"><div class="gower-quote-body"><span aria-hidden="true">&ldquo;</span><p>I did not want a downtown firm. I wanted someone who knew the street I wrecked on.</p><p class="gower-attr">Sample - Carrollton</p></div></article><article class="gower-quote"><div class="gower-quote-body"><span aria-hidden="true">&ldquo;</span><p>The insurance emails stopped landing on me. That was the whole point of hiring him.</p><p class="gower-attr">Sample - Mid-City</p></div></article><article class="gower-quote"><div class="gower-quote-body"><span aria-hidden="true">&ldquo;</span><p>After the storm he told us what to photograph before we pulled a single board.</p><p class="gower-attr">Sample - Southern Louisiana</p></div></article></div><button class="gower-chevron next" type="button" aria-label="Next testimonials">&rsaquo;</button></div>'

$quotes = New-Container @{
  content_width="full"; background_background="classic"; background_color=$INK
  css_id="testimonials"; _css_classes="gower-quotes"; padding=(Dim 88 0 88 0 $false)
} @(
  (New-Container (Merge (Boxed) @{ flex_gap=(Gap 28) }) @(
    (Section-Head "Testimonials" "Placeholder quotes for homepage review. They are not real client reviews." $true)
    (New-Widget "html" @{ html=$quotesHtml })
  ) $true)
)

$results = New-Container @{
  content_width="full"; background_background="classic"; background_color=$PAPER
  css_id="results"; _css_classes="gower-results"; padding=(Dim 72 0 72 0 $false)
} @(
  (New-Container (Merge (Boxed) @{ flex_gap=(Gap 28) }) @(
    (Section-Head "Results" "Sample case notes for layout - not published verdicts on this page.")
    (New-Container @{
      content_width="full"; flex_direction="row"; flex_gap=(Gap 12)
      flex_direction_tablet="column"; flex_direction_mobile="column"; _css_classes="gower-result-grid"
    } @(
      (New-Result "practice-car" '$500,000 Recovered Following Auto Injury' "Uptown avenue still for a sample auto-injury result" $true)
      (New-Container @{
        content_width="full"; width=(Slider 50 "%"); width_tablet=(Slider 100 "%"); width_mobile=(Slider 100 "%")
        _css_classes="gower-result-quad"; flex_direction="row"; flex_wrap="wrap"; flex_gap=(Gap 8)
      } @(
        (New-Result "result-hurricane" '$650,000 Recovered from Hurricane Damage' "Blue tarp on an Uptown roof after a storm")
        (New-Result "practice-slip" '$275,000 Slip and Fall' "Wet Uptown sidewalk used as a sample premises result")
        (New-Result "result-streetcar" '$180,000 Rideshare Collision' "St. Charles streetcar under live oaks")
        (New-Result "practice-truck" '$420,000 Trucking Crash' "Box truck on a New Orleans street for a sample trucking result")
      ) $true)
    ) $true)
  ) $true)
)

Save-El "home" "Home" "wp-page" @($hero, $storm, $practice, $about, $quotes, $results)
Write-Host "done"
