<footer class="footer section">
    <div class="footer__logo-box">
        <a href='<?php echo site_url( )?>'>
            <svg class="brand__img">
                <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#newresonance"></use>
            </svg>   
        </a> 
        <a class="brand__text" href="<?php echo site_url( )?>"><strong>Resonance</strong>Realty</a>
    </div>

    <div class="row">
        <div class="col-1-of-2">
            <div class="footer__navigation">
                <ul class="footer__list">
                    <li class="footer__item"><a href="<?php echo site_url( '/about-us' )?>" class="footer__link">About</a></li>
                    <li class="footer__item"><a href="#" class="footer__link">Contact us</a></li>
                    <li class="footer__item"><a href="#" class="footer__link">Carrers</a></li>
                    <li class="footer__item"><a href="<?php echo site_url( '/privacy-policy' )?>" class="footer__link">Privacy policy</a></li>
                    <li class="footer__item"><a href="#" class="footer__link">Terms</a></li>
                </ul>
            </div>
        </div>
        <div class="col-1-of-2">
            <p class="footer__copyright center">
                Copyright &copy; since 2016 by Resonance Realty Management Incorporated
            </p>
        </div>
    </div>
</footer>



<?php wp_footer();?>
</body>
</html>

