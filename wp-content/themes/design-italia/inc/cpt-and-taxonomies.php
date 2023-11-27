<?php

function create_luogo_post_type() {
    $slug = 'luogocontemporaneo';
    $slug_plural = 'luoghicontemporanei';
    register_post_type( $slug,
        array(
            'labels' => array(
                'name' => __('Luoghi del contemporaneo'),
                'singular_name' => __('Luogo del contemporaneo'),
                'add_new' => __('Aggiungi'),
                'add_new_item' => __('Aggiungi un nuovo luogo'),
                'view_item' => __('Vedi luogo'),
                'edit_item' => __('Modifica luogo'),
                'search_items' => __('Cerca luoghi'),
                'not_found' => __('Luoghi non trovati'),
                'not_found_in_trash' => __('Luoghi non trovati nel cestino')
            ),
            'public' => true,
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 2,
            'menu_icon' => 'dashicons-location-alt',
            'rewrite' => array('slug' => __('esplora')),
            'supports' => array('title', 'editor', 'thumbnail', "custom-fields", "author"),
            'show_ui' => true,
            'map_meta_cap' => true,
            // 'capability_type' => $slug,
            // 'capabilities' => [
            //     'create_posts' => 'create_' . $slug_plural,
            //     'delete_others_posts' => 'delete_others_' . $slug_plural,
            //     'delete_posts' => 'delete_' . $slug_plural,
            //     'delete_private_posts' => 'delete_private_' . $slug_plural,
            //     'delete_published_posts' => 'delete_published_' . $slug_plural,
            //     'edit_posts' => 'edit_' . $slug_plural,
            //     'edit_others_posts' => 'edit_others_' . $slug_plural,
            //     'edit_private_posts' => 'edit_private_' . $slug_plural,
            //     'edit_published_posts' => 'edit_published_' . $slug_plural,
            //     'publish_posts' => 'publish_' . $slug_plural,
            //     'read_private_posts' => 'read_private_' . $slug_plural,
            //     'read_others_posts' => 'read_others_' . $slug_plural,
            //     'list_others_posts' => 'list_others_' . $slug_plural,
            //     'list_published_posts' => 'list_published_' . $slug_plural,
            //     'read' => 'read_' . $slug_plural,
            // ]
        )
    );
 
    register_taxonomy('tipologia', ['luogocontemporaneo'], [
        'label' => __('Tipologie', 'txtdomain'),
        'hierarchical' => false,
        'rewrite' => ['slug' => 'tipologie'],
        'show_admin_column' => true,
        'show_in_rest' => true,
		'meta_box_cb'       => 'tipologia_meta_box',
        'labels' => [
            'singular_name' => __('Tipologia', 'txtdomain'),
            'all_items' => __('Tutte le Tipologie', 'txtdomain'),
            'edit_item' => __('Modifica Tipologia', 'txtdomain'),
            'view_item' => __('Mostra Tipologia', 'txtdomain'),
            'update_item' => __('Aggiorna Tipologia', 'txtdomain'),
            'add_new_item' => __('Aggiungi Nuova Tipologia', 'txtdomain'),
            'new_item_name' => __('Nuovo Nome Tipologia', 'txtdomain'),
            'search_items' => __('Cerca Tipologie', 'txtdomain'),
            'popular_items' => __('Tipologie Popolari', 'txtdomain'),
            'separate_items_with_commas' => __('Separa le tipologie con la virgola', 'txtdomain'),
            'choose_from_most_used' => __('Scegli fra le tipologie più usate', 'txtdomain'),
            'not_found' => __('Nessuna tipologia trovata', 'txtdomain'),
        ]
    ]); 
 
    register_taxonomy('servizio', ['luogocontemporaneo'], [
        'label' => __('Servizi', 'txtdomain'),
        'hierarchical' => false,
        'rewrite' => ['slug' => 'servizi'],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'labels' => [
            'singular_name' => __('Servizio', 'txtdomain'),
            'all_items' => __('Tutti i Servizi', 'txtdomain'),
            'edit_item' => __('Modifica Servizio', 'txtdomain'),
            'view_item' => __('Mostra Servizio', 'txtdomain'),
            'update_item' => __('Aggiorna Servizio', 'txtdomain'),
            'add_new_item' => __('Aggiungi Nuovo Servizio', 'txtdomain'),
            'new_item_name' => __('Nuovo Nome Servizio', 'txtdomain'),
            'search_items' => __('Cerca Servizi', 'txtdomain'),
            'popular_items' => __('Servizi Popolari', 'txtdomain'),
            'separate_items_with_commas' => __('Separa i servizi con la virgola', 'txtdomain'),
            'choose_from_most_used' => __('Scegli fra i servizi più usati', 'txtdomain'),
            'not_found' => __('Nessun servizio trovato', 'txtdomain'),
        ]
    ]); 
}
add_action('init', 'create_luogo_post_type');






