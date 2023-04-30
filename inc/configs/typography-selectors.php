<?php if ( ! defined('BASEL_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Elements selectors for advanced typography options
 * ------------------------------------------------------------------------------------------------
 */

return apply_filters( 'basel_typography_selectors', array(
    'main_nav' => array(
        'title' => 'Main navigation',
    ),
    'main_navigation' => array(
        'title' => 'Main navigation links',
        'selector' => 'html .website-wrapper .basel-navigation.main-nav .menu > .menu-item > a',
        'selector-hover' => 'html .website-wrapper .basel-navigation.main-nav .menu > .menu-item:hover > a, html .website-wrapper .basel-navigation.main-nav .menu > .menu-item.current-menu-item > a'
    ),
    'mega_menu_drop_first_level' => array(
        'title' => 'Menu dropdowns first level',
        'selector' => 'html .website-wrapper .basel-navigation .menu-item-design-full-width .sub-menu-dropdown .sub-menu > li > a, html .website-wrapper .basel-navigation .menu-item-design-sized .sub-menu-dropdown .sub-menu > li > a',
        'selector-hover' => 'html .website-wrapper .basel-navigation .menu-item-design-full-width .sub-menu-dropdown .sub-menu > li > a:hover, html .website-wrapper .basel-navigation .menu-item-design-sized .sub-menu-dropdown .sub-menu > li > a:hover'
    ),
    'mega_menu_drop_second_level' => array(
        'title' => 'Menu dropdowns second level',
        'selector' => 'html .website-wrapper .basel-navigation .menu-item-design-full-width .sub-menu-dropdown .sub-sub-menu li a, html .website-wrapper .basel-navigation .menu-item-design-sized .sub-menu-dropdown .sub-sub-menu li a',
        'selector-hover' => 'html .website-wrapper .basel-navigation .menu-item-design-full-width .sub-menu-dropdown .sub-sub-menu li a:hover, html .website-wrapper .basel-navigation .menu-item-design-sized .sub-menu-dropdown .sub-sub-menu li a:hover'
    ),
    'simple_dropdown' => array(
        'title' => 'Menu links on simple dropdowns',
        'selector' => 'html .website-wrapper .basel-navigation .menu-item-design-default .sub-menu-dropdown li a',
        'selector-hover' => 'html .website-wrapper .basel-navigation .menu-item-design-default .sub-menu-dropdown li a:hover'
    ),
    'secondary_nav' => array(
        'title' => 'Other navigations',
    ),
    'browse_categories' => array(
        'title' => '"Browse categories" title',
        'selector' => 'html .header-categories .mega-navigation .menu-opener',
        'selector-hover' => 'html .header-categories .mega-navigation .menu-opener:hover'
    ),
    'category_navigation' => array(
        'title' => 'Categories navigation links',
        'selector' => 'html .basel-navigation.categories-menu-dropdown .menu > .menu-item > a',
        'selector-hover' => 'html .basel-navigation.categories-menu-dropdown .menu > .menu-item:hover > a'
    ),
    'mobile_nav' => array(
        'title' => 'Mobile menu',
    ),
    'mobile_menu_first_level' => array(
        'title' => 'Mobile menu first level',
        'selector' => 'html .mobile-nav .site-mobile-menu > li > a, html .mobile-nav .header-links > ul > li > a',
        'selector-hover' => 'html .mobile-nav .site-mobile-menu > li > a:hover, html .mobile-nav .site-mobile-menu > li.current-menu-item > a, html .mobile-nav .header-links > ul > li > a:hover'
    ),
    'mobile_menu_second_level' => array(
        'title' => 'Mobile menu second level',
        'selector' => 'html .mobile-nav .site-mobile-menu .sub-menu li a',
        'selector-hover' => 'html .mobile-nav .site-mobile-menu .sub-menu li a:hover, html .mobile-nav .site-mobile-menu .sub-menu li.current-menu-item > a'
    ),
    'page_header' => array(
        'title' => 'Page heading',
    ),
    'page_title' => array(
        'title' => 'Page title',
        'selector' => 'html .page-title > .container .entry-title'
    ),
    'page_title_bredcrumps' => array(
        'title' => 'Breadcrumbs links',
        'selector' => 'html .website-wrapper .page-title .breadcrumbs a, html .website-wrapper .page-title .breadcrumbs span, html .website-wrapper .page-title .yoast-breadcrumb a, html .website-wrapper .page-title .yoast-breadcrumb span',
        'selector-hover' => 'html .website-wrapper .page-title .breadcrumbs a:hover, html .website-wrapper .page-title .yoast-breadcrumb a:hover'
    ),
    'products_categories' => array(
        'title' => 'Products and categories',
    ),
    'product_title' => array(
        'title' => 'Product grid title',
        'selector' => 'html .product.product-grid-item .product-title a',
        'selector-hover' => 'html .product.product-grid-item .product-title a:hover'
    ),
    'product_price' => array(
        'title' => 'Product grid price',
        'selector' => 'html .product-grid-item .price > .amount, html .product-grid-item .price ins > .amount'
    ),
    'product_old_price' => array(
        'title' => 'Product old price',
        'selector' => 'html .product.product-grid-item del, html .product.product-grid-item del .amount, html .product-image-summary .summary-inner > .price del, html .product-image-summary .summary-inner > .price del .amount'
    ),
    'product_category_title' => array(
        'title' => 'Category title',
        'selector' => 'html .product.category-grid-item .hover-mask h3'
    ),
    'product_category_count' => array(
        'title' => 'Category products count',
        'selector' => 'html .product.category-grid-item .products-cat-number'
    ),
    'single_product' => array(
        'title' => 'Single product',
    ),
    'product_title_single_page' => array(
        'title' => 'Single product title',
        'selector' => 'html .single-product-page .entry-summary .entry-title'
    ),
    'product_price_single_page' => array(
        'title' => 'Single product price',
        'selector' => 'html .single-product-page .summary-inner > .price > .amount, html .single-product-page .basel-scroll-content > .price > .amount, html .single-product-page .summary-inner > .price > ins .amount, html .single-product-page .basel-scroll-content > .price > ins .amount'
    ),
    'product_variable_price_single_page' => array(
        'title' => 'Variable product price',
        'selector' => 'html .single-product-page .variations_form .woocommerce-variation-price .price > .amount, html .single-product-page .variations_form .woocommerce-variation-price .price > ins .amount'
    ),
    'blog' => array(
        'title' => 'Blog',
    ),
    'blog_title' => array(
        'title' => 'Blog post title',
        'selector' => 'html .website-wrapper .post.blog-post-loop .entry-title a',
        'selector-hover' => 'html .website-wrapper .post.blog-post-loop .entry-title a:hover'
    ),
    'blog_title_shortcode' => array(
        'title' => 'Blog title on WPBakery element',
        'selector' => 'html .website-wrapper .basel-blog-holder .post.blog-post-loop .entry-title a',
        'selector-hover' => 'html .website-wrapper .basel-blog-holder .post.blog-post-loop .entry-title a:hover'
    ),
    'blog_title_carousel' => array(
        'title' => 'Blog title on carousel',
        'selector' => 'html .post-slide.post .entry-title a',
        'selector-hover' => 'html .post-slide.post .entry-title a:hover'
    ),
    'blog_title_sinle_post' => array(
        'title' => 'Blog title on single post',
        'selector' => 'html .post-single-page .entry-title'
    ),
    'custom_selector' => array(
        'title' => 'Write your own selector',
    ),
    'custom' => array(
        'title' => 'Custom selector',
        'selector' => 'custom'
    ),
) );