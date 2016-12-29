<?php
/**
 * The template used for displaying page content in page.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		 <h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<?php
	$text = get_post_meta($post->ID,'ct_mb_page_desc', true);
	if ( !empty($text) ) : ?>
		<div class="page-desc"><?php echo $text; ?></div>
	<?php endif; ?>

	<div class="entry-content clearfix">
		<?php the_content(); ?>
		<?php ct_wp_link_pages(); ?>
	</div><!-- .entry-content -->
	
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'color-theme-framework' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->