// A callback function to add a custom field to our "presenters" taxonomy
function create_tipologia_taxonomy($term) {
    // print_r($tag);
    // Check for existing taxonomy meta for the term you're editing
     $t_id = $tag->term_id; // Get the ID of the term you're editing
    //  $description = get_option( "taxonomy_term_$t_id" ); // Do the check
     $description = get_term_meta( $term->term_id, 'description', true );
     $color = get_term_meta( $term->term_id, 'color', true );
     $term_meta = array('description'=>$description,'color'=>$color);

     global $post;
     // Nonce field to validate form request came from current site
     wp_nonce_field( basename( __FILE__ ), 'layout' );

 ?>
 <style>
    .form-field.term-description-wrap {
        display: none;
    }
 </style>
 <tr class="form-field">
     <th scope="row" valign="top">
         <label for="color">Descrizione </label>
     </th>
     <td>
        <?php
            //We first get the post_meta from the DB if there's any there.
            // $description        = get_post_meta( $post->ID, 'description2', true );
            //Second ID the field.
            $description_field  = 'description2';
            //Provide the settings arguments for this specific editor in an array
            $description_args   = array( 'media_buttons' => false, 'textarea_rows' => 12, 'textarea_name' => 'term_meta[description]',
            'editor_class' => 'description-editor widefat', 'wpautop' => true );
            wp_editor( $term_meta['description'], $description_field, $description_args );
        ?>
     </td>
 </tr>
 
 <tr class="form-field">
     <th scope="row" valign="top">
         <label for="color">Colore </label>
     </th>
     <td>
         <input type="color" name="term_meta[color]" id="term_meta[color]" size="25" style="width:60%;" value="<?php echo $term_meta['color'] ? $term_meta['color'] : ''; ?>">
     </td>
 </tr>

 <?php
 } 
// A callback function to save our extra taxonomy field(s)
function save_tipologia_custom_fields( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $description = get_term_meta( $term->term_id, 'description', true );
        $color = get_term_meta( $term->term_id, 'color', true );
        $term_meta = array('description'=>$description,'color'=>$color);
        // print_r($_POST);
        // print_r($term_meta);die();
        $cat_keys = array_keys( $_POST['term_meta'] );
            foreach ( $cat_keys as $key ){
            if ( isset( $_POST['term_meta'][$key] ) ){
                $term_meta[$key] = $_POST['term_meta'][$key];
                update_term_meta(
                    $term_id,
                    $key,
                    sanitize_text_field( $_POST['term_meta'][$key] )
                );
            }
        }
        //save the option array
        // update_option( "taxonomy_term_$t_id", $term_meta );
    }
}

 // Add the fields to the "presenters" taxonomy, using our callback function
add_action( 'tipologia_add_form_fields', 'create_tipologia_taxonomy' );
add_action( 'tipologia_edit_form_fields', 'create_tipologia_taxonomy');

// Save the changes made on the "presenters" taxonomy, using our callback function 
add_action( 'created_tipologia', 'save_tipologia_custom_fields' );
add_action( 'edited_tipologia', 'save_tipologia_custom_fields' );









/**
 * Display meta box contents.
 *
 * @param object $post Post
 */
