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
 *                    if ( has_post_thumbnail( $post->ID )) {
 *                       echo '<a href="' . get_permalink( $post->ID ) . '"title="' . esc_attr( $post->post_title ) . '">';
 *                       echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
 *                   }
 *
 * @package sthlmesport
 */

get_header(); ?>

<div id="content" class="site-content">

    <div id="featured-area">

    <?php
        $featured_post = get_posts('numberposts=1&category=2');
        foreach($featured_post as $post) :?>
            <?php $featured_id = get_the_ID(); ?>

			<article id="featured-post" <?php post_class(); ?>>
				<a class="entry-image" href="<?php the_permalink(); ?>" rel="bookmark"><?php

					if ( has_post_thumbnail() ) {
						the_post_thumbnail('top-image');
					}
					else {
						echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/img/thumbnail-fallback.png" />';
					}

				?></a>
				
				<a id="featured-description" href="<?php the_permalink(); ?>" rel="bookmark">
					<h1 class="entry-title"><?php the_title(); ?></h1>

					<p class="entry-summary">
						<?php echo get_the_excerpt(); ?>
					</p><!-- .entry-summary -->
				</a>

			</article><!-- #post-## -->

        <?php endforeach; ?>

		<div id="schedule">
			<div id="comminty-viewer">
				
			</div>
		</div>
	</div>

	<div id="primary" class="content-area">

		<?php get_sidebar('events'); ?>

		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>


			<?php while ( have_posts() ) : the_post(); ?>
				<?php
                    if ( $post->ID !== $featured_id ) {
                    /* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
                    }
				?>

			<?php endwhile; ?>

			<?php sthlmesport_paging_nav(); ?>

        <?php else : ?>

            <?php get_template_part( 'content', 'none' ); ?>

        <?php endif; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
