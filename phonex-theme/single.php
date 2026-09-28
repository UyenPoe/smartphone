<?php
/**
 * The template for displaying all single posts in PhoneX
 *
 * @package PhoneX
 */

get_header();
?>

<main id="primary" class="site-main max-w-5xl mx-auto px-4 py-10 font-sans min-h-[60vh]">
	<?php
	while ( have_posts() ) :
		the_post();

		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-2xl p-6 md:p-10 shadow-sm border border-gray-100' ); ?>>
			<header class="entry-header mb-6 pb-4 border-b border-gray-100">
				<?php the_title( '<h1 class="entry-title text-2xl md:text-4xl font-black text-gray-900 leading-tight">', '</h1>' ); ?>
				<div class="entry-meta text-xs text-gray-500 mt-3 flex items-center gap-3">
					<span><?php echo get_the_date(); ?></span>
					<span>•</span>
					<span><?php the_author(); ?></span>
				</div>
			</header>

			<div class="entry-content prose max-w-none text-gray-700 leading-relaxed text-base">
				<?php the_content(); ?>
			</div>

			<footer class="entry-footer mt-8 pt-6 border-t border-gray-100">
				<?php
				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle text-xs text-gray-400 block">' . esc_html__( 'Bài trước:', 'phonex' ) . '</span> <span class="nav-title font-bold text-gray-800 hover:text-red-600">%title</span>',
						'next_text' => '<span class="nav-subtitle text-xs text-gray-400 block">' . esc_html__( 'Bài tiếp theo:', 'phonex' ) . '</span> <span class="nav-title font-bold text-gray-800 hover:text-red-600">%title</span>',
					)
				);
				?>
			</footer>
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
