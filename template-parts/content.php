<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kuhnian
 */

?>

<!--$kuhnian_display_featured_image_on_posts is a flag: whether to display featured image
	on posts. It takes either 'display' or 'hide'.
-->
<?php
	$kuhnian_display_featured_image_on_posts = get_option('kuhnian_display_featured_image_on_single_posts','OOPS!') ;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
		if ( has_post_thumbnail() ) {
			if (!is_singular()) {    // NOT a single; e.g., it's an archive page
	?>								<!--Create a figure with image linked to the post-->
				<figure class="featured-image">
					<a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark">
						<?php $thumbnail_alt = 'Go to ' . get_the_title(); the_post_thumbnail('kuhnian-index', 'alt=' . $thumbnail_alt);?>
					</a>
				</figure>
			<?php } else {			// IS a single post
				if ($kuhnian_display_featured_image_on_posts == 'display') {?>
					<figure class="featured-image">
						<?php the_post_thumbnail('kuhnian-index'); ?>
					</figure>
				<?php } elseif ($kuhnian_display_featured_image_on_posts == 'hide') {
				} else {
					$error_message_kuhnian_display_featured_image_on_posts=
						"Illegal value for option kuhnian_display_featured_image_on_posts: '$kuhnian_display_featured_image_on_posts'";
/*					add_action('admin_notices','kuhnian_error_message_invalid_display_featured_image_preference'); */
				}
			}?>
	<!-- </figure> --><!-- .featured-image full-bleed -->
	<?php } ?>

	<header class="entry-header">
		<?php kuhnian_the_category_list(); ?>
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
		<?php kuhnian_posted_on(); ?>
	</div><!-- .entry-meta -->
	<?php
	endif; ?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) {
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'kuhnian' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kuhnian' ),
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
			<?php kuhnian_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	<?php } ?>

</article><!-- #post-## -->
