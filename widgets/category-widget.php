<?php

if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}

/**
 * category-widget.php - sidebar widget for displaying recipe categories.
 *
 * @package RecipePress
 * @subpackage widgets
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 1.0
 */
class rp_Widget_Category extends WP_Widget {

     var $options = array();

     /**
      * Constructor
      */
     function rp_Widget_Category() {
          global $RECIPEPRESSOBJ;
          load_plugin_textdomain('recipe-press', false, dirname(dirname(plugin_basename(__FILE__))) . '/lang');

          /* translators: The description of the Category List widget on the Appearance->Widgets page. */
          $widget_ops = array('description' => __('List recipe categories on your sidebar. By GrandSlambert.', 'recipe-press'));
          /* translators: The title for the Category List widget. */
          $this->WP_Widget('recipe_press_category_widget', __('RecipePress &raquo; Categories', 'recipe-press'), $widget_ops);

          $this->pluginPath = WP_CONTENT_DIR . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/';
          $this->options = $RECIPEPRESSOBJ->loadSettings();
     }

     /**
      * Get Instance Defaults
      */
     function defaults($instance) {
          $defaults = array(
               'title' => '',
               'items' => isset($this->options['widget-items']) ? $this->options['widget-items'] : 0,
               'linktarget' => $this->options['widget-target'],
               'order-by' => $this->options['widget-sort'],
               'show-icon' => isset($this->options['show-icon']),
               'icon-size' => isset($this->options['icon-size']) ? $this->options['icon-size'] : 25,
               'target' => $this->options['widget-target'],
               'show-count' => false,
               'before-count' => '(',
               'after-count' => ')',
               'submit_link' => false,
               'li-class' => 'recipe-press-category-list',
          );

          return wp_parse_args($instance, $defaults);
     }

     /**
      * Widget code
      */
     function widget($args, $instance) {
          global $RECIPEPRESSOBJ;

          if ( isset($instance['error']) && $instance['error'] ) {
               return;
          }

          $instance = $this->defaults($instance);

          extract($args, EXTR_SKIP);

          $options = array(
               'number' => $instance['items'],
               'hierarchical' => true,
               'pad_counts' => false,
               'include' => get_published_categories('recipe-category')
          );

          switch ($instance['order-by']) {
               case 'count':
                    $options['orderby'] = 'count';
                    $options['order'] = 'desc';
                    break;
               case 'random':
                    $options['orderby'] = 'rand()';
                    break;
               default:
                    $options['orderby'] = 'name';
                    break;
          }

          $categories = get_terms('recipe-category', $options);

          echo $before_widget;
          if ( $instance['title'] ) {
               echo $before_title . $instance['title'] . $after_title;
          }

          echo '<ul class="rp_widget_category_list">';

          foreach ( $categories as $category ) {
               echo '<li class="' . $instance['li-class'] . '"><a href="' . get_term_link($category, 'recipe-category') . '" target="' . $instance['target'] . '">' . $category->name;
               if ( $instance['show-count'] ) {
                    echo $instance['before-count'] . $category->count . $instance['after-count'];
               }
               echo '</a></li>';
          }

          if ( $instance['submit_link'] )
               echo '<li class="recipe-submit"><a href="' . get_page_link($this->options['form-page']) . '">' . $this->options['submit-title'] . '</a></li>';

          echo '</ul>';
          echo $after_widget;
     }

     /** @see WP_Widget::form */
     function form($instance) {
          $instance = $this->defaults($instance);
          include( $this->pluginPath . 'category-form.php');
     }

}

add_action('widgets_init', create_function('', 'return register_widget("rp_Widget_Category");'));