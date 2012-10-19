<?php

if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}

/**
 * rpr_core.php - RecipePressReloaded Core Class
 *
 * @package RecipePress
 * @subpackage classes
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 2.0.4
 */
class RPR_Core {

     var $menuName = 'recipe-press-reloaded';
     var $pluginName = 'RecipePressReloaded';
     var $version = '0.1';
     var $optionsName = 'rpr-options';
     var $options = array();
     
     var $in_shortcode = false;


     /**
      * Initialize the plugin.
      */
     function RPR_Core() {
          /* Load Language Files */
          load_plugin_textdomain('recipe-press', false, dirname(dirname(plugin_basename(__FILE__))) . '/lang');

          /* Plugin Settings */
          /* translators: The name of the plugin, should be a translation of "RecipePress" only! */
          $this->pluginName = __('RecipePress', 'recipe-press');

          /* Plugin Folders */
          $this->pluginPath = WP_PLUGIN_DIR . '/' . basename(dirname(dirname(dirname(__FILE__)))) . '/';
          $this->pluginURL = WP_PLUGIN_URL . '/' . basename(dirname(dirname(dirname(__FILE__)))) . '/';
          $this->templatesPath = WP_PLUGIN_DIR . '/' . basename(dirname(dirname(dirname(__FILE__)))) . '/templates/';
          $this->templatesURL = WP_PLUGIN_URL . '/' . basename(dirname(dirname(dirname(__FILE__)))) . '/templates/';
          $this->loadSettings();

          /* Add custom images sizes for RecipePress */
          foreach ( $this->options['image-sizes'] as $image => $size ) {
               add_image_size('recipe-press-' . $image, $size['width'], $size['height'], $size['crop']);
          }
     }