function luoghi_form_meta_web_box($post) {
    echo "
    <div class=\"hcf_box\">
    <style scoped>
        .hcf_box{
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }
        .hcf_field{
            display: contents;
        }
    </style>
    
    
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_web\">Web</label>
        <input id=\"luogo_web\" type=\"url\" name=\"luogo_web\" value=\"".get_post_meta($post->ID, 'luogo_web', true)."\">
    </p>  
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_facebook\">Facebook</label>
        <input id=\"luogo_facebook\" type=\"url\" name=\"luogo_facebook\" value=\"".get_post_meta($post->ID, 'luogo_facebook', true)."\">
    </p>  
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_twitter\">Twitter</label>
        <input id=\"luogo_twitter\" type=\"url\" name=\"luogo_twitter\" value=\"".get_post_meta($post->ID, 'luogo_twitter', true)."\">
    </p>  
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_instagram\">Instagram</label>
        <input id=\"luogo_instagram\" type=\"url\" name=\"luogo_instagram\" value=\"".get_post_meta($post->ID, 'luogo_instagram', true)."\">
    </p>  
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_youtube\">YouTube</label>
        <input id=\"luogo_youtube\" type=\"url\" name=\"luogo_youtube\" value=\"".get_post_meta($post->ID, 'luogo_youtube', true)."\">
    </p>  
</div>
";
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function luoghi_save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = [
        'luogo_indirizzo',
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
        // 'luogo_tipologia_id',
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
        'luogo_collocazione',
        'luogo_dimensioni',
        'luogo_promotore',
        'luogo_curatore', 
        'luogo_proprietario',
        'luogo_gestore',
        // 'luogo_tipologia',
        'luogo_opere', 
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_GET ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_GET[$field] ) );
        }
     }
}
add_action( 'add_meta_boxes', 'add_luoghi_form_meta_box' ); 
add_action( 'save_post', 'luoghi_save_meta_box' );



/**
 * Display meta box.
 *
 * @param int $post_id Post ID
 */
function add_luoghi_form_meta_box() {
    // add_meta_box('contact-form-meta-box-id', 'Submission Data', 'contact_form_meta_box', 'contact_form', 'normal', 'high');
    add_meta_box( 'luogo_box_indirizzo_id',   'Indirizzo',           'luoghi_form_meta_indirizzo_box',   'luogocontemporaneo',           'normal', 'high', null );
    add_meta_box( 'luogo_box_contatti_id',    'Contatti',            'luoghi_form_meta_contatti_box',    'luogocontemporaneo',           'normal', 'high', null );
    add_meta_box( 'luogo_box_web_id',         'Web',                 'luoghi_form_meta_web_box',         'luogocontemporaneo',           'normal', 'high', null );
    add_meta_box( 'luogo_box_altro_id',       'Altro',               'luoghi_form_meta_altro_box',       'luogocontemporaneo',           'normal', 'high', null );
}

/**
 * Display meta box contents.
 *
 * @param object $post Post
 */
