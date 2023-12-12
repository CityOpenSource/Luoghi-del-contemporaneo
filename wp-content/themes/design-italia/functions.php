<?php


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);




function fb_opengraph() {
    global $post;
 
    if(is_single()) {
        if(has_post_thumbnail($post->ID)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'medium');
        } else {
            $img_src = get_stylesheet_directory_uri() . '/img/opengraph_image.jpg';
        }
        if($excerpt = $post->post_excerpt) {
            $excerpt = strip_tags($post->post_excerpt);
            $excerpt = str_replace("", "'", $excerpt);
        } else {
            $excerpt = get_bloginfo('description');
        }
        ?>
 
    <meta property="og:title" content="<?php echo the_title(); ?>"/>
    <meta property="og:description" content="<?php echo $excerpt; ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="<?php echo the_permalink(); ?>"/>
    <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
    <meta property="og:image" content="<?php echo $img_src; ?>"/>
 
<?php
    } else {
        return;
    }
}
add_action('wp_head', 'fb_opengraph', 5);


include __DIR__.'/inc/api.php';
include __DIR__.'/inc/cpt-and-taxonomies.php';
include __DIR__.'/inc/form.php';
include __DIR__.'/inc/gallery.php';
include __DIR__.'/inc/menus-and-walkers.php';
include __DIR__.'/inc/styles-and-scripts.php';
include __DIR__.'/inc/theme-options.php';
include __DIR__.'/inc/treemap.php';


function theme_init(){
    load_theme_textdomain('design-italia', get_template_directory() . '/languages');
}
add_action ('init', 'theme_init');


function theme_xyz_header_metadata() {
    
    // Post object if needed
    global $post;
    
    // Page conditional if needed 
    if(is_post_type_archive('luogocontemporaneo')) :
        ?>
    <meta property="og:title" content="Esplora" />
    <meta property="og:description" content="Luoghi del contemporaneo" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo home_url( '/esplora/' );?>" /> 
        <?php 
    elseif( 'luogocontemporaneo' == get_post_type() ):

    
    $gallery = get_post_meta( $post->ID, 'gallery_data', true );
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
    if(empty($image)) $image = $gallery['image_url'][0];
    
  ?>
    
    <meta property="og:title" content="<?php echo esc_html(get_the_title( $post ));?>" />
    <meta property="og:description" content="<?php echo esc_html(get_the_excerpt( $post ));?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php the_permalink( $post );?>" />
    <meta property="og:image" content="<?php echo $image;?>" />
    
  <?php
  elseif(is_single( )):
    
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
    
  ?>
    
    <meta property="og:title" content="<?php echo esc_html(get_the_title( $post ));?>" />
    <meta property="og:description" content="<?php echo esc_html(get_the_excerpt( $post ));?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php the_permalink( $post );?>" />
    <?php if(empty($image)):?><meta property="og:image" content="<?php echo $image;?>" /><?php endif;?>
 

<?php endif;
}
add_action( 'wp_head', 'theme_xyz_header_metadata' );

function twentytwelve_setup() {
    add_theme_support('post-thumbnails');
}
add_action( 'after_setup_theme', 'twentytwelve_setup' );


function custom_type_archive_display($query) {
    if (is_post_type_archive('luogocontemporaneo') && $query->is_main_query()) {
         $query->set('posts_per_page', 12);
         $query->set('orderby', 'date' );
         $query->set('order', 'DESC' );
    }     
}
add_action('pre_get_posts', 'custom_type_archive_display');

