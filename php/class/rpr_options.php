<?php
if (!function_exists('is_admin')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit ();
}

if (!class_exists("RPR_Options")): 

class RPR_Options {
	var $menuName;
	var $pluginName;
	var $version;
	
	private $options;

	public function __construct( $menuname='', $pluginname='', $version='0' ) {
		$this->menuName = $menuname;
		$this->pluginName = $pluginname;
		$this->version = $version;
		
		$this->loadOptions();
	}

	/*Init function for the backend*/
	public function admin_init() {
		//if ( is_admin() ):
			//Register settings
			register_setting('rpr_options', 'rpr_options', array ( &$this, 'rpr_options_validate' ) );
			
			//Register the different settings sections:
			//Settings Section general
			add_settings_section(
				'rpr_general',
				__("General Settings", "recipe-press-reloaded"),
				array (&$this, 'rpr_section_general_callback'),
				'general'
				);
			//Settings sections for the taxonomies:
			$this->add_taxonomy_options();
			$this->add_new_taxonomy_options();
			//Settings section display
			add_settings_section(
				'rpr_display',
				__("Display Settings", "recipe-press-reloaded"),
				array(&$this, 'rpr_section_display_callback'),
				'display'
			);
			//Settings section admin display
			add_settings_section(
				'rpr_admin_post_list',
				__("Admin Post List Settings", "recipe-press-reloaded"),
				array(&$this, 'rpr_section_admin_post_list_callback'),
				'admin_post_list'
			);
          
			
			//register scripts and styles:
			wp_register_style('rpr_admin_CSS', RPR_URL . 'css/rpr-admin.css');
			wp_register_script('rpr_admin_JS', RPR_URL . 'js/rpr-admin.js');
		//endif;
	}
	
	//Create the admin-menu entries:
	public function admin_menu() {
		//Setup settings page:
		$settings_page = add_submenu_page(
			'edit.php?post_type=recipe',
			__('RecipePress reloaded Settings', 'recipe-press-reloaded'),
			__('Settings', 'recipe-press-reloaded'),
			'edit_files',
			'rpr_options_page',
			array(&$this, 'options_page_callback')
			);
		//add scripts and styles to the settings page:
		add_action('admin_print_styles-' . $settings_page, array(&$this, 'options_page_styles_callback'));
		add_action('admin_print_scripts-' . $settings_page , array(&$this, 'options_page_scripts_callback'));
	}

	public function getOption($key) {
		if (array_key_exists($key, $this->options)) {
			return $this->options[$key];
		} else {
			//May be we need a better error handling here.
			return false;
		}

	}

	//Options page styles callback
	function options_page_styles_callback() {
		wp_enqueue_style('rpr_admin_CSS');
	}
	
	//Options page scripts callback
	function options_page_scripts_callback() {
		wp_localize_script('rpr_admin_JS', 'RPAJAX', array(
               'ajaxurl' => admin_url('admin-ajax.php'),
          ));
          wp_enqueue_script('jquery.autocomplete');
          wp_enqueue_script('rpr_admin_JS');
	}
	