function luoghi_form_meta_altro_box($post) {
    global $wpdb;
    $query = "SELECT * 
    FROM {$wpdb->prefix}luoghi_tipologie AS t ORDER BY t.tipologia_nome_ita";
    $tipologie = $wpdb->get_results( $query, OBJECT ); 
    echo "
    <div class=\"hcf_box\">
    <style scoped>
        .hcf_box{
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }
        .hcf_field{
            display: contents;
        }
    </style>
    
    <!--<p class=\"meta-options hcf_field\">
        <label for=\"luogo_tipologia_id\" class=\"required\">Tipologia * </label>
        <select id=\"luogo_tipologia_id\" name=\"luogo_tipologia_id\" required>
        <option value=\"\">-- Seleziona un valore --</option>";
        
        // $loc = get_post_meta($post->ID, 'luogo_tipologia_id', true);
        // foreach($tipologie as $r=>$c) { 
            // echo "<option value=\"{$c->tipologia_id}\"".($c->tipologia_id == $loc ? ' selected':'').">{$c->tipologia_nome_ita}</option>";
        // }
        echo "</select>    </p> -->
    
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_data_inserimento\">Data Inserimento</label>
        <input id=\"luogo_data_inserimento\" type=\"date\" name=\"luogo_data_inserimento\" value=\"".get_post_meta($post->ID, 'luogo_youtube', true)."\">
    </p>  
    
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_note\">Note</label>
        <textarea id=\"luogo_note\" name=\"luogo_note\">".get_post_meta($post->ID, 'luogo_note', true)."</textarea>
    </p>  
    
    
    <!--<p class=\"meta-options hcf_field\">
        <label for=\"luogo_url\">URL</label>
        <input id=\"luogo_url\" type=\"url\" name=\"luogo_url\" value=\"".get_post_meta($post->ID, 'luogo_url', true)."\">
    </p>-->  
    
    
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_collezione\">Collezione</label>
        <input id=\"luogo_collezione\" type=\"text\" name=\"luogo_collezione\" value=\"".get_post_meta($post->ID, 'luogo_collezione', true)."\">
    </p>  
    
    
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_autore\">Autore</label>
        <input id=\"luogo_autore\" type=\"text\" name=\"luogo_autore\" value=\"".get_post_meta($post->ID, 'luogo_autore', true)."\">
    </p>  
    
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_realizzazione\">Realizzazione</label>
        <input id=\"luogo_realizzazione\" type=\"number\" name=\"luogo_realizzazione\" value=\"".get_post_meta($post->ID, 'luogo_realizzazione', true)."\">
    </p>  
    
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_collocazione\">Collocazione</label>
        <input id=\"luogo_collocazione\" type=\"number\" name=\"luogo_collocazione\" value=\"".get_post_meta($post->ID, 'luogo_collocazione', true)."\">
    </p>  
    
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_dimensioni\">Dimensioni</label>
        <input id=\"luogo_dimensioni\" type=\"text\" name=\"luogo_dimensioni\" value=\"".get_post_meta($post->ID, 'luogo_dimensioni', true)."\">
    </p>  
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_promotore\">Promotore</label>
        <input id=\"luogo_promotore\" type=\"text\" name=\"luogo_curatore\" value=\"".get_post_meta($post->ID, 'luogo_promotore', true)."\">
    </p>  
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_curatore\">Curatore</label>
        <input id=\"luogo_curatore\" type=\"text\" name=\"luogo_curatore\" value=\"".get_post_meta($post->ID, 'luogo_curatore', true)."\">
    </p>   
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_proprietario\">Proprietario</label>
        <input id=\"luogo_proprietario\" type=\"text\" name=\"luogo_proprietario\" value=\"".get_post_meta($post->ID, 'luogo_proprietario', true)."\">
    </p>  
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_gestore\">Gestore</label>
        <input id=\"luogo_gestore\" type=\"text\" name=\"luogo_gestore\" value=\"".get_post_meta($post->ID, 'luogo_gestore', true)."\">
    </p>  
    <!-- <p class=\"meta-options hcf_field\">
        <label for=\"luogo_tipologia\">Tipologia</label>
        <input id=\"luogo_tipologia\" type=\"text\" name=\"luogo_tipologia\" value=\"".get_post_meta($post->ID, 'luogo_tipologia', true)."\">
    </p> --> 
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_opere\">Opere</label>
        <input id=\"luogo_opere\" type=\"text\" name=\"luogo_opere\" value=\"".get_post_meta($post->ID, 'luogo_opere', true)."\">
    </p>
</div>
";
}
/**
 * Display meta box contents.
 *
 * @param object $post Post
 */
function luoghi_form_meta_indirizzo_box($post) {
    global $wpdb;
    $query = "SELECT * 
    FROM {$wpdb->prefix}luoghi_localita AS c 
    INNER JOIN {$wpdb->prefix}luoghi_province AS p ON c.localita_provincia_id = p.provincia_id
    INNER JOIN {$wpdb->prefix}luoghi_regioni AS r ON p.provincia_regione_id = r.regione_id 
    ";
    $regioni2 = $wpdb->get_results( $query, OBJECT ); 
    echo "
    <div class=\"hcf_box\">
    <style scoped>
        .hcf_box{
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }
        .hcf_field{
            display: contents;
        }
    </style>
    
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_indirizzo\">Indirizzo</label>
        <input id=\"luogo_indirizzo\" type=\"text\" name=\"luogo_indirizzo\" value=\"".get_post_meta($post->ID, 'luogo_indirizzo', true)."\">
    </p>
 
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_localita_id\">Località *</label>
        <select id=\"luogo_localita_id\" name=\"luogo_localita_id\" required>
        <option value=\"\">-- Seleziona un valore --</option>";
        
        $loc = get_post_meta($post->ID, 'luogo_localita_id', true);
        foreach($regioni2 as $r=>$c) { 
            echo "<option value=\"{$c->localita_id}\"".($c->localita_id == $loc ? ' selected':'').">{$c->localita_nome}</option>";
        }
        echo "</select>
    </p> 

    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_cap\">CAP</label>
        <input id=\"luogo_cap\" type=\"number\" name=\"luogo_cap\" length=\"5\" value=\"".get_post_meta($post->ID, 'luogo_cap', true)."\">
    </p> 
 
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_lat\">Latitudine</label>
        <input id=\"luogo_lat\" type=\"number\" name=\"luogo_lat\" value=\"".get_post_meta($post->ID, 'luogo_lat', true)."\">
    </p>  
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_lon\">Longitudine</label>
        <input id=\"luogo_lon\" type=\"number\" name=\"luogo_lon\" value=\"".get_post_meta($post->ID, 'luogo_lon', true)."\">
    </p> 
</div>
";
}
/**
 * Display meta box contents.
 *
 * @param object $post Post
 */
