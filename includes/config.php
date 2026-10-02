<?php
/**
 * Shared config + helpers for the Sparkle Haven page.
 *
 * MAIN_SITE_URL: header/footer markup and the theme CSS/JS are loaded from the main site,
 * so the page inherits the same fonts, colours and menu behaviour. When this page is
 * dropped into the main site's codebase, point MAIN_SITE_URL at '' (relative) if preferred.
 */
define('MAIN_SITE_URL', 'https://jagathswapnahyd.com/');
define('PAGE_URL', 'https://jagathswapnahyd.com/projects/sparkle-haven-villa-east-hyderabad');
define('CONTACT_URL', MAIN_SITE_URL . 'contact');
define('PHONE_TEL', '+919885447747');

/** Base path of this page's own assets (relative to the document root the page is served from). */
define('SH_ASSETS', '/assets/');

function e($v)
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

/**
 * Renders a project image if the file exists in assets/img/sparkle-haven/, otherwise a
 * neutral placeholder block so the layout is identical before/after the artwork is supplied.
 * Drop files named <key>.jpg|.jpeg|.webp|.png into that folder and they are picked up automatically.
 */
function sh_img($key, $alt, $class = '', $eager = false, $sizes = '100vw')
{
    $dir = __DIR__ . '/../assets/img/sparkle-haven/';
    $base = SH_ASSETS . 'img/sparkle-haven/';
    foreach (['webp', 'jpg', 'jpeg', 'png'] as $ext) {
        if (is_file($dir . $key . '.' . $ext)) {
            $dim = @getimagesize($dir . $key . '.' . $ext);
            // resized copies (<key>-640.webp etc.) feed srcset so phones don't download the 2000px original
            $set = [];
            foreach ([640, 1024, 1440] as $w) {
                if (is_file($dir . $key . '-' . $w . '.' . $ext)) $set[] = e($base . $key . '-' . $w . '.' . $ext) . ' ' . $w . 'w';
            }
            if ($set && $dim) $set[] = e($base . $key . '.' . $ext) . ' ' . $dim[0] . 'w';
            return '<img src="' . e($base . $key . '.' . $ext) . '"'
                . ($set ? ' srcset="' . implode(', ', $set) . '" sizes="' . e($sizes) . '"' : '')
                . ($dim ? ' width="' . $dim[0] . '" height="' . $dim[1] . '"' : '')
                . ' alt="' . e($alt) . '" class="' . e($class) . '" loading="' . ($eager ? 'eager' : 'lazy')
                . '" decoding="async"' . ($eager ? ' fetchpriority="high"' : '') . '>';
        }
    }
    return '<div class="sh-ph ' . e($class) . '" role="img" aria-label="' . e($alt) . '"><span>' . e($key) . '</span></div>';
}

/** Returns the URL of a hero video / poster if supplied, else null. */
function sh_asset($rel)
{
    return is_file(__DIR__ . '/../assets/' . $rel) ? SH_ASSETS . $rel : null;
}
