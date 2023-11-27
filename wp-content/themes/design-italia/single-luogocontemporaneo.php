<?php
/*
 * Generic Page Template
 *
 * @package Design_Italia
 */

  get_header();


// $sql = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = 'gallery_data' AND meta_id<140000 GROUP BY post_id ORDER BY post_id ASC";
// echo $sql;
// $items = $wpdb->get_results($sql);
// // $items = array_splice($items, 0, 10);
// echo '<pre>';
// foreach ($items as $key => $item) {
//     // print_r($item);
//     $array = unserialize($item->meta_value);
//     $array['post_id'] = [];
//     // print_r($array);
//     foreach ($array['image_url'] as $key2 => $value2) {
//       $array['image_url'][$key2] = str_replace('https://luoghidelcontemporaneo.beniculturali.it/reserved/foto/','/wp-content/uploads/2023/11/',$value2);
//       $id = str_replace(array('/wp-content/uploads/2023/11/','.jpg'),array('',''),strtolower($array['image_url'][$key2]));
//       // echo "$id $id-1\n";
//       $array['image_url'][$key2] = str_replace($id,$id-1,$array['image_url'][$key2]);
//       $array['post_id'][$key2] = intval($id) + 2000;
//     }
//     $items[$key]->meta_value = serialize($array);
//     unset($items[$key]->meta_id);
//     $items[$key]->meta_value = str_replace("'","\'",$items[$key]->meta_value);
//     $ql = "INSERT INTO {$wpdb->prefix}postmeta(post_id,meta_key,meta_value) VALUES ({$items[$key]->post_id},'{$items[$key]->meta_key}','{$items[$key]->meta_value}')";
//     echo "$ql\n";
//     // print_r($array);
//     // $wpdb->get_results($ql);

// }
// die();


  $metas = get_post_meta( $post->ID);
  $gallery = get_post_meta( $post->ID, 'gallery_data', true );
  $citta = get_post_meta( $post->ID, 'luogo_localita_id', true );
  $sql = "SELECT * FROM {$wpdb->prefix}luoghi_localita AS l INNER JOIN {$wpdb->prefix}luoghi_province AS p ON l.localita_provincia_id = p.provincia_id INNER JOIN {$wpdb->prefix}luoghi_regioni AS r ON p.provincia_regione_id = r.regione_id WHERE l.localita_id = '".$citta."'";
  $indirizzo = $wpdb->get_results($sql)[0];
 
  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
  if(empty($image)) $image = $gallery['image_url'][0];


  $tip = get_post_meta( $post->ID, 'luogo_tipologia_id', true );


  $tipologia = wp_get_post_terms( $post->ID, 'tipologia' )[0]; 
  $colore = get_term_meta( $tipologia->term_id, 'color', true ); 
  $servizi = wp_get_post_terms( $post->ID, 'servizio' );  

  $info = [];
  if(strlen($metas['luogo_autore'][0])):$info[] = 'Autore: ' . $metas['luogo_autore'][0] . '</li>'; endif;
  if(strlen($metas['luogo_realizzazione'][0])):$info[] = 'Anno realizzazione: ' . $metas['luogo_realizzazione'][0] . '</li>'; endif;
  if(strlen($metas['luogo_collocazione'][0])):$info[] = 'Anno collocazione: ' . $metas['luogo_collocazione'][0] . '</li>'; endif;
  if(strlen($metas['luogo_dimensioni'][0])):$info[] = 'Dimensioni: ' . $metas['luogo_dimensioni'][0] . '</li>'; endif;
  if(strlen($metas['luogo_promotore'][0])):$info[] = 'Promotore: ' . $metas['luogo_promotore'][0] . '</li>'; endif;
  if(strlen($metas['luogo_curatore'][0])):$info[] = 'Curatore: ' . $metas['luogo_curatore'][0] . '</li>'; endif;
  if(strlen($metas['luogo_proprietario'][0])):$info[] = 'Proprietario: ' . $metas['luogo_proprietario'][0] . '</li>'; endif;
  if(strlen($metas['luogo_gestore'][0])):$info[] = 'Gestore: ' . $metas['luogo_gestore'][0] . '</li>'; endif;
  if(strlen($metas['luogo_opere'][0])):$info[] = 'Opere: ' . $metas['luogo_opere'][0] . '</li>'; endif;
