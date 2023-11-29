<?php
global $post;

$prefix = '_dci_luogo_';
$img = dci_get_meta('immagine', $prefix, $post->ID);
$descrizione = dci_get_meta('descrizione_breve', $prefix, $post->ID);
$tipi_luogo = get_the_terms($post->ID,'tipi_luogo');
?>

<div class="col-lg-6 col-xl-4">
    <div class="card-wrapper shadow-sm rounded border border-light">
        <div class="card no-after rounded">
            <div class="img-responsive-wrapper">
                <div class="img-responsive img-responsive-panoramic">
                    <figure class="img-wrapper">
                        <?php dci_get_img($img, 'rounded-top img-fluid'); ?>
                    </figure>
                </div>
            </div>
            <div class="card-body">
                <div class="category-top">
                    <?php 
                        $count = 1;
                        if ( is_array($tipi_luogo) && count($tipi_luogo) ) {
                        foreach ($tipi_luogo as $tipo_luogo) {
                    ?>
                        <?php echo $count == 1 ? '' : ' - '; ?>
                        <a class="category text-decoration-none"
                            href="<?php echo get_term_link($tipo_luogo->term_id); ?>"
                        >
                            <?php echo $tipo_luogo->name;?>
                        </a>
                    <?php ++$count; }} ?>
                </div>
                <h3 class="card-title">
                    <a class="text-decoration-none"
                        href="<?php echo get_permalink($post->ID); ?>"
                        data-element="live-category-link"
                    >
                        <?php echo $post->post_title ?>
                    </a>
                </h3>
                <p class="card-text text-secondary pb-3">
                    <?php echo $descrizione; ?>
                </p>
                <a class="read-more t-primary text-uppercase"
                    href="<?php echo get_permalink($post->ID); ?>"
                    aria-label="Leggi di più sulla pagina di <?php echo $post->post_title ?>"
                >
                    <span class="text">Leggi di più</span>
                    <span class="visually-hidden"></span>
                    <svg class="icon icon-primary icon-xs ml-10">
                        <use href="#it-arrow-right"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>