	//Load settings from DB and populate empty options with defaults
	private function loadOptions() {
		$defaults_taxonomy = array(
			'slug' => 'new-taxonomy-slug',
			'singular_name' => __('New Taxonomy', 'recipe-press-reloaded'),
			'plural_name' => __('New Taxonomies', 'recipe-press-reloaded'),
			'hierarchical' => true,
			'active' => true,
			'default' => false,
			'allow_multiple' => true,
			'page' => false,
			'builtin' => false,
			'per_page' => 10,
			'show_on_posts_list' => true,
		);
		$defaults = array (
			'index_slug' => 'recipes',
			'use_plugin_permalinks' => true,
			'singular_name' => 'recipe',
			'plural_name' => 'recipes',
			'identifier' => 'recipe',
			'permalink_structure' => '%identifier%/%postname%',
			'use_categories' => true,
			'use_cuisines' => true,
			'use_servings' => true,
			'use_times' => true,
			'use_courses' => true,
			'use_seasons' => true,
			'use_thumbnails' => true,
			'use_featured' => true,
			'use_comments' => true,
			'use_trackbacks' => true,
			'use_custom_fields' => false,
			'use_revisions' => true,
			'use_post_categories' => false,
			'use_post_tags' => false,
			//taxonomies
			'taxonomies' => array (
				'recipe-category' => array (
					'slug' => 'recipe-category',
					'singular_name' => __('Recipe Category', 'recipe-press-reloaded'),
					'plural_name' => __('Recipe Categories', 'recipe-press-reloaded'),
					'hierarchical' => true,
					'active' => true,
					'default' => false,
					'allow_multiple' => true,
					'page' => false,
					'builtin' => false,
					'per_page' => 10,
					'show_on_posts_list' => true,
					
				),
				'recipe-cuisine' => array (
					'slug' => 'recipe-cuisine',
					'singular_name' => __('Recipe Cuisine', 'recipe-press-reloaded'),
					'plural_name' => __('Recipe Cuisines', 'recipe-press-reloaded'),
					'hierarchical' => false,
					'active' => true,
					'default' => false,
					'allow_multiple' => true,
					'page' => false,
					'builtin' => false,
					'per_page' => 10,
					'show_on_posts_list' => true,
					
				),
				'recipe-course' => array (
					'slug' => 'recipe-course',
					'singular_name' => __('Course', 'recipe-press-reloaded'),
					'plural_name' => __('Courses', 'recipe-press-reloaded'),
					'hierarchical' => false,
					'active' => true,
					'default' => false,
					'allow_multiple' => true,
					'page' => false,
					'builtin' => false,
					'per_page' => 10,
					'show_on_posts_list' => true,
					
				),
				'recipe-season' => array (
					'slug' => 'recipe-season',
					'singular_name' => __('Season', 'recipe-press-reloaded'),
					'plural_name' => __('Seasons', 'recipe-press-reloaded'),
					'hierarchical' => false,
					'active' => true,
					'default' => false,
					'allow_multiple' => true,
					'page' => false,
					'builtin' => false,
					'per_page' => 10,
					'show_on_posts_list' => true,
					
				),
				'recipe-ingredient' => array (
					'slug' => 'recipe-ingredient',
					'singular_name' => __('Ingredient', 'recipe-press-reloaded'),
					'plural_name' => __('Ingredients', 'recipe-press-reloaded'),
					'hierarchical' => false,
					'active' => true,
					'default' => false,
					'allow_multiple' => true,
					'page' => false,
					'builtin' => false,
					'per_page' => 10,
					'show_on_posts_list' => false,
					
				),
			),
			/* Display Settings */
			'menu_position' => 5,
			'default_excerpt_length' => 20,
			'recipe_count' => get_option('posts_per_page'),
			'recipe_orderby' => 'title',
			'recipe_order' => 'asc',
			'add_to_author_list' => false,
			'disable_content_filter' => false,
			'custom_css' => true,
			'hour_text' => __(' hour', 'recipe-press-reloaded'),
			'minute_text' => __(' min', 'recipe-press-reloaded'),
			'time_display_type' => 'single',
			'link_ingredients' => false,
			//Image sizes (as a fallback if not provided by theme)
			'image_sizes' => array (
				'image' => array (
					'name' => 'RPR Image',
					'width' => 250,
					'height' => 250,
					'crop' => isset ($this->options['image_sizes']['image']['crop']) ? $this->options['image_sizes']['image']['crop'] : true,
					'builtin' => true
				),
				'thumb' => array (
					'name' => 'RPR Thumbnail',
					'width' => 50,
					'height' => 50,
					'crop' => isset ($this->options['image_sizes']['thumb']['crop']) ? $this->options['image_sizes']['thumb']['crop'] : true,
					'builtin' => true
				),
				
			),
			// Non-Configurable Settings 
			'menu_icon' => RPR_URL . 'images/icons/small_logo.png',
			//To think about
			'ingredient_slug' => 'recipe-ingredients',
			'ingredients_per_page' => 10,
			'ingredient_page' => 0,
			'ingredients_fields' => 5,
			'plural_times' => true,
			'new_tax' => $defaults_taxonomy,
			
		);
		
		$this->options = wp_parse_args(get_option('rpr_options'), $defaults);

		//Unfortunately wp_parse_args can't handle nested args so we do a little trick here:
		foreach ($this->options['taxonomies'] as $key => $options):
			if(array_key_exists($key,  $defaults['taxonomies'] )):
				$this->options['taxonomies'][$key] = wp_parse_args($options, $defaults['taxonomies'][$key]);
			endif;
			$this->options['taxonomies'][$key] = wp_parse_args($options, $defaults_taxonomy);
		endforeach;

	}

	//The settings page function
	public function options_page_callback() {
		include(RPR_PATH . 'php/inc/settings.php');
	}
	