     /**
      * Load plugin settings.
      */
     function loadSettings() {
          $this->rpr_options_defaults = array(
  			'index_slug' => 'recipes',
  			'use_plugin_permalinks' => true,
  			'singular_name' => 'recipe',
  			'plural_name' => 'recipes',
  			'identifier' => 'recipe',
			'permalink_structure' => '%identifier%/%postname%',
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
			'taxonomies'=>array(
				'recipe-category' => array(
					'slug' => 'recipe-category',
					'singular_name' => 'recipe category',
					'plural_name' => 'recipe categories',
					'hierarchical' => false,
					'active' => true,
					'default' => false,
					'allow_multiple' => true,
					'page' => false,
					'builtin' => false,
					'per_page' => 10,
					),
				'recipe-cuisine' => array(
					'slug' => 'recipe-cuisine',
					'singular_name' => 'recipe cuisine',
					'plural_name' => 'recipe cuisines',
					'hierarchical' => false,
					'active' => true,
					'default' => false,
					'allow_multiple' => true,
					'page' => false,
					'builtin' => false,
					'per_page' => 10,
					),
				'recipe-course' => array(
					'slug' => 'recipe-course',
					'singular_name' => __('Course', 'recipe-press'),
					'plural_name' => __('Courses', 'recipe-press'),
					'hierarchical' => false,
					'active' => true,
					'default' => false,
					'allow_multiple' => true,
					'page' => false,
					'builtin' => false,
					'per_page' => 10,
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
               	'hour_text' => __(' hour', 'recipe-press'),
               	'minute_text' => __(' min', 'recipe-press'),
               	'time_display_type' => 'double',
			);
		  $this->rpr_options = wp_parse_args(get_option('rpr_options'), $this->rpr_options_defaults);
		
          $options = get_option($this->optionsName);

          $defaults = array(
               /* Recipe Options */
               'use-plugin-permalinks' => false,
               'index-slug' => 'recipes',
               'identifier' => 'recipe',
               'permalink' => (get_option('permalink_structure')) ? '%identifier%' . get_option('permalink_structure') : '%identifier%/%postname%',
               'plural-name' => __('Recipes', 'recipe-press'),
               'plural_name' => __('Recipes', 'recipe-press'),
               'singular-name' => __('Recipe', 'recipe-press'),
               
'use-taxonomies' => true,//Deprecated
			   'use-categories'=> '1',
			   'use-cuisines'=> true,
               'use-servings' => true,
               'use-times' => true,
               'use-courses' => true,
               'use-seasons' => true,
               'use-thumbnails' => true,
               'use-featured' => true,
               'use-comments' => false,
               'use-trackbacks' => false,
               'use-custom-fields' => false,
               'use-revisions' => false,
               'use-post-categories' => false,
               'use-post-tags' => false,
               //'use-categories' => false, /* Depreciated */
               //'use-cuisines' => false, /* Depreciated */
               'plural-times' => false,
               /* Taxonomy Defaults */
               //'taxonomies' => array(
                    
                    
                 //   'recipe-course' => array('slug' => 'recipe-course', 'plural' => __('Courses', 'recipe-press'), 'singular' => __('Course', 'recipe-press'), 'hierarchical' => false, 'active' => true, 'default' => false, 'allow_multiple' => true, 'page' => false, 'builtin' => false, 'per-page' => 10)
               //),
               'ingredient-slug' => 'recipe-ingredients',
               'ingredients-per-page' => 10,
               'ingredient-page' => 0,
               /* Image Sizes */
               'image-sizes' => array(
                    'image' => array('name' => 'RecipePress Image', 'width' => 250, 'height' => 250, 'crop' => isset($options['image-sizes']['image']['crop']) ? $options['image-sizes']['image']['crop'] : true, 'builtin' => true),
                    'thumb' => array('name' => 'RecipePress Thumbnail', 'width' => 50, 'height' => 50, 'crop' => isset($options['image-sizes']['thumb']['crop']) ? $options['image-sizes']['thumb']['crop'] : true, 'builtin' => true),
               ),
               /* Display Settings */
               'menu-position' => 5,
               'default-excerpt-length' => 20,
               'recipe-count' => get_option('posts_per_page'),
               'recipe-orderby' => 'title',
               'recipe-order' => 'asc',
               'add-to-author-list' => false,
               'disable-content-filter' => false,
               'custom-css' => (count($options) > 2) ? isset($options['custom-css']) : true,
               'hour-text' => __(' hour', 'recipe-press'),
               'minute-text' => __(' min', 'recipe-press'),
               'time-display-type' => 'double',
               /* Form Defaults */
//FRONTPAGE form should be removed!!
               'form-page' => NULL,
               'form-redirect' => NULL,
               'use-form' => false,
               'form-identifier' => 'submit-recipe',
               'form-permalink' => '%identifier%',
               'form-extension' => false,
               'on-submit-redirect' => false,
               'new-recipe-status' => 'pending',
               'ingredients-fields' => 5,
               'required-fields' => array('title', 'instructions', 'name', 'email'),
               'submit-title' => 'Share a Recipe',
               'require-login' => false,

               /* Widget Defaults */
               'widget-orderby' => 'name',
               'widget-order' => 'asc',
               'widget-style' => 'list',
               'widget-show-count' => false,
               'widget-hide-empty' => (count($options) > 2) ? isset($options['widget-hide-empty']) : true,
               'widget-items' => 10,
               'widget-depth' => 0,
               'widget-pad-counts' => false,
               'widget-taxonomy' => 'recipe-category',
               'widget-type' => 'Newest',
               'widget-target' => NULL,
               'widget-show-icon' => false,
               'widget-icon-size' => 25,
               /* Printing Options */
               'use-recipe-print' => false,
               
               /* Recipe Box Options */
               'use-recipe-box' => true,
               'recipe-box-slug' => 'recipe-box',
               'recipe-box-page' => false,
               'recipe-box-title' => __('My Recipe Box', 'recipe-press'),
               'recipe-box-add-title' => __('Add To Box', 'recipe-press'),
               'recipe-box-view-title' => __('View My Box', 'recipe-press'),
               
               /* Non-Configurable Settings */
               'menu-icon' => $this->pluginURL . 'images/icons/small_logo.png',
               /* Size Settings  - DEPRICATED FOR TAXONOMY USE */
               'standard' => array(
                    'ingredient-sizes' => array('bag', 'big', 'bottle', 'box', 'bunch', 'can', 'carton', 'container', 'count', 'cup', 'clove', 'dash', 'dozen', 'drop', 'envelope', 'fluid ounce', 'gallon', 'gram', 'head', 'jar', 'large', 'pound', 'leaf', 'link', 'liter', 'loaf', 'medium', 'ounce', 'package', 'packet', 'piece', 'pinch', 'pint', 'quart', 'scoop', 'sheet', 'slice', 'small', 'sprig', 'stalk', 'stick', 'strip', 'tablespoon', 'teaspoon', 'whole'),
                    'serving-sizes' => array('cup', 'quart', 'pint', 'gallon', 'dozen', 'serving', 'piece')
               ),
               'metric' => array(
                    'ingredient-sizes' => array('drop', 'dash', 'pinch', 'teaspoon', 'desert spoon', 'tablespoon', 'fluid ounce', 'pint', 'quart', 'gallon', 'pound', 'gram', 'stone', 'ton', 'milligram', 'kilogram'),
                    'serving-sizes' => array('quart', 'pint', 'gallon', 'serving', 'piece')
               ),
               /* Nutritional Markers */
               'nutritional-markers' => array(
                    'txt_glycemic_load' => array('name' => 'Glycemic Load'),
                    'txt_calories' => array('name' => 'Calories'),
                    'txt_total_fat' => array('name' => 'Total Fat', 'size' => 'g'),
                    'txt_saturated_fat' => array('name' => 'Saturated Fat', 'size' => 'g'),
                    'txt_polyunsaturated_fat' => array('name' => 'Polyunsaturated Fat', 'size' => 'g'),
                    'txt_monounsaturated_fat' => array('name' => 'Monounsaturated Fat', 'size' => 'g'),
                    'txt_cholesterol' => array('name' => 'Cholesterol', 'size' => 'mg'),
                    'txt_sodium' => array('name' => 'Sodium', 'size' => 'mg'),
                    'txt_potassium' => array('name' => 'Potassium', 'size' => 'mg'),
                    'txt_total_carbohydrate' => array('name' => 'Total Carbohydrates', 'size' => 'g'),
                    'txt_dietary_fiber' => array('name' => 'Dietary Fiber', 'size' => 'g'),
                    'txt_sugars' => array('name' => 'Sugars', 'size' => 'g'),
                    'txt_protein' => array('name' => 'Protein', 'size' => 'g'),
               ),
          );

          $this->options = wp_parse_args($options, $defaults);

          /* Handle renaming of built-in taxonomies */
          if ( isset($this->options['taxonomies']['recipe-categories']) ) {
               $this->options['taxonomies']['recipe-category'] = $this->options['taxonomies']['recipe-categories'];
               unset($this->options['taxonomies']['recipe-categories']);
          }

          if ( isset($this->options['taxonomies']['recipe-cuisines']) ) {
               $this->options['taxonomies']['recipe-cuisine'] = $this->options['taxonomies']['recipe-cuisines'];
               unset($this->options['taxonomies']['recipe-cuisines']);
          }

          if ( $this->options['use-thumbnails'] ) {
               add_theme_support('post-thumbnails');
          }

          $this->formFieldNames = array(
               'title' => __('Recipe Name', 'recipe-press'),
               'image' => __('Recipe Image', 'recipe-press'),
               'notes' => __('Recipe Notes', 'recipe-press'),
               'recipe-category' => $this->options['taxonomies']['recipe-category']['singular'],
               'recipe-cuisine' => $this->options['taxonomies']['recipe-cuisine']['singular'],
               'servings' => __('Servings', 'recipe-press'),
               'prep_time' => __('Prep Time', 'recipe-press'),
               'cook_time' => __('Cook Time', 'recipe-press'),
               'measure_type' => __('Measurement', 'recipe-press'),
               'ingredients' => __('Ingredients', 'recipe-press'),
               'instructions' => __('Instructions', 'recipe-press'),
               
               'submitter' => __('Name', 'recipe-press'),
               'submitter_email' => __('Email', 'recipe-press'),
          );

          /* Eliminate individual taxonomies */
    /*      if ( $this->options['use-categories'] ) {
               $this->options['use-taxonomies'] = true;
               $this->options['taxonomies']['recipe-category'] = array(
                    'plural' => __('Categories', 'recipe-press'),
                    'singular' => __('Category', 'recipe-press'),
                    'hierarchical' => true,
                    'active' => true,
                    'page' => $this->options['categories-page'],
                    'converted' => true
               );
          }

          if ( $this->options['use-cuisines'] ) {
               $this->options['use-taxonomies'] = true;
               $this->options['taxonomies']['recipe-cuisine'] = array(
                    'plural' => __('Cuisines', 'recipe-press'),
                    'singular' => __('Cuisine', 'recipe-press'),
                    'hierarchical' => false,
                    'active' => true,
                    'page' => $this->options['cuisines-page'],
                    'converted' => true
               );
          }

          if ( is_array($this->options['taxonomies']) ) {
               foreach ( $this->options['taxonomies'] as $key => $taxonomy ) {
                    if ( isset($taxonomy['page']) ) {
                         $this->pageIDs[$key] = $taxonomy['page'];
                         $this->taxonomyPages[$key] = $taxonomy['page'];
                    }
               }
          } else {
               $this->options['taxonomies'] = array();
          }
*/
          if ( isset($this->options['new-recipe-status']) and $this->options['new-recipe-status'] == 'active' ) {
               $this->options['new-recipe-status'] = 'publish';
          }

          return $this->options;
     }

     /**
      * Collect recipe details from front end form.
      *
      * @global <type> $current_user
      * @param <type> $object
      * @return <type>
      */
/*     function input($data = NULL) {
          global $current_user;
          get_currentuserinfo();

          if ( !$data ) {
               $data = $_POST;
          }

          if ( count($data) == 0 ) {
               return array('ingredients' => array());
          }
          $ingredients = array();

          if ( isset($data['ingredients']) ) {
               $ingredientArray = $data['ingredients'];

               if ( is_array($ingredientArray) ) {
                    foreach ( $ingredientArray as $id => $ingredient ) {
                         if ( $id != 'NULL' and (isset($ingredient['item']) or $ingredient['size'] == 'divider') ) {
                              $ingredients[$id] = $ingredient;
                         }
                    }
               }
          } else {
               $ingredients = array();
          }

          return array(
               'title' => @$data['title'],
               'user_id' => @$data['user_id'],
               'notes' => @$data['notes'],
               'prep_time' => @$data['prep_time'],
               'cook_time' => @$data['cook_time'],
               'ready_time' => @$this->readyTime(),
               'ready_time_raw' => @$this->readyTime(NULL, NULL, false),
               'recipe-category' => @$data['recipe-category'],
               'recipe-cuisine' => @$data['recipe-cuisine'],
               'ingredients' => @$ingredients,
               'instructions' => @$data['instructions'],
               'servings' => @$data['servings'],
               'serving_size' => @$data['serving-size'],
               'status' => @$data['status'],
               'submitter' => @$data['submitter'],
               'submitter_email' => @$data['submitter_email'],
               'updated' => time(),
          );
     }
     */

     /**
      * Method to populate default taxonomy settings.
      *
      * @param array $tax
      * @return array
      */
     function taxDefaults($tax) {
          $defaults = array(
               'default' => false,
               'hierarchical' => false,
               'active' => false,
               'delete' => false,
               'allow_multiple' => false,
               'page' => false,
               'per-page' => 10,
          );

          /* Make sure the taxonomy has the singular and plural names. */
          if ( $tax['singular'] == '' ) {
               $tax['singular'] = ucwords(rpr_inflector::humanize($tax['slug']));
          }

          if ( $tax['plural'] == '' ) {
               $tax['plural'] = rpr_inflector::plural(ucwords(rpr_inflector::humanize($tax['slug'])));
          }
          return wp_parse_args($tax, $defaults);
     }

     /**
      * Method to filter the output and add the recipe details.
      *
      * @global object $post
      * @global object $wp
      * @global object $current_user
      * @param string $content
      * @return string
      */
     function the_content_filter($content) {
          global $post, $wp, $current_user;
          get_currentuserinfo();

          $files = wp_get_theme(get_option('current_theme'));

          if ( is_single ( ) ) {
               $template_file = get_stylesheet_directory() . '/single-recipe.php';
          } elseif ( is_archive ( ) ) {
               $template_file = get_stylesheet_directory() . '/archive-recipe.php';
          } else {
               $template_file = get_stylesheet_directory() . '/index-recipe.php';
          }

          if ( $post->post_type != 'recipe' or in_array($template_file, $files['Template Files']) or $this->in_shortcode ) {
               return $content;
          }

          remove_filter('the_content', array(&$this, 'the_content_filter'));

          if ( is_archive ( ) ) {
               $template = $this->get_template('recipe-archive');
          } elseif ( is_single ( ) ) {
               $template = $this->get_template('recipe-single');
          } elseif ( $post->post_type == 'recipe' and in_the_loop() ) {
               $template = $this->get_template('recipe-loop');
          } else {
               return $content;
          }

          ob_start();
          require ($template);
          $content = ob_get_contents();
          ob_end_clean();

          add_filter('the_content', array(&$this, 'the_content_filter'));

          return $content;
     }
     
     /**
      * Save the meta boxes for a recipe.
      *
      * @global <object> $postoptions
      * @param <integer> $post_id
      * @return <integer>
      */
     function save_recipe($post_id) {
          global $post;

          if ( is_object($post) and $post->post_type == 'revision' ) {
               return;
          }

          do_action('rp_before_save');

          /* Save details */
          if ( isset($_POST['recipe_details']) and isset($_POST['details_noncename']) and wp_verify_nonce($_POST['details_noncename'], 'recipe_press_details') ) {
               $details = $_POST['recipe_details'];
               $details['recipe_ready_time'] = $this->readyTime();
               $details['recipe_ready_time_raw'] = $this->readyTime(NULL, NULL, false);


               foreach ( $details as $key => $value ) {
                    $key = '_' . $key . '_value';
                    if ( get_post_meta($post_id, $key) == "" ) {
                         add_post_meta($post_id, $key, $value, true);
                    } elseif ( $value != get_post_meta($post_id, $key . '_value', true) ) {
                         update_post_meta($post_id, $key, $value);
                    } elseif ( $value == "" ) {
                         delete_post_meta($post_id, $key, get_post_meta($post_id, $key, true));
                    }
               }
          }

          /* Turn off featured if not checked */
          if ( !isset($_POST['recipe_details']['recipe_featured']) ) {
               update_post_meta($post_id, '_recipe_featured_value', 0);
          }

          /* Turn off ingredient link if not checked */
          if ( !isset($_POST['recipe_details']['recipe_link_ingredients']) ) {
               update_post_meta($post_id, '_recipe_link_ingredients_value', 0);
          }


          if ( isset($_POST['ingredients']) and isset($_POST['ingredients_noncename']) and wp_verify_nonce($_POST['ingredients_noncename'], 'recipe_press_ingredients') ) {
               $this->save_ingredients($post_id, $_POST['ingredients']);
          }

          do_action('rp_after_save');

          return $post_id;
     }

     /**
      * Save the ingredients.
      *
      * @global object $post
      * @param string $post_id
      * @param array $ingredients
      */
     function save_ingredients($post_id, $ingredients) {
          global $post;
          $detailkey = '_recipe_ingredient_value';
          $postIngredients = array();
          delete_post_meta($post_id, $detailkey);
          $ictr = 0;

          foreach ( $ingredients as $id => $ingredient ) {
               $ingredient['order'] = $ictr;

               if ( (isset($ingredient['item']) and $ingredient['item'] != -1 and $ingredient['item'] != '' and $ingredient['item'] != '0')
                       or (isset($ingredient['new-ingredient']) and $ingredient['new-ingredient'] != '') ) {

                    if ( isset($ingredient['size']) and $ingredient['size'] == 'divider' ) {
                         $ingredient['item'] = $ingredient['new-ingredient'];
                    } else {
                         /* Save ingredient taxonomy information */
                         if ( isset($ingredient['item']) ) {
                              $term = get_term_by('id', $ingredient['item'], 'recipe-ingredient');
                         } else {
                              $term = array();
                         }

                         if ( is_object($term) and !isset($term->errors) ) {
                              array_push($postIngredients, (int) $term->term_id);
                         } elseif ( isset($ingredient['new-ingredient']) and $ingredient['new-ingredient'] != '' ) {
                              $term = wp_insert_term($ingredient['new-ingredient'], 'recipe-ingredient');
                              if ( isset($term->errors) ) {
                                   $ingredient['item'] = $term->error_data['term_exists'];
                              } else {
                                   $ingredient['item'] = $term['term_id'];
                              }

                              $term = get_term_by('id', $ingredient['item'], 'recipe-ingredient');
                              array_push($postIngredients, $term->slug);
                         }
                    }
                    unset($ingredient['new-ingredient']);

                    add_post_meta($post_id, $detailkey, $ingredient, false);
               }
               ++$ictr;
          }

          wp_set_object_terms($post_id, $postIngredients, 'recipe-ingredient', false);
     }

     /**
      * Retrieve a template file from either the theme or the plugin directory.
      *
      * @param <string> $template    The name of the template.
      * @return <string>             The full path to the template file.
      */
     function get_template($template = NULL, $ext = '.php', $type = 'path') {
          if ( $template == NULL ) {
               return false;
          }

          $themeFile = get_stylesheet_directory() . '/' . $template . $ext;
          $folder = '/';

          if ( !file_exists($themeFile) ) {
               $themeFile = get_stylesheet_directory() . '/recipe-press/' . $template . $ext;
               $folder = '/recipe-press/';
          }

          if ( file_exists($themeFile) and !$this->in_shortcode ) {
               if ( $type == 'url' ) {
                    $file = get_bloginfo('template_url') . $folder . $template . $ext;
               } else {
                    $file = get_stylesheet_directory() . $folder . $template . $ext;
               }
          } elseif ( $type == 'url' ) {
               $file = $this->templatesURL . $template . $ext;
          } else {
               $file = $this->templatesPath . $template . $ext;
          }

          return $file;
     }
      
     /**
      * Get the ingredients stored in the post meta.
      *
      * @global <object> $post   If no ID is specified, use the preloaded post object.
      * @param <integer> $post   ID of the post, NOT the post object.
      * @return <array>
      */
     function getIngredients($post = NULL) {
          if ( !$post ) {
               global $post;
          }

          $ingredients = get_post_meta($post->ID, '_recipe_ingredient_value');

          if ( count($ingredients) < 1 ) {
               return $this->emptyIngredients($this->options['ingredients-fields']);
          } else {
               $ings = array();

               $defaults = array(
                    'quantity' => NULL,
                    'size' => 0,
                    'item' => 0,
                    'notes' => NULL,
                    'page-link' => NULL,
                    'url' => NULL,
                    'order' => 0
               );


               foreach ( $ingredients as $ingredient ) {
                    $ings[$ingredient['order']] = $ingredient;
                    wp_parse_args($ings[$ingredient['order']], $defaults);
               }


               ksort($ings);
               return $ings;
          }
     }

     /**
      * Return an empty array for creating ingredients form on new posts.
      *
      * @param <integer> $count
      * @return <array>
      */
     function emptyIngredients($count = 5) {
          $ingredients = array();
          for ( $ctr = 0; $ctr < $count; ++$ctr ) {
               $ingredients[$ctr]['size'] = 'none';
               $ingredients[$ctr]['item'] = 0;
          }

          return $ingredients;
     }

     /**
      * Calculate the ready time for a recipe.
      *
      * @param <integer> $prep   The prep time.
      * @param <integer> $cook   The cook time.
      * @return <string>         Formatted ready time.
      */
     function readyTime($prep = NULL, $cook = NULL, $formatted = true) {
          if ( !isset($prep) ) {
               $prep = isset($_POST['recipe_details']['recipe_prep_time']) ? $_POST['recipe_details']['recipe_prep_time'] : 0;
          }

          if ( !isset($cook) ) {
               $cook = isset($_POST['recipe_details']['recipe_cook_time']) ? $_POST['recipe_details']['recipe_cook_time'] : 0;
          }

          $hplural = '';
          $mplural = '';

          $total = $prep + $cook;

          if ( $total > 60 ) {
               $hours = floor($total / 60);

               if ( $hours > 1 and $this->options['plural-times'] )
                    $hplural = 's';
               else
                    $mplural = '';

               $hours = $hours . ' ' . $this->options['hour-text'] . $hplural . ', ';
          } else {
               $hours = '';
          }

          $mins = $total - ( $hours * 60);

          if ( $mins > 1 and $this->options['plural-times'] )
               $mplural = 's';
          else
               $mplural = '';

          if ($formatted) {
               return $hours . $mins . ' ' . $this->options['minute-text'] . $mplural;
          } else {
               return $total;
          }
     }

     /**
      * Create a help icon on the administration pages.
      *
      * @param <string> $text
      */
     function help($text) {
          echo '<img src="' . $this->pluginURL . 'images/icons/help.jpg" align="absmiddle" onmouseover="return overlib(\'' . $text . '\');" onmouseout="return nd();" />';
     }

     /**
      * Displayes any data sent in textareas.
      *
      * @param <type> $input
      */
     function debug($input) {
          $contents = func_get_args();

          foreach ( $contents as $content ) {
               print '<textarea style="width:49%; height:250px; float: left;">';
               print_r($content);
               print '</textarea>';
          }

          echo '<div style="clear: both"></div>';
     }

}
