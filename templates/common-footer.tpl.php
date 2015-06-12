<?php

//dpm($menu_quicklinksNY);

?>
<!-- Staff Toolkit -->
      
      <div class="row">
        <div class="col-lg-12">
          <div class="toolkit large-text" id="toolkit-anchor">&nbsp;<i class="fa fa-briefcase"></i>&nbsp;&nbsp;Toolkit</div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 footer-border">
        <div class="footer-background toolkit-row">
        <div class="col-md-3 left-menu">
           <div class="row underline left-menu-top">
              <div  class="partners content-large-text">
                <h5 class="content-large-text">Quicklinks - New York</h5>
                <?php print $menu_quicklinksNY;?>
              </div>
          </div>
          <div class="about-us">
              <img src=<?php print $path_logo_footer;?>  class="img-responsive" id="logo-footer" alt="iseek logo"/>
              <?php print render($about_us_block); ?>
        </div>
        </div>
          <div class="col-md-3">
           <div class="footer-menu-items">
            <div class="content-large-text" id="key-tools">
              <?php print $menu_ktt; ?>
            </div>
            <h5 class="content-large-text underline">Key tools</h5>
            <div class="medium-text">
              <?php print $menu_ktb; ?>
            </div>             
          </div>

        </div>
        <div class="col-md-3">
          <div class="footer-menu-items"> 
            <h5 class="content-large-text underline">Staff development</h5>
            <div class="medium-text">
              <?php print $menu_staff; ?>
            </div> 
            <h5 class="content-large-text underline">Pay, benefits, insurance</h5>
            <div class="medium-text">
              <?php print $menu_pay; ?>
            </div> 
            <h5 class="content-large-text underline">Security</h5>
            <div class="medium-text">
              <?php print $menu_security; ?>
            </div> 
            <h5 class="content-large-text underline">Travel and Visas</h5>
            <div class="medium-text">
              <?php print $menu_travel; ?>
            </div> 
            <h5 class="content-large-text underline">Health and wellbeing</h5>
            <div class="medium-text">
              <?php print $menu_health; ?>
            </div> 

          </div>
        </div>
        <div class="col-md-3">
          <div class="footer-menu-items"> 
            <h5 class="content-large-text underline">Rules and regulations</h5>
            <div class="medium-text">
              <?php print $menu_rules; ?>
            </div> 
            <h5 class="content-large-text underline">Reference and manuals</h5>
            <div class="medium-text">
              <?php print $menu_reference; ?>
            </div> 

            <h5 class="content-large-text underline">Ethics, internal justice</h5>
            <div class="medium-text">
              <?php print $menu_ethics; ?>
            </div> 
              <h5 class="content-large-text underline">Finance and budget</h5>
              <div class="medium-text">
                <?php print $menu_finance; ?>
            </div> 
          </div>
        
        
        </div>
              <div class="about-us-xs visible-xs visible-sm">
                <img src=<?php print $path_logo_footer;?> class="img-responsive" id="logo-footer" alt="iseek logo"/>
                <?php print render($about_us_block); ?>
            </div>
        </div>
      </div>
    </div>
    </div><!-- / main .container -->
    <p>&nbsp;</p>
    <footer class="blog-footer visible-xs">
      
        <a href="#top-bar">Back to top</a>
      
      <p>
        <?php print render($page['footer']); ?>
      </p>

    </footer>
  </div> <!-- main container
