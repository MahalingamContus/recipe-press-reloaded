<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * category-form.php - category widget form.
 *
 * @package RecipePress
 * @subpackage widgets
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 1.0
 */
?>

<p>
     <label for="<?php echo $this->get_field_id('title'); ?>">
<?php _e('Widget Title (optional):', 'recipe-press'); ?>
     </label>
     <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
</p>
<p>
     <label for="rss-items-4"><?php _e('How many categories would you like to display?', 'recipe-press'); ?></label>
     <select name="<?php echo $this->get_field_name('items'); ?>" id="<?php echo $this->get_field_id('items'); ?>">
          <option value="default" <?php selected($instance['items'], 'default'); ?>><?php _e('Always use default', 'recipe-press'); ?></option>
          <?php
          for ( $i = 1; $i <= 20; ++$i ) echo "<option value='$i' " . ( $instance['items'] == $i ? "selected='selected'" : '' ) . ">$i</option>";
          ?>
     </select>
</p>
<p>
     <label for="<?php echo $this->get_field_id('order-by'); ?>"><?php _e('Sort by:', 'recipe-press'); ?></label>
     <select name="<?php echo $this->get_field_name('order-by'); ?>" id="<?php echo $this->get_field_id('order-by'); ?>">
          <option value="name" <?php selected($instance['order-by'], 'name'); ?> ><?php _e('Category Name', 'recipe-press'); ?></option>
          <option value="count" <?php selected($instance['order-by'], 'count'); ?> ><?php _e('Recipe count', 'recipe-press'); ?></option>
          <option value="random" <?php selected($instance['order-by'], 'random'); ?> ><?php _e('Random Order', 'recipe-press'); ?></option>
     </select>
</p>
<p>
     <label for="<?php echo $this->get_field_id('show-count'); ?>">
          <input type="checkbox" name="<?php echo $this->get_field_name('show-count'); ?>" id ="<?php echo $this->get_field_id('show-count'); ?>" <?php checked($instance['show-count'], 1); ?> value="1" />
<?php _e('Show Count?', 'recipe-press'); ?>
     </label>
</p>
<p>
     <label for="<?php echo $this->get_field_id('before-count'); ?>">
<?php _e('Text before count (optional):', 'recipe-press'); ?>
     </label>
     <input class="widefat" id="<?php echo $this->get_field_id('before-count'); ?>" name="<?php echo $this->get_field_name('before-count'); ?>" type="text" value="<?php echo $instance['before-count']; ?>" />
</p>
<p>
     <label for="<?php echo $this->get_field_id('after-count'); ?>">
<?php _e('Test after count (optional):', 'recipe-press'); ?>
     </label>
     <input class="widefat" id="<?php echo $this->get_field_id('after-count'); ?>" name="<?php echo $this->get_field_name('after-count'); ?>" type="text" value="<?php echo $instance['after-count']; ?>" />
</p>
<p>
     <label for="<?php echo $this->get_field_id('target'); ?>">
<?php _e('Link Target:', 'recipe-press'); ?>
     </label>
     <select name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>">
          <option value=""><?php _e('None', 'recipe-press'); ?></option>
          <option value="_blank" <?php selected($instance['target'], '_blank'); ?>><?php _e('New Window', 'recipe-press'); ?></option>
          <option value="_top" <?php selected($instance['target'], '_top'); ?>><?php _e('Top Window', 'recipe-press'); ?></option>
     </select>
</p>
<p>
     <label for="<?php echo $this->get_field_id('submit_link'); ?>"><?php _e('Add link to Submit form?', 'recipe-press'); ?></label>
     <input name="<?php echo $this->get_field_name('submit_link'); ?>" type="checkbox" id="<?php echo $this->get_field_id('submit_link'); ?>" value="Y" <?php checked($instance['submit_link'], 'Y'); ?> />
</p>
