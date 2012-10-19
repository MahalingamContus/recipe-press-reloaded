<?php
/**
 * The Template for displaying all single posts.
 * Template Name: Recipe Form
 * 
 * @package WordPress
 * @subpackage Recipe_Press
 * @since Recipe Press 2.0
 */
global $RECIPEPRESSOBJ;
get_header();
?>

<div id="container">
     <div id="content" role="main">

          <?php if ( have_posts ( ) )
               while (have_posts ()) : the_post(); ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                         <h1 class="entry-title"><?php the_title(); ?></h1>

                         <div class="entry-content"><?php the_content(); ?></div>
                         <div class="recipe-form"><?php show_recipe_form(); ?></div>

                         <div class="entry-utility">
                    <?php edit_post_link(__('Edit', 'recipe-press'), '<span class="edit-link">', '</span>'); ?>
               </div><!-- .entry-utility -->
          </div><!-- #post -->
          <?php endwhile; // end of the loop.   ?>

          </div><!-- #content -->
     </div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
