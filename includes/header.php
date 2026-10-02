<?php
/** Expects $meta (title, description). Mirrors the main site's <head> + header markup. */
$m = MAIN_SITE_URL;
?><!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= e($meta['title']) ?></title>
    <meta name="description" content="<?= e($meta['description']) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="canonical" href="<?= e(PAGE_URL) ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= e($meta['title']) ?>">
    <meta property="og:description" content="<?= e($meta['description']) ?>">
    <meta property="og:url" content="<?= e(PAGE_URL) ?>">
    <link rel="shortcut icon" href="<?= $m ?>assets/img/jslogo.png" type="image/x-icon">

    <!-- Main-site theme (fonts, colours, grid, header, footer) -->
    <link rel="stylesheet" href="<?= $m ?>assets/css/font-icons.css">
    <link rel="stylesheet" href="<?= $m ?>assets/css/plugins.css">
    <link rel="stylesheet" href="<?= $m ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $m ?>assets/css/responsive.css">
    <!-- Same families the main site specifies (its own @import lists Poppins with a malformed URL, so load explicitly) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700&family=Poppins:wght@200;300;400;500;600&display=swap">
    <link rel="stylesheet" href="<?= SH_ASSETS ?>dev/fa-local.css">
    <!-- Page styles -->
    <link rel="stylesheet" href="<?= SH_ASSETS ?>css/sparkle-haven.css?v=4">
</head>

<body class="sh-page">
<script>document.documentElement.classList.add('sh-js');</script>

<header class="ltn__header-area ltn__header-5 ltn__header-logo-and-mobile-menu-in-mobile ltn__header-logo-and-mobile-menu">
    <div class="ltn__header-top-area section-bg-6">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="ltn__top-bar-menu">
                        <ul>
                            <li><a href="mailto:info@jagathswapnahyd.com"><i class="icon-mail"></i> info@jagathswapnahyd.com</a></li>
                            <li><a href="#"><i class="icon-placeholder"></i>Office Address : Habsiguda, Hyderabad</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="top-bar-right text-end">
                        <div class="ltn__top-bar-menu">
                            <ul>
                                <li>
                                    <div class="ltn__social-media">
                                        <ul>
                                            <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="#" title="Dribbble"><i class="fab fa-dribbble"></i></a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="site-logo-wrap">
                        <div class="site-logo">
                            <a href="<?= $m ?>"><img src="<?= $m ?>assets/img/jagatswapna.png" alt="Sri Jagathswapna Realtors" style="width: 280px;"></a>
                        </div>
                    </div>
                </div>
                <div class="col header-menu-column">
                    <div class="header-menu d-none d-xl-block">
                        <nav>
                            <div class="ltn__main-menu">
                                <ul>
                                    <li><a href="<?= $m ?>">Home</a></li>
                                    <li><a href="<?= $m ?>ongoing_projects">On Going Projects</a></li>
                                    <li><a href="<?= $m ?>contact">Contact</a></li>
                                    <li class="special-link"><a href="<?= $m ?>spanesta">Spanesta</a></li>
                                    <li class="special-link"><a href="https://havenbysrijagathswapnahyd.com/app/v2/public/home" target="_blank" rel="noopener">Haven</a></li>
                                    <li class="special-link"><a href="https://docs.google.com/forms/d/e/1FAIpQLSdoYoTCczUFxPDxcCwYOmPw5ynyFEyyyBZUfHhFB0U-oyOemA/viewform?usp=sf_link">Registration</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="ltn__header-options ltn__header-options-2">
                    <div class="mobile-menu-toggle d-xl-none">
                        <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle">
                            <svg viewBox="0 0 800 600">
                                <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                <path d="M300,320 L540,320" id="middle"></path>
                                <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
    <div class="ltn__utilize-menu-inner ltn__scrollbar">
        <div class="ltn__utilize-menu-head">
            <div class="site-logo">
                <a href="<?= $m ?>"><img src="<?= $m ?>assets/img/jagatswapna-main.png" alt="Logo"></a>
            </div>
            <button class="ltn__utilize-close">×</button>
        </div>
        <div class="ltn__utilize-menu">
            <ul>
                <li><a href="<?= $m ?>">Home</a></li>
                <li><a href="<?= $m ?>ongoing_projects">On Going Projects</a></li>
                <li><a href="<?= $m ?>contact">Contact</a></li>
                <li class="special-link"><a href="<?= $m ?>spanesta">Spanesta</a></li>
                <li class="special-link"><a href="https://havenbysrijagathswapnahyd.com/app/v2/public/home" target="_blank" rel="noopener">Haven</a></li>
            </ul>
        </div>
        <div class="ltn__social-media-2">
            <ul>
                <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="ltn__utilize-overlay"></div>

<div class="body-wrapper">
