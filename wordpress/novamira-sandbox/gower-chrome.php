<?php
if (!defined('ABSPATH')) {
  exit;
}

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style(
    'gower-fonts',
    'https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400;1,700&family=PT+Sans:ital,wght@0,400;0,700;1,400&display=swap',
    [],
    null
  );
  wp_register_style('gower-chrome', false, ['gower-fonts'], '2.0.0');
  wp_enqueue_style('gower-chrome');
  wp_add_inline_style('gower-chrome', gower_chrome_css());
}, 40);

add_action('wp_footer', function () {
  echo '<a class="gower-dock" href="tel:+13402772799">Call 340-277-2799</a>';
  echo '<script id="gower-chrome-js">' . gower_chrome_js() . '</script>';
}, 40);

add_action('wp_head', function () {
  if (!is_front_page()) {
    return;
  }
  echo '<script type="application/ld+json">' . wp_json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'WebSite',
        'name' => 'Gower Legal',
        'url' => home_url('/'),
      ],
      [
        '@type' => ['LegalService', 'LocalBusiness'],
        'name' => 'Gower Legal LLC',
        'telephone' => '+1-340-277-2799',
        'email' => 'jacob@gowerlegal.com',
        'address' => [
          '@type' => 'PostalAddress',
          'streetAddress' => '1919 Pine St',
          'addressLocality' => 'New Orleans',
          'addressRegion' => 'LA',
          'postalCode' => '70118',
          'addressCountry' => 'US',
        ],
        'areaServed' => ['New Orleans', 'Uptown', 'Southern Louisiana'],
        'url' => home_url('/'),
      ],
    ],
  ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}, 20);

