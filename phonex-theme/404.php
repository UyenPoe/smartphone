<?php
/**
 * The template for displaying 404 pages (not found) in PhoneX
 *
 * @package PhoneX
 */

get_header();
?>

<main id="primary" class="site-main max-w-4xl mx-auto px-4 py-16 text-center font-sans">
	<div class="bg-white rounded-3xl p-8 md:p-14 shadow-sm border border-gray-100 flex flex-col items-center">
		<div class="w-20 h-20 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mb-6">
			<span class="material-symbols-outlined text-5xl">error</span>
		</div>

		<h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight mb-3">404</h1>
		<h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4"><?php esc_html_e( 'Không tìm thấy trang bạn yêu cầu', 'phonex' ); ?></h2>
		<p class="text-gray-600 max-w-md mb-8">
			<?php esc_html_e( 'Liên kết bạn truy cập có thể đã hết hạn, bị đổi tên hoặc không tồn tại trên hệ thống PhoneX.', 'phonex' ); ?>
		</p>

		<div class="flex flex-wrap items-center justify-center gap-3">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-md shadow-red-600/20 flex items-center gap-2">
				<span class="material-symbols-outlined text-[20px]">home</span>
				<?php esc_html_e( 'Về trang chủ', 'phonex' ); ?>
			</a>
			<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' ) ); ?>" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition-all flex items-center gap-2">
				<span class="material-symbols-outlined text-[20px]">shopping_bag</span>
				<?php esc_html_e( 'Khám phá sản phẩm', 'phonex' ); ?>
			</a>
		</div>
	</div>
</main>

<?php
get_footer();
