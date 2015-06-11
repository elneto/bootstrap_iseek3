<div id="top-bar">
        <div class="container">
                <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 hidden-xs">
                                <!-- eric: base_url needs to be i18n and domain aware: is not currently -->
                                <img src="/sites/iseek.un.org/themes/bootstrap_iseek3/images/un-logo-top.png" border="0" id="un-top-logo" alt="United Nations logo"><a class="top-nav-item" href="<?php echo $GLOBALS['base_url']; ?>">Welcome to the United Nations Intranet</a>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6">
<!--
                                <a class="top-nav-item" href="#">Low bandwidth | High contrast</a>
-->
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6" id="block_login_or_user-menu">
                                <?php
                                        if (user_is_logged_in()) {
                                                $user_menu_block = module_invoke('system', 'block_view', 'user-menu');
                                                print render($user_menu_block['content']);
                                        } else {
                                                $login_block = module_invoke('user', 'block_view', 'login');
                                                print render($login_block['content']);
                                        }
                                ?>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                                <?php
                                        $block = module_invoke('locale', 'block_view', 'language');
                                        print render($block['content']);
                                ?>
                                <?php // print render($page['header']); ?>
                        </div>
                </div>
        </div>
</div>

<!-- Main container -->
<div class="container">

        <div class="row">
                <div class="col-md-3 col-xs-6">
                        <div class="row">
                                <div class="col-md-10 col-xs-12">
                                        <a href="<?php echo url('<front>');?>">
                                                <img src="<?php print $logo; ?>" onerror="this.onerror=null; this.src='images/iseek-logo.png'" border="0" class="img-responsive img-logo-banner" alt="iseek logo" width="225"/>
                                        </a>
                                </div>
                                <div class="col-md-2 hidden-xs">
                                        <div id="banner-separation"></div>
                                </div>
                        </div>
                </div>
                <div class="col-md-7 col-xs-6">
                        <div class="navbar-default" id="location-navbar">
                                <ul class="nav navbar-nav">
                                        <li class="dropdown">

                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span id="location-display">New York</span> <span class="caret"></span></a>
                                                <ul id="ul-location" class="dropdown-menu" role="menu">
                                                        <li><a href="https://iseek-addisababa.un.org">Addis Ababa</a></li>
                                                        <li><a href="https://iseek-bangkok.un.org">Bangkok</a></li>
                                                        <li><a href="https://iseek-beirut.un.org">Beirut</a></li>
                                                        <li><a href="https://iseek-geneva.un.org">Geneva</a></li>
                                                        <li><a href="https://iseek-nairobi.un.org">Nairobi</a></li>
                                                        <li><a href="https://iseek-newyork.un.org">New York</a></li>
                                                        <li><a href="https://iseek-santiago.un.org">Santiago</a></li>
                                                        <li><a href="https://iseek-vienna.un.org">Vienna</a></li>
                                                </ul>

                                        </li>
                                </ul>
                        </div><!-- /.navbar-collapse -->
                </div>
                <div class="col-md-2 visible-md visible-lg">
                        <img src="/sites/iseek.un.org/themes/bootstrap_iseek3/images/un-70.svg" onerror="this.onerror=null; this.src='/sites/iseek.un.org/themes/bootstrap_iseek3/images/un-70.png'" border="0" class="img-responsive img-logo-banner" alt="UN 70 logo" width="145">
                </div>
        </div>

</div>
<!-- /Main container -->

<div class="main-container container">

        <div class="row" id="iseek-main-nav">

                <div class="col-sm-12">

                        <div class="navbar-header navbar-default">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar-collapse" aria-expanded="true">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                </button>
                        </div>

                        <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])): ?>
                          <div class="navbar-collapse collapse" id="main-navbar-collapse">
                                <nav role="navigation">
                                  <?php if (!empty($primary_nav)): ?>
                                        <?php print render($primary_nav); ?>
                                  <?php endif; ?>
                                  <?php if (!empty($secondary_nav)): ?>
                                        <?php print render($secondary_nav); ?>
                                  <?php endif; ?>
                                  <?php if (!empty($page['navigation'])): ?>
                                        <?php print render($page['navigation']); ?>
                                  <?php endif; ?>
                                </nav>
                          </div>
                        <?php endif; ?>

                </div>

        <!-- <div class="col-sm-2 col-xs-12">
                <?php //print render($page['header']); //do we need this region? ?>
        </div> -->

        </div>
        <!-- Urgent message -->
        <div class="row">
                <div class="col-md-12">
                        <?php
                                // eric: double-check if this is the correct view
                                echo views_embed_view('urgent_message_with_domains');
                        ?>
                </div>
        </div>

<!-- end common header -->

