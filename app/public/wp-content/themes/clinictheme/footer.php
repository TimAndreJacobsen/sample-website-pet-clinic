<footer class="site-footer">

  <div class="site-footer__inner container container--narrow">

    <div class="group">

      <div class="site-footer__col-one">
        <h1 class="clinic-logo-text clinic-logo-text--alt-color"><a href="<?php echo esc_url(site_url()); ?>">The <strong>Clinic</strong></a></h1>
        <p><a class="site-footer__link" href="#">Phone ### ## ###</a></p>
      </div>

      <div class="site-footer__col-two-three-group">
        <div class="site-footer__col-two">
          <h3 class="headline headline--small">Explore</h3>
          <nav class="nav-list">
            <?php
            wp_nav_menu(array(
              'theme_location' => 'footer_menu_location_left'
            ));
          ?>
        </div>


        <div class="site-footer__col-three">
          <h3 class="headline headline--small">Learn more</h3>
          <nav class="nav-list">
            <?php
            wp_nav_menu(array(
              'theme_location' => 'footer_menu_location_right'
            ));
          ?>
        </div>
      </div>

      <div class="site-footer__col-four">
        <h3 class="headline headline--small">Connect With Us</h3>
        <nav>
          <ul class="min-list social-icons-list group">
            <li><a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
          </ul>
        </nav>
      </div>
    </div>

  </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>