<?php
/**
 * Sparkle Haven – project page
 * Proposed URL: /projects/sparkle-haven-villa-east-hyderabad  (see .htaccess)
 *
 * Section flow and scroll behaviour follow the reference project page (Radhey Raaga):
 * hero video → intro split → pinned "curtain" details panel (Highlights / Specification tabs)
 * → pinned sideways amenities → floor plans → map with sidebar → FAQ.
 */
require __DIR__ . '/includes/config.php';
$c = require __DIR__ . '/includes/content.php';
$meta = $c['meta'];

$heroVideo = sh_asset('video/sparkle-haven-hero.mp4');
$mapSrc = 'https://maps.google.com/maps?q=' . rawurlencode($c['location']['map_query']) . '&t=k&z=14&output=embed';
$mapLink = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($c['location']['map_query']);

/** Splits "Label: value" spec lines so the label can be set in bold, as in the reference cards. */
function sh_spec_row($text)
{
    if (preg_match('/^([^:]{2,42}):\s+(.+)$/u', $text, $m)) {
        return '<span class="sh-kv__k">' . e($m[1]) . ':</span> <span class="sh-kv__v">' . e($m[2]) . '</span>';
    }
    return '<span class="sh-kv__v">' . e($text) . '</span>';
}

/** One row per destination with its drive time (the source table lists several destinations per time). */
$drives = [];
foreach ($c['location']['times'] as [$time, $places]) {
    foreach (array_map('trim', explode(';', $places)) as $place) {
        $drives[] = [ucfirst($place), $time];
    }
}
$specGroups = $c['specs']['groups'];

require __DIR__ . '/includes/header.php';
?>

<!-- ============ HERO ============ -->
<section class="sh-hero" id="top">
    <div class="sh-hero__media">
        <?php if ($heroVideo): ?>
            <video class="sh-hero__video" autoplay muted loop playsinline preload="auto" poster="<?= e(SH_ASSETS) ?>img/sparkle-haven/hero.webp" data-hero-video>
                <source src="<?= e($heroVideo) ?>" type="video/mp4">
            </video>
        <?php else: ?>
            <?= sh_img('hero', 'Sparkle Haven villas', 'sh-hero__img', true) ?>
        <?php endif; ?>
    </div>
    <div class="sh-hero__shade"></div>
    <div class="sh-hero__content">
        <h1>
            <span class="sh-hero__name"><?= e($c['hero']['name']) ?></span>
            <span class="sh-sr">: </span>
            <span class="sh-hero__tag"><?= e($c['hero']['tagline']) ?></span>
        </h1>
    </div>
    <?php if ($heroVideo): ?>
        <button type="button" class="sh-hero__sound" data-hero-sound aria-label="Unmute video" aria-pressed="false">
            <i class="fas fa-volume-mute"></i>
        </button>
    <?php endif; ?>
</section>

