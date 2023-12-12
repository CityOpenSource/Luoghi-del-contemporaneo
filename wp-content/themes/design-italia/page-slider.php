<?php

global $wpdb;

$query = "SELECT * 
FROM {$wpdb->prefix}luoghi_localita AS c 
INNER JOIN {$wpdb->prefix}luoghi_province AS p ON c.localita_provincia_id = p.provincia_id
INNER JOIN {$wpdb->prefix}luoghi_regioni AS r ON p.provincia_regione_id = r.regione_id 
";
$regioni2 = $wpdb->get_results( $query, OBJECT );
 

$slides = [];
$args = array('post_type' => 'luogocontemporaneo','posts_per_page' => -1); 

// Leggo tutti i post di tipo luogo contemporaneo
$loop = get_posts($args);

// Li mescolo per aggiungere una componenente random al carousel
shuffle($loop);  

// Eseguo il loop per la creazione delle singole slide
foreach($loop as $k=>$row):

    $custom_fields = get_post_meta( $row->ID );
    $images        = unserialize($custom_fields['gallery_data'][0]);
    $loc           = $custom_fields['luogo_localita_id'][0];  
    foreach($regioni2 as $v) {
        if($v->localita_id == $loc) {
            $localita = $v;
            break;
        } 
    } 
    $slides[] = '<div class="carousel-item'.($k==0?' active':'').'"><img class="object-fit-cover object-fit-lg-contain" src="'.$images['image_url'][0].'" style="object-fit:contain;width:100vw;height:100vh;" alt="'.$images['image_alt'][0].'" /><div class="gradientBottom"></div><div class="carousel-caption d-none d-md-block"><h5>'.$row->post_title.'</h5><p>'.$localita->localita_nome.' ('.$localita->provincia_sigla.')</p></div></div>';
endforeach;
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php wp_head(); ?>
        <style>
            #gradientTop {
                position:absolute;top:0;height:180px;width:100%;background: rgb(0,0,0);background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.6) 20%, rgba(0,0,0,0) 100%);
            }
            .gradientBottom {
                position:absolute;bottom:0;height:180px;width:100%;background: rgb(0,0,0);background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.6) 20%, rgba(0,0,0,0) 100%);
            }
            button {
                height: 100vh;
            }
        </style>
    </head>
    <body>
        <div class="modal-body">
            <div id="carouselHome" class="carousel slide">
                <div class="carousel-inner p-relative">
                    <?php echo implode("\n",$slides);?>
                    <div id="gradientTop"></div>
                    <div class="carousel-caption d-none d-md-block" style="top:1.25rem" ><svg height="86" width="260" aria-hidden="true" style="height:86px!important;width:260px!important;z-index:11;"><image height="86" width="260" xlink:href="<?php echo get_template_directory_uri();?>/svg/logo.svg"></image></svg></div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <?php wp_footer(); ?>
        <script>
            // jQuery(document).ready(function() {
            //     const myCarouselElement = jQuery('#carouselHome')
            //     const carousel = new bootstrap.Carousel(myCarouselElement, {
            //         interval: 2000,
            //         touch: false,
            //         ride: 'carousel',
            //     })
            //     console.log(carousel);
            // });
        </script>
    </body>
</html>