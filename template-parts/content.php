<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kuhn
 */

?>

<!--$kuhnian_display_featured_image_on_posts is a flag: whether to display featured image
	on posts.
	This should be moved somewhere for easier customization.
-->
<?php $kuhnian_display_featured_image_on_posts = FALSE ; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
		if ( has_post_thumbnail() ) {
			if (!is_singular()) {    // NOT a single; e.g., it's an archive page
	?>								<!--Create a figure with image linked to the post-->
				<figure class="featured-image">
					<a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark">
						<?php $thumbnail_alt = 'Go to ' . get_the_title(); the_post_thumbnail('kuhn-index', 'alt=' . $thumbnail_alt);?>
					</a>
				</figure>
			<?php } else {			// IS a single post
				if ($kuhnian_display_featured_image_on_posts) { ?>
					<figure class="featured-image">
						<?php the_post_thumbnail('kuhn-index'); ?>
					</figure>
				<?php } else {} 
			}?>
	<!-- </figure> --><!-- .featured-image full-bleed -->
	<?php } ?>

	<header class="entry-header">
		<?php kuhn_the_category_list(); ?>
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>
	</header><!-- .entry-header -->

	<?php
	if ( 'post' === get_post_type() ) : ?>
	<div class="entry-meta">
		<?php kuhn_posted_on(); ?>
	</div><!-- .entry-meta -->
	<?php
	endif; ?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) {
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'kuhn' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kuhn' ),
				'after'  => '</div>',
			) );
		} else {
			the_excerpt();
		}
		?>
	</div><!-- .entry-content -->
	<?php
	if ( is_singular() ) { ?>
		<footer class="entry-footer">
			<?php kuhn_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	<?php } ?>

</article><!-- #post-## -->