?>

<main>
      <div class="container" id="main-container">
        <div class="row">
          <div class="col px-lg-4">
            <div class="cmp-breadcrumbs py-4" role="navigation">
            <?php get_template_part("template-parts/common/breadcrumb"); ?>
            </div>      
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 px-lg-4 py-lg-2">
            <h1 data-audio="Titolo: <?php the_title();?>"><?php the_title();?></h1>
            <h2 class="h4 py-2" data-audio="Tipologia: <?php echo $tipologia->name;?>"><?php echo $tipologia->name;?></h2> 
          </div>
          <div class="col-lg-3 offset-lg-1">

            <?php get_template_part( "template-parts/actions" ); ?>
    
            <div class="mt-4 mb-4">
              <h6 class="text-secondary"><?php _e('Servizi','design-italia');?></h6>
              <ul class="d-flex flex-wrap gap-1 mt-2">
                <?php foreach($servizi as $servizio):?>
                <li>
                  <a class="chip chip-simple" href="#">
                    <span class="chip-label"><?php echo $servizio->name;?></span>
                  </a>
                </li>
                <?php endforeach;?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    
      <div class="container-fluid my-3">
        <div class="row">
          <figure class="figure px-0 img-full">
            <img src="<?php echo $image;?>" class="figure-img img-fluid" alt="<?php echo wp_get_attachment_caption($post->ID);?>">
            <figcaption class="figure-caption text-center pt-3"><?php echo wp_get_attachment_caption($post->ID);?></figcaption>
          </figure>
        </div>
      </div>
    
      <div class="container">
        <div class="row border-top border-light row-column-border row-column-menu-left">
          <aside class="col-lg-4">
            <div class="cmp-navscroll sticky-top" aria-labelledby="accordion-title-one">
              <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="INDICE DELLA PAGINA" data-bs-navscroll="">
                <div class="navbar-custom" id="navbarNavProgress">
                  <div class="menu-wrapper">
                    <div class="link-list-wrapper">
                      <div class="accordion">
                        <div class="accordion-item">
                          <span class="accordion-header" id="accordion-title-one">
                            <button class="accordion-button pb-10 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-one" aria-expanded="true" aria-controls="collapse-one">
                            <?php _e('INDICE DELLA PAGINA','design-italia');?>
                              <svg class="icon icon-xs right">
                                <use href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-expand"></use>
                              </svg>
                            </button>
                          </span>
                          <div class="progress">
                            <div class="progress-bar it-navscroll-progressbar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                          </div>
                          <div id="collapse-one" class="accordion-collapse collapse show" role="region" aria-labelledby="accordion-title-one">
                            <div class="accordion-body">
                              <ul class="link-list" data-element="page-index">
                                <li class="nav-item">
                                  <a class="nav-link active" href="#cos-e">
                                    <span class="title-medium"><?php _e("Cos'è?",'design-italia');?></span>
                                  </a>
                                </li> 
                                <li class="nav-item">
                                  <a class="nav-link" href="#luogo">
                                    <span class="title-medium"><?php _e('Luogo','design-italia');?></span>
                                  </a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" href="#contatti">
                                    <span class="title-medium"><?php _e('Contatti','design-italia');?></span>
                                  </a>
                                </li>
                                <?php if(strlen($metas['luogo_note'][0])):?>
                                <li class="nav-item">
                                  <a class="nav-link" href="#note">
                                    <span class="title-medium"><?php _e('Note','design-italia');?></span>
                                  </a>
                                </li>
                                <?php endif;?>
                                <?php if(count($info)):?>
                                <li class="nav-item">
                                  <a class="nav-link" href="#info">
                                    <span class="title-medium"><?php _e('Info','design-italia');?></span>
                                  </a>
                                </li>
                                <?php endif;?>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </nav>
            </div>      
          </aside>
          <section class="col-lg-8 it-page-sections-container border-light">
            <article id="cos-e" class="it-page-section mb-5" data-audio="">
              <h2 class="mb-3"><?php _e("Cos'è?",'design-italia');?></h2>
              <?php the_content();?>
              <div class="it-carousel-wrapper it-carousel-landscape-abstract-three-cols splide splide--slide splide--ltr splide--draggable is-active is-initialized" data-bs-carousel-splide="" id="splide01">
                <div class="it-header-block">
                  <div class="it-header-block-title">
                    <h3 class="h4"><?php _e('Galleria di immagini','design-italia');?></h3>
                  </div>
                </div>
                <div class="splide__track" id="splide01-track" style="padding-left: 0px; padding-right: 0px;">
                  <ul class="splide__list it-carousel-all" id="splide01-list" style="transform: translateX(0px);">
                    <?php foreach($gallery['image_url'] as $k => $item):?>
                      <li class="splide__slide is-active is-visible" id="splide01-slide<?php echo $k+1;?>" style="margin-right: 24px; width: calc(((100% + 24px) / 3) - 24px);" tabindex="<?php echo $k;?>" data-focus-mouse="false">
                      <div class="it-single-slide-wrapper">
                        <figure>
                          <a href="<?php echo $item;?>" data-lightbox="roadtrip" data-title="<?php $gallery['image_title'][$k];?>"><img src="<?php echo $item;?>" alt="Festa di Sant'Efisio" class="img-fluid"></a>
                          <figcaption class="figure-caption mt-2"><?php $gallery['caption'][$k];?></figcaption>
                        </figure>
                      </div>
                    </li>
                    <?php endforeach;?>
                  </ul>
                </div>
            </article> 
            <article id="luogo" class="it-page-section mb-5">
              <h2 class="mb-3"><?php _e('Luogo','design-italia');?></h2>
              <div class="card-wrapper card-teaser-wrapper">
                <div class="card card-teaser shadow mt-3 rounded">
                  <svg class="icon icon-success" aria-hidden="true">
                    <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-pin"></use>
                  </svg>
                  <div class="card-body">
                    <h3 class="card-title h5">
                      <a href="#" class="text-decoration-none">
                        <?php echo $indirizzo->localita_nome;?> (<?php echo $indirizzo->provincia_sigla;?>) 
                      </a>
                    </h3>
                    <div class="card-text">
                      <p><?php echo get_post_meta( $post->ID, 'luogo_indirizzo', true );?></p> 
                    </div>
                  </div>
                </div>
              </div>
              <div class="map-wrapper map-column mt-4"> 
                <div id="mapdettaglio" style="width: 100%; aspect-ratio: 320/180;"></div>
                <script>
                  var light = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}.png?api_key=<?php echo get_theme_mod( 'stadiamaps' );?>', {
                      maxZoom: 19,
                      attribution: '© OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team hosted by OpenStreetMap France'
                  });
                    var map = L.map('mapdettaglio',{
                        center: [<?php echo get_post_meta( $post->ID, 'luogo_lat', true );?>, <?php echo get_post_meta( $post->ID, 'luogo_lon', true );?>],
                        layers: [light],
                        zoom: 13,
                        dragging: !L.Browser.mobile
                    });
                    L.circleMarker([<?php echo get_post_meta( $post->ID, 'luogo_lat', true );?>, <?php echo get_post_meta( $post->ID, 'luogo_lon', true );?>], {weight:0.5,radius:8, opacity: 0.9, color: '<?php echo $colore;?>', fillColor:'<?php echo $tipologia->tipologia_colore;?>', fillOpacity: 1}).addTo(map);

                    // Check if geolocation is available in the browser
                    if ("geolocation" in navigator) {
                        // Get the user's current location
                        navigator.geolocation.getCurrentPosition(function(position) {
                            // The user's latitude and longitude are in position.coords.latitude and position.coords.longitude
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude; 

                            L.circleMarker([latitude, longitude], {weight:3,radius:5, opacity: 0.9, color: '#000000', fillColor:'#FFF', fillOpacity: 1}).addTo(map);  
                        }, function(error) {
                            // Handle errors, if any
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    console.error("User denied the request for geolocation.");
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    console.error("Location information is unavailable.");
                                    break;
                                case error.TIMEOUT:
                                    console.error("The request to get user location timed out.");
                                    break;
                                case error.UNKNOWN_ERROR:
                                    console.error("An unknown error occurred.");
                                    break;
                            }
                        });
                    } else {
                        console.error("Geolocation is not available in this browser.");
                    }
                </script>
              </div>
            </article>
    
    
            <article id="contatti" class="it-page-section mb-5">
              <h2 class="mb-3"><?php _e('Contatti','design-italia');?></h2>
              <div class="mb-4">
                <div class="card card-teaser shadow rounded">
                  <svg class="icon" aria-hidden="true">
                    <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-telephone"></use>
                  </svg>
                  <div class="card-body">
                    <h3 class="card-title h5">
                      <a href="#" class="text-decoration-none">
                        <?php the_title();?>
                      </a>
                    </h3>
                    <div class="card-text">
                      <p><?php echo get_post_meta( $post->ID, 'luogo_indirizzo', true );?> - <?php echo get_post_meta( $post->ID, 'luogo_cap', true );?> <?php echo $indirizzo->localita_nome;?> (<?php echo $indirizzo->provincia_sigla;?>)</p>
                      <div class="mt-3">
                        <?php if(!empty(get_post_meta( $post->ID, 'luogo_telefono', true ))):?><p>T <?php echo get_post_meta( $post->ID, 'luogo_telefono', true );?></p><?php endif;?>
                        <?php if(!empty(get_post_meta( $post->ID, 'luogo_web', true ))):?><p><a aria-label="scopri di più su <?php echo get_post_meta( $post->ID, 'luogo_web', true );?> - link esterno - apertura nuova scheda" target="_blank" title="vai sul sito di <?php the_title();?>" href="<?php echo get_post_meta( $post->ID, 'luogo_web', true );?>">Web</a></p><?php endif;?>
                        <?php if(!empty(get_post_meta( $post->ID, 'luogo_email', true ))):?><p><a aria-label="invia un'email a <?php echo get_post_meta( $post->ID, 'luogo_email', true );?>< - apertura casella postale" title="invia un'email a <?php echo get_post_meta( $post->ID, 'luogo_email', true );?> - apertura casella postale" href="mailto:<?php echo get_post_meta( $post->ID, 'luogo_email', true );?>">Email</a></p><?php endif;?>
                        <?php if(!empty(get_post_meta( $post->ID, 'luogo_facebook', true ))):?><p><a aria-label="scopri di più su <?php echo get_post_meta( $post->ID, 'luogo_facebook', true );?> - link esterno - apertura nuova scheda" target="_blank" title="vai sulla pagina Facebook di <?php the_title();?>" href="<?php echo get_post_meta( $post->ID, 'luogo_facebook', true );?>">Facebook</a></p><?php endif;?>
                        <?php if(!empty(get_post_meta( $post->ID, 'luogo_twitter', true ))):?><p><a aria-label="scopri di più su <?php echo get_post_meta( $post->ID, 'luogo_twitter', true );?> - link esterno - apertura nuova scheda" target="_blank" title="vai sulla pagina X di <?php the_title();?>" href="<?php echo get_post_meta( $post->ID, 'luogo_twitter', true );?>">X</a></p><?php endif;?>
                        <?php if(!empty(get_post_meta( $post->ID, 'luogo_instagram', true ))):?><p><a aria-label="scopri di più su <?php echo get_post_meta( $post->ID, 'luogo_instagram', true );?> - link esterno - apertura nuova scheda" target="_blank" title="vai sulla pagina Instagram di <?php the_title();?>" href="<?php echo get_post_meta( $post->ID, 'luogo_instagram', true );?>">Instagram</a></p><?php endif;?>
                        <?php if(!empty(get_post_meta( $post->ID, 'luogo_youtube', true ))):?><p><a aria-label="scopri di più su <?php echo get_post_meta( $post->ID, 'luogo_youtube', true );?> - link esterno - apertura nuova scheda" target="_blank" title="vai sulla pagina YouTube di <?php the_title();?>" href="<?php echo get_post_meta( $post->ID, 'luogo_youtube', true );?>">YouTube</a></p></div><?php endif;?>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <h4 class="h5">Con il supporto di:</h4>
              <div class="card card-teaser shadow mt-3 rounded">
                <svg class="icon" aria-hidden="true">
                  <use xlink:href="<?php echo get_template_directory_uri();?>/svg/sprites.svg#it-pa"></use>
                </svg>
                <div class="card-body">
                  <h3 class="card-title h5">
                    <a href="#" class="text-decoration-none">
                      Ufficio delle Attività Produttive
                    </a>
                  </h3>
                  <div class="card-text">
                    <p>Piazza Alcide De Gasperi, 2</p>
                    <p class="mt-3">T +39 070 6776430</p>
                    <p><a href="mailto:produttive@comune.cagliari.it" aria-label="invia un'email a produttive@comune.cagliari.it - apertura casella portale" title="invia un'email a produttive@comune.cagliari.it - apertura casella portale">produttive@comune.cagliari.it</a>
                    </p>
                  </div>
                </div>
              </div> -->
            </article>
    
            <?php if(strlen($metas['luogo_note'][0])):?>
            <article id="note" class="it-page-section mb-5">
            <h2 class="mb-3"><?php _e('Note','design-italia');?></h2>
              <div class="link-list-wrapper mb-3">
                <?php echo $metas['luogo_note'][0];?>
              </div>
            </article>
            <?php endif;?>

            <?php if(count($info)>0):?>
            <article id="info" class="it-page-section mb-5">
            <h2 class="mb-3"><?php _e('Informazioni varie','design-italia');?></h2>
            <div class="link-list-wrapper">
              <ul class="link-list">
                <?php echo implode("\n", $info);?>
                <!-- <li><a class="list-item px-0" href="#"><span>Sogaer - Aeroporto di Cagliari</span></a></li>
                <li><a class="list-item px-0" href="#"><span>Autorità Portuale di Cagliari</span></a></li>
                <li><a class="list-item px-0" href="#"><span>ARST</span></a></li>
                <li><a class="list-item px-0" href="#"><span>CTM Cagliari</span></a></li>
                <li><a class="list-item px-0" href="#"><span>Trenitalia</span></a></li>
                <li><a class="list-item px-0" href="#"><span>Camera di Commercio di Cagliari</span></a></li>-->
              </ul>
            </div>
            </article>
            <?php endif;?>

            <!-- <article id="patrocinio" class="it-page-section mb-5">
              <h2 class="mb-3">Patrocinato da</h2>
              <div class="link-list-wrapper mb-3">
                <ul class="link-list">
                  <li><a class="list-item px-0" href="#"><span>Regione Autonome della Sardegna</span></a></li>
                </ul>
              </div>
            </article> -->
    
            <!-- <article id="sponsor" class="it-page-section mb-5">
              <h2 class="mb-3">Sponsor</h2>
              <div class="link-list-wrapper">
                <ul class="link-list">
                  <li><a class="list-item px-0" href="#"><span>Provincia di Cagliari</span></a></li>
                  <li><a class="list-item px-0" href="#"><span>Sogaer - Aeroporto di Cagliari</span></a></li>
                  <li><a class="list-item px-0" href="#"><span>Autorità Portuale di Cagliari</span></a></li>
                  <li><a class="list-item px-0" href="#"><span>ARST</span></a></li>
                  <li><a class="list-item px-0" href="#"><span>CTM Cagliari</span></a></li>
                  <li><a class="list-item px-0" href="#"><span>Trenitalia</span></a></li>
                  <li><a class="list-item px-0" href="#"><span>Camera di Commercio di Cagliari</span></a></li>
                </ul>
              </div>
            </article> -->
    
            <article id="ultimo-aggiornamento" class="it-page-section mt-5">
            <?php get_template_part( "template-parts/single/bottom" ); ?>
            </article>
          </section>
        </div>
      </div>
    </main>
<?php
get_footer();