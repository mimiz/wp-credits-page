<?php
/*
Plugin Name: Credits Page
Plugin URI: 
Description: Create a page to thanks plugins authors
Version: 1.0
Author: Rémi Goyard
Author URI: http://www.mimiz.fr/
*/
require_once 'creditsPage.class.php';
if(is_admin())
{
	new CreditsPagesPlugin();
}

wp_register_style('custom_style', WP_PLUGIN_URL . '/credits-page/style.css' );
wp_enqueue_style('custom_style');