function justread_filter_archive( $query ) {
    if ( is_admin() ) {
            return;
    }
    if ( is_post_type_archive('luogocontemporaneo') && is_archive() && $query->is_main_query() ) {
        // get meta query
        $meta_query = $query->get('meta_query');
        if(!is_array($meta_query)) $meta_query = ['relation' => 'AND'];

        // loop over filters
        foreach( ['luogo_indirizzo',
        'luogo_localita_id',
        'luogo_cap',
        'luogo_telefono',
        'luogo_email',
        'luogo_web',
        'luogo_facebook',
        'luogo_twitter',
        'luogo_instagram',
        'luogo_youtube',
        'luogo_lat',
        'luogo_lon', 
        'luogo_data_inserimento',
        'luogo_note',
        // 'luogo_url',
        'luogo_localita_id',
        'luogo_collezione',
        
        'luogo_autore',
        'luogo_realizzazione',
        'luogo_collocazione',
        'luogo_dimensioni',
        'luogo_promotore',
        'luogo_curatore', 
        // 'luogo_collocazione',
        'luogo_dimensioni',
        'luogo_promotore',
        'luogo_curatore', 
        'luogo_proprietario',
        'luogo_gestore',
        'luogo_tipologia',
        'luogo_opere', ] as $name ) {

            // continue if not found in url
            if( empty($_GET[ $name ]) ) {
                continue;
            }
            $value = sanitize_text_field($_GET[ $name ]);

            // append meta query
            $meta_query[] = array(
                'key'       => $name,
                'value'     => $value,
                'compare'   => 'LIKE',
            );

        } 
        if( !empty($_GET[ 'luogo_da' ]) ) {
            $value = sanitize_text_field($_GET[ 'luogo_da' ]);
            $meta_query[] = array(
                'key'       => 'luogo_da',
                'value'     => $value,
                'compare'   => '>=',
            );
        }
        if( !empty($_GET[ 'luogo_a' ]) ) {
            $value = sanitize_text_field($_GET[ 'luogo_a' ]);
            $meta_query[] = array(
                'key'       => 'luogo_a',
                'value'     => $value,
                'compare'   => '<=',
            );
        }
        // if( !empty($_GET[ 'tipologia_id' ]) ) {
        //     $value = sanitize_text_field($_GET[ 'tipologia_id' ]);
        //     $meta_query[] = array(
        //         'key'       => 'luogo_tipologia_id',
        //         'value'     => $value,
        //         'compare'   => '=',
        //     );
        // }

        if( !empty($_GET[ 'comune_id' ]) ) {
            $value = sanitize_text_field($_GET[ 'comune_id' ]);
            $meta_query[] = array(
                'key'       => 'luogo_localita_id',
                'value'     => $value,
                'compare'   => '=',
            );
        }

        
        global $wpdb;
        if( empty($_GET[ 'comune_id' ])  && !empty($_GET[ 'provincia_id' ]) ) {
            $value = sanitize_text_field($_GET[ 'provincia_id' ]);
            $mypostids = $wpdb->get_col("SELECT localita_id FROM {$wpdb->prefix}luoghi_localita WHERE localita_provincia_id = '{$value}'"); 
            $meta_query[] = array(
                'key'       => 'luogo_localita_id',
                'value'     => $mypostids,
                'compare'   => 'IN',
            );
        } 

        if( empty($_GET[ 'comune_id' ])  && empty($_GET[ 'provincia_id' ]) && !empty($_GET[ 'regione_id' ]) ) {
            $value = sanitize_text_field($_GET[ 'regione_id' ]);
            $mypostids = $wpdb->get_col("SELECT localita_id FROM {$wpdb->prefix}luoghi_localita AS c INNER JOIN {$wpdb->prefix}luoghi_province AS p ON c.localita_provincia_id = p.provincia_id WHERE provincia_regione_id = '{$value}'"); 
            $meta_query[] = array(
                'key'       => 'luogo_localita_id',
                'value'     => $mypostids,
                'compare'   => 'IN',
            );
        } 

        // update meta query
        $query->set('meta_query', $meta_query);


        if( !empty($_GET[ 'luogo_nome' ]) ) {
            $post__in = $query->get('post_in');
            $value = sanitize_text_field($_GET[ 'luogo_nome' ]);
            $mypostids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_title LIKE '%".$value."%' AND post_type='luogocontemporaneo'"); 

            if(is_array($post__in)) {
                $mynew = array_intersect((count($mypostids) ? $mypostids : [-1]),$post__in);
                $query->set('post__in', $mynew);
            } else {
                $query->set('post__in', count($mypostids) ? $mypostids : [-1]);
            }
        }
        if( !empty($_GET[ 'tipologia_id' ]) ) {
            $query->set('tax_query', array( // NOTE: array of arrays!
                array(
                    'taxonomy' => 'tipologia',
                    'field'    => 'term_id',
                    'terms'    => array($_GET['tipologia_id']),
                    'operator'    => 'IN'
                ),
            ));
            if(is_array($tax_query)) {
                $tax_query[]=$tax; 
                $tax_query['relation'] = 'AND';
                $query->set('tax_query', $tax_query);
            } else {
                $query->set('tax_query', array($tax, 'relation' => 'AND'));
            } 
        }
        if( !empty($_GET[ 'category' ]) ) {
            $query->set('tax_query', array( // NOTE: array of arrays!
                array(
                    'taxonomy' => 'tipologia',
                    'field'    => 'slug',
                    'terms'    => array($_GET['category']),
                    // 'operator'    => 'IN'
                ),
            ));
            if(is_array($tax_query)) {
                $tax_query[]=$tax; 
                $tax_query['relation'] = 'AND';
                $query->set('tax_query', $tax_query);
            } else {
                $query->set('tax_query', array($tax, 'relation' => 'AND'));
            } 
        }
        if( !empty($_GET[ 'servizio_id' ]) ) { 

            $tax_query = $query->get('tax_query');
            $tax = array(
                    'taxonomy' => 'servizio',
                    'field'    => 'term_id',
                    'terms'    => $_GET['servizio_id'],
                    'operator'    => 'AND'
            );
            if(is_array($tax_query)) {
                $tax_query[]=$tax; 
                $tax_query['relation'] = 'AND';
                $query->set('tax_query', $tax_query);
            } else {
                $query->set('tax_query', array($tax, 'relation' => 'AND'));
            } 
        } 

        switch($_GET['orderby']) {
            case 'localita': 
                $query->set('meta_key','luogo_localita_id');
                $query->set('orderby','luogo_localita_id');
            break;
            case 'autore': 
                $query->set('meta_key','luogo_autore');
                $query->set('orderby','luogo_autore');
            break;
            case 'data':  
                $query->set('meta_key','luogo_collocazione');
                $query->set('orderby','luogo_collocazione');
            break;
            default:
                $query->set('orderby','title');
            break;
        }

        switch($_GET['orderdir']) {
            case 'desc':
                $query->set('order','desc');
                break;
            default:
                $query->set('order','asc');
            break;
        } 
 
    } 
}
add_action( 'pre_get_posts', 'justread_filter_archive');

// function orderby_tax_clauses( $clauses, $wp_query ) {
//     global $wpdb;
//     $taxonomies = get_taxonomies();
//     foreach ($taxonomies as $taxonomy) {
//         if ( isset( $wp_query->query['orderby'] ) && $taxonomy == $wp_query->query['orderby'] ) {
//             $clauses['join'] .=<<<SQL
// LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
// LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
// LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
// SQL;
//             $clauses['where'] .= " AND (taxonomy = '{$taxonomy}' OR taxonomy IS NULL)";
//             $clauses['groupby'] = "object_id";
//             $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
//             $clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
//         }
//     }
//     return $clauses;
// }

// add_filter('posts_clauses', 'orderby_tax_clauses', 10, 2 );
