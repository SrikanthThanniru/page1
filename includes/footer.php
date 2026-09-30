<?php $m = MAIN_SITE_URL; ?>
</div><!-- /.body-wrapper -->

<footer class="ltn__footer-area">
    <div class="footer-top-area section-bg-2 plr--5">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget footer-about-widget">
                        <div class="footer-logo">
                            <div class="site-logo">
                                <img src="<?= $m ?>assets/img/jagatswapna-footer1.png" alt="Logo">
                            </div>
                        </div>
                        <div class="footer-address">
                            <ul>
                                <li>
                                    <div class="footer-address-icon"><i class="icon-placeholder"></i></div>
                                    <div class="footer-address-info"><p style="color: white !important;">Habsiguda, Hyderabad</p></div>
                                </li>
                                <li>
                                    <div class="footer-address-icon"><i class="icon-call"></i></div>
                                    <div class="footer-address-info"><p style="color: white !important;"><a href="tel:<?= e(PHONE_TEL) ?>">+91 9885447747</a></p></div>
                                </li>
                                <li>
                                    <div class="footer-address-icon"><i class="icon-mail"></i></div>
                                    <div class="footer-address-info"><p style="color: white !important;"><a href="mailto:info@jagathswapnahyd.com">info@jagathswapnahyd.com</a></p></div>
                                </li>
                            </ul>
                        </div>
                        <div class="ltn__social-media mt-20">
                            <ul>
                                <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                <li><a href="#" title="Youtube"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget footer-menu-widget clearfix">
                        <h4 class="footer-title">Quick Links</h4>
                        <div class="footer-menu">
                            <ul>
                                <li><a href="<?= $m ?>">Home</a></li>
                                <li><a href="<?= $m ?>spanesta">Spanesta</a></li>
                                <li><a href="<?= $m ?>ongoing_projects">On-Going Projects</a></li>
                                <li><a href="<?= $m ?>contact">Contact us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 col-12">
                    <div class="footer-widget footer-newsletter-widget">
                        <h4 class="footer-title">Newsletter</h4>
                        <p style="color: white !important;">Subscribe to our weekly Newsletter and receive updates via email.</p>
                        <div class="footer-newsletter">
                            <form action="#">
                                <input type="email" name="email" placeholder="Email*">
                                <div class="btn-wrapper">
                                    <button class="theme-btn-1 btn" type="submit"><i class="fas fa-location-arrow"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ltn__copyright-area ltn__copyright-2 section-bg-7 plr--5">
        <div class="container-fluid ltn__border-top-2">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="ltn__copyright-design clearfix">
                        <p style="color: white !important;">All Rights Reserved @ Jagathswapna Relators Pvt. Ltd. <?= date('Y') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="<?= $m ?>assets/js/plugins.js"></script>
<script src="<?= $m ?>assets/js/main.js"></script>
<script src="<?= SH_ASSETS ?>js/sparkle-haven.js?v=2"></script>
</body>

</html>
