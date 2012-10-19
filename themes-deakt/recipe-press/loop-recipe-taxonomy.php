<?php
/**
 * The loop that displays recipes in a selected taxonomy.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Recipe_Press
 * @since Recipe Press 2.0
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
     <div id="nav-above" class="navigation">
          <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older recipes', 'recipe-press')); ?></div>
          <div class="nav-next"><?php previous_posts_link(__('Newer recipes <span class="meta-nav">&rarr;</span>', 'recipe-press')); ?></div>
     </div><!-- #nav-above -->
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( !have_posts() ) : ?>
          <div id="post-0" class="post error404 not-found">
               <h1 class="entry-title"><?php _e('No Recipes Found', 'recipe-press'); ?></h1>
               <div class="entry-content">
                    <p><?php _e('There are currently no recipes in this category. Perhaps searching will help find a related post.', 'recipe-press'); ?></p>
          <?php get_search_form(); ?>
     </div><!-- .entry-content -->
</div><!-- #post-0 -->
<?php endif; ?>

          <div class="cleared"></div>
<?php while (have_posts ()) : the_post(); ?>
               <div id="post-<?php the_ID(); ?>" <?php post_class('recipe-box'); ?> <?php the_recipe_box_image(); ?>>

                    <div class="entry-content">

                         <div class="recipe-about">
                              <div class="recipe-title">
                                   <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                              </div><!-- .recipe-title -->
                              <div class="recipe-meta">
<?php printf(__('<span>Posted</span> %1$s by %2$s', 'recipe-press'), get_the_date(), get_the_author()); ?>
                              </div><!-- .recipe-meta -->
                              <blockquote class="recipe-notes"><?php the_recipe_introduction(array('length' => '5000')); ?></blockquote>

               <div class="recipe-meta attach-bottom">
<?php _e('Posted in', 'recipe-press'); ?>: <?php the_terms(get_the_id(), 'recipe-category'); ?> |
                    <?php _e('Cuisines', 'recipe-press'); ?>: <?php the_terms(get_the_id(), 'recipe-cuisine'); ?>
               </div>
          </div><!-- .recipe-about -->

     </div><!-- .entry-content -->

     <div class="cleared"></div>
</div><!-- #post-## -->

<?php endwhile; // End the loop.   ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
                         <div id="nav-below" class="navigation">
                              <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older recipes', 'recipe-press')); ?></div>
                              <div class="nav-next"><?php previous_posts_link(__('Newer recipes <span class="meta-nav">&rarr;</span>', 'recipe-press')); ?></div>
                         </div><!-- #nav-below -->
<?php endif; ?>
