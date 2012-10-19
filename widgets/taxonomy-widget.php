<?php

if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}

/**
 * taxonomy-widget.php - sidebar widget for displaying recipe taxonomies.
 *
 * @package RecipePress
 * @subpackage widgets
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 2.2
 */
class recipe_press_taxonomy_widget extends WP_Widget {

     var $recipePress;
     var $options = array();

     /**
      * Constructor
      */
     function recipe_press_taxonomy_widget() {
          load_plugin_textdomain('recipe-press', false, dirname(dirname(plugin_basename(__FILE__))) . '/lang');

          /* translators: The description of the Category List widget on the Appearance->Widgets page. */
          $widget_ops = array('description' => __('List recipe taxonomies on your sidebar. By GrandSlambert.', 'recipe-press'));
          $control_ops = array('width' => 400, 'height' => 350);
          /* translators: The title for the Taxonomy List widget. */
          $this->WP_Widget('recipe_press_taxonomy_widget', __('RecipePress &raquo; Taxonomies', 'recipe-press'), $widget_ops, $control_ops);

          /* Plugin Folders */
          $this->pluginPath = WP_PLUGIN_DIR . '/' . basename(dirname(dirname(__FILE__))) . '/';
          $this->pluginURL = WP_PLUGIN_URL . '/' . basename(dirname(dirname(__FILE__))) . '/';
          $this->templatesPath = WP_PLUGIN_DIR . '/' . basename(dirname(dirname(__FILE__))) . '/templates/';
          $this->templatesURL = WP_PLUGIN_URL . '/' . basename(dirname(dirname(__FILE__))) . '/templates/';

          include ($this->pluginPath . 'php/class/custom-walkers.php');
          require_once ($this->pluginPath . 'php/class/rpr_core.php');
          $this->recipePress = new RPR_Core();
     }

     /**
      * Get Instance Defaults
      */
     function defaults($instance) {
          $defaults = array(
               'orderby' => $this->recipePress->options['widget-orderby'],
               'order' => $this->recipePress->options['widget-order'],
               'style' => $this->recipePress->options['widget-style'],
               'thumbnail_size' => 'recipe-press-thumb',
               'hide-empty' => $this->recipePress->options['widget-hide-empty'],
               'exclude' => NULL,
               'include' => NULL,
               'taxonomy' => 'recipe-category',
               'title' => '',
               'items' => $this->recipePress->options['widget-items'],
               'show-count' => false,
               'before-count' => ' ( ',
               'after-count' => ' ) ',
               'show-view-all' => false,
               'view-all-text' => '&darr; ' . __('View All', 'recipe-press'),
               'submit_link' => false,
               'list-class' => 'recipe-press-taxonomy-widget',
               'item-class' => 'recipe-press-taxonomy-item',
               'child-class' => 'recipe-press-child-item',
               'target' => 'none',
          );

          return wp_parse_args($instance, $defaults);
     }

     /**
      * Widget code
      */
     function widget($args, $instance) {
          global $this_instance;

          if ( isset($instance['error']) && $instance['error'] ) {
               return;
          }

          $this_instance = $this->defaults($instance);
          $instance = $this->defaults($instance);
          extract($args, EXTR_SKIP);

          echo $before_widget;
          if ( $instance['title'] ) {
               echo $before_title . $instance['title'] . $after_title;
          }

          if ( $instance['style'] == 'list' ) {
               echo '<ul id="the_' . $args['widget_id'] . '" class="' . $instance['list-class'] . '">';
          } else {
               echo '<div id="the_' . $args['widget_id'] . '" class="' . $instance['list-class'] . '-' . $instance['style'] . '">';
          }

          $taxArgs = array(
               'orderby' => $instance['orderby'],
               'order' => $instance['order'],
               'style' => $instance['style'],
               'show_count' => $instance['show-count'],
               'hide_empty' => $instance['hide-empty'],
               'use_desc_for_title' => 1,
               'child_of' => 0,
               'exclude' => $instance['exclude'],
               'include' => get_published_categories($instance['taxonomy']),
               'hierarchical' => ($instance['taxonomy'] == 'recipe-ingredient' or $instance['style'] != 'list') ? false : $this->recipePress->options['taxonomies'][$instance['taxonomy']]['hierarchical'],
               'title_li' => '',
               'show_option_none' => __('No categories'),
               'number' => $instance['items'],
               'echo' => 1,
               'depth' => 0,
               'current_category' => 0,
               'pad_counts' => false,
               'taxonomy' => $instance['taxonomy'],
               'walker' => new Walker_RP_Taxonomy
          );

          wp_list_categories($taxArgs);

          if ( $instance['style'] == 'list' ) {
               echo '</ul>';
          } else {
               echo '</div>';
          }

          echo '<div class="cleared" style="clear:both"></div>';

          if ( $instance['taxonomy'] == 'recipe-ingredient' ) {
               $slug = $this->recipePress->options['ingredient-slug'];
          } else {
               $slug = $this->recipePress->options['taxonomies'][$instance['taxonomy']]['slug'];
          }

          if ( $instance['show-view-all'] ) {
               echo '<p id="view_all_' . $args['widget_id'] . '" class="recipe-press-view-all"><a href="' . get_home_url() . '/' . $slug . '" onclick="return recipe_press_view_all_tax(\'' . $instance['taxonomy'] . '\', \'' . $args['widget_id'] . '\')">' . $instance['view-all-text'] . '</a></p>';
          }

          echo $after_widget;
     }

     /** @see WP_Widget::form */
     function form($instance) {
          $instance = $this->defaults($instance);
          include( $this->pluginPath . 'widgets/taxonomy-form.php');
     }

     /**
      * Retern a list of select options for all taxonomies.
      * 
      * @param string $selected
      * @return string 
      */
     function taxonomy_dropdown($selected, $echo = true) {
          $output = '';

          foreach ( $this->recipePress->options['taxonomies'] as $taxonomy => $settings ) {
               $output.= '<option value="' . $taxonomy . '" ' . selected($instance['taxonomy'], $taxonomy, true) . '>' . $settings['plural'] . "</option>\n";
          }

          $output.= '<option value="recipe-ingredient" ' . selected($selected, 'recipe-ingredient') . '>' . __('Ingredients', 'recipe-press') . "</option>\n";

          if ( $echo ) {
               echo $output;
          } else {
               return $output;
          }
     }

}

add_action('widgets_init', create_function('', 'return register_widget("recipe_press_taxonomy_widget");'));