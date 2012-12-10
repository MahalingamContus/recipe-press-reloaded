<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}

ini_set('error_reporting', 'E_WARNING');
/**
 * settings.php - View for the Settings page.
 *
 * @package RecipePress Reloaded
 * @subpackage includes
 * @author dasmaeh
 * @copyright 2012
 * @access public
 * @since 1.0
 */
/* Flush the rewrite rules */
//global $wp_rewrite;
//$wp_rewrite->flush_rules();

//global $RECIPEPRESSOBJ;
//var_dump($RECIPEPRESSOBJ);

?>
<!-- move this to somewhere else -->
<script type="text/javascript">
var confirmText="<?php _e('Are you sure you want to  delete this taxonomy?', 'recipe-press-reloaded'); ?>";
</script>
<div class="wrap">
	<?php if ( ( isset( $_GET[ 'updated' ] ) && $_GET[ 'updated' ] == 'true' ) || ( isset( $_GET[ 'settings-updated' ] ) && $_GET[ 'settings-updated' ] == 'true' ) ):
		$msg = __( 'Settings updated', 'recipe-press' );
		echo '<div id="message" style="width:94%;" class="message updated"><p><strong>' . $msg . '.</strong></p></div>';
	endif; ?>
	
	<div class="icon32" id="icon-edit"><br/></div>
	<h2><?php echo $this->pluginName; ?> &raquo; <?php _e('Plugin Settings', 'recipe-press-reloaded'); ?> </h2> 
	<!-- Tab Menu -->
	<nav id="rpr-tab-menu">
		<a class="nav-tab" id="general-tab" href="#top#general"><?php _e( 'General', 'recipe-press-reloaded' );?></a>
		<a class="nav-tab" id="taxonomies-tab" href="#top#taxonomies"><?php _e( 'Taxonomies', 'recipe-press-reloaded' );?></a>
		<a class="nav-tab" id="display-tab" href="#top#display"><?php _e( 'Display', 'recipe-press-reloaded' );?></a>
		<a class="nav-tab" id="admin-display-tab" href="#top#admin-display"><?php _e( 'Admin Display', 'recipe-press-reloaded' );?></a>
	</nav>
	
	<?php echo '<form action="' . admin_url( 'options.php' ) . '" method="post" id="rpr-conf">';?>
	
		<div id="general" class="rpr-tab" >
			<?php settings_fields('rpr_options'); ?>
			<?php do_settings_sections('general'); ?>
		</div>
		
		<div id="taxonomies" class="rpr-tab">
			<nav id="rpr-sub-tab-menu">
			<?php foreach($this->options['taxonomies'] as $key => $tax ): ?>
				<a class="nav-tab" id="rpr-taxonomies-<?php echo $key; ?>-sub-tab" href="#top#taxonomies#<?php echo $key; ?>"><?php echo $tax['singular_name']; ?></a>
			<?php endforeach; ?>
				<a class="nav-tab new" id="rpr-taxonomies-new-sub-tab" href="#top#taxonomies#new">+</a>
			</nav>
			
			<?php foreach($this->options['taxonomies'] as $key => $tax ): ?>
				<div id="rpr-taxonomies-<?php echo $key; ?>" class="rpr-sub-tab">
					<?php do_settings_sections('taxonomies_'.$key); ?>
				</div>
			<?php endforeach; ?>
			<div id="rpr-taxonomies-new" class="rpr-sub-tab">
				<p class="notice widefat"><?php _e("<b>IMPORTANT:</b> To create a new taxonomy you must set 'slug', 'singular name' and 'plural name'!", "recipe-press-reloaded");?></p>
				<?php do_settings_sections('taxonomies_new'); ?>
			</div>
			
		</div>
		
		<div id="display" class="rpr-tab">
			<?php do_settings_sections('display'); ?>
		</div>
		
		<div id="admin-display" class="rpr-tab">
			<?php do_settings_sections('admin_post_list'); ?>
		</div>

		<?php submit_button(__('Save Changes'), 'primary', 'rpr_submit'); ?>
	</form>
</div>

