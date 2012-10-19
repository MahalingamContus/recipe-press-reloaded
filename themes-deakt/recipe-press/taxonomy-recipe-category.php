<?php
/**
 * The template for displaying Recipe Category pages.
 *
 * Used to display taxonomy-type pages if nothing more specific matches a query.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Recipe_Press
 * @since Recipe Press 2.0
 */
get_header();

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

$tax_args = array(
     'taxonomy' => 'recipe-category',
     'current_category' => $term->term_id
);
?>

<div id="container">
     <div id="content" role="main">

          <?php
          /* Queue the first post, that way we know
           * what date we're dealing with (if that is the case).
           *
           * We reset this later so we can run the loop
           * properly with a call to rewind_posts().
           */
          if ( have_posts ( ) )
               the_post();
          ?>

          <h1 class="page-title"><?php printf(__('Recipes listed in %1$s:', 'recipe-press'), $term->name); ?></h1>
          <div class="recipe-press-categories">
               <ul id="recipe_taxonomy_list" class="recipe-press-taxonomy-list">
                    <li class="cat-item cat-intro"><?php _e('More Categories: ', 'recipe-press'); ?></li>
                    <?php list_recipe_categories($tax_args); ?>
               </ul>
          </div>

          <?php
                    /* Since we called the_post() above, we need to
                     * rewind the loop back to the beginning that way
                     * we can run the loop properly, in full.
                     */
                    rewind_posts();

                    /* Run the loop for the archives page to output the posts.
                     * If you want to overload this in a child theme then include a file
                     * called loop-archives.php and that will be used instead.
                     */
                    get_template_part('loop', 'recipe-taxonomy');
          ?>

               </div><!-- #content -->
          </div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
