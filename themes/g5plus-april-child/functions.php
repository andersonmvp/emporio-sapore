<?php
add_action( 'wp_enqueue_scripts', 'g5plus_child_theme_enqueue_styles', 1000 );
function g5plus_child_theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'gsf_main' ) );
}

add_action( 'after_setup_theme', 'g5plus_child_theme_setup');
function g5plus_child_theme_setup(){
    $language_path = get_stylesheet_directory() .'/languages';
    if(is_dir($language_path)){
        load_child_theme_textdomain('g5plus-april', $language_path );
    }
}
// if you want to add some custom function


// Limitar estado
 
add_filter( 'woocommerce_states', 'limitar_estado_sp' );
 
function limitar_estado_sp( $states ) {
$states['BR'] = array(
'SP' => 'São Paulo',
);
return $states;
}

//Valor mínimo de compra

add_action( 'woocommerce_checkout_process', 'wc_minimum_order_amount' );
add_action( 'woocommerce_before_cart' , 'wc_minimum_order_amount' );

function wc_minimum_order_amount() {
    // Set this variable to specify a minimum order value
    $minimum = 80;

    if ( WC()->cart->total < $minimum ) {

        if( is_cart() ) {

            wc_print_notice(
                sprintf( 'Para concluir a compra, o pedido deve atingir o valor mínimo de %s. O valor atual do seu pedido é de %s.' ,
                    wc_price( $minimum ),
                    wc_price( WC()->cart->total )
                ), 'error'
            );

        } else {

            wc_add_notice(
                sprintf( 'Para concluir a compra, o pedido deve atingir o valor mínimo de %s. O valor atual do seu pedido é de %s.' ,
                    wc_price( $minimum ),
                    wc_price( WC()->cart->total )
                ), 'error'
            );

        }
    }

}

//ocultar erros
add_action('admin_head', 'ocultar_erros');

function ocultar_erros() {
  echo '<style>
    .notice {
      display:none;
    }
  </style>';
}


//EXIBIR TAGS NO CONTENT PRODUCT
function exibir_tags_content_product(){

    $product_tags = wp_get_post_terms( get_the_ID(), 'product_tag' );

    if ( $product_tags && ! is_wp_error ( $product_tags ) ){

        $single_tag = array_shift( $product_tags ); ?>

        <span itemprop="name" class="tags_content_product"><?php echo $single_tag->name; ?></span>

<?php }
}
add_action( 'woocommerce_shop_loop_item_title', 'exibir_tags_content_product', 40 );