function luoghi_form_meta_contatti_box($post) {
    echo "
    <div class=\"hcf_box\">
    <style scoped>
        .hcf_box{
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }
        .hcf_field{
            display: contents;
        }
    </style> 

    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_telefono\">Telefono</label>
        <input id=\"luogo_telefono\" type=\"phone\" name=\"luogo_telefono\" value=\"".get_post_meta($post->ID, 'luogo_telefono', true)."\">
    </p>  
    <p class=\"meta-options hcf_field\">
        <label for=\"luogo_email\">Email</label>
        <input id=\"luogo_email\" type=\"email\" name=\"luogo_email\" value=\"".get_post_meta($post->ID, 'luogo_email', true)."\">
    </p>  
</div>
";
}





  /**
 * Display an error message at the top of the post edit screen explaining that ratings is required.
 *
 * Doing this prevents users from getting confused when their new posts aren't published, as we
 * require a valid rating custom taxonomy.
 *
 * @param WP_Post The current post object.
 */
function show_required_field_error_msg( $post ) {
	if ( 'movie' === get_post_type( $post ) && 'auto-draft' !== get_post_status( $post ) ) {
	    $rating = wp_get_object_terms( $post->ID, 'tipologia', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
        if ( is_wp_error( $rating ) || empty( $rating ) ) {
			printf(
				'<div class="error below-h2"><p>%s</p></div>',
				esc_html__( 'Rating is mandatory for creating a new movie post' )
			);
		}
	}
}

// Unfortunately, 'admin_notices' puts this too high on the edit screen
add_action( 'edit_form_top', 'show_required_field_error_msg' );
/**
 * Display Movie Rating meta box
 */
function tipologia_meta_box( $post ) {
	$terms = get_terms( 'tipologia', array( 'hide_empty' => false ) );

	$post  = get_post();
	$rating = wp_get_object_terms( $post->ID, 'tipologia', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
	$name  = '';

    if ( ! is_wp_error( $rating ) ) {
    	if ( isset( $rating[0] ) && isset( $rating[0]->name ) ) {
			$name = $rating[0]->name;
	    }
    }

	foreach ( $terms as $term ) {
?>
		<label title='<?php esc_attr_e( $term->name ); ?>'>
		    <input type="radio" name="tipologia" value="<?php esc_attr_e( $term->name ); ?>" <?php checked( $term->name, $name ); ?>>
			<span><?php esc_html_e( $term->name ); ?></span>
		</label><br>
<?php
    }
}
/**
 * Register 'Movie Rating' custom taxonomy.
 */
// function register_tipologia_taxonomy() {
    
// 	$args = array(
// 		'label'             => __( 'Rating' ),
// 		'hierarchical'      => false,
// 		'show_ui'           => true,
// 		'show_admin_column' => true,
// 		'meta_box_cb'       => 'tipologia_meta_box',
// 	);

// 	register_taxonomy( 'tipologia', 'movie', $args );
// }
// add_action( 'init', 'register_tipologia_taxonomy' );
  /**
 * Save the movie meta box results.
 *
 * @param int $post_id The ID of the post that's being saved.
 */
function save_tipologia_meta_box( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['tipologia'] ) ) {
		return;
	}

	$rating = sanitize_text_field( $_POST['tipologia'] );
	
	// A valid rating is required, so don't let this get published without one
	if ( empty( $rating ) ) {
		// unhook this function so it doesn't loop infinitely
		remove_action( 'save_post_movie', 'save_tipologia_meta_box' );

		$postdata = array(
			'ID'          => $post_id,
			'post_status' => 'draft',
		);
		wp_update_post( $postdata );
	} else {
		$term = get_term_by( 'name', $rating, 'tipologia' );
		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			wp_set_object_terms( $post_id, $term->term_id, 'tipologia', false );
		}
	}
}
add_action( 'save_post_movie', 'save_tipologia_meta_box' );



