<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}

/**
 * list-widget.php - sidebar widget for listing recipes.
 *
 * @package RecipePress
 * @subpackage widgets
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 1.0
 */
class rp_Widget_List_Recipes extends WP_Widget {

     var $options = array();

     /**
      * Constructor
      */
     function rp_Widget_List_Recipes() {
          global $RECIPEPRESSOBJ;

          load_plugin_textdomain('recipe-press', false, dirname(dirname(plugin_basename(__FILE__))) . '/lang');

          /* translators: The description of the Recpipe List widget on the Appearance->Widgets page. */
          $widget_ops = array('description' => __('List recipes on your sidebar. By GrandSlambert.', 'recipe-press'));
          /* translators: The title for the Recipe List widget. */
          $this->WP_Widget('recipe_press_list_widget', __('RecipePress &raquo; List', 'recipe-press'), $widget_ops);

          $this->pluginPath = WP_CONTENT_DIR . '/plugins/' . plugin_basename(dirname(__FILE__)) . '/';
          $this->options = $RECIPEPRESSOBJ->loadSettings();
     }

     function defaults($args = array()) {
          $defaults = array(
               'title' => '',
               'items' => $this->options['widget-items'],
               'type' => $this->options['widget-type'],
               'sort_order' => $this->options['widget-sort'],
               'category' => false,
               'submit_link' => false,
               'linktarget' => $this->options['widget-target'],
               'show-icon' => isset($args['items']) ? isset($args['show-icon']) : isset($this->options['widget-show-icon']),
               'icon-size' => $this->options['widget-icon-size'],
               'li-class' => 'recipe-press-list-class',
          );

          return wp_parse_args($args, $defaults);
     }

     /**
      * Widget code
      */
     function widget($args, $instance) {
          if ( isset($instance['error']) && $instance['error'] ) {
               return;
          }

          extract($args, EXTR_SKIP);
          $instance = $this->defaults($instance);

          if ( $instance['items'] < 1 or $instance['items'] > 20 ) {
               $instance['items'] = $this->options['widget-items'];
          }

          if ( isset($this->options['form-page']) ) {
               $page = get_page($this->options['form-page']);
          }

          echo $before_widget;

          if ( $instance['title'] ) {
               echo $before_title . $instance['title'] . $after_title;
          }

          echo '<ul class="recipe-widget-list">';

          $options = array(
               'post_type' => 'recipe',
               'order' => $instance['sort_order'],
               'numberposts' => $instance['items'],
          );

          switch ($instance['type']) {
               case 'newest':
                    $options['ordeby'] = 'date';
                    $options['order'] = 'desc';
                    break;
               case 'random':
                    $options['orderby'] = 'rand';
                    break;
               case 'featured':
                    $options['meta_key'] = '_recipe_featured_value';
                    $options['meta_value'] = 1;
                    break;
               case 'updated':
                    $options['orderby'] = 'modified';
                    break;
               default:
                    break;
          }

          $recipes = get_posts($options);

          foreach ( $recipes as $recipe ) :
?>
               <li class="<?php echo $instance['li-class']; ?>">
     <?php
               if ( $instance['show-icon'] && function_exists('has_post_thumbnail') && has_post_thumbnail($recipe->ID) ) {
                    echo get_the_post_thumbnail($recipe->ID, array($instance['icon-size'], $instance['icon-size']));
               }
     ?>
               <a href="<?php echo get_post_permalink($recipe->ID); ?>" target="<?php echo $instance['target']; ?>"><?php echo apply_filters('the_title', $recipe->post_title); ?></a>
          </li>
<?php
               endforeach;

               if ( $instance['submit_link'] == 'Y' and isset($page) ) {
                    echo '<li class="' . $instance['li-class'] . '"><a href="' . get_page_link($page->ID) . '">' . $this->options['submit-title'] . '</a></li>';
               }

               echo '</ul>';
               echo $after_widget;
          }

          /** @see WP_Widget::form */
          function form($instance) {
               global $RECIPEPRESSOBJ;

               $instance = $this->defaults($instance);
               include( $this->pluginPath . 'list-form.php');
          }

     }

     add_action('widgets_init', create_function('', 'return register_widget("rp_Widget_List_Recipes");'));