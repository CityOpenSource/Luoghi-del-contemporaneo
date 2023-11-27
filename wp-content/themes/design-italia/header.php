<?php
// $theme_locations = get_nav_menu_locations();
// $current_group = dci_get_current_group();
?><!doctype html>
<html lang="it">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri();?>/favicons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri();?>/favicons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri();?>/favicons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri();?>/favicons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri();?>/favicons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri();?>/favicons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri();?>/favicons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri();?>/favicons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri();?>/favicons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri();?>/favicons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri();?>/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri();?>/favicons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri();?>/favicons/favicon-16x16.png">
        <link rel="manifest" href="<?php echo get_template_directory_uri();?>/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri();?>/favicons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <?php wp_head(); ?>
    </head>

    <body>
        <div class="skiplink">
            <a class="visually-hidden-focusable" href="#main-container">Vai ai contenuti</a>
            <a class="visually-hidden-focusable" href="#footer">Vai al footer</a>
        </div>
        <header class="it-header-wrapper" data-bs-target="#header-nav-wrapper" style="">
          <div class="it-header-slim-wrapper">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <div class="it-header-slim-wrapper-content">
                    <a class="d-lg-block navbar-brand" target="_blank" href="#" aria-label="Vai al portale del Ministero della cultura - link esterno - apertura nuova scheda" title="Vai al portale del Ministero della cultura">Ministero della cultura</a>
                    <div class="it-header-slim-right-zone" role="navigation">
                      <?php 
                          $langwalker = new Lang_Menu_Walker; 
                          $langMenu = array(
                            
                            'walker' => $langwalker,
                            'theme_location' => 'langmenu',
                            'container' => 'div',
                            'container_class' => 'nav-item dropdown',
                            'items_wrap' => '%3$s'
                            );
                          wp_nav_menu($langMenu);
                        ?>

                      <!-- <a class="btn btn-primary btn-icon btn-full" href="/wp-admin/" data-element="personal-area-login">
                        <span class="rounded-icon" aria-hidden="true">
                          <svg class="icon icon-primary">
                            <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-user"></use>
                          </svg>
                        </span>
                        <span class="d-none d-lg-block">Accedi all'area personale</span>
                      </a> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
          <div class="it-nav-wrapper">
            <div class="it-header-center-wrapper">
              <div class="container">
                <div class="row">
                  <div class="col-12">
                    <div class="it-header-center-content-wrapper">
                      <div class="it-brand-wrapper d-flex flex-row">
                        
                          <a href="https://creativitacontemporanea.cultura.gov.it/" title="Vai alla homepage" target="_blank" rel="noopener" class="d-md-inline-block d-none">
                            <svg height="82" class="icon" aria-hidden="true" style="width:305px!important">
                              <image style="width:305px!important" href="<?php echo get_template_directory_uri();?>/images/mic-logo.png"></image>
                            </svg>
                            <!-- <div class="it-brand-text">
                              <div class="it-brand-title">Luoghi del contemporaneo</div>
                              <div class="it-brand-tagline d-none d-md-block">Portale ufficiale</div>
                            </div> -->
                          </a>
                          <a href="/" title="Vai alla homepage">
                            <svg height="82" class="icon" aria-hidden="true">
                              <image xlink:href="<?php echo get_template_directory_uri();?>/svg/logo.svg"></image>
                            </svg>
                            <!-- <div class="it-brand-text">
                              <div class="it-brand-title">Luoghi del contemporaneo</div>
                              <div class="it-brand-tagline d-none d-md-block">Portale ufficiale</div>
                            </div> -->
                          </a>
                      </div>
                      <div class="it-right-zone">
                        <div class="it-search-wrapper">
                          <span class="d-none d-md-block"><?php _e('Cerca','design-italia');?></span>
                          <button class="search-link rounded-icon" type="button" data-bs-toggle="modal" data-bs-target="#search-modal" aria-label="Cerca nel sito">
                            <svg class="icon">
                              <use href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-search"></use>
                            </svg>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="it-header-navbar-wrapper" id="header-nav-wrapper">
              <div class="container">
                <div class="row">
                  <div class="col-12">
                    <!--start nav-->
                    <div class="navbar navbar-expand-lg has-megamenu">
                      <button class="custom-navbar-toggler" type="button" aria-controls="nav4" aria-expanded="false" aria-label="Mostra/Nascondi la navigazione" data-bs-target="#nav4" data-bs-toggle="navbarcollapsible">
                        <svg class="icon">
                          <use href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-burger"></use>
                        </svg>
                      </button>
                      <div class="navbar-collapsable" id="nav4">
                        <div class="overlay" style="display: none;"></div>
                        <div class="close-div">
                          <button class="btn close-menu" type="button">
                            <span class="visually-hidden">Nascondi la navigazione</span>
                            <svg class="icon">
                              <use href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-close-big"></use>
                            </svg>
                          </button>
                        </div>
                        <div class="menu-wrapper">
                          <a href="/" class="logo-hamburger"> 
                            <div class="it-brand-text">
                              <div class="it-brand-title"><img class="img-fluid mt-5" src="<?php echo get_template_directory_uri();?>/svg/logo-b.svg"></img><!-- <?php _e('Luoghi del contemporaneo','design-italia');?> --></div>
                            </div>
                          </a>
                          <nav aria-label="Principale">
                          <?php 
                          $walker = new Main_Menu_Walker; 
                          $topMenu = array(
                            
                            'walker' => $walker,
                            'theme_location' => 'mainmenu',
                            'container' => false,
                            'items_wrap' => '<ul class="navbar-nav" data-element="main-navigation">%3$s</ul>'  
                            );
                          wp_nav_menu($topMenu);
                          ?> 
                          </nav> 
                          <div class="it-socials">
                            <span><?php _e('Seguici su','design-italia');?></span>
                            <ul>
                              <?php if(strlen(get_theme_mod( 'twitter' ))):?>
                              <li>
                                <a href="<?php echo get_theme_mod( 'twitter' );?>" target="_blank">
                                  <svg class="icon icon-sm icon-white align-top">
                                    <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-twitter"></use>
                                  </svg>
                                  <span class="visually-hidden">Twitter</span></a>
                              </li>
                              <?php endif;?>
                              <?php if(strlen(get_theme_mod( 'facebook' ))):?>
                              <li>
                                <a href="<?php echo get_theme_mod( 'facebook' );?>" target="_blank">
                                  <svg class="icon icon-sm icon-white align-top">
                                    <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-facebook"></use>
                                  </svg>
                                  <span class="visually-hidden">Facebook</span></a>
                              </li>
                              <?php endif;?>
                              <?php if(strlen(get_theme_mod( 'instagram' ))):?>
                              <li>
                                <a href="<?php echo get_theme_mod( 'instagram' );?>" target="_blank">
                                  <svg class="icon icon-sm icon-white align-top">
                                    <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-instagram"></use>
                                  </svg>
                                  <span class="visually-hidden">Instagram</span></a>
                              </li>
                              <?php endif;?>
                              <?php if(strlen(get_theme_mod( 'youtube' ))):?>
                              <li>
                                <a href="<?php echo get_theme_mod( 'youtube' );?>" target="_blank">
                                  <svg class="icon icon-sm icon-white align-top">
                                    <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-youtube"></use>
                                  </svg>
                                  <span class="visually-hidden">YouTube</span></a>
                              </li>
                              <?php endif;?>
                              <?php if(strlen(get_theme_mod( 'telegram' ))):?>
                              <li>
                                <a href="<?php echo get_theme_mod( 'telegram' );?>" target="_blank">
                                  <svg class="icon icon-sm icon-white align-top">
                                    <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-telegram"></use>
                                  </svg>
                                  <span class="visually-hidden">Telegram</span></a>
                              </li>
                              <?php endif;?>
                              <?php if(strlen(get_theme_mod( 'whatsapp' ))):?>
                              <li>
                                <a href="<?php echo get_theme_mod( 'whatsapp' );?>" target="_blank">
                                  <svg class="icon icon-sm icon-white align-top">
                                    <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-whatsapp"></use>
                                  </svg>
                                  <span class="visually-hidden">Whatsapp</span></a>
                              </li>
                              <?php endif;?> 
                              <li>
                                <a href="/feed/?post_type=luogocontemporaneo" target="_blank">
                                  <svg class="icon icon-sm icon-white align-top">
                                    <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-rss"></use>
                                  </svg>
                                  <span class="visually-hidden">RSS</span></a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </header>