<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}

/**
 * recipe-archive.php - The Template for displaying all recipe archives.
 *
 * @package RecipePress
 * @subpackage templates
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 1.0
 */
global $wp_query;
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('recipe'); ?>>
    <?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) : ?>
        <div class="recipe-press-image align-left">
            <a href="<?php the_permalink();?>"><?php the_post_thumbnail('recipe-press-image'); ?></a>
        </div>
    <?php endif; ?> 
    <p class="recipe-notes"><?php the_recipe_introduction(array('length' => '5000')); ?></p>
        <?php if ( use_recipe_categories() ) :?>
            <span class="recipe-category">
                <?php _e('Posted in: ', 'recipe-press');
                the_terms(get_the_id(), 'recipe-category');?>
            </span><br/>
        <?php endif; ?>
        <?php if ( use_recipe_cuisines() ): ?>
            <span class="recipe-cuisine">
                <?php _e('from: ', 'recipe-press');
                the_terms(get_the_id(), 'recipe-cuisine');?>
            </span><br/>
        <?php endif; ?>
        <?php if ( use_recipe_seasons() ): ?>
            <span class="recipe-season">
                <?php _e('Season: ', 'recipe-press');
                the_terms(get_the_id(), 'recipe-season');?>
            </span><br/>
        <?php endif; ?>
        <?php if ( use_recipe_courses() ): ?>
            <span class="recipe-course">
                <?php the_terms(get_the_id(), 'recipe-course');?>
            </span>&nbsp;
        <?php endif; ?>
        <?php if ( use_recipe_servings() ): ?>
            <span class="recipe-servings">
                <?php _e("for", "recipe-press"); ?>
                <?php the_recipe_servings(); ?>
            </span>
        <?php endif; ?>
     <div class="cleared"></div>
</div><!-- #post-## -->
