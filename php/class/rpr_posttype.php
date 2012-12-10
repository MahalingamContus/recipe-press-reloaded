<?php
if (!function_exists('is_admin')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit ();
}

if (!class_exists("RPR_Posttype")): 
class RPR_Posttype {
	var $options;
	
	public function __construct() {
		$this->options = new RPR_Options();
	}
	
	//Initialize the posttype (and related taxonomies...) 
	public function init(){
		$this->create_post_type();
	}
	
	//Create the post type 'recipe'
	function create_post_type() {
          $labels = array(
               'name' => $this->options->getOption('plural_name'),
               'singular_name' => $this->options->getOption('singular_name'),
               'add_new' => __('Add New', 'recipe-press-reloaded'),
               'add_new_item' => sprintf(__('Add New %1$s', 'recipe-press-reloaded'), $this->options->getOption('singular_name')),
               'edit_item' => sprintf(__('Edit %1$s', 'recipe-press-reloaded'), $this->options->getOption('singular_name')),
               'edit' => __('Edit', 'recipe-press-reloaded'),
               'new_item' => sprintf(__('New %1$s', 'recipe-press-reloaded'), $this->options->getOption('singular_name')),
               'view_item' => sprintf(__('View %1$s', 'recipe-press-reloaded'), $this->options->getOption('singular_name')),
               'search_items' => sprintf(__('Search %1$s', 'recipe-press-reloaded'), $this->options->getOption('singular_name')),
               'not_found' => sprintf(__('No %1$s found', 'recipe-press-reloaded'), $this->options->getOption('plural_name')),
               'not_found_in_trash' => sprintf(__('No %1$s found in Trash', 'recipe-press-reloaded'), $this->options->getOption('plural_name')),
               'view' => sprintf(__('View %1$s', 'recipe-press-reloaded'), $this->options->getOption('singular_name')),
               'parent_item' => sprintf(__('Parent %1$s', 'recipe-press-reloaded'), $this->options->getOption('singular_name')),
               'parent_item_colon' => sprintf(__('Parent %1$s:', 'recipe-press-reloaded'), $this->options->getOption('singular_name')),
          );
          $args = array(
               'labels' => $labels,
               'public' => true,
               'publicly_queryable' => true,
               'show_ui' => true,
               'query_var' => true,
               'capability_type' => 'page',
               'hierarchical' => false,
               'menu_position' => (int) $this->options->getOption('menu_position'),
               'menu_icon' => $this->options->getOption('menu_icon'),
               'supports' => array('title', 'editor', 'author', 'excerpt', 'page-attributes'),
               //'register_meta_box_cb' => array(&$this, 'init_metaboxes'),
          );
/*
          if ( $this->rpr_options['use_custom_fields'] ) {
               $args['supports'][] = 'custom-fields';
          }

          if ( $this->rpr_options['use_thumbnails'] ) {
               $args['supports'][] = 'thumbnail';
          }

          if ( $this->rpr_options['use_comments'] ) {
               $args['supports'][] = 'comments';
          }

          if ( $this->rpr_options['use_trackbacks'] ) {
               $args['supports'][] = 'trackbacks';
          }

          if ( $this->rpr_options['use_revisions'] ) {
               $args['supports'][] = 'revisions';
          }

          if ( $this->rpr_options['use_post_tags'] ) {
               $args['taxonomies'][] = 'post_tag';
          }

          if ( $this->rpr_options['use_post_categories'] ) {
               $args['taxonomies'][] = 'category';
          }

        //  if (  !$this->options['use-plugin-permalinks'] ) {
               $args['rewrite'] = true;
               $args['has_archive'] = $this->rpr_options['index_slug'];
         // }
 */        
          register_post_type('recipe', $args);
     }
}
endif;
?>