function gower_chrome_css() {
  return <<<'CSS'
:root{
  --ink:#1c1c1c;--mute:#4f554f;--teal:#2f4a3c;--teal-deep:#22372d;
  --brick:#8b3a2f;--sand:#c4a46a;--paper:#f6f1e8;--white:#fffdf8;--hairline:#d8cdbb;
  --on-teal:#ffffff;--ease:cubic-bezier(.22,.1,.15,1);
  --pad:clamp(4rem,8.5vw,7rem);--pad-tight:clamp(3rem,6vw,5rem);--pad-loose:clamp(5rem,10vw,8.5rem);
}
html{scroll-behavior:smooth;scroll-padding-top:5.5rem;-webkit-text-size-adjust:100%;text-size-adjust:100%}
body,body.elementor-page{
  font-family:"PT Sans",sans-serif!important;
  font-size:1.0625rem;line-height:1.5;color:var(--mute);
  background:var(--paper);overflow-x:hidden;
}
a{color:var(--teal);text-underline-offset:.16em}
h1,h2,h3,.elementor-heading-title{
  font-family:"Libre Baskerville",serif!important;
  color:var(--ink);font-weight:700!important;letter-spacing:-.02em;
}
.site-header,header.site-header,.hello-header,#site-header,#masthead,
.site-footer,footer.site-footer,.site-footer-copyright{display:none!important}
body.elementor-page .page-header,
body.elementor-page .entry-header,
body.elementor-page .page-title{display:none!important}
body.elementor-page #content,
body.elementor-page .site-main,
body.elementor-page .page-content,
body.elementor-page .elementor{
  margin:0!important;padding:0!important;max-width:none!important;width:100%!important;
}
.ha-template-content-header .elementor,
.ha-template-content-footer .elementor{margin:0!important;padding:0!important}
.ha-template-content-header .elementor-widget{margin:0!important}
.ha-template-content-header .elementor-widget-container{padding:0!important}

.gower-band,.gower-hero,.gower-storm,.gower-practice,.gower-about,.gower-quotes,.gower-results,
.ha-template-content-header,.ha-template-content-footer{position:relative}
.gower-band:before,.gower-hero:before,.gower-storm:before,.gower-practice:before,.gower-about:before,
.gower-quotes:before,.gower-results:before,.ha-template-content-header:before,.ha-template-content-footer:before{
  content:"";pointer-events:none;position:absolute;inset:0;z-index:0;
  opacity:.12;mix-blend-mode:normal;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
}
.gower-hero:before,.gower-storm:before,.gower-quotes:before,.ha-template-content-footer:before{opacity:.05;mix-blend-mode:overlay}
.gower-band:after,.gower-hero:after,.gower-storm:after,.gower-practice:after,.gower-about:after,
.gower-quotes:after,.gower-results:after,.ha-template-content-header:after,.ha-template-content-footer:after{
  content:"";pointer-events:none;position:absolute;inset:0;z-index:0;
  opacity:.07;mix-blend-mode:multiply;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='f'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.35' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23f)'/%3E%3C/svg%3E");
}
.gower-hero:after,.gower-storm:after,.gower-quotes:after,.ha-template-content-footer:after{mix-blend-mode:overlay;opacity:.04}

.gower-btn .elementor-button,
.gower-btn a.elementor-button{
  display:inline-flex!important;align-items:center;justify-content:center;
  min-height:50px!important;padding:0 1.35rem!important;border-radius:2px!important;
  font-family:"PT Sans",sans-serif!important;font-weight:700!important;
  letter-spacing:.04em!important;text-transform:uppercase!important;font-size:.74rem!important;
  box-shadow:none!important;
}
.gower-btn .elementor-button:hover{transform:scale(.98)}
.gower-btn-primary .elementor-button{background:var(--brick)!important;color:#fff!important}
.gower-btn-primary .elementor-button:hover{background:var(--teal)!important;color:#fff!important}
.gower-btn-paper .elementor-button{background:var(--paper)!important;color:var(--teal-deep)!important}
.gower-btn-paper .elementor-button:hover{background:var(--brick)!important;color:#fff!important}
.gower-btn-ink .elementor-button{background:var(--ink)!important;color:var(--paper)!important}
.gower-btn-ink .elementor-button:hover{background:var(--brick)!important;color:#fff!important}
.gower-btn-brick .elementor-button{background:var(--brick)!important;color:#fff!important}
.gower-btn-brick .elementor-button:hover{background:var(--sand)!important;color:var(--ink)!important}

.ha-template-content-header{
  position:fixed!important;top:0;left:0;right:0;z-index:40;
  isolation:isolate;background-color:var(--paper)!important;
  border-bottom:1px solid var(--hairline);padding-top:env(safe-area-inset-top);
  box-shadow:none!important;
}
body.admin-bar .ha-template-content-header{top:32px}
@media (max-width:782px){
  body.admin-bar .ha-template-content-header{top:46px}
}
.ha-template-content-header:before{opacity:.1}
.ha-template-content-header:after{opacity:.04}
.ha-template-content-header.is-scrolled{
  background-color:var(--paper)!important;
  border-bottom-color:var(--hairline);
}
.ha-template-content-header.is-scrolled:before{opacity:.1;mix-blend-mode:normal}
.ha-template-content-header.is-scrolled:after{opacity:.04;mix-blend-mode:multiply}
.gower-header,.gower-header-bar{
  background:var(--paper)!important;
}
.gower-header-bar>.e-con-inner{
  display:flex!important;flex-direction:row!important;
  align-items:center!important;justify-content:space-between!important;
  --display:flex!important;--flex-direction:row!important;
  --align-items:center!important;--justify-content:space-between!important;
  min-height:94px!important;width:100%!important;
  padding-left:24px!important;padding-right:24px!important;
  background:transparent!important;
}
.ha-template-content-header.is-scrolled .gower-header-bar>.e-con-inner{min-height:82px!important}
.gower-header-logo{
  margin-right:auto!important;flex:0 0 auto!important;align-self:center!important;
  --align-items:center!important;
}
.gower-header-nav{
  display:flex!important;align-items:center!important;justify-content:flex-end!important;
  flex:1 1 auto!important;align-self:center!important;
  --align-items:center!important;--justify-content:flex-end!important;
}
.gower-header-cta{flex:0 0 auto!important;align-self:center!important}
.gower-wordmark{display:grid;grid-template-columns:auto 46px;grid-template-rows:auto auto;align-items:center;column-gap:.75rem;text-decoration:none!important;color:var(--teal)!important}
.gower-wordmark span{font-family:"Libre Baskerville",serif;font-size:1.35rem;font-weight:700;letter-spacing:-.03em;line-height:1}
.gower-wordmark i{display:block;width:46px;height:1px;background:var(--sand)}
.gower-wordmark small{grid-column:1/-1;margin-top:.35rem;font-family:"PT Sans",sans-serif;color:var(--mute);font-size:.68rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase}
@media (min-width:901px){
  .ha-template-content-header .ha-nav-humberger-wrapper{display:none!important}
  .ha-template-content-header .ha-nav-menu,
  .ha-template-content-header .ha-navigation-menu-wrapper,
  .ha-template-content-header .menu-primary-container{
    display:flex!important;align-items:center!important;height:auto!important;position:static!important;
  }
  .ha-template-content-header .ha-nav-menu ul.menu{
    position:static!important;top:auto!important;left:auto!important;right:auto!important;
    display:flex!important;flex-wrap:nowrap;align-items:center;gap:1.75rem;justify-content:flex-end;
    margin:0!important;padding:0!important;width:auto!important;list-style:none;
  }
  .ha-template-content-header .ha-nav-menu .menu-item{
    position:static!important;top:auto!important;margin:0!important;float:none!important;
  }
}
.ha-template-content-header .ha-nav-menu .menu-item a{
  font-family:"PT Sans",sans-serif!important;font-size:.95rem!important;font-weight:700!important;
  color:var(--teal)!important;padding:0 0 2px!important;border-bottom:1px solid transparent;
  text-transform:none!important;letter-spacing:0!important;line-height:1!important;
  text-shadow:none;
  position:static!important;top:auto!important;
}
.ha-template-content-header .ha-nav-menu .menu-item a:hover{color:var(--brick)!important;border-bottom-color:var(--brick)}
.ha-template-content-header.is-scrolled .ha-nav-menu .menu-item a{color:var(--teal)!important;text-shadow:none}
.ha-template-content-header.is-scrolled .ha-nav-menu .menu-item a:hover{color:var(--brick)!important}

.gower-hero{
  position:relative!important;min-height:100svh!important;overflow:hidden!important;
  display:flex!important;flex-direction:column!important;
  justify-content:flex-end!important;align-items:center!important;
  --display:flex!important;--flex-direction:column!important;
  --justify-content:flex-end!important;--align-items:center!important;
  --min-height:100svh!important;
  background-color:var(--ink)!important;background-size:cover!important;background-position:50% 22%!important;
}
.gower-hero>.e-con-inner{
  position:relative;z-index:2;width:100%;min-height:100svh;
  display:flex!important;flex-direction:column!important;
  justify-content:flex-end!important;align-items:center!important;
  --flex-direction:column!important;--justify-content:flex-end!important;--align-items:center!important;
}
.gower-hero>.e-con-inner>.elementor-widget-html,
.gower-hero .elementor-element.elementor-widget-html{
  position:absolute!important;inset:0;z-index:1;width:100%!important;height:100%!important;margin:0!important;pointer-events:none;
}
.gower-hero-veil{
  position:absolute!important;inset:0;z-index:1;pointer-events:none;width:100%!important;height:100%!important;margin:0!important;
  background:linear-gradient(180deg,rgba(1,52,71,.05) 0%,rgba(1,52,71,.1) 32%,rgba(1,52,71,.32) 46%,rgba(1,52,71,.6) 70%,rgba(1,52,71,.8) 100%);
}
.gower-hero-copy{
  position:relative;z-index:2;text-align:center;
  width:min(44rem,100%)!important;max-width:44rem!important;
  padding:8.25rem 1rem 4.75rem!important;text-shadow:0 1px 22px rgba(0,0,0,.45);
  --align-items:center!important;align-items:center!important;
}
.gower-hero .gower-label .elementor-widget-container,
.gower-label-chip{
  display:inline-block;color:var(--sand)!important;background:rgba(28,28,28,.9);
  box-shadow:inset 0 0 0 1px rgba(196,164,106,.35);backdrop-filter:blur(2px);
  border-radius:2px;padding:.4rem .75rem;margin-bottom:.9rem;text-shadow:none;
}
.gower-hero .gower-label p,.gower-label-chip p{
  margin:0!important;color:var(--sand)!important;font-size:.7rem!important;font-weight:700!important;
  letter-spacing:.14em!important;text-transform:uppercase!important;
}
.gower-hero h1,.gower-hero .elementor-heading-title{color:var(--white)!important;margin-bottom:.7rem!important;font-size:clamp(2.15rem,5.2vw,3.85rem)!important;line-height:1.12!important}
.gower-hero h1 em,.gower-hero .elementor-heading-title em{font-style:italic;color:#d8aa58!important}
.gower-hero .gower-lede p{color:rgba(255,246,234,.94)!important;margin:0 auto 1.25rem!important;max-width:36rem;font-size:1.08rem!important}

.gower-label p{
  margin:0 0 .65rem!important;font-size:.7rem!important;font-weight:700!important;
  letter-spacing:.14em!important;text-transform:uppercase!important;color:var(--teal)!important;
}
.gower-storm .gower-label p{color:var(--sand)!important}
.gower-section-head{text-align:left;max-width:42rem;margin:0 0 2.75rem}
.gower-section-head .elementor-widget-heading,.gower-section-head .elementor-widget-text-editor{text-align:left!important}
.gower-section-head h2,.gower-section-head .elementor-heading-title{margin-bottom:.85rem!important;font-size:clamp(1.7rem,3vw,2.6rem)!important;text-align:left!important}
.gower-section-head h2:after,.gower-section-head .elementor-heading-title:after{
  content:"";display:block;width:72px;height:1px;margin:.85rem 0 0;background:var(--brick);
}
.gower-sub p{margin:0!important;max-width:38rem;font-size:.95rem!important;line-height:1.55;text-align:left!important}

.gower-storm{background:var(--teal-deep)!important;color:var(--paper);padding:0!important;overflow:hidden}
.gower-storm h2,.gower-storm .elementor-heading-title{color:var(--white)!important}
.gower-storm .elementor-widget-text-editor p{color:rgba(255,233,206,.94)!important}
.gower-split.e-con-boxed{display:block!important}
.gower-split>.e-con-inner{
  display:grid!important;grid-template-columns:minmax(0,1fr) minmax(0,1fr)!important;
  gap:clamp(1.75rem,4vw,3.25rem)!important;align-items:stretch!important;width:100%!important;
}
.gower-split.e-con-full{
  display:grid!important;grid-template-columns:minmax(0,1fr) minmax(0,1fr)!important;
  gap:clamp(1.75rem,4vw,3.25rem)!important;align-items:stretch!important;
}
.gower-split>.e-con-inner>.e-con,.gower-split.e-con-full>.e-con{
  width:auto!important;max-width:none!important;min-width:0!important;flex:none!important;--width:100%!important;
}
.gower-split-copy{
  display:flex!important;flex-direction:column!important;
  justify-content:center!important;--justify-content:center!important;
  --flex-direction:column!important;--align-items:flex-start!important;
  height:100%!important;min-height:100%!important;align-self:stretch!important;
  max-width:32rem;
}
.gower-split-media img,.gower-storm .elementor-widget-image img{
  width:100%!important;aspect-ratio:1;object-fit:cover;object-position:50% 18%;
}
.gower-storm .gower-split>.e-con-inner,.gower-storm .gower-split.e-con-full{grid-template-columns:minmax(0,58fr) minmax(0,42fr)!important;gap:0!important}
.gower-storm-media img{height:100%!important;min-height:520px;aspect-ratio:auto!important;object-position:50% 42%!important}
.gower-storm-copy{max-width:none!important;padding:clamp(3rem,7vw,7rem)!important}
.gower-about .gower-split>.e-con-inner,.gower-about .gower-split.e-con-full{grid-template-columns:minmax(0,55fr) minmax(0,45fr)!important}
.gower-about-media{padding:0;background:var(--white);border:1px solid var(--hairline);box-shadow:none}
.gower-about-media img{outline:0;aspect-ratio:4/5;object-fit:cover;object-position:50% 18%}

.gower-practice,.gower-about,.gower-results{background:var(--paper)!important;padding:var(--pad) 0!important}
.gower-practice{padding:var(--pad-tight) 0!important}
.gower-about,.gower-results{border-top:1px solid var(--hairline)}
.gower-practice>.e-con-inner,.gower-about>.e-con-inner,.gower-results>.e-con-inner,
.gower-quotes>.e-con-inner{position:relative;z-index:1}

.gower-address-block{margin:.15rem 0 1.4rem;padding:0 0 1.4rem;border-bottom:1px solid var(--sand);display:flex;flex-direction:column}
.gower-address-block span,.gower-facts dt{font-size:.68rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--brick)}
.gower-address-block strong{font-family:"Libre Baskerville",serif;color:var(--teal);font-size:clamp(1.45rem,2.4vw,2rem);line-height:1.2;margin:.35rem 0 .2rem}
.gower-address-block small{color:var(--mute);font-size:.95rem}
.gower-facts{margin:.35rem 0 1.35rem;padding:0;background:transparent;box-shadow:none}
.gower-fact{display:grid;grid-template-columns:8.5rem minmax(0,1fr);gap:1rem;padding:1rem 0;border-bottom:1px solid var(--hairline)}
.gower-fact:last-child{border-bottom:0}
.gower-facts dt{padding-top:.2rem}
.gower-facts dd{margin:0;color:var(--ink)}
.gower-about-close{font-style:italic}

.gower-practice-grid.e-con-boxed{display:block!important}
.gower-practice-grid.e-con-full,.gower-practice-grid>.e-con-inner{
  display:grid!important;grid-template-columns:repeat(4,minmax(0,1fr))!important;
  grid-template-rows:repeat(2,minmax(230px,1fr));gap:1.1rem!important;width:100%!important;
}
.gower-practice-grid>.e-con-inner>.e-con,.gower-practice-grid.e-con-full>.e-con{
  width:auto!important;max-width:none!important;min-width:0!important;flex:none!important;--width:100%!important;
}
.gower-practice-tile{position:relative!important;min-height:230px;overflow:hidden;border:1px solid var(--sand);background:var(--ink)}
.gower-practice-featured{grid-row:span 2!important;grid-column:span 2!important;min-height:478px}
.gower-practice-media,.gower-practice-media .elementor-widget-image,.gower-practice-media .elementor-widget-container{position:absolute!important;inset:0;margin:0!important}
.gower-practice-media img{width:100%!important;height:100%!important;max-width:none!important;object-fit:cover;transition:transform 650ms var(--ease)}
.gower-practice-tile:hover .gower-practice-media img{transform:scale(1.035)}
.gower-practice-caption{position:absolute!important;z-index:2;left:0;right:0;bottom:0;padding:1.25rem!important;background:linear-gradient(180deg,transparent,rgba(28,28,28,.88));min-height:48%;justify-content:flex-end!important}
.gower-practice-caption .elementor-heading-title{color:var(--white)!important;font-size:clamp(1.05rem,1.7vw,1.35rem)!important}
.gower-practice-line p{color:rgba(255,253,248,.82)!important;margin:0!important;font-size:.88rem!important}

.gower-quotes{background:var(--teal-deep)!important;padding:var(--pad-loose) 0!important;overflow:hidden}
.gower-quotes .gower-section-head .elementor-heading-title{color:var(--white)!important}
.gower-quotes .gower-sub p{color:rgba(246,241,232,.78)!important}
.gower-carousel{display:grid;grid-template-columns:auto 1fr auto;gap:.85rem;align-items:center}
.gower-carousel-track{display:flex;gap:1rem;overflow-x:auto;scroll-snap-type:x mandatory;scrollbar-width:none}
.gower-carousel-track::-webkit-scrollbar{display:none}
.gower-quote{
  position:relative;flex:0 0 calc((100% - 2rem)/3);min-height:310px;scroll-snap-align:start;
  overflow:hidden;background:var(--paper);border:1px solid rgba(196,164,106,.55);
}
.gower-quote-body{
  position:relative;z-index:1;height:100%;padding:2rem 1.75rem 1.65rem;
  display:flex;flex-direction:column;justify-content:space-between;color:var(--ink);
}
.gower-quote-body>span{font-family:"Libre Baskerville",serif;color:var(--brick);font-size:4.25rem;line-height:.8}
.gower-quote-body p{font-family:"Libre Baskerville",serif;color:var(--ink);margin:1.25rem 0;font-size:1.05rem;line-height:1.65}
.gower-attr{font-family:"PT Sans",sans-serif!important;font-size:.72rem!important;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--teal)!important;margin:0!important}
.gower-attr small{display:block;margin-top:.3rem;color:var(--mute);font-size:.68rem;font-weight:400;letter-spacing:.08em}
.gower-chevron{
  width:44px;height:44px;border:1px solid rgba(238,171,90,.45);background:transparent;
  color:var(--paper);font-size:1.6rem;cursor:pointer;
}
.gower-chevron:hover{background:var(--sand);border-color:var(--sand);color:var(--ink)}

.gower-result-grid.e-con-boxed{display:block!important}
.gower-result-grid.e-con-full,.gower-result-grid>.e-con-inner{
  display:grid!important;grid-template-columns:minmax(0,2fr) minmax(0,1fr) minmax(0,1fr)!important;
  gap:.75rem!important;align-items:stretch!important;width:100%!important;
}
.gower-result-grid>.e-con-inner>.e-con,.gower-result-grid.e-con-full>.e-con{
  width:auto!important;max-width:none!important;min-width:0!important;flex:none!important;--width:100%!important;
}
.gower-result{
  position:relative;aspect-ratio:4/5;overflow:hidden;background:var(--ink);min-height:0;
}
.gower-result .elementor-widget-image,
.gower-result .elementor-widget-image .elementor-widget-container{position:absolute;inset:0;margin:0!important}
.gower-result img{width:100%!important;height:100%!important;object-fit:cover;position:absolute;inset:0;max-width:none;transition:transform 680ms var(--ease)}
.gower-result:hover img{transform:scale(1.05)}
.gower-result-body{
  position:relative;z-index:1;height:100%;min-height:100%;padding:1.15rem 1.05rem;
  display:flex;flex-direction:column;justify-content:flex-end;align-items:flex-start;
  background:linear-gradient(180deg,transparent 35%,rgba(28,28,28,.86));
}
.gower-result:hover .gower-result-body{background:linear-gradient(180deg,rgba(28,28,28,.05) 20%,rgba(28,28,28,.94))}
.gower-result-body:before{content:"";width:38px;height:1px;margin-bottom:.65rem;background:var(--brick)}
.gower-result-body .elementor-heading-title{
  color:var(--white)!important;margin:0!important;font-size:clamp(1rem,1.4vw,1.2rem)!important;
  display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;
}
.gower-result-lg{aspect-ratio:8/5;height:100%;min-height:100%}
.gower-result-lg .gower-result-body{padding:1.6rem 1.5rem}
.gower-result-lg .gower-result-body:before{width:48px;margin-bottom:.8rem}
.gower-result-lg .gower-result-body .elementor-heading-title{font-size:clamp(1.15rem,1.9vw,1.6rem)!important}

.ha-template-content-footer,.gower-footer{background:var(--ink)!important;color:#d9d2c4;text-align:left}
.gower-footer{padding:3.5rem 0 5.75rem!important}
.gower-footer-brand .elementor-heading-title{
  font-size:clamp(1.8rem,3vw,2.6rem)!important;color:var(--paper)!important;margin-bottom:.6rem!important;
}
.gower-footer a{color:var(--sand)!important}
.gower-footer-contact{display:flex;flex-direction:column;gap:.35rem}
.gower-footer-contact a{font-size:1.1rem;font-weight:700;text-decoration:none}
.gower-footer-contact a+a:before{content:none}
.gower-footer-vi{margin-top:1rem;padding-top:1rem;border-top:1px solid rgba(246,241,232,.15)}
.gower-footer-vi a{color:#a9a69e!important;font-size:.8rem}
.gower-footer-inner>.e-con-inner>.e-con,.gower-footer-inner.e-con-full>.e-con{width:auto!important;max-width:none!important;min-width:0!important;flex:none!important;--width:100%!important}

.gower-dock{
  position:fixed;left:max(1rem,env(safe-area-inset-left));right:max(1rem,env(safe-area-inset-right));
  bottom:max(1rem,env(safe-area-inset-bottom));z-index:50;display:none;
  align-items:center;justify-content:center;min-height:52px;background:var(--brick);color:var(--on-teal);
  text-decoration:none;font-weight:700;letter-spacing:.1em;text-transform:uppercase;font-size:.74rem;border-radius:999px;
}

@media (max-width:900px){
  .gower-split.e-con-full,.gower-split>.e-con-inner,.gower-result-grid.e-con-full,.gower-result-grid>.e-con-inner{grid-template-columns:1fr!important}
  .gower-practice-grid.e-con-full,.gower-practice-grid>.e-con-inner{grid-template-columns:repeat(2,minmax(0,1fr))!important;grid-template-rows:auto!important;gap:1rem!important}
  .gower-practice-featured{grid-column:1/-1!important;grid-row:auto!important;min-height:420px}
  .gower-practice-tile{min-height:280px}
  .gower-fact{grid-template-columns:minmax(0,1fr);gap:.2rem}
  .gower-facts dt{padding-top:0}
  .gower-quote{flex:0 0 calc((100% - 1rem)/2)}
  .ha-template-content-header .ha-nav-menu ul.menu{display:none!important}
  .gower-header-cta{display:none!important}
  .gower-dock{display:flex}
  .gower-footer{padding-bottom:calc(7rem + env(safe-area-inset-bottom))!important}
  .gower-result-lg{aspect-ratio:4/3}
  .gower-section-head{margin-bottom:1.85rem}
  .gower-footer-inner>.e-con-inner,.gower-footer-inner.e-con-full{display:grid!important;grid-template-columns:1fr 1fr!important}
}
@media (max-width:700px){
  :root{--pad:3.25rem;--pad-tight:2.5rem;--pad-loose:3.5rem}
  .gower-header,.gower-header-bar,.gower-header-bar>.e-con-inner{min-height:76px!important}
  .ha-template-content-header.is-scrolled .gower-header-bar,
  .ha-template-content-header.is-scrolled .gower-header-bar>.e-con-inner{min-height:64px!important}
  .gower-wordmark span{font-size:1.15rem}
  .gower-wordmark i{width:32px}
  .gower-wordmark small{font-size:.58rem}
  .gower-hero,.gower-hero>.e-con-inner{min-height:100svh!important}
  .gower-hero{background-position:68% 18%!important}
  .gower-hero-copy{width:100%;padding:7.75rem 1rem 5.75rem}
  .gower-hero .gower-btn{display:none!important}
  .gower-hero h1,.gower-hero .elementor-heading-title{font-size:clamp(1.55rem,7.2vw,2.05rem)!important}
  .gower-hero .gower-lede p{font-size:.98rem!important;margin-bottom:0!important}
  .gower-storm .elementor-widget-image img{aspect-ratio:4/3}
  .gower-storm-media img{min-height:0}
  .gower-storm-copy{padding:2.75rem 1.5rem!important}
  .gower-practice-grid.e-con-full,.gower-practice-grid>.e-con-inner{grid-template-columns:1fr!important}
  .gower-practice-featured,.gower-practice-tile{grid-column:auto!important;min-height:360px}
  .gower-quote{flex:0 0 100%}
  .gower-result{aspect-ratio:16/10}
  .gower-footer-inner>.e-con-inner,.gower-footer-inner.e-con-full{grid-template-columns:1fr!important}
}
@media (prefers-reduced-motion:reduce){
  *,*:before,*:after{animation:none!important;transition:none!important;scroll-behavior:auto!important}
}
CSS;
}

function gower_chrome_js() {
  return <<<'JS'
(function(){
  var header=document.querySelector(".ha-template-content-header");
  var hero=document.getElementById("top")||document.querySelector(".gower-hero");
  function syncHeader(){
    if(!header||!hero) return;
    header.classList.toggle("is-scrolled",hero.getBoundingClientRect().bottom<=72);
  }
  window.addEventListener("scroll",syncHeader,{passive:true});
  window.addEventListener("resize",syncHeader);
  syncHeader();
  var root=document.querySelector("[data-gower-carousel]");
  if(!root) return;
  var track=root.querySelector(".gower-carousel-track");
  var prev=root.querySelector(".prev");
  var next=root.querySelector(".next");
  function step(dir){
    var card=track&&track.querySelector(".gower-quote");
    if(!card) return;
    track.scrollBy({left:dir*(card.getBoundingClientRect().width+16),behavior:"smooth"});
  }
  if(prev) prev.addEventListener("click",function(){step(-1);});
  if(next) next.addEventListener("click",function(){step(1);});
})();
JS;
}
