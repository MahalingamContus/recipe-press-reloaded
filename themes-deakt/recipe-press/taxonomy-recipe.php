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
 * @since Recipe Press 2.1
 */
get_header();
?>

<div id="container">
     <div id="content" role="main">
          <h1 class="page-title"><?php echo $tax->labels->name; ?></h1>

          <?php if ( $pagination['pages'] > 1 ) : ?>
               <div id="nav-above" class="navigation recipe-navigation cleared">
                    <div class="nav-previous"><?php previous_taxonomies_link(); ?></div>
                    <div class="nav-next"><?php next_taxonomies_link(); ?></div>
               </div><!-- #nav-above -->
          <?php endif; ?>
     
          <?php foreach ( $terms as $id => $term ) :
          ?>
                    <div id="recipe_taxonomy_<?php the_term_id($term); ?>" class="recipe-taxonomy-content">
                         <div id="recipe_taxonomy_image_<?php the_term_id($term); ?>" class="recipe-taxonomy-image">
                              <a href="<?php echo get_term_link($term, $taxonomy); ?>"><?php the_term_thumbnail($term); ?></a>
                         </div>
                         <div id="recipe_taxonomy_about_<?php the_term_id($term); ?>" class="recipe-taxonomy-about">
                              <h3 class="recipe-category-title"><a href="<?php echo get_term_link($term, $taxonomy); ?>"><?php the_term_name($term); ?></a></h3>
                              <blockquote class="recipe-category-description"><?php the_term_description($term); ?></blockquote>
                              <div class="recipe-meta"><?php _e('Sample recipes', 'recipe-press'); ?>: <?php the_random_posts_list($term, array('after-link' => ' | ')); ?></div>
                              <div class="cleared"></div>
                         </div>
                         <div class="cleared"></div>
                    </div>
          <?php endforeach; ?>

          <?php if ( $pagination['pages'] > 1 ) : ?>
                         <div id="nav-below" class="navigation recipe-navigation">
                              <div class="nav-previous"><?php previous_taxonomies_link(); ?></div>
                              <div class="nav-next"><?php next_taxonomies_link(); ?></div>
                         </div><!-- #nav-below -->
          <?php endif; ?>
                    </div><!-- #content -->
               </div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
