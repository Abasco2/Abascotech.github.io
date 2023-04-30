<?php 

/* Template name: Portfolio */


get_header(); 

echo basel_shortcode_portfolio( array() );

do_action( 'basel_after_portfolio_loop' );

get_footer(); ?>