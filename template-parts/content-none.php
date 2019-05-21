<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kuhnian
 */

?>



	<main id="main" class="site-main" role="main">
		<section class="none-header">
			<header class="page-header">
				<h1 class="page-title">
					<?php
					if ( is_404() ) { esc_html_e( 'Page not available', 'kuhnian' );
					} else if ( is_search() ) {
						/* translators: %s = search query */
						printf( esc_html__( 'Nothing found for &ldquo;%s&rdquo;', 'kuhnian'), get_search_query() );
					} else {
						esc_html_e( 'Nothing Found', 'kuhnian' );
					}
					?>
				</h1>


				<div class="page-content">
					<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

						<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'kuhnian' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

					<?php elseif ( is_search() ) : ?>

						<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'kuhnian' ); ?></p>
						<?php get_search_form(); ?>

					<?php elseif ( is_404() ) : ?>

						<p><?php esc_html_e( 'You seem to be lost. To find what you are looking for check out the most recent articles below or try a search:', 'kuhnian' ); ?></p>
						<?php get_search_form(); ?>

					<?php else : ?>

						<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'kuhnian' ); ?></p>
						<?php get_search_form(); ?>

					<?php endif; ?>
				</div><!-- .page-content -->
			</header><!-- .page-header -->
		</section>

		<?php
		if ( is_404() || is_search() ) {
		?>

			<?php
			// Get the 6 latest posts
			$args = array(
				'posts_per_page' => 6
			);
			$latest_posts_query = new WP_Query( $args );
			// The Loop
			if ( $latest_posts_query->have_posts() ) {
					while ( $latest_posts_query->have_posts() ) {
						$latest_posts_query->the_post();
						// Get the standard index page content
						get_template_part( 'template-parts/content', get_post_format() );
					}
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		} // endif
		?>


	</main><!-- #main -->


<?php
get_sidebar();
get_footer();