<!-- ============ INTRO + DETAILS (one pinned stage; the details panels slide up over the intro) ============ -->
<section class="sh-story" id="introduction" data-story>
    <div class="sh-story__pin">

        <!-- base layer: intro split -->
        <div class="sh-story__base">
            <div class="sh-story__text">
                <div class="sh-intro">
                    <h2 class="sh-h2"><?= e($c['intro']['title']) ?></h2>
                    <div class="sh-rule"></div>
                    <p class="sh-p"><?= e($c['intro']['text']) ?></p>
                    <a class="sh-btn sh-btn--red" href="<?= e(CONTACT_URL) ?>"><?= e($c['intro']['cta']) ?></a>
                    <div class="sh-meta">
                        <?php foreach ($c['intro']['meta'] as $i => $mt): ?>
                            <?php if ($i): ?><span class="sh-meta__sep">|</span><?php endif; ?>
                            <span><?= e($mt) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="sh-story__media"><?= sh_img('introduction', 'Introducing Sparkle Haven', '', true) ?></div>
        </div>

        <!-- overlay: left image panel -->
        <div class="sh-story__left" data-left>
            <?= sh_img('highlights', 'Sparkle Haven project highlights', '', true) ?>
            <div class="sh-story__shade"></div>
            <div class="sh-story__caption">
                <div data-caption="highlights" class="is-on">
                    <h2 class="sh-h2 sh-h2--light"><?= e($c['highlights']['title']) ?></h2>
                </div>
                <div data-caption="specs">
                    <h2 class="sh-h2 sh-h2--light"><?= e($c['specs']['title']) ?></h2>
                    <p class="sh-p sh-p--light"><?= e($c['specs']['text']) ?></p>
                </div>
            </div>
        </div>

        <!-- overlay: right panel with tabs -->
        <div class="sh-story__right" data-right>
            <div class="sh-tabs" data-tabs role="tablist">
                <span class="sh-tabs__thumb"></span>
                <button type="button" role="tab" class="is-active" data-tab="highlights">Highlights</button>
                <button type="button" role="tab" data-tab="specs">Specification</button>
            </div>

            <div class="sh-story__scroll" data-scroll>
                <div class="sh-story__list is-on" data-list="highlights">
                    <?php foreach ($c['highlights']['groups'] as [$gicon, $gtitle, $rows]): ?>
                        <article class="sh-panel-card">
                            <header><h3><?= e($gtitle) ?></h3><span class="sh-badge"><i class="fas <?= e($gicon) ?>"></i></span></header>
                            <div class="sh-rule sh-rule--left"></div>
                            <ul class="sh-hl">
                                <?php foreach ($rows as [$ricon, $label, $value]): ?>
                                    <li><i class="fas <?= e($ricon) ?>"></i><div><span class="sh-kv__k"><?= e($label) ?>:</span> <span class="sh-kv__v"><?= e($value) ?></span></div></li>
                                <?php endforeach; ?>
                            </ul>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="sh-story__list" data-list="specs">
                    <?php foreach ($specGroups as [$sicon, $stitle, $points]): ?>
                        <article class="sh-panel-card">
                            <header><h3><?= e($stitle) ?></h3><span class="sh-badge"><i class="fas <?= e($sicon) ?>"></i></span></header>
                            <div class="sh-rule sh-rule--left"></div>
                            <ul class="sh-kvlist">
                                <?php foreach ($points as $pt): ?><li><?= sh_spec_row($pt) ?></li><?php endforeach; ?>
                            </ul>
                        </article>
                    <?php endforeach; ?>
                    <p class="sh-note"><em><?= e($c['specs']['note']) ?></em></p>
                </div>
            </div>

            <div class="sh-story__cta">
                <a class="sh-btn sh-btn--red" href="<?= e(CONTACT_URL) ?>"><?= e($c['intro']['cta']) ?></a>
            </div>
        </div>
    </div>
</section>

<!-- ============ WHY INVEST ============ -->
<section class="sh-section sh-wave sh-why" id="why-invest">
    <div class="sh-wrap sh-why__grid">
        <div class="sh-why__head">
            <h2 class="sh-h2" data-reveal><?= e($c['why']['title']) ?></h2>
            <div class="sh-rule sh-rule--left"></div>
        </div>
        <ol class="sh-why__list">
            <?php foreach ($c['why']['items'] as $i => [$t, $d]): ?>
                <li data-reveal data-n="<?= sprintf('%02d', $i + 1) ?>" style="--d:<?= $i * .08 ?>s">
                    <span class="sh-why__num"><?= sprintf('%02d', $i + 1) ?></span>
                    <div>
                        <h3><?= e($t) ?></h3>
                        <p><?= e($d) ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<!-- ============ COMMUNITY PLANNING ============ -->
<section class="sh-section sh-wave sh-planning" id="community-planning">
    <div class="sh-wrap">
        <div class="sh-planning__top">
            <div class="sh-planning__text">
                <h2 class="sh-h2" data-reveal><?= e($c['planning']['title']) ?></h2>
                <div class="sh-rule sh-rule--left"></div>
                <?php foreach ($c['planning']['paras'] as $p): ?>
                    <p class="sh-p" data-reveal><?= e($p) ?></p>
                <?php endforeach; ?>
            </div>
            <div class="sh-planning__media" data-badge="Entrance arch view"><?= sh_img('community-planning', 'Sparkle Haven community layout') ?></div>
        </div>
        <h3 class="sh-chips__title" data-reveal>Infrastructure at a glance</h3>
        <ul class="sh-chips">
            <?php foreach ($c['planning']['chips'] as [$icon, $label]): ?>
                <li data-reveal><i class="fas <?= e($icon) ?>"></i><span><?= e($label) ?></span></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- ============ VILLAS / FLOOR PLANS ============ -->
