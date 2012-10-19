<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * taxonomy-form.php - category widget form.
 *
 * @package RecipePress
 * @subpackage widgets
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 2.2
 */
?>

<p>
     <label for="<?php echo $this->get_field_id('title'); ?>">
          <?php _e('Widget Title (optional)', 'recipe-press'); ?> : 
     </label>
     <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
</p>
<p>
     <label for="<?php echo $this->get_field_id('taxonomy'); ?>">
          <?php _e('Taxonomy to display', 'recipe-press'); ?> :
     </label>
     <select name="<?php echo $this->get_field_name('taxonomy'); ?>" id="<?php echo $this->get_field_id('taxonomy'); ?>">
          <?php $this->taxonomy_dropdown($instance['taxonomy']); ?>
     </select>
</p>
<p>
     <label for="<?php echo $this->get_field_id('style'); ?>">
          <?php _e('Display style', 'recipe-press'); ?> :
     </label>
     <select name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>">
          <option value="list" <?php selected($instance['style'], 'list'); ?>><?php _e('List', 'recipe-press'); ?></option>
          <option value="image" <?php selected($instance['style'], 'image'); ?>><?php _e('Thumbnails', 'recipe-press'); ?></option>
     </select>
</p>
<p>
     <label for="<?php echo $this->get_field_id('items'); ?>"><?php _e('Display', 'recipe-press'); ?></label>
     <select name="<?php echo $this->get_field_name('items'); ?>" id="<?php echo $this->get_field_id('items'); ?>" style="width:50px;">
          <option value="all" <?php selected($instance['items'], 'all'); ?>><?php _e('All Terms', 'recipe-press'); ?></option>
          <?php
          for ( $i = 1; $i <= 20; ++$i ) echo "<option value='$i' " . ( $instance['items'] == $i ? "selected='selected'" : '' ) . ">$i</option>";
          ?>
     </select>

     <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('entries sorted by:', 'recipe-press'); ?></label>
     <select name="<?php echo $this->get_field_name('orderby'); ?>" id="<?php echo $this->get_field_id('orderby'); ?>">
          <option value="name" <?php selected($instance['orderby'], 'name'); ?> ><?php _e('Name', 'recipe-press'); ?></option>
          <option value="count" <?php selected($instance['orderby'], 'count'); ?> ><?php _e('Count', 'recipe-press'); ?></option>
     </select>
     <select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>">
          <option value="asc" <?php selected($instance['order'], 'asc'); ?> ><?php _e('Ascending', 'recipe-press'); ?></option>
          <option value="desc" <?php selected($instance['order'], 'desc'); ?> ><?php _e('Descending', 'recipe-press'); ?></option>
     </select>
</p>
<p>
     <input type="checkbox" name="<?php echo $this->get_field_name('show-count'); ?>" id ="<?php echo $this->get_field_id('show-count'); ?>" <?php checked($instance['show-count'], 1); ?> value="1" />
     <label for="<?php echo $this->get_field_id('show-count'); ?>">
          <?php _e('Show counts with', 'recipe-press'); ?>
     </label>
     <label>
          <input id="<?php echo $this->get_field_id('before-count'); ?>" name="<?php echo $this->get_field_name('before-count'); ?>" type="text" value="<?php echo $instance['before-count']; ?>" style="width:25px;" />
          <?php _e(' before and ', 'recipe-press'); ?>
     </label>
     <label>
          <input id="<?php echo $this->get_field_id('after-count'); ?>" name="<?php echo $this->get_field_name('after-count'); ?>" type="text" value="<?php echo $instance['after-count']; ?>" style="width:25px;" />
          <?php _e(' after.', 'recipe-press'); ?>
     </label>
</p>
<p>
     <input type="checkbox" name="<?php echo $this->get_field_name('show-view-all'); ?>" id ="<?php echo $this->get_field_id('show-view-all'); ?>" <?php checked($instance['show-view-all'], 1); ?> value="1" />
     <label for="<?php echo $this->get_field_id('show-view-all'); ?>">
          <?php _e('Show option to view all entries', 'recipe-press'); ?>
     </label>
     <label>
          <input id="<?php echo $this->get_field_id('view-all-text'); ?>" name="<?php echo $this->get_field_name('view-all-text'); ?>" type="text" value="<?php echo $instance['view-all-text']; ?>" />
          <?php _e('', 'recipe-press'); ?>
     </label>
</p>
<p>
     <label for="<?php echo $this->get_field_id('target'); ?>">
          <?php _e('Link Target:', 'recipe-press'); ?>
     </label>
     <select name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>">
          <option value="none" <?php selected($instance['target'], 'none'); ?>><?php _e('None', 'recipe-press'); ?></option>
          <option value="_blank" <?php selected($instance['target'], '_blank'); ?>><?php _e('New Window', 'recipe-press'); ?></option>
          <option value="_top" <?php selected($instance['target'], '_top'); ?>><?php _e('Top Window', 'recipe-press'); ?></option>
     </select>
</p>
<p>
     <input name="<?php echo $this->get_field_name('submit_link'); ?>" type="checkbox" id="<?php echo $this->get_field_id('submit_link'); ?>" value="Y" <?php checked($instance['submit_link'], 'Y'); ?> />
     <label for="<?php echo $this->get_field_id('submit_link'); ?>"><?php _e('Add link to Submit form?', 'recipe-press'); ?></label>
</p>
<h3><?php _e('Custom Class Names', 'recipe-press'); ?></h3>
<p>
     <label for="<?php echo $this->get_field_id('list-class'); ?>">
          <?php _e('Widget list class', 'recipe-press'); ?> :
     </label>
     <input id="<?php echo $this->get_field_id('list-class'); ?>" name="<?php echo $this->get_field_name('list-class'); ?>" type="text" value="<?php echo $instance['list-class']; ?>" />
</p>
<p>
     <label for="<?php echo $this->get_field_id('item-class'); ?>">
          <?php _e('Widget item class', 'recipe-press'); ?> :
     </label>
     <input id="<?php echo $this->get_field_id('item-class'); ?>" name="<?php echo $this->get_field_name('item-class'); ?>" type="text" value="<?php echo $instance['item-class']; ?>" />
</p>
<p>
     <label for="<?php echo $this->get_field_id('child-class'); ?>">
          <?php _e('Widget child class', 'recipe-press'); ?> :
     </label>
     <input id="<?php echo $this->get_field_id('child-class'); ?>" name="<?php echo $this->get_field_name('child-class'); ?>" type="text" value="<?php echo $instance['child-class']; ?>" />
</p>