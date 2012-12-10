<?php

/*
  Plugin Name: RecipePressReloaded
  Plugin URI: 
  Description: A simple recipe plugin. It basically adds a post type for recipes to your site. You can publish recipes as standalone posts or include in your posts and pages. Organize your recipes in categories, cuisines, courses, seasons, ... Of course there are post images and all the normal wordpress post goodies for your recipes as well.
  Version: 0.3
  Author: dasmaeh
  Author URI: 
  License: GPL2

 * *************************************************************************

  Copyright (C) 2012 Jan Köster

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see http://www.gnu.org/licenses/

 * *************************************************************************

 */
// don't load directly
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}


 
/*Set plugin location constants:*/
if ( !defined('RPR_URL') )
	define( 'RPR_URL', plugin_dir_url( __FILE__ ) );
if ( !defined('RPR_PATH') )
	define( 'RPR_PATH', plugin_dir_path( __FILE__ ) );
if ( !defined('RPR_TEMPLATES_PATH') )
	define( 'RPR_TEMPLATES_PATH', RPR_PATH."/templates");
	if ( !defined('RPR_TEMPLATES_URL') )
	define( 'RPR_TEMPLATES_URL', RPR_URL."/templates");
if ( !defined('RPR_BASENAME') )
	define( 'RPR_BASENAME', plugin_basename( __FILE__ ) );

/*Set plugin version*/
define( 'RPR_VERSION', '0.2' );

require_once('php/class/rpr_core.php');
require_once('php/class/rpr_administration.php');

require_once('php/class/rpr_shortcodes.php');
require_once('php/class/rpr_initialize.php');
include_once('php/inc/form_tags.php');
include_once('php/inc/template_tags.php');
include_once('php/inc/taxonomy_tags.php');
require_once('php/inc/inflector.php');

rpr_inflector::init();

class RecipePressReloaded{
	var $menuName = 'recipe-press-reloaded';
	var $pluginName = 'RecipePress reloaded';
	var $version = '0.2';
	
	var $options;
	var $posttype;
	
	public function __construct(){
		//Get posttype
		if (!class_exists("RPR_Posttype"))
			require('php/class/rpr_posttype.php');
		
		//Get options
		if (!class_exists("RPR_Options"))
			require('php/class/rpr_options.php');
		
		$this->posttype = new RPR_Posttype();
		$this->options = new RPR_Options($this->menuName, $this->pluginName, $this->version);
		
		add_action('init', array(&$this,'init') );
		add_action('admin_init', array(&$this,'admin_init') );
		add_action('admin_menu', array(&$this,'admin_menu') );
	}
	
	function init(){
		$this->posttype->init();
	}
	
	function admin_init(){
		$this->options->admin_init();
	}
	
	function admin_menu() {
		$this->options->admin_menu();
	}
}




/* Instantiate the Plugin */
if (class_exists("RecipePressReloaded")) {
	$rp_reloaded = new RecipePressReloaded();
}

/* Set up the plugin */
if (isset($rp_reloaded)) {
	/* Setting up filters and options*/
	
	
		
}