<section class="sh-section sh-wave sh-plans" id="villas">
    <div class="sh-wrap sh-wrap--wide">
        <div class="sh-plans__head">
            <div class="sh-plans__title">
                <h2 class="sh-h2" data-reveal><?= e($c['villas']['title']) ?></h2>
                <p class="sh-p" data-reveal><?= e($c['villas']['text']) ?></p>
                <p class="sh-p" data-reveal><strong><?= e($c['villas']['sub_title']) ?>.</strong> <?= e($c['villas']['sub_text']) ?></p>
            </div>
            <div class="sh-switch" role="tablist" aria-label="Villa facing">
                <?php $first = true; foreach ($c['villas']['facings'] as $k => $label): ?>
                    <button type="button" role="tab" class="<?= $first ? 'is-active' : '' ?>" data-facing="<?= e($k) ?>"><?= e($label) ?></button>
                    <?php if ($first): ?><span>/</span><?php endif; $first = false; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="sh-plans__body">
            <div class="sh-plans__info">
                <div class="sh-pills" role="tablist" aria-label="Floor" data-pills>
                    <span class="sh-pills__thumb"></span>
                    <?php $first = true; foreach ($c['villas']['floors'] as $k => $label): ?>
                        <button type="button" role="tab" class="<?= $first ? 'is-active' : '' ?>" data-floor="<?= e($k) ?>"><?= e($label) ?></button>
                    <?php $first = false; endforeach; ?>
                </div>

                <dl class="sh-rows">
                    <?php foreach ($c['villas']['rows'] as [$k, $v]): ?>
                        <div><dt><?= e($k) ?></dt><dd><?= e($v) ?></dd></div>
                    <?php endforeach; ?>
                    <div><dt>Facing</dt><dd data-facing-label><?= e(reset($c['villas']['facings'])) ?></dd></div>
                </dl>

                <p class="sh-p sh-p--sm"><?= e($c['villas']['summary']) ?></p>

                <div class="sh-plans__actions">
                    <a class="sh-btn sh-btn--red" href="<?= e(CONTACT_URL) ?>"><?= e($c['villas']['cta']) ?></a>
                    <div class="sh-arrows">
                        <button type="button" class="sh-arrow" data-floor-prev aria-label="Previous floor"><i class="fas fa-chevron-left"></i></button>
                        <button type="button" class="sh-arrow is-solid" data-floor-next aria-label="Next floor"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

            <div class="sh-plans__card">
                <div class="sh-plans__frame">
                    <?php foreach ($c['villas']['facings'] as $fk => $fl): foreach ($c['villas']['floors'] as $ok => $ol): ?>
                        <div class="sh-plan" data-plan="<?= e($fk . '-' . $ok) ?>" hidden>
                            <?= sh_img('plan-' . $fk . '-' . $ok, $fl . ' – ' . $ol . ' (4 BHK)', '', true) ?>
                        </div>
                    <?php endforeach; endforeach; ?>
                </div>
                <div class="sh-plans__caption">
                    <span data-floor-label><?= e(reset($c['villas']['floors'])) ?> (4 BHK)</span>
                    <span data-facing-caption><?= e(reset($c['villas']['facings'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ OUTDOOR SPACES (pinned sideways scroll) ============ -->
<section class="sh-amen sh-wave" id="outdoor-spaces" data-hscroll>
    <div class="sh-amen__pin">
        <div class="sh-amen__title" data-amen-title>
            <h2 class="sh-h2"><?= e($c['outdoor']['title']) ?></h2>
            <p class="sh-p sh-p--sm"><?= e($c['outdoor']['intro']) ?></p>
        </div>
        <div class="sh-amen__stat" data-amen-stat>
            <span class="sh-amen__num"><?= e($c['outdoor']['stat'][0]) ?></span>
            <div class="sh-amen__line"></div>
            <span class="sh-amen__cap"><?= e($c['outdoor']['stat'][1]) ?></span>
        </div>
        <div class="sh-amen__viewport">
            <div class="sh-amen__track" data-track>
                <?php foreach ($c['outdoor']['spaces'] as [$key, $name, $area]): ?>
                    <figure class="sh-card" data-card>
                        <div class="sh-card__img"><?= sh_img($key, $name, '', true) ?></div>
                        <figcaption>
                            <strong><?= e($name) ?></strong>
                            <span>Approx. <?= e($area) ?></span>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="sh-amen__progress" data-progress>
            <?php foreach ($c['outdoor']['spaces'] as $_): ?><i></i><?php endforeach; ?>
        </div>
    </div>
</section>
<div class="sh-closing sh-wave">
    <div class="sh-wrap"><p class="sh-p" data-reveal><?= e($c['outdoor']['closing']) ?></p></div>
</div>

<!-- ============ CLUBHOUSE ============ -->
<section class="sh-section sh-club" id="clubhouse">
    <div class="sh-wrap">
        <div class="sh-club__head">
            <div>
                <h2 class="sh-h2 sh-h2--light" data-reveal><?= e($c['clubhouse']['title']) ?></h2>
                <div class="sh-rule sh-rule--left sh-rule--light"></div>
            </div>
            <p class="sh-p sh-p--light" data-reveal><?= e($c['clubhouse']['text']) ?></p>
        </div>
        <ul class="sh-club__grid">
            <?php foreach ($c['clubhouse']['items'] as $i => [$icon, $label]): ?>
                <li data-reveal style="--d:<?= ($i % 4) * .07 ?>s">
                    <span class="sh-club__icon"><i class="fas <?= e($icon) ?>"></i></span>
                    <span class="sh-club__label"><?= e($label) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="sh-center">
            <a class="sh-btn sh-btn--light" href="#outdoor-spaces"><?= e($c['clubhouse']['cta']) ?></a>
        </div>
    </div>
</section>

<!-- ============ LOCATION ============ -->
<section class="sh-loc sh-wave" id="location">
    <div class="sh-loc__head">
        <h2 class="sh-h2" data-reveal><?= e($c['location']['title']) ?></h2>
        <p class="sh-p" data-reveal><?= e($c['location']['text']) ?></p>
    </div>
    <div class="sh-loc__stage" data-map-stage>
        <iframe class="sh-loc__map" title="Sparkle Haven location map" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="<?= e($mapSrc) ?>"></iframe>
        <div class="sh-loc__veil" data-map-veil></div>
        <button type="button" class="sh-loc__interact" data-map-toggle>Interact with map</button>

        <aside class="sh-loc__side" data-map-side>
            <h3 class="sh-h3"><?= e($c['location']['sidebar_title']) ?></h3>
            <ul class="sh-times">
                <?php foreach ($drives as [$place, $time]): ?>
                    <li><span><?= e($place) ?></span><strong><?= e($time) ?></strong></li>
                <?php endforeach; ?>
            </ul>
            <p class="sh-note"><em>*<?= e($c['location']['note']) ?></em></p>
            <div class="sh-loc__actions">
                <a class="sh-btn sh-btn--red" href="<?= e($mapLink) ?>" target="_blank" rel="noopener"><?= e($c['location']['cta_map']) ?></a>
                <a class="sh-btn sh-btn--ghost" href="<?= e(CONTACT_URL) ?>"><?= e($c['location']['cta_visit']) ?></a>
            </div>
        </aside>
    </div>
</section>

<!-- ============ ABOUT ============ -->
<section class="sh-section sh-about" id="about">
    <div class="sh-wrap sh-about__grid">
        <div>
            <h2 class="sh-h2 sh-h2--light" data-reveal><?= e($c['about']['title']) ?></h2>
            <div class="sh-rule sh-rule--left sh-rule--light"></div>
            <p class="sh-p sh-p--light" data-reveal><?= e($c['about']['text']) ?></p>
        </div>
        <ul class="sh-stats">
            <?php foreach ($c['about']['stats'] as [$n, $suffix, $label]): ?>
                <li data-reveal>
                    <span class="sh-stats__n"><?= e($n) ?><sup><?= e($suffix) ?></sup></span>
                    <span class="sh-stats__l"><?= e($label) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- ============ FAQ ============ -->
<section class="sh-section sh-wave sh-faq" id="faqs">
    <div class="sh-wrap sh-wrap--narrow">
        <div class="sh-center">
            <h2 class="sh-h2" data-reveal><?= e($c['faqs']['title']) ?></h2>
        </div>
        <div class="sh-faq__list">
            <?php foreach ($c['faqs']['items'] as $i => [$q, $a]): ?>
                <div class="sh-acc <?= $i === 0 ? 'is-open' : '' ?>" data-acc data-reveal>
                    <button type="button" class="sh-acc__btn" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
                        <span class="sh-acc__title"><?= e($q) ?></span>
                        <span class="sh-acc__toggle"><i class="fas fa-plus"></i><i class="fas fa-minus"></i></span>
                    </button>
                    <div class="sh-acc__panel"><div class="sh-acc__inner"><p class="sh-p sh-p--sm"><?= e($a) ?></p></div></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============ VISIT CTA ============ -->
<section class="sh-visit" id="visit">
    <div class="sh-visit__bg"><?= sh_img('visit', 'Visit Sparkle Haven') ?></div>
    <div class="sh-visit__shade"></div>
    <div class="sh-visit__content">
        <h2 class="sh-h2 sh-h2--light" data-reveal><?= e($c['visit']['title']) ?></h2>
        <p class="sh-p sh-p--light" data-reveal><?= e($c['visit']['text']) ?></p>
        <div class="sh-visit__actions">
            <a class="sh-btn sh-btn--red" href="<?= e(CONTACT_URL) ?>"><?= e($c['visit']['cta_enquire']) ?></a>
            <a class="sh-btn sh-btn--light" href="<?= e(CONTACT_URL) ?>"><?= e($c['visit']['cta_visit']) ?></a>
        </div>
        <p class="sh-disclaimer"><em><?= e($c['visit']['disclaimer']) ?></em></p>
    </div>
</section>

<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(fn($f) => [
        '@type' => 'Question', 'name' => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ], $c['faqs']['items']),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
