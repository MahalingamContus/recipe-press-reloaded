<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
get_header();

$tax_args = array(
     'taxonomy' => 'recipe-category',
     'current_category' => false
);
?>

<div id="container">
     <div id="content" role="main">
          <h1 class="page-title">
               <?php if ( is_day ( ) ) : ?>
               <?php printf(__('Recipes posted on <span>%s</span>', 'recipe-press'), get_the_date()); ?>
               <?php elseif ( is_month ( ) ) : ?>
               <?php printf(__('Recipes posted in <span>%s</span>', 'recipe-press'), get_the_date('F Y')); ?>
               <?php elseif ( is_year ( ) ) : ?>
               <?php printf(__('Recipes posted in <span>%s</span>', 'recipe-press'), get_the_date('Y')); ?>
               <?php else : ?>
               <?php _e('Recipe Archives', 'recipe-press'); ?>
               <?php endif; ?>
                              </h1>                    
                              <div class="recipe-press-categories">
                                   <ul id="recipe_taxonomy_list" class="recipe-press-taxonomy-list">
                                        <li class="cat-item cat-intro"><?php _e('Categories: ', 'recipe-press'); ?></li>
                    <?php list_recipe_categories($tax_args); ?>
                              </ul>
                         </div>

          <?php
                                   /* Run the loop to output the posts.
                                    * If you want to overload this in a child theme then include a file
                                    * called loop-index.php and that will be used instead.
                                    */
                                   get_template_part('loop', 'recipe');
          ?>
                              </div><!-- #content -->
                         </div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
