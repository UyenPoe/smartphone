<?php
/**
 * The template for displaying all pages in PhoneX WordPress Theme
 *
 * @package PhoneX
 */

get_header();
?>

<main id="primary" class="site-main max-w-7xl mx-auto px-4 py-10 font-sans min-h-[60vh]">
	<?php
	while ( have_posts() ) :
		the_post();

		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-2xl p-6 md:p-10 shadow-sm border border-gray-100' ); ?>>
			<header class="entry-header mb-6 pb-4 border-b border-gray-100">
				<?php the_title( '<h1 class="entry-title text-2xl md:text-3xl font-black text-gray-900">', '</h1>' ); ?>
			</header>

			<div class="entry-content prose max-w-none text-gray-700 leading-relaxed">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links mt-4 pt-4 border-t border-gray-100">' . esc_html__( 'Trang:', 'phonex' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
		</article>
		<?php

		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile;
	?>
</main>

<?php
get_footer();