	//The settings callback functions:
	//General settings:
	function rpr_section_general_callback() {
		add_settings_field(
			'rpr_index_slug', 
			__("Index slug", "recipe-press-reloaded"), 
			array(&$this, 'rpr_options_input'), 
			'general',
			'rpr_general',
			array (
				'id' => 'index_slug',
				'name' => '[index_slug]',
				'value' => $this->options['index_slug'],
				'desc' => __('This will be used as the slug (URL) for the recipe index pages.', 'recipe-press-reloaded'),
				'link' => "<a href=\"" . get_option('home') . "/" . $this->options['index_slug'] . "\">" . __('View on Site', 'recipe-press-reloaded') . "</a>",
				'class' => 'test',
			));
		add_settings_field(
			'rpr_use_plugin_permalinks', 
			__("Use plugin permalinks?", "recipe-press-reloaded"), 
			array(& $this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array (
				'id' => 'use_plugin_permalink',
				'checked' => $this->options['use_plugin_permalinks'],
				'desc' => __("Check this if you want to use your own permalink structure defined below. If not checked the default wordpress permalink structure will be used", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_singular_name', 
			__("Singular name", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_input'),
			'general',
			'rpr_general',
			array(
				'id' => 'singular_name',
				'name' => '[singular_name]',
				'value' => $this->options['singular_name'],
				'desc' => __("The name for a single recipe-post", "recipe-press")
			));
		add_settings_field(
			'rpr_plural_name',
			__("Plural name", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_input'),
			'general',
			'rpr_general',
			array(
				'id' => 'plural_name',
				'name' => '[plural_name]',
				'value' => $this->options['plural_name'],
				'desc' => __("The name for multiple recipe-posts", "recipe-press")
			));
		add_settings_field(
			'rpr_identifier',
			__("Identifier", "recipe-press-reloaded"), 
			array(&$this, 'rpr_options_input'),
			'general',
			'rpr_general',
			array (
				'id' => 'identifier',
				'name' => '[identifier]',
				'value' => $this->options['identifier'],
				'desc' => __("The <strong>%identifier%</strong> used in the permalink structure below", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_permalink_structure',
			__("Permalink structure", "recipe-press-reloaded"),
			array (&$this, 'rpr_options_input'),
			'general',
			'rpr_general',
			array (
				'id' => 'permalink_structure',
				'name' => '[permalink_structure]',
				'value' => $this->options['permalink_structure'],
				'desc' => __(" This permalink structure will be used to create the custom URL structure for your individual recipes. These follow WP's normal <a href=\"http://codex.wordpress.org/Using_Permalinks\" title=\"Wordpress Documentation on permalinks\">permalink tags</a>, but must also include the content type <strong>%identifier%</strong> and at least one of these unique tags: <strong>%postname%</strong> or <strong>%post_id%</strong>.<br/>Allowed tags: %year%, %monthnum%, %day%, %hour%, %minute%, %second%, %postname%, %post_id% ", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_categories',
			__("Use categories?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array(
				'id' => 'use_categories',
				'checked' => $this->options['use_categories'],
				'desc' => __("Check this if you want to use the recipe categories taxonomy", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_cuisines',
			__("Use cuisines?", "recipe-press-reloaded"), 
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array(
				'id' => 'use_cuisines',
				'checked' => $this->options['use_cuisines'],
				'desc' => __("Check this if you want to use the recipe cuisines taxonomy", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_servings',
			__("Use servings?", "recipe-press-reloaded"), 
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array(
				'id' => 'use_servings',
				'checked' => $this->options['use_servings'],
				'desc' => __("Check this if you want to use the servings taxonomy", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_times',
			__("Use times?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array(
				'id' => 'use_times',
				'checked' => $this->options['use_times'],
				'desc' => __("Check this if you want to use the times taxonomy", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_courses',
			__("Use courses?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general', 
			array(
				'id' => 'use_courses',
				'checked' => $this->options['use_courses'],
				'desc' => __("Check this if you want to use the courses taxonomy", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_seasons',
			__("Use seasons?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array (
				'id' => 'use_seasons',
				'checked' => $this->options['use_seasons'],
				'desc' => __("Check this if you want to use the seasons taxonomy", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_thumbnails',
			__("Use thumbnails?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array (
				'id' => 'use_thumbnails',
				'checked' => $this->options['use_thumbnails'],
				'desc' => __("Check this if you want to use thumbnails", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_featured',
			__("Use featured?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array (
				'id' => 'use_featured',
				'checked' => $this->options['use_featured'],
				'desc' => __("Check this if you want to use featured recipes", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_comments',
			__("Use comments?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array(
				'id' => 'use_comments',
				'checked' => $this->options['use_comments'],
				'desc' => __("Check this if you want to use comments", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_trackbacks',
			__("Use trackbacks?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array(
				'id' => 'use_trackbacks',
				'checked' => $this->options['use_trackbacks'],
				'desc' => __("Check this if you want to use trackbacks", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_custom_fields',
			__("Use custom fields?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array(
				'id' => 'use_custom_fields',
				'checked' => $this->options['use_custom_fields'],
				'desc' => __("Check this if you want to use custom fields", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_revisions',
			__("Use revisions?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array(
				'id' => 'use_revisions',
				'checked' => $this->options['use_revisions'],
				'desc' => __("Check this if you want to use revisions", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_post_categories',
			__("Use post categories?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array(
				'id' => 'use_post_categories',
				'checked' => $this->options['use_post_categories'],
				'desc' => __("Check this if you want to use the post categories instead of the recipe categories", "recipe-press-reloaded")
			));
		add_settings_field(
			'rpr_use_post_tags',
			__("Use post tags?", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_checkbox'),
			'general',
			'rpr_general',
			array(
				'id' => 'use_post_tags',
				'checked' => $this->options['use_post_tags'],
				'desc' => __("Check this if you want to use the post tags", "recipe-press-reloaded")
			));
	}

	//Taxonomy related settings:
	function add_taxonomy_options(){
		foreach($this->options['taxonomies'] as $key=>$tax):
			add_settings_section(
				'rpr_taxonomies_'.$key,
				sprintf(__("Taxonomy %s", "recipe-press-reloaded"), $key),
				array(&$this, 'rpr_section_taxonomies_tax_callback'),
				'taxonomies_'.$key,
				array(
					'key'=> $key,
					'value' => $tax,
				));
			$options = $this->options['taxonomies'][$key];
			$this->add_taxonomy_options_fields($key, $options);
		endforeach;
	}
	
	function add_new_taxonomy_options(){
		add_settings_section(
			'rpr_taxonomies_new',
			sprintf(__("Add new taxonomy", "recipe-press-reloaded")),
			array(&$this, 'rpr_section_taxonomies_tax_callback'),
			'taxonomies_new',
			array(
			));
		$key='new';
		$options = $this->options['new_tax'];
		$this->add_taxonomy_options_fields($key, $options);
	}
	
	function add_taxonomy_options_fields($key, $options){
		add_settings_field(
			'rpr_taxonomies_'.$key.'_slug',
			__("Taxonomy slug", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_input'),
			'taxonomies_'.$key,
			'rpr_taxonomies_'.$key,
			array(
				'id'=>'rpr_options_taxonomies_'.$key.'_slug',
				'name' => '[taxonomies][' . $key . '][slug]',
				'value' => $options['slug'],
				'desc'=>__('The URL slug for listing all terms of this taxonomy.', 'recipe-press-reloaded'),
				'link'=>"&nbsp;<a href=\"".get_option('home')."/".$options['slug']."\">".__('View on Site', 'recipe-press-reloaded')."</a>"
			));
		add_settings_field(
			'rpr_taxonomies_'.$key.'_singular_name',
			__("Singular name", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_input'),
			'taxonomies_'.$key, 'rpr_taxonomies_'.$key,
			array(
				'id'=>'taxonomies_'.$key.'_singular_name',
				'name' => '[taxonomies][' . $key . '][singular_name]',
				'value' => $options['singular_name'],
				'desc'=>__('The name for a single term.', 'recipe-press-reloaded')
			));
		add_settings_field(
			'rpr_taxonomies_'.$key.'_plural_name',
			__("Plural name", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_input'),
			'taxonomies_'.$key,
			'rpr_taxonomies_'.$key,
			array(
				'id'=>'taxonomies_'.$key.'_plural_name',
				'name' => '[taxonomies][' . $key . '][plural_name]',
				'value' => $options['plural_name'],
				'desc'=>__('The name for multiple term.', 'recipe-press-reloaded')
			));
		add_settings_field(
			'rpr_taxonomies_'.$key.'_page',
			__("Display page", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_dropdown_pages'),
			'taxonomies_'.$key,
			'rpr_taxonomies_'.$key,
			array(
				'key'=>$key,
				'selected' => $options['page'],
				'desc'=>sprintf(__('The page where this taxonomy will be listed. You must place the short code <strong>[%1$s]</strong> on this page to display the recipes. This will be the page that users will be directed to if the template file "%2$s" does not exist in your theme.', 'recipe-press-reloaded'),
				'recipe-tax tax=' . $key, 'taxonomy-recipe.php')
			));
		add_settings_field(
			'rpr_taxonomies_'.$key.'_per_page',
			__("Display how many per page", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_input'),
			'taxonomies_'.$key,
			'rpr_taxonomies_'.$key,
			array(
				'name' => 'rpr_options[taxonomies]['.$key.'][per_page]',
				'id' => 'rpr_taxonomies_'.$key.'_per_page',
				'value' => $options['per_page'],
				'type' => 'number',
				'min' => 1,
				'max' => 25,
				'size' => 15,
				'desc'=>__('How many items shall be shown on one page?', 'recipe-press-reloaded')
			));
      	
      	if($key != "recipe-ingredient"):
      		add_settings_field(
				'rpr_taxonomies_'.$key.'_default',
				__("Default value", "recipe-press-reloaded"),
				array(&$this, 'rpr_options_dropdown_categories'),
				'taxonomies_'.$key,
				'rpr_taxonomies_'.$key,
				array(
					'key'=>$key,
					'id' => 'default',
					'selected' => $options['default'],
					'desc'=>__('Default value for this taxononomy.', 'recipe-press-reloaded'),
					'options' => $options,
				)); 
      		add_settings_field(
				'rpr_taxonomies_'.$key.'_hierarchical',
				__("Hierarchical", "recipe-press-reloaded"),
				array(&$this, 'rpr_options_checkbox'),
				'taxonomies_'.$key,
				'rpr_taxonomies_'.$key,
				array(
					'id'=>'taxonomies_'.$key.'_hierarchical',
					'name' => '[taxonomies][' . $key . '][hierarchical]',
					'checked' => $options['hierarchical'],
					'desc'=>__('Check this if you want to enable nested terms for this the taxonomy', 'recipe-press-reloaded')
				));
      		add_settings_field(
				'rpr_taxonomies_'.$key.'_allow_multiple',
				__("Allow multiple", "recipe-press-reloaded"),
				array(&$this, 'rpr_options_checkbox'),
				'taxonomies_'.$key,
				'rpr_taxonomies_'.$key,
				array(
					'id'=>'taxonomies_'.$key.'_allow_multiple',
					'name' => '[taxonomies][' . $key . '][allow_multiple]',
					'checked' => $options['allow_multiple'],
					'desc'=>__('Check this if you want to allow more than one term assigned to recipe', 'recipe-press-reloaded')
				));
      		add_settings_field(
				'rpr_taxonomies_'.$key.'_active',
				__("Active", "recipe-press-reloaded"),
				array(&$this, 'rpr_options_checkbox'),
				'taxonomies_'.$key,
				'rpr_taxonomies_'.$key,
				array(
					'id'=>'taxonomies_'.$key.'_active',
					'name' => '[taxonomies][' . $key . '][active]',
					'checked' => $options['active'],
					'desc'=>__('Check this if you want this taxonomy to be active', 'recipe-press-reloaded')
				));
			add_settings_field(
				'rpr_taxonomies_'.$key.'_delete',
				__("Delete this taxonomy", "recipe-press-reloaded"),
				array(&$this, 'rpr_options_checkbox'),
				'taxonomies_'.$key,
				'rpr_taxonomies_'.$key,
				array(
					'name' => '[taxonomies]['.$key.'][delete]',
					'id' => 'taxonomies_'.$key.'_delete',
					'checked' => false,
					//'desc'=>__('Check this if you want to have the taxonomy items displayed on the recipes posts list in the admin area.', 'recipe-press-reloaded')
			));	
      	endif;
      	
      	
	}
	
	function rpr_section_taxonomies_tax_callback() {
		//this is actually doin nothing. We just need a callback function. As this can't take any arguments the has to be done above.
	}

	//Display settings
	/*Section display*/
     function rpr_section_display_callback() {
     	add_settings_field(
			'rpr_default_excerpt_length',
			__("Default excerpt length", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_input'),
			'display',
			'rpr_display',
			array(
				'id' => 'default_excerpt_length',
				'name' => '[default_excerpt_length]',
				'value' => $this->options['default_excerpt_length'],
				'desc' => __( 'Default length of introduction excerpt when displaying in lists.', 'recipe-press' )
			));
    	add_settings_field(
			'rpr_add_to_author_list',
			__('Add to author list', 'recipe-press-reloaded'),
			array(&$this, 'rpr_options_checkbox'),
			'display',
			'rpr_display',
			array(
				'id' => 'add_to_author_list',
				'checked' => $this->options['add_to_author_list'],
				'desc' => __('Check this to include the recipes by each author in their respective post list.', 'recipe-press' ) 
			));
     	add_settings_field(
			'rpr_recipe_count',
			__("Number of recipes to display per page", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_dropdown'),
			'display',
			'rpr_display',
			array(
				'name' => 'rpr_options[recipe_count]',
				'id' => 'rpr_recipe_count',
				'selected' => $this->options['recipe_count'],
				'options' => range(1,25),
				'desc'=>__('How many recipes to display per page on the listing pages.', 'recipe-press-reloaded')
				));
     	add_settings_field(
			'rpr_recipe_orderby',
			__("Order by", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_dropdown'),
			'display',
			'rpr_display',
			array(
				'name' => 'rpr_options[recipe_orderby]',
				'id' => 'rpr_recipe_orderby',
				'selected' => $this->options['recipe_orderby'],
				'options' => array(
					__('Date', 'recipe-press-reloaded') => 'date',
					__('Title', 'recipe-press-reloaded') => 'title', 
					__('Random', 'recipe-press-reloaded') => 'random', 
					__('Comment count', 'recipe-press-reloaded') => 'comment_count', 
					__('Menu order', 'recipe-press-reloaded') => 'menu_order' 
				)));
     	add_settings_field(
			'rpr_recipe_order',
			"",
			array(&$this, 'rpr_options_dropdown'),
			'display',
			'rpr_display',
			array(
				'name' => 'rpr_options[recipe_order]',
				'id' => 'rpr_recipe_order',
				'selected' => $this->options['recipe_order'],
				'options' => array(
					__('Ascending', 'recipe-press-reloaded') => 'asc', 
					__('Descending', 'recipe-press-reloaded') => 'desc'
					),
				'desc'=>__('The listing order of recipes on the index page.', 'recipe-press-reloaded')
				));
     	
     	add_settings_field(
			'rpr_custom_css',
			__('Use plugin CSS', 'recipe-press-reloaded'),
			array(&$this, 'rpr_options_checkbox'),
			'display',
			'rpr_display',
			array(
				'id' => 'custom_css',
				'checked' => $this->options['custom_css'],
				'desc' => __('Check this to use the builtin css from the plugin.', 'recipe-press' ) 
			));
     	add_settings_field(
			'rpr_disable_content_filter',
			__('Disable content filter', 'recipe-press-reloaded'),
			array(&$this, 'rpr_options_checkbox'),
			'display',
			'rpr_display',
			array(
				'id' => 'disable_content_filter',
				'checked' => $this->options['disable_content_filter'],
				'desc' => __('Check this this option to completely disable any content filtering. <strong>Warning!</strong> Only do this if you have created template files and are having an issue with template display.', 'recipe-press' )
				));
     	add_settings_field(
			'rpr_link_ingredients',
			__('Link ingredients', 'recipe-press-reloaded'),
			array(&$this, 'rpr_options_checkbox'),
			'display',
			'rpr_display',
			array(
				'id' => 'link_ingredients',
				'checked' => $this->options['link_ingredients'],
				'desc' => __('Check this to link ingredients to the taxonomy listing or the page set in the taxonomies tab.', 'recipe-press' )
				));
     	add_settings_field(
			'rpr_time_display_type',
			__("Time display type", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_dropdown'),
			'display',
			'rpr_display',
			array(
				'name' => 'rpr_options[time_display_type]',
				'id' => 'time_display_type',
				'selected' => $this->options['time_display_type'],
				'options' => array(
					__("Two lines", "recipe-press-reloaded")=>'double',
					__('One line', 'recipe-press-reloaded') => 'single'
					),
				'desc' => 'Mode to display the time field. Double means time and unit in seperate lines'
				));
     	add_settings_field(
			'rpr_default_hour_text',
			__("Hours text", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_input'),
			'display',
			'rpr_display',
			array(
				'id' => 'hour_text',
				'name' => '[hour_text]',
				'value' => $this->options['hour_text'],
				'desc' => __( 'Text that will be displayed in front of times greater than 60 min. Use singular only.', 'recipe-press' )
			));
     	add_settings_field(
     		'rpr_default_minute_text',
     		__("Minutes text", "recipe-press-reloaded"),
     		array(&$this, 'rpr_options_input'),
     		'display',
     		'rpr_display',
     		array(
     			'id' => 'minute_text',
     			'name' => '[minute_text]',
     			'value' => $this->options['minute_text'],
     			'desc' => __( 'Text that will be displayed in front of times. Use singular only.', 'recipe-press' )
     		));
     	add_settings_field(
			'rpr_image_size_image',
			__("Image size", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_image_size'),
			'display',
			'rpr_display',
			array(
				'id' => 'image_sizes_image',
				'name' => '[image_sizes][image]',
				'width' => $this->options['image_sizes']['image']['width'],
				'height' => $this->options['image_sizes']['image']['height'],
				'crop' => $this->options['image_sizes']['image']['crop'],
				'desc' => __( 'Image size that will be used to display images in the single view. Might be overriden by your theme.', 'recipe-press' )
			));
     	add_settings_field(
			'rpr_image_size_thumb',
			__("Thumbnail size", "recipe-press-reloaded"),
			array(&$this, 'rpr_options_image_size'),
			'display',
			'rpr_display',
			array(
				'id' => 'image_sizes_thumb',
				'name' => '[image_sizes][thumb]',
				'width' => $this->options['image_sizes']['thumb']['width'],
				'height' => $this->options['image_sizes']['thumb']['height'],
				'crop' => $this->options['image_sizes']['thumb']['crop'],
				'desc' => __( 'Image size that will be used to display images in the list view. Might be overriden by your theme.', 'recipe-press' )
			));
     }
     
	//Admin display settings
     function rpr_section_admin_post_list_callback() {
     	foreach($this->options['taxonomies'] as $key=>$tax):
     	//	add_settings_section('rpr_taxonomies_'.$key, sprintf(__("Taxonomy %s", "recipe-press-reloaded"), $key), array(&$this, 'rpr_section_taxonomies_tax_callback_function'), 'taxonomies_'.$key, array('key'=>$key));
     		add_settings_field(
				'rpr_taxonomies_'.$key.'_show_on_posts_list',
				sprintf(__("Show '%s' on posts list", "recipe-press-reloaded"), $key),
				array(&$this, 'rpr_options_checkbox'),
				'admin_post_list',
				'rpr_admin_post_list',
				array(
					'name' => 'rpr_options[taxonomies]['.$key.'][show_on_posts_list]',
					'id' => 'rpr_taxonomies_'.$key.'_show_on_posts_list',
					'checked' => $this->options['taxonomies'][$key]['show_on_posts_list']
				));
     	endforeach;
     }
	
	//The settings field callback functions_
	/*Creates a checkbox field
	* args: 
	* - id (id for the field)
	* - name (optional, name for the field)
	* - checked (boolean value at which the field should appear checked)
	* - desc (optional, descriptive text)
	*/
	function rpr_options_checkbox($args) {
		if (isset ($args['id']) && $args['id'] != "" && isset ($args['checked']))
			: $outp = "<input id=\"rpr_options_" . $args['id'] . "\" name=\"";
		if (isset ($args['name']) && $args['name'] != "")
			: $outp .= "rpr_options" .
			$args['name'];
		else
			: $outp .= "rpr_options[" . $args['id'] . "]";
		endif;
		$outp .= "\" type=\"checkbox\" value=\"1\" ";
		$outp .= checked('1', $args['checked'], false);
		$outp .= "/>";
		if (isset ($args['desc']) && $args['desc'] != "")
			: $outp .= "<p>" . $args['desc'] . "</p>";
		endif;
		else
			: $outp = "<p class=\"error\">" .
			sprintf(__('There was an error in %1$s in function %2$s. Please file a bug!', "recipe-press-reloaded"), "rpr_administration.php", "rpr_options_checkbox()") . "</p>";
		endif;
		echo $outp;
	}

	/* Creates an input field
	* args:
	* - id (id for the field)
	* - name (name for the field)
	* - type (optional, text or number, defaults to text)
	* - value (current value of the option)
	* - size (optional)
	* - min (optional, min value for type number)
	* - max (optional, max value for type number)
	* - desc (optional, descriptive text)
	* - link (optional, view on site link)
	*/
	function rpr_options_input($args) {
		if (isset ($args['id']) && $args['id'] != "" && isset ($args['name']) && $args['name'] != "" && isset ($args['value']) && ($args['value'] != "")):
			$outp = "<input id=\"" . $args['id'] . "\" name=\"rpr_options" . $args['name'] . "\" ";
			if( isset( $args['type'] ) && $args['type'] == 'number'):
				$outp.='type="number" step="1"';
				if( isset( $args['min']) && ( is_float( $args['min'] ) || is_int($args['min']) ) ):
					$outp.=' min="' . $args['min'] . '"';
				endif;
				if( isset( $args['max'] ) && ( is_float( $args['max'] ) || is_int( $args['max'] ) ) ):
					$outp.=' max="' . $args['max'] . '"';
				endif;
			else:
			 	 $outp.='type=\"text\"';
			endif;
		$outp.=' size="';
		if (isset ($args['size']) && is_int($args['size']))
			: $outp .= $args['size'];
		else
			: $outp .= "40";
		endif;
		$outp .= "\" value=\"" . $args['value'] . '" />';
		if (isset ($args['link']) && $args['link'] != "")
			: $outp .= "&nbsp;" .
			$args['link'];
		endif;
		if (isset ($args['desc']) && $args['desc'] != "")
			: $outp .= "<p>" . $args['desc'] . "</p>";
		endif;
		else
			: $outp = "<p class=\"error\">" .
			sprintf(__('There was an error in %1$s in function %2$s. Please file a bug!', "recipe-press-reloaded"), "rpr_administration.php", "rpr_options_input()") . "</p>";
		endif;
		echo $outp;
	}

	/*Creates a dropdown field
	 * args:
	 * - name (of the field)
	 * - id (name for the field)
	 * - selected (current value)
	 * - options (array aof options)
	 * - desc (optional, descriptive text)
	 */
	function rpr_options_dropdown($args) {
		if (isset ($args['name']) && $args['name'] != "" && isset ($args['id']) && $args['id'] != "" && isset ($args['selected']) && isset ($args['options']) && is_array($args['options']))
			: $outp = "<select name=\"" . $args['name'] . "\" id=\"" . $args['id'] . " \">\n";
		if (array_values($args['options']) === $args['options'])
			: foreach ($args['options'] as $opt)
				: $outp .= "<option value=\"$opt\" " . selected($args['selected'], $opt, false) . ">$opt</option>\n";
		endforeach;
		else
			: foreach ($args['options'] as $key => $value)
				: $outp .= "<option value=\"$value\" " . selected($args['selected'], $value, false) . ">$key</option>\n";
		endforeach;
		endif;
		$outp .= "</select>";
		if (isset ($args['desc']) && $args['desc'] != "")
			: $outp .= "<p>" . $args['desc'] . "</p>";
		endif;
		else
			: $outp = "<p class=\"error\">" .
			sprintf(__('There was an error in %1$s in function %2$s. Please file a bug!', "recipe-press-reloaded"), "rpr_administration.php", "rpr_options_dropdown_pages()") . "</p>";
		endif;
		echo $outp;
	}

	/*Creates a wp_page_dropdown field
	 * args:
	 * - key (of the taxonomy)
	 * - selected (current value)
	 * - desc (optional, descriptive text)
	 */
	function rpr_options_dropdown_pages($args) {
		if (isset ($args['key']) && $args['key'] != "" && isset ($args['selected']))
			: $outp = wp_dropdown_pages(array (
				'name' => 'rpr_options[taxonomies][' . $args['key'] . '][page]',
				'show_option_none' => __('None', 'recipe-press-reloaded'),
				'selected' => $args['selected'],
				'echo' => false
			));
		if (isset ($args['desc']) && $args['desc'] != "")
			: $outp .= "<p>" . $args['desc'] . "</p>";
		endif;
		else
			: $outp = "<p class=\"error\">" .
			sprintf(__('There was an error in %1$s in function %2$s. Please file a bug!', "recipe-press-reloaded"), "rpr_administration.php", "rpr_options_dropdown_pages()") . "</p>";
		endif;
		echo $outp;
	}

	/*Creates a wp_category_dropdown field
	 * - key (of the taxonomy)
	 * - selected (current value)
	 * - desc (optional, descriptive text)
	 */
	function rpr_options_dropdown_categories($args) {
		if (isset ($args['key']) && $args['key'] != "" && isset ($args['selected']) && isset ($args['options'])):
			$outp = wp_dropdown_categories(array (
				'name' => 'rpr_options[taxonomies][' . $args['key'] . '][default]',
				'id' => $args['key'],
				'hierarchical' => $args['options']['hierarchical'],
				'taxonomy' => $args['key'],
				'show_option_none' => __('No Default', 'recipe-press-reloaded'),
				'hide_empty' => false,
				'orderby' => 'name',
				'selected' => $args['selected'],
				'echo' => false,
				'hide_if_empty'=>true,
			));
		if (isset ($args['desc']) && $args['desc'] != "")
			: $outp .= "<p>" . $args['desc'] . "</p>";
		endif;
		else
			: $outp = "<p class=\"error\">" .
			sprintf(__('There was an error in %1$s in function %2$s. Please file a bug!', "recipe-press-reloaded"), "rpr_administration.php", "rpr_options_dropdown_pages()") . "</p>";
		endif;
		echo $outp;
	}

	/*Creates a settings set for an image size
	 * - id (id for the field)
	 * - name (name for the field)
	 * - crop
	 * - width
	 * - height
	 */
	function rpr_options_image_size($args) {
		if (isset ($args['id']) && $args['id'] != "" && isset ($args['crop']))
			: $outp = "<input id=\"" . $args['id'] . "_width\" name=\"rpr_options" . $args['name'] . "[width]\" type=\"text\" size=\"10\" value=\"" . $args['width'] . " \" />";
		$outp .= "<input id=\"" . $args['id'] . "_height\" name=\"rpr_options" . $args['name'] . "[height]\" type=\"text\" size=\"10\" value=\"" . $args['height'] . " \" />";

		$outp .= "<select name=\"rpr_options" . $args['name'] . "[crop]\" id=\"" . $args['id'] . "_crop \">\n";
		$outp .= "<option value=\"1\" " . selected($args['crop'], '1', false) . ">" . __("crop", "recipe-press-reloaded") . "</option>\n";
		$outp .= "<option value=\"0\" " . selected($args['crop'], '0', false) . ">" . __("proportional", "recipe-press-reloaded") . "</option>\n";
		$outp .= "</select>\n";

		if (isset ($args['desc']) && $args['desc'] != "")
			: $outp .= "<p>" . $args['desc'] . "</p>";
		endif;
		else
			: $outp = "<p class=\"error\">" .
			sprintf(__('There was an error in %1$s in function %2$s. Please file a bug!', "recipe-press-reloaded"), "rpr_administration.php", "rpr_options_dropdown_pages()") . "</p>";
		endif;
		echo $outp;
	}

	 /* validate our options*/
	function rpr_options_validate($input) {
		//Using a very simple validator which just strips any HTML:
		
		//If a new taxonomy is to be created:
		if( 
			(isset($input['taxonomies']['new']['slug']) && trim($input['taxonomies']['new']['slug']) != $this->options['new_tax']['slug']) &&
			(isset($input['taxonomies']['new']['singular_name']) && trim($input['taxonomies']['new']['singular_name']) != $this->options['new_tax']['singular_name']) &&
			(isset($input['taxonomies']['new']['plural_name']) && trim($input['taxonomies']['new']['plural_name']) != $this->options['new_tax']['plural_name'])
			):
			$slug = $input['taxonomies']['new']['slug'];
			$input['taxonomies'][$slug] = $input['taxonomies']['new'];
		endif;
		//unset 'new' taxonomy:
		unset($input['taxonomies']['new']);
		
		//check if a taxonomy is to be deleted:
		foreach( $input['taxonomies'] as $key=>$tax ):
			if( isset($tax['delete']) && $tax['delete']==true && $tax !='recipe-ingredient' ):
				//delete tax:
				register_taxonomy($key, array());
				unset( $input['taxonomies'][$key] );
			endif;
		endforeach;
		
		// Create an array for storing the validated options  
    	$output = array();  
 
    	foreach( $input as $key => $value ):  
        	// Check to see if the current option has a value and ist not an array  
        	if( $key == 'taxonomies'):
        		$output[$key] = $this->rpr_options_taxonomies_validate($input[$key]);
        	elseif($key == 'image_sizes'):
        		$output[$key] = $this->rpr_options_image_sizes_validate($input[$key]);
        	else:
        		$output[$key] = $this->rpr_validate_value($input[$key], $key);
            endif; 
    	endforeach;
    	
    	
	    // Return the array processing any additional functions filtered by this action  
    	return apply_filters( 'rpr_options_validate', $output, $input );
	}  
	
	private function rpr_options_taxonomies_validate($input) {
		foreach($input as $taxkey=>$tax):
			foreach($tax as $key=>$value):
				$out[$taxkey][$key] = $this->rpr_validate_value($input[$taxkey][$key], $key);
			endforeach;
		endforeach;
		//This does currently not allow the adding of new taxonomies!
		/*foreach($this->options['taxonomies'] as $taxkey=>$value):
			foreach($this->options['taxonomies'][$taxkey] as $key=>$value):
				if(isset($input[$taxkey][$key])):
					$out[$taxkey][$key] = $this->rpr_validate_value($input[$taxkey][$key], $key);
				else:
					$out[$taxkey][$key] = $value;
				endif;
			endforeach;
		endforeach;*/
		
		return $out;
	}
	
	private function rpr_options_image_sizes_validate($input) {
		foreach($this->options['image_sizes'] as $imkey=>$image_size):
			foreach($this->options['image_sizes'][$imkey] as $key => $value):
				if(isset($input[$imkey][$key])):
					$out[$imkey][$key] = $this->rpr_validate_value($input[$imkey][$key], $key);
				else:
					$out[$imkey][$key] = $value;
				endif;
			endforeach;
		endforeach;
		
		return $out;
	}
	
	private function rpr_validate_value($in, $key='') {
		$checkboxes = array(
    		'use_categories',
			'use_cuisines',
			'use_servings',
			'use_times',
			'use_courses',
			'use_seasons',
			'use_thumbnails',
			'use_featured',
			'use_comments',
			'use_trackbacks',
			'use_custom_fields',
			'use_revisions',
			'use_post_categories',
			'use_post_tags',
			'hierarchical',
			'active',
			'allow_multiple',
			'crop',
			'link_ingredients',
    	);
		// Strip all HTML and PHP tags and properly handle quoted strings  
        $out = strip_tags( stripslashes( $in ) );
        //if is checkbox:
        if(in_array($key, $checkboxes)):
			if ( $in == 1 or $in == '1' ) {
				$out = true;
			} else {
				$out = false;
			}
		endif;
		return $out;
	}
	
	function checked($data, $value) {
          if (
                  (is_array($data) and in_array($value, $data) )
                  or $data == $value
          ) {
               echo 'checked="checked"';
          }
     }
}
endif;
?>