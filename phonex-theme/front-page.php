<?php
/**
 * The template for displaying the PhoneX Front Page
 *
 * @package PhoneX
 */

get_header();
?>

<main class="w-full pt-4 md:pt-6 bg-background"><div class="flex flex-col w-full">
<!-- SECTION 1: HERO SHOWCASE -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-md">
<div class="relative w-full rounded-2xl overflow-hidden bg-surface-pure shadow-md">
<div class="absolute inset-0 bg-gradient-to-r from-surface-pure via-surface-pure/90 to-transparent z-10 w-full lg:w-3/5"></div>
<div class="absolute -right-20 -bottom-20 w-96 h-96 rounded-full bg-primary/5 blur-3xl pointer-events-none"></div>
<div class="relative z-20 grid grid-cols-1 lg:grid-cols-12 gap-gutter items-center p-space-lg lg:p-space-xl min-h-[460px]">
<div class="lg:col-span-7 flex flex-col items-start space-y-space-md">
<div class="flex flex-wrap items-center gap-space-xs">
<span class="inline-flex items-center gap-1 px-space-sm py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-badge text-label-badge uppercase">
<span class="material-symbols-outlined text-[14px]">verified</span>
              Chính Hãng VN/A &amp; SSVN
            </span>
<span class="px-space-sm py-1 rounded-full bg-surface-container-high text-secondary font-label-badge text-label-badge">
              Trợ giá thu cũ 3.000.000₫
            </span>
<span class="px-space-sm py-1 rounded-full bg-surface-container-high text-secondary font-label-badge text-label-badge">
              Trả góp 0% 12 Tháng
            </span>
</div>
<div class="space-y-space-xs">
<h1 class="font-headline-xl text-headline-xl text-text-main tracking-tight leading-none">
              iPhone 18 Pro Max Titan &amp; Galaxy S25 Ultra
            </h1>
<p class="font-body-regular text-body-regular text-secondary max-w-xl">
              Đỉnh cao kiến trúc vi xử lý 2nm thế hệ mới. Độc quyền tại PhoneX với chính sách bảo hành 1 đổi 1 trong 30 ngày và kiểm định chất lượng nghiêm ngặt.
            </p>
</div>
<div class="flex items-baseline gap-space-sm">
<span class="font-headline-xl text-headline-xl text-primary font-bold">33.490.000₫</span>
<span class="font-price-strikethrough text-price-strikethrough text-secondary line-through">36.990.000₫</span>
<span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-badge text-label-badge font-bold">-9%</span>
</div>
<div class="flex flex-wrap items-center gap-space-sm pt-space-xs">
<a class="h-11 px-space-xl flex items-center justify-center rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button shadow-sm transition-all duration-200" data-path="product-checkout" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html">
              Mua ngay trả trước 0₫
            </a>
<a class="h-11 px-space-lg flex items-center justify-center rounded-lg bg-surface-container-low hover:bg-surface-container text-text-main font-label-button text-label-button transition-colors" data-path="compare" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/compare/index.html">
              Xem thông số kỹ thuật
            </a>
</div>
</div>
<div class="lg:col-span-5 relative flex justify-center items-center h-full min-h-[320px]">
<img class="w-full h-auto max-h-[380px] object-contain drop-shadow-2xl transition-transform duration-300 hover:scale-105" alt="Duo flagship smartphones side by side, natural titanium iPhone 18 Pro Max and sleek phantom black Galaxy S25 Ultra on a minimalist pristine white reflective studio stage with soft red edge rim lighting, crisp 8k photorealistic presentation" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9iXg8zaZhE4OKft1WCV6P49FDaMF2Hh32A9A1yLPXMz0GbTDwdMYpEFdSTBEk5-6EjcHUBbXzjPyMu9mJTrTm9jpQS1FwafF4dMzs4wwC2X9tk1b5RQYim6brDHSc5_52vBUQXMosJCtzf9ZDuWF01ztcupn5Dzwq3iLX3uiSYPRZkR3VlYKwR9sbUO4eHEav8Vx9CCGyhm06N2UC_XHqc0lG_Xa4wpLMIRflUxXHziAfC_dQWh77"/>
</div>
</div>
</div>
<!-- 2 High-Momentum Action Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter mt-space-md">
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex items-center justify-between group cursor-pointer" onclick="document.getElementById('trade-in-calculator').scrollIntoView({behavior: 'smooth'})">
<div class="flex items-center gap-space-md">
<div class="w-12 h-12 rounded-xl bg-primary-fixed flex items-center justify-center text-primary shrink-0 group-hover:scale-105 transition-transform">
<span class="material-symbols-outlined text-[28px]">published_with_changes</span>
</div>
<div>
<div class="flex items-center gap-2">
<h3 class="font-headline-sm text-headline-sm text-text-main">Trung Tâm Thu Cũ Lên Đời</h3>
<span class="px-2 py-0.5 rounded bg-primary-container text-on-primary font-label-badge text-label-badge">Trợ Giá +3Tr</span>
</div>
<p class="font-body-sm text-body-sm text-secondary mt-0.5">Định giá bằng thuật toán AI trong 60 giây, giải ngân tiền mặt hoặc trừ ngay vào máy mới.</p>
</div>
</div>
<span class="material-symbols-outlined text-secondary group-hover:text-primary group-hover:translate-x-1 transition-all">chevron_right</span>
</div>
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex items-center justify-between group cursor-pointer" onclick="document.getElementById('preowned-vault').scrollIntoView({behavior: 'smooth'})">
<div class="flex items-center gap-space-md">
<div class="w-12 h-12 rounded-xl bg-surface-container-high flex items-center justify-center text-text-main shrink-0 group-hover:scale-105 transition-transform">
<span class="material-symbols-outlined text-[28px]">verified_user</span>
</div>
<div>
<div class="flex items-center gap-2">
<h3 class="font-headline-sm text-headline-sm text-text-main">Kho Máy Cũ Tuyển Chọn 68 Bước</h3>
<span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary font-label-badge text-label-badge">Grade A 99%</span>
</div>
<p class="font-body-sm text-body-sm text-secondary mt-0.5">Pin Zin &gt; 95%, nguyên bản chưa thay thế linh kiện, bảo hành 1 đổi 1 trong 30 ngày.</p>
</div>
</div>
<span class="material-symbols-outlined text-secondary group-hover:text-primary group-hover:translate-x-1 transition-all">chevron_right</span>
</div>
</div>
</section>
<!-- SECTION 2: QUICK CATEGORIES -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-md">
<div class="grid grid-cols-2 sm:grid-cols-5 lg:grid-cols-10 gap-space-sm">
<a class="flex flex-col items-center p-space-sm bg-surface-pure rounded-xl shadow-sm hover:shadow hover:bg-surface-container-low transition-all text-center group" data-path="brand-apple" href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>">
<div class="w-12 h-12 rounded-full bg-surface-container-low group-hover:bg-primary/10 flex items-center justify-center text-text-main group-hover:text-primary transition-colors mb-2">
<span class="material-symbols-outlined text-[24px]">phone_iphone</span>
</div>
<span class="font-label-button text-label-button text-text-main">iPhone</span>
</a>
<a class="flex flex-col items-center p-space-sm bg-surface-pure rounded-xl shadow-sm hover:shadow hover:bg-surface-container-low transition-all text-center group" data-path="brand-samsung" href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>">
<div class="w-12 h-12 rounded-full bg-surface-container-low group-hover:bg-primary/10 flex items-center justify-center text-text-main group-hover:text-primary transition-colors mb-2">
<span class="material-symbols-outlined text-[24px]">smartphone</span>
</div>
<span class="font-label-button text-label-button text-text-main">Samsung</span>
</a>
<a class="flex flex-col items-center p-space-sm bg-surface-pure rounded-xl shadow-sm hover:shadow hover:bg-surface-container-low transition-all text-center group" data-path="brand-xiaomi" href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>">
<div class="w-12 h-12 rounded-full bg-surface-container-low group-hover:bg-primary/10 flex items-center justify-center text-text-main group-hover:text-primary transition-colors mb-2">
<span class="material-symbols-outlined text-[24px]">bolt</span>
</div>
<span class="font-label-button text-label-button text-text-main">Xiaomi/Poco</span>
</a>
<a class="flex flex-col items-center p-space-sm bg-surface-pure rounded-xl shadow-sm hover:shadow hover:bg-surface-container-low transition-all text-center group" data-path="brand-oppo" href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>">
<div class="w-12 h-12 rounded-full bg-surface-container-low group-hover:bg-primary/10 flex items-center justify-center text-text-main group-hover:text-primary transition-colors mb-2">
<span class="material-symbols-outlined text-[24px]">photo_camera</span>
</div>
<span class="font-label-button text-label-button text-text-main">OPPO Series</span>
</a>
<a class="flex flex-col items-center p-space-sm bg-surface-pure rounded-xl shadow-sm hover:shadow hover:bg-surface-container-low transition-all text-center group" data-path="brand-vivo" href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>">
<div class="w-12 h-12 rounded-full bg-surface-container-low group-hover:bg-primary/10 flex items-center justify-center text-text-main group-hover:text-primary transition-colors mb-2">
<span class="material-symbols-outlined text-[24px]">lens_blur</span>
</div>
<span class="font-label-button text-label-button text-text-main">vivo Flagship</span>
</a>
<a class="flex flex-col items-center p-space-sm bg-surface-pure rounded-xl shadow-sm hover:shadow hover:bg-surface-container-low transition-all text-center group" data-path="preowned" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/stores/used-phones/index.html">
<div class="w-12 h-12 rounded-full bg-surface-container-low group-hover:bg-primary/10 flex items-center justify-center text-text-main group-hover:text-primary transition-colors mb-2">
<span class="material-symbols-outlined text-[24px]">sync_saved_locally</span>
</div>
<span class="font-label-button text-label-button text-text-main">Máy Cũ 99%</span>
</a>
<a class="flex flex-col items-center p-space-sm bg-surface-pure rounded-xl shadow-sm hover:shadow hover:bg-surface-container-low transition-all text-center group" data-path="trade-in" href="<?php echo esc_url(home_url("/thu-cu-doi-moi/")); ?>">
<div class="w-12 h-12 rounded-full bg-surface-container-low group-hover:bg-primary/10 flex items-center justify-center text-text-main group-hover:text-primary transition-colors mb-2">
<span class="material-symbols-outlined text-[24px]">swap_horiz</span>
</div>
<span class="font-label-button text-label-button text-text-main">Thu Cũ Trợ Giá</span>
</a>
<a class="flex flex-col items-center p-space-sm bg-surface-pure rounded-xl shadow-sm hover:shadow hover:bg-surface-container-low transition-all text-center group" data-path="accessories" href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>">
<div class="w-12 h-12 rounded-full bg-surface-container-low group-hover:bg-primary/10 flex items-center justify-center text-text-main group-hover:text-primary transition-colors mb-2">
<span class="material-symbols-outlined text-[24px]">headphones</span>
</div>
<span class="font-label-button text-label-button text-text-main">Phụ Kiện Zin</span>
</a>
<a class="flex flex-col items-center p-space-sm bg-surface-pure rounded-xl shadow-sm hover:shadow hover:bg-surface-container-low transition-all text-center group" data-path="installment" href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>">
<div class="w-12 h-12 rounded-full bg-surface-container-low group-hover:bg-primary/10 flex items-center justify-center text-text-main group-hover:text-primary transition-colors mb-2">
<span class="material-symbols-outlined text-[24px]">credit_card</span>
</div>
<span class="font-label-button text-label-button text-text-main">Trả Góp 0%</span>
</a>
<a class="flex flex-col items-center p-space-sm bg-surface-pure rounded-xl shadow-sm hover:shadow hover:bg-surface-container-low transition-all text-center group" data-path="deals" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/promotions/promotions/index.html">
<div class="w-12 h-12 rounded-full bg-primary-fixed text-primary flex items-center justify-center transition-colors mb-2">
<span class="material-symbols-outlined text-[24px]">local_fire_department</span>
</div>
<span class="font-label-button text-label-button text-primary font-bold">Hot Deals -50%</span>
</a>
</div>
</section>
<!-- SECTION 3: FLASH SALE GIỜ VÀNG (2 HÀNG - 8 SẢN PHẨM & TIMELINE TABS & LIVE COUNTDOWN) -->
<?php
$flashsale_settings = function_exists( 'phonex_get_flashsale_settings' ) ? phonex_get_flashsale_settings() : array();
$fs_enabled         = $flashsale_settings['enabled'] ?? '1';

if ( $fs_enabled === '1' ) :
	$fs_title        = $flashsale_settings['title'] ?? 'FLASH SALE GIỜ VÀNG';
	$fs_subtitle     = $flashsale_settings['subtitle'] ?? 'Khung giờ vàng giảm sốc - Số lượng có hạn';
	$fs_slots        = $flashsale_settings['slots'] ?? array();
	$fs_active_index = intval( $flashsale_settings['active_slot_index'] ?? 1 );
	$fs_products     = $flashsale_settings['products'] ?? array();
	$cd_hours        = intval( $flashsale_settings['countdown_hours'] ?? 2 );
	$cd_minutes      = intval( $flashsale_settings['countdown_minutes'] ?? 45 );
	$cd_seconds      = intval( $flashsale_settings['countdown_seconds'] ?? 0 );

	// Background color & styling presets (Pastel PhoneX brand red / Warm cream)
	$bg_preset       = $flashsale_settings['bg_preset'] ?? 'brand_rose';
	$bg_custom       = $flashsale_settings['bg_custom'] ?? '#fff5f5';

	if ( $bg_preset === 'brand_rose' ) {
		// PhoneX brand soft rose pastel gradient (inspired by reference image, matching site primary)
		$container_style = 'background: linear-gradient(180deg, #fff5f5 0%, #fff0f2 100%); border-color: #fecdd3; box-shadow: 0 10px 30px rgba(186, 13, 26, 0.05);';
	} elseif ( $bg_preset === 'warm_cream' ) {
		// Warm cream pastel directly from user-uploaded image (#fff6e3)
		$container_style = 'background: linear-gradient(180deg, #fffcf5 0%, #fff6e3 100%); border-color: #fde68a; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.06);';
	} elseif ( $bg_preset === 'custom' && ! empty( $bg_custom ) ) {
		$container_style = 'background: ' . esc_attr( $bg_custom ) . '; border-color: #e2e8f0;';
	} else {
		// clean_white
		$container_style = 'background: #ffffff; border-color: #e2e8f0;';
	}

	// Products split: 8 initial products, remaining into expandable 'Xem thêm'
	$initial_products  = array_slice( $fs_products, 0, 8 );
	$extra_products    = array_slice( $fs_products, 8 );
	$has_extra         = ! empty( $extra_products );
	$view_more_enabled = ( ( $flashsale_settings['view_more_enabled'] ?? '1' ) === '1' );
	$view_more_text    = $flashsale_settings['view_more_text'] ?? 'Xem thêm deal Flash Sale';
	$all_deals_text    = $flashsale_settings['all_deals_text'] ?? 'Xem tất cả khuyến mãi';
	$all_deals_url     = $flashsale_settings['all_deals_url'] ?? '/khuyen-mai/';

	// Helper function for rendering card
	$render_fs_card = function( $prod, $idx ) {
		$sold = intval( $prod['sold'] ?? 0 );
		$total = max( 1, intval( $prod['total_stock'] ?? 50 ) );
		$percent = min( 100, max( 5, round( ( $sold / $total ) * 100 ) ) );
		
		$raw_link = $prod['link'] ?? '';
		$pid = intval( $prod['product_id'] ?? 0 );
		if ( $pid > 0 && function_exists( 'get_permalink' ) && get_post_status( $pid ) === 'publish' ) {
			$prod_link = esc_url( get_permalink( $pid ) );
		} elseif ( strpos( $raw_link, 'http' ) === 0 ) {
			$prod_link = esc_url( $raw_link );
		} elseif ( ! empty( $raw_link ) && strpos( $raw_link, '/' ) === 0 ) {
			$prod_link = esc_url( home_url( $raw_link ) );
		} else {
			$prod_link = esc_url( get_template_directory_uri() . '/pages/shop/product-detail/index.html' );
		}
		?>
		<!-- Flash Sale Item #<?php echo esc_html( $idx + 1 ); ?> -->
		<div class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-all flex flex-col justify-between group border border-border-subtle/70 hover:border-primary/50 relative hover:-translate-y-1 duration-200">
			<!-- Thumbnail & Badges -->
			<div class="relative w-full aspect-square flex items-center justify-center p-space-sm bg-surface-container-low rounded-lg mb-space-sm overflow-hidden">
				<span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded bg-primary-container text-on-primary font-label-badge text-label-badge font-bold shadow-sm">
					<?php echo esc_html( $prod['badge'] ?? '-15%' ); ?>
				</span>
				<span class="absolute top-2 right-2 z-10 text-secondary hover:text-primary cursor-pointer transition-colors">
					<span class="material-symbols-outlined text-[20px]">favorite_border</span>
				</span>
				<img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" alt="<?php echo esc_attr( $prod['name'] ); ?>" src="<?php echo esc_url( $prod['image'] ); ?>" loading="lazy"/>
			</div>

			<!-- Content Details -->
			<div>
				<div class="flex gap-1 mb-1">
					<span class="px-1.5 py-0.5 bg-surface-container rounded font-label-badge text-label-badge text-secondary font-medium">
						<?php echo esc_html( $prod['specs'] ?? 'Chính hãng VN/A' ); ?>
					</span>
				</div>
				<h4 class="font-title-product text-title-product text-text-main line-clamp-1 group-hover:text-primary transition-colors font-bold">
					<?php echo esc_html( $prod['name'] ); ?>
				</h4>
				<div class="mt-2 flex items-baseline gap-2">
					<span class="font-price-card text-price-card text-primary font-bold">
						<?php echo esc_html( $prod['price_sale'] ); ?>
					</span>
					<span class="font-price-strikethrough text-price-strikethrough text-secondary line-through">
						<?php echo esc_html( $prod['price_orig'] ); ?>
					</span>
				</div>

				<!-- Sold Progress Bar -->
				<div class="mt-3 space-y-1">
					<div class="flex justify-between font-label-badge text-label-badge text-secondary">
						<span>Đã bán <?php echo esc_html( $sold ); ?>/<?php echo esc_html( $total ); ?></span>
						<span class="text-primary font-bold"><?php echo esc_html( $prod['stock_text'] ?? 'Đang bán chạy' ); ?></span>
					</div>
					<div class="w-full h-2 rounded-full bg-surface-container overflow-hidden">
						<div class="h-full bg-primary-container rounded-full transition-all duration-500" style="width: <?php echo esc_attr( $percent ); ?>%;"></div>
					</div>
				</div>
			</div>

			<!-- Action Button -->
			<button class="mt-space-md w-full h-10 rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button transition-colors flex items-center justify-center gap-1 shadow-sm fs-product-buy-btn" onclick="window.location.href='<?php echo $prod_link; ?>'">
				<span>Mua Ngay</span>
			</button>
		</div>
		<?php
	};
?>
<section class="w-full max-w-7xl mx-auto px-margin py-space-lg" id="section-flash-sale">
  <div class="rounded-2xl p-space-md lg:p-space-lg shadow-sm border transition-all duration-300" style="<?php echo $container_style; ?>">
    <!-- Top Header Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm pb-space-sm">
      <div class="flex items-center gap-space-md flex-wrap">
        <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-primary-container text-on-primary font-headline-sm text-headline-sm tracking-tight shadow-sm">
          <span class="material-symbols-outlined text-[26px] text-amber-300 animate-pulse">local_fire_department</span>
          <span class="font-extrabold uppercase"><?php echo esc_html( $fs_title ); ?></span>
        </div>
        <span class="font-body-sm text-body-sm text-secondary hidden sm:inline" id="fs-header-subtitle">
          <?php echo esc_html( $fs_subtitle ); ?>
        </span>
      </div>

      <!-- Real-Time Countdown Box -->
      <div class="flex items-center gap-space-xs font-label-button text-label-button bg-white px-4 py-2 rounded-xl border border-border-subtle/80 shadow-xs">
        <span class="text-secondary text-sm font-medium" id="fs-countdown-label">Kết thúc sau:</span>
        <div class="flex items-center gap-1 font-mono text-on-primary font-bold" id="phonex-fs-countdown" data-hours="<?php echo esc_attr( $cd_hours ); ?>" data-minutes="<?php echo esc_attr( $cd_minutes ); ?>" data-seconds="<?php echo esc_attr( $cd_seconds ); ?>">
          <span class="bg-inverse-surface px-2.5 py-1 rounded text-sm shadow-inner min-w-[28px] text-center" id="fs-cd-h"><?php echo esc_html( sprintf( '%02d', $cd_hours ) ); ?></span>
          <span class="text-text-main font-bold">:</span>
          <span class="bg-inverse-surface px-2.5 py-1 rounded text-sm shadow-inner min-w-[28px] text-center" id="fs-cd-m"><?php echo esc_html( sprintf( '%02d', $cd_minutes ) ); ?></span>
          <span class="text-text-main font-bold">:</span>
          <span class="bg-primary-container px-2.5 py-1 rounded text-sm shadow-inner min-w-[28px] text-center text-amber-300 font-extrabold" id="fs-cd-s"><?php echo esc_html( sprintf( '%02d', $cd_seconds ) ); ?></span>
        </div>
      </div>
    </div>

    <!-- Timeline Slots Navigation (PhoneX Brand Red & Gold) -->
    <div class="mt-4 mb-6 border-b border-border-subtle/60 overflow-x-auto no-scrollbar">
      <div class="flex items-center gap-2 sm:gap-3 min-w-[620px] pb-3" id="phonex-flashsale-tabs">
        <?php foreach ( $fs_slots as $idx => $slot ) : 
          $is_active = ( $idx === $fs_active_index );
          $is_ended = ( ( $slot['status'] ?? '' ) === 'ended' );
        ?>
          <button 
            type="button" 
            class="flashsale-slot-tab flex-1 py-3 px-3 sm:px-4 rounded-xl flex flex-col items-center justify-center transition-all duration-200 cursor-pointer text-center relative border <?php echo $is_active ? 'bg-primary-container text-on-primary shadow-md border-primary-container transform scale-[1.02]' : ( $is_ended ? 'bg-surface-container text-secondary/70 border-transparent hover:bg-surface-container-high' : 'bg-white text-text-main border-border-subtle hover:bg-rose-50 hover:text-primary hover:border-primary/40 shadow-xs' ); ?>"
            data-slot-index="<?php echo esc_attr( $idx ); ?>"
            data-slot-time="<?php echo esc_attr( $slot['time'] ); ?>"
            data-slot-endtime="<?php echo esc_attr( $slot['end_time'] ?? '' ); ?>"
            data-slot-status="<?php echo esc_attr( $slot['status'] ?? 'upcoming' ); ?>"
            data-slot-label="<?php echo esc_attr( $slot['label'] ); ?>"
          >
            <span class="font-headline-sm text-[20px] sm:text-[22px] font-extrabold tracking-tight leading-none mb-1 slot-time-text">
              <?php echo esc_html( $slot['time'] ); ?>
            </span>
            <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-1 slot-label-text <?php echo $is_active ? 'text-amber-300' : ''; ?>">
              <?php if ( $is_active ) : ?>
                <span class="inline-block w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
              <?php endif; ?>
              <?php echo esc_html( $slot['label'] ); ?>
            </span>
            <?php if ( $is_active ) : ?>
              <div class="active-indicator-triangle absolute -bottom-2 left-1/2 -translate-x-1/2 w-3 h-3 bg-primary-container rotate-45 border-r border-b border-primary-container"></div>
            <?php endif; ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- 8 Default Products Grid (2 Rows x 4 Columns) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mt-space-md" id="phonex-fs-product-grid">
      <?php foreach ( $initial_products as $idx => $prod ) {
        $render_fs_card( $prod, $idx );
      } ?>
    </div>

    <!-- Extra Expandable Products Grid (Products 9-12+ when user clicks "Xem thêm") -->
    <?php if ( $has_extra ) : ?>
      <div class="hidden grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mt-space-md transition-all duration-300" id="phonex-fs-extra-grid">
        <?php foreach ( $extra_products as $idx => $prod ) {
          $render_fs_card( $prod, 8 + $idx );
        } ?>
      </div>
    <?php endif; ?>

    <!-- Action Bar: "Xem thêm" & "Xem tất cả khuyến mãi" -->
    <?php if ( $view_more_enabled ) : ?>
      <div class="mt-8 pt-5 border-t border-border-subtle/50 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4" id="phonex-fs-more-bar">
        <?php if ( $has_extra ) : ?>
          <button 
            type="button" 
            id="btn-toggle-fs-more" 
            class="w-full sm:w-auto px-7 py-3 rounded-xl bg-white hover:bg-rose-50 text-primary font-bold text-sm border-2 border-primary/30 hover:border-primary shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer group"
            data-expanded="0"
            data-more-text="<?php echo esc_attr( $view_more_text . ' (' . count( $extra_products ) . ' sản phẩm)' ); ?>"
            data-less-text="Thu gọn bớt deal Flash Sale"
          >
            <span id="label-toggle-fs-more"><?php echo esc_html( $view_more_text . ' (' . count( $extra_products ) . ' sản phẩm)' ); ?></span>
            <span class="material-symbols-outlined text-[20px] transition-transform duration-200 group-hover:translate-y-0.5" id="icon-toggle-fs-more">expand_more</span>
          </button>
        <?php endif; ?>

        <?php 
          $all_url = ( strpos( $all_deals_url, 'http' ) === 0 ) ? esc_url( $all_deals_url ) : esc_url( home_url( $all_deals_url ) );
        ?>
        <a 
          href="<?php echo $all_url; ?>" 
          class="w-full sm:w-auto px-7 py-3 rounded-xl bg-primary-container hover:bg-primary-hover text-on-primary font-bold text-sm shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2"
        >
          <span><?php echo esc_html( $all_deals_text ); ?></span>
          <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>

<!-- LIVE FLASHSALE COUNTDOWN & TIMELINE & XEM THÊM INTERACTION SCRIPT -->
<script>
(function() {
  const cdContainer = document.getElementById('phonex-fs-countdown');
  if (!cdContainer) return;

  const hEl = document.getElementById('fs-cd-h');
  const mEl = document.getElementById('fs-cd-m');
  const sEl = document.getElementById('fs-cd-s');
  const labelEl = document.getElementById('fs-countdown-label');
  const tabs = document.querySelectorAll('.flashsale-slot-tab');
  const buyBtns = document.querySelectorAll('.fs-product-buy-btn');

  // Initial seconds from data attributes
  let hours = parseInt(cdContainer.dataset.hours, 10) || 2;
  let minutes = parseInt(cdContainer.dataset.minutes, 10) || 45;
  let seconds = parseInt(cdContainer.dataset.seconds, 10) || 18;
  let totalRemaining = (hours * 3600) + (minutes * 60) + seconds;

  let currentSlotStatus = 'active';

  function updateTimerDisplay() {
    if (currentSlotStatus === 'ended') {
      if (hEl) hEl.textContent = '00';
      if (mEl) mEl.textContent = '00';
      if (sEl) sEl.textContent = '00';
      if (labelEl) labelEl.textContent = 'Đã kết thúc:';
      return;
    }

    if (totalRemaining <= 0) {
      totalRemaining = 7200; // Reset 2 hours loop
    }

    const curH = Math.floor(totalRemaining / 3600);
    const curM = Math.floor((totalRemaining % 3600) / 60);
    const curS = totalRemaining % 60;

    if (hEl) hEl.textContent = String(curH).padStart(2, '0');
    if (mEl) mEl.textContent = String(curM).padStart(2, '0');
    if (sEl) sEl.textContent = String(curS).padStart(2, '0');

    totalRemaining--;
  }

  // Run timer every second
  updateTimerDisplay();
  const timerInterval = setInterval(updateTimerDisplay, 1000);

  // Tab switching handler
  tabs.forEach(tab => {
    tab.addEventListener('click', function() {
      // Remove active classes from all tabs
      tabs.forEach(t => {
        t.className = 'flashsale-slot-tab flex-1 py-3 px-3 sm:px-4 rounded-xl flex flex-col items-center justify-center transition-all duration-200 cursor-pointer text-center relative border bg-white text-text-main border-border-subtle hover:bg-rose-50 hover:text-primary hover:border-primary/40 shadow-xs';
        const labelText = t.querySelector('.slot-label-text');
        if (labelText) {
          labelText.classList.remove('text-amber-300');
          const pingDot = labelText.querySelector('.animate-ping');
          if (pingDot) pingDot.remove();
        }
        const triangle = t.querySelector('.active-indicator-triangle');
        if (triangle) triangle.remove();
      });

      // Activate clicked tab
      this.className = 'flashsale-slot-tab flex-1 py-3 px-3 sm:px-4 rounded-xl flex flex-col items-center justify-center transition-all duration-200 cursor-pointer text-center relative border bg-primary-container text-on-primary shadow-md border-primary-container transform scale-[1.02]';
      const activeLabel = this.querySelector('.slot-label-text');
      if (activeLabel) {
        activeLabel.classList.add('text-amber-300');
        if (!activeLabel.querySelector('.animate-ping')) {
          const dot = document.createElement('span');
          dot.className = 'inline-block w-2 h-2 rounded-full bg-amber-400 animate-ping';
          activeLabel.prepend(dot);
        }
      }
      const triangle = document.createElement('div');
      triangle.className = 'active-indicator-triangle absolute -bottom-2 left-1/2 -translate-x-1/2 w-3 h-3 bg-primary-container rotate-45 border-r border-b border-primary-container';
      this.appendChild(triangle);

      const status = this.dataset.slotStatus || 'upcoming';
      const time = this.dataset.slotTime || '';
      currentSlotStatus = status;

      if (status === 'active') {
        if (labelEl) labelEl.textContent = 'Kết thúc sau:';
        totalRemaining = 2 * 3600 + 45 * 60 + 18;
        buyBtns.forEach(btn => {
          btn.innerHTML = '<span>Mua Ngay</span>';
          btn.className = 'mt-space-md w-full h-10 rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button transition-colors flex items-center justify-center gap-1 shadow-sm fs-product-buy-btn';
        });
      } else if (status === 'upcoming') {
        if (labelEl) labelEl.textContent = 'Mở bán lúc ' + time + ':';
        totalRemaining = 1 * 3600 + 15 * 60 + 40;
        buyBtns.forEach(btn => {
          btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">notifications_active</span><span>Nhắc Tôi Khi Mở Bán</span>';
          btn.className = 'mt-space-md w-full h-10 rounded-lg bg-surface-container-highest hover:bg-primary-container hover:text-on-primary text-text-main font-label-button text-label-button transition-colors flex items-center justify-center gap-1 shadow-sm fs-product-buy-btn';
        });
      } else if (status === 'ended') {
        if (labelEl) labelEl.textContent = 'Đã kết thúc lúc ' + time + ':';
        totalRemaining = 0;
        buyBtns.forEach(btn => {
          btn.innerHTML = '<span>Xem Lại Sản Phẩm</span>';
          btn.className = 'mt-space-md w-full h-10 rounded-lg bg-surface-container text-secondary font-label-button text-label-button transition-colors flex items-center justify-center gap-1 fs-product-buy-btn';
        });
      }
      updateTimerDisplay();
    });
  });

  // Toggle "Xem Thêm" Extra Products Handler
  const btnToggleMore = document.getElementById('btn-toggle-fs-more');
  const extraGrid = document.getElementById('phonex-fs-extra-grid');
  const labelToggleMore = document.getElementById('label-toggle-fs-more');
  const iconToggleMore = document.getElementById('icon-toggle-fs-more');

  if (btnToggleMore && extraGrid) {
    btnToggleMore.addEventListener('click', function() {
      const isExpanded = this.dataset.expanded === '1';
      if (!isExpanded) {
        // Expand extra products
        extraGrid.classList.remove('hidden');
        extraGrid.classList.add('grid');
        this.dataset.expanded = '1';
        if (labelToggleMore) labelToggleMore.textContent = this.dataset.lessText || 'Thu gọn bớt deal Flash Sale';
        if (iconToggleMore) {
          iconToggleMore.textContent = 'expand_less';
          iconToggleMore.classList.remove('group-hover:translate-y-0.5');
          iconToggleMore.classList.add('group-hover:-translate-y-0.5');
        }
      } else {
        // Collapse extra products
        extraGrid.classList.remove('grid');
        extraGrid.classList.add('hidden');
        this.dataset.expanded = '0';
        if (labelToggleMore) labelToggleMore.textContent = this.dataset.moreText || 'Xem thêm deal Flash Sale';
        if (iconToggleMore) {
          iconToggleMore.textContent = 'expand_more';
          iconToggleMore.classList.remove('group-hover:-translate-y-0.5');
          iconToggleMore.classList.add('group-hover:translate-y-0.5');
        }
        // Smooth scroll back to top of Flash Sale section
        const fsSection = document.getElementById('section-flash-sale');
        if (fsSection) {
          fsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }
    });
  }
})();
</script>
<?php endif; ?>

<!-- SECTION 4: BỘ SƯU TẬP MŨI NHỌN (TABS) -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-lg">
<div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm mb-space-md">
<div>
<span class="font-label-badge text-label-badge text-primary uppercase font-bold tracking-wider">Hiệu Năng Vô Địch</span>
<h2 class="font-headline-lg text-headline-lg text-text-main tracking-tight">Bộ Sưu Tập Smartphone Mũi Nhọn</h2>
</div>
<div class="inline-flex p-1 bg-surface-container rounded-xl gap-1">
<button class="px-space-md py-2 rounded-lg bg-surface-pure text-text-main font-label-button text-label-button shadow-sm">
          Top Flagship Bán Chạy
        </button>
<button class="px-space-md py-2 rounded-lg text-secondary hover:text-text-main font-label-button text-label-button transition-colors" onclick="window.location.href='<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>'">
          Điện Thoại Mới Ra Mắt
        </button>
<button class="px-space-md py-2 rounded-lg text-secondary hover:text-text-main font-label-button text-label-button transition-colors">
          Máy Độc Bản Hot Nhất
        </button>
</div>
</div>
<!-- Product Grid with Chipset Badges -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
<!-- Card 1 -->
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
<div>
<div class="flex items-center justify-between mb-space-sm">
<span class="px-2.5 py-1 rounded-full bg-primary/10 text-primary font-label-badge text-label-badge font-bold">
              Apple A19 Pro Bionic (3nm)
            </span>
<span class="material-symbols-outlined text-secondary hover:text-primary cursor-pointer text-[20px]">bookmark_border</span>
</div>
<div class="w-full aspect-[4/3] bg-surface-container-low rounded-lg p-space-sm flex items-center justify-center overflow-hidden mb-space-sm">
<img class="w-full h-full object-contain hover:scale-105 transition-transform duration-300" alt="iPhone 18 Pro Max desert titanium studio presentation with glossy edge high clarity" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBJyznqsxffSwTtLf_Zq39mGYtP6-N2l1DW7UdBg4VHdO7TB7TP1Emx96FLeopoInASb14-MUqPS_MVc7IBTm_htX4I9jv-o1HtFHiro4wY1W7k7OLbzTxK46_0bYmADaWguBvx-U_xMCQwFM1MMRaKY8kkOfa63ICmdfXEFRffFJ07gQOtBLu1tHSnjRgA7vBSx5HN89ilJQoCjC5_RfyrGfgBXhBU-3mnFbC7xUyCO6hubG4c29n5"/>
</div>
<div class="flex items-center gap-2 mb-2">
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">256GB</span>
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">512GB</span>
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">1TB</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-main">iPhone 18 Pro Max 512GB</h3>
<p class="font-body-sm text-body-sm text-secondary mt-1">Camera Fusion 48MP Zoom 10x, Màn hình OLED Super Retina 120Hz Promotion</p>
</div>
<div class="pt-space-md mt-space-md flex items-center justify-between border-t-0">
<div>
<div class="font-headline-sm text-headline-sm text-primary font-bold">37.890.000₫</div>
<div class="font-body-sm text-body-sm text-secondary">Trả góp từ 3.150.000₫/tháng</div>
</div>
<a class="h-10 px-4 rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button flex items-center justify-center transition-colors" data-path="cart" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html">
            Mua Ngay
          </a>
</div>
</div>
<!-- Card 2 -->
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
<div>
<div class="flex items-center justify-between mb-space-sm">
<span class="px-2.5 py-1 rounded-full bg-primary/10 text-primary font-label-badge text-label-badge font-bold">
              Snapdragon 8 Elite Extreme
            </span>
<span class="material-symbols-outlined text-secondary hover:text-primary cursor-pointer text-[20px]">bookmark_border</span>
</div>
<div class="w-full aspect-[4/3] bg-surface-container-low rounded-lg p-space-sm flex items-center justify-center overflow-hidden mb-space-sm">
<img class="w-full h-full object-contain hover:scale-105 transition-transform duration-300" alt="Samsung Galaxy S25 Ultra titanium gray camera array detailed close up render in high-end tech studio setting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBFswaEK-PT3kG-Mgseohz-XXVoD9pnH5ofQ8NnW-eBay11gSqH4UvbvPlBn9maTs-RwRimdwdNi2bx1-JiubBG500wV6lGiThaaaoZrymS1l2Pa78M30y4b9wsV2_doZsxCAELa_3NBJDRinmfD_3f6AbffxWqFlBK7PaMRsxvKL0yeI0GKnlh5xTs9hDZaWp38-EW9ejZRDkMXdx_sjDjKbOlH8xyOlzkej4eF90hI9oJS8N4tQ3h"/>
</div>
<div class="flex items-center gap-2 mb-2">
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">256GB</span>
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">512GB</span>
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">1TB</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-main">Galaxy S25 Ultra 256GB</h3>
<p class="font-body-sm text-body-sm text-secondary mt-1">Galaxy AI 2.0 toàn diện, Camera 200MP bắt sáng tốt hơn 40%, S-Pen tích hợp</p>
</div>
<div class="pt-space-md mt-space-md flex items-center justify-between border-t-0">
<div>
<div class="font-headline-sm text-headline-sm text-primary font-bold">31.990.000₫</div>
<div class="font-body-sm text-body-sm text-secondary">Trả góp từ 2.660.000₫/tháng</div>
</div>
<a class="h-10 px-4 rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button flex items-center justify-center transition-colors" data-path="cart" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html">
            Mua Ngay
          </a>
</div>
</div>
<!-- Card 3 -->
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
<div>
<div class="flex items-center justify-between mb-space-sm">
<span class="px-2.5 py-1 rounded-full bg-primary/10 text-primary font-label-badge text-label-badge font-bold">
              MediaTek Dimensity 9400 (3nm)
            </span>
<span class="material-symbols-outlined text-secondary hover:text-primary cursor-pointer text-[20px]">bookmark_border</span>
</div>
<div class="w-full aspect-[4/3] bg-surface-container-low rounded-lg p-space-sm flex items-center justify-center overflow-hidden mb-space-sm">
<img class="w-full h-full object-contain hover:scale-105 transition-transform duration-300" alt="vivo X200 Pro Zeiss blue finish camera flagship phone angled front and back render" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCK7p8y0wueLx_GFQ6SzM_FCPpUSZ5PdxWyhOAHjx1RaJYkcXHouRzp_edIuT2N7d5WnwBw1HPyYussus-ILC2xIRziLYL48GUN4dJ8k0R3xtOI2hNVSm5jmyAlimdC0c43ciMLlgKLViMHsXS76ZNG61lQryvd7RhKIH_PtXzrcwzHSIImcvnE_X-gVFFUoYGj4OQlhbq0eCKjhW6BnuLQZ8vBAj23eQHDRtSgbE-06tbRm2ejtoID"/>
</div>
<div class="flex items-center gap-2 mb-2">
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">256GB</span>
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">512GB</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-main">vivo X200 Pro 5G Zeiss</h3>
<p class="font-body-sm text-body-sm text-secondary mt-1">Ống kính tiềm vọng Zeiss APO 200MP, Pin 6000mAh BlueVolt, Sạc nhanh 90W</p>
</div>
<div class="pt-space-md mt-space-md flex items-center justify-between border-t-0">
<div>
<div class="font-headline-sm text-headline-sm text-primary font-bold">21.990.000₫</div>
<div class="font-body-sm text-body-sm text-secondary">Trả góp từ 1.830.000₫/tháng</div>
</div>
<a class="h-10 px-4 rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button flex items-center justify-center transition-colors" data-path="cart" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html">
            Mua Ngay
          </a>
</div>
</div>
</div>
</section>
<!-- SECTION 5: ĐỐI TÁC CHIẾN LƯỢC -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-md">
<div class="bg-surface-pure rounded-2xl p-space-lg shadow-sm">
<div class="text-center max-w-2xl mx-auto mb-space-lg">
<span class="font-label-badge text-label-badge text-secondary uppercase font-bold tracking-wider">Hệ Sinh Thái Phân Phối</span>
<h3 class="font-headline-sm text-headline-sm text-text-main mt-1">Đối Tác Chiến Lược &amp; Ủy Quyền Trực Tiếp</h3>
<p class="font-body-sm text-body-sm text-secondary mt-1">100% sản phẩm phân phối tại PhoneX được nhập khẩu chính ngạch với chính sách bảo hành chính hãng toàn cầu.</p>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-gutter items-center">
<div class="p-space-sm rounded-xl bg-surface-container-low flex flex-col items-center justify-center text-center h-24 hover:bg-surface-container transition-colors">
<span class="font-headline-sm text-headline-sm text-text-main font-bold">Apple</span>
<span class="font-label-badge text-label-badge text-primary">AAR Ủy Quyền</span>
</div>
<div class="p-space-sm rounded-xl bg-surface-container-low flex flex-col items-center justify-center text-center h-24 hover:bg-surface-container transition-colors">
<span class="font-headline-sm text-headline-sm text-text-main font-bold">Samsung</span>
<span class="font-label-badge text-label-badge text-secondary">Strategic Partner</span>
</div>
<div class="p-space-sm rounded-xl bg-surface-container-low flex flex-col items-center justify-center text-center h-24 hover:bg-surface-container transition-colors">
<span class="font-headline-sm text-headline-sm text-text-main font-bold">Xiaomi</span>
<span class="font-label-badge text-label-badge text-primary">Bảo hành 24T</span>
</div>
<div class="p-space-sm rounded-xl bg-surface-container-low flex flex-col items-center justify-center text-center h-24 hover:bg-surface-container transition-colors">
<span class="font-headline-sm text-headline-sm text-text-main font-bold">OPPO</span>
<span class="font-label-badge text-label-badge text-secondary">Chính Hãng VN</span>
</div>
<div class="p-space-sm rounded-xl bg-surface-container-low flex flex-col items-center justify-center text-center h-24 hover:bg-surface-container transition-colors">
<span class="font-headline-sm text-headline-sm text-text-main font-bold">vivo</span>
<span class="font-label-badge text-label-badge text-secondary">Phân Phối Flagship</span>
</div>
<div class="p-space-sm rounded-xl bg-surface-container-low flex flex-col items-center justify-center text-center h-24 hover:bg-surface-container transition-colors">
<span class="font-headline-sm text-headline-sm text-text-main font-bold">Pixel</span>
<span class="font-label-badge text-label-badge text-primary">Nhập Khẩu Seal</span>
</div>
<div class="p-space-sm rounded-xl bg-surface-container-low flex flex-col items-center justify-center text-center h-24 hover:bg-surface-container transition-colors">
<span class="font-headline-sm text-headline-sm text-text-main font-bold">Nothing</span>
<span class="font-label-badge text-label-badge text-secondary">Độc Quyền PhoneX</span>
</div>
</div>
</div>
</section>
<!-- SECTION 6: ĐIỆN THOẠI MỚI 100% NGUYÊN SEAL VN/A -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-lg">
<div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm mb-space-md">
<div>
<div class="flex items-center gap-2">
<span class="w-2.5 h-2.5 rounded-full bg-primary-container"></span>
<span class="font-label-badge text-label-badge text-primary uppercase font-bold tracking-wider">Hàng Mới 100%</span>
</div>
<h2 class="font-headline-lg text-headline-lg text-text-main tracking-tight mt-1">Điện Thoại Nguyên Seal VN/A</h2>
</div>
<!-- Capacity Filter Chips -->
<div class="flex items-center gap-1.5 overflow-x-auto pb-1">
<button class="px-3 py-1.5 rounded-full bg-primary-container text-on-primary font-label-badge text-label-badge">Tất cả</button>
<button class="px-3 py-1.5 rounded-full bg-surface-pure hover:bg-surface-container text-secondary font-label-badge text-label-badge shadow-sm">128GB</button>
<button class="px-3 py-1.5 rounded-full bg-surface-pure hover:bg-surface-container text-secondary font-label-badge text-label-badge shadow-sm">256GB</button>
<button class="px-3 py-1.5 rounded-full bg-surface-pure hover:bg-surface-container text-secondary font-label-badge text-label-badge shadow-sm">512GB</button>
<button class="px-3 py-1.5 rounded-full bg-surface-pure hover:bg-surface-container text-secondary font-label-badge text-label-badge shadow-sm">1TB</button>
</div>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
<!-- Product 1 -->
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
<div>
<div class="relative w-full aspect-square bg-surface-container-low rounded-lg p-space-sm flex items-center justify-center overflow-hidden mb-space-sm">
<span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded bg-primary-container text-on-primary font-label-badge text-label-badge">Seal VN/A</span>
<img class="w-full h-full object-contain hover:scale-105 transition-transform duration-300" alt="iPhone 16 base model ultramarine blue front view centered high quality official studio product render" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAy0pZVhm7B1wcJsoP8U7rAsSoaYVe6RDQcgIF20KSOA1SlzsB1AuOd2M1Ov9V_qvSZzcPbJjSAYAYLUMYA39Y37XIFlblez91rzmlahxeWXkwfJItwtbKCA0HBH3hBQ-dj3hwLVJOFSw7DhyXznNsFe3Y6KLWpr46X-yoRyUwZTAkmi0MiY469mUd2J5ZqFIHE7RdT1K_UfDvnRWVEpwLGJkWTNQpn1LA_-0JmcDafgH8B5gsLwqha"/>
</div>
<h4 class="font-title-product text-title-product text-text-main">iPhone 16 128GB Chính Hãng VN/A</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Nút Camera Control mới, Chip A18 3nm thế hệ mới, hỗ trợ Apple Intelligence</p>
</div>
<div class="mt-space-md pt-space-sm flex items-center justify-between border-t-0">
<div>
<div class="font-price-card text-price-card text-primary font-bold">21.490.000₫</div>
<div class="font-price-strikethrough text-price-strikethrough text-secondary line-through">22.990.000₫</div>
</div>
<button class="h-9 px-4 rounded-lg bg-surface-container-high hover:bg-primary-container hover:text-on-primary text-text-main font-label-button text-label-button transition-colors" onclick="window.location.href='<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html'">
            Mua Ngay
          </button>
</div>
</div>
<!-- Product 2 -->
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
<div>
<div class="relative w-full aspect-square bg-surface-container-low rounded-lg p-space-sm flex items-center justify-center overflow-hidden mb-space-sm">
<span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded bg-primary-container text-on-primary font-label-badge text-label-badge">Seal SSVN</span>
<img class="w-full h-full object-contain hover:scale-105 transition-transform duration-300" alt="Samsung Galaxy Z Flip6 mint folding smartphone opened half way showing flex mode studio shot" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBarWlk3jzp56qMBuEBfYLjX_Vf0Qr6QG60OBA-PI3zu5xr9rU0SR_26WoNHQE-777V77A1nXber402_dkuMND3j8_QdA_ls57RqI39unMl49aS5inpa1W8OJmUNG8W2T2uKcc-6Emvk---Y8hS6hxAPQBARx3vv5hl7UZW0kM4JQ42eWCZWZ40tT9YmYnhC2VO6WyGZ_XjX76hCJ0_ofQjNldTUFr8APZ28XYd9s02mALFTYGLCx23"/>
</div>
<h4 class="font-title-product text-title-product text-text-main">Galaxy Z Flip6 256GB SSVN</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Màn hình gập bền bỉ bản lề rãnh kép, Camera 50MP ProVisual Engine, Pin 4000mAh</p>
</div>
<div class="mt-space-md pt-space-sm flex items-center justify-between border-t-0">
<div>
<div class="font-price-card text-price-card text-primary font-bold">22.990.000₫</div>
<div class="font-price-strikethrough text-price-strikethrough text-secondary line-through">28.990.000₫</div>
</div>
<button class="h-9 px-4 rounded-lg bg-surface-container-high hover:bg-primary-container hover:text-on-primary text-text-main font-label-button text-label-button transition-colors" onclick="window.location.href='<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html'">
            Mua Ngay
          </button>
</div>
</div>
<!-- Product 3 -->
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
<div>
<div class="relative w-full aspect-square bg-surface-container-low rounded-lg p-space-sm flex items-center justify-center overflow-hidden mb-space-sm">
<span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded bg-inverse-surface text-surface-pure font-label-badge text-label-badge">Độc Quyền</span>
<img class="w-full h-full object-contain hover:scale-105 transition-transform duration-300" alt="Nothing Phone 2 transparent glass back with illuminated white Glyph interface LEDs studio angled render" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCrR54laFyTLoPI8UXJM0NpEmf8TrH2TGXQeASacBHybWj2ASfyBEhq5rFiYW-Rf9p51-wPfXZtKhffZEUC3qW55BNTOEBR3nVTORxioUcvJu4lpHO9HfXm6tzgwSuztgkHHFWEulYsn2t26FIRoC4m7nncSi5Z2ClgjCJLlD3SzuVpWbt-WIv0jfZ67thIsK5-i37qYxf-VGw3bNKEnVbatqqnB2CfqFn8fcBCHanfnbK7t3qVkIFf"/>
</div>
<h4 class="font-title-product text-title-product text-text-main">Nothing Phone (2) 256GB White</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Giao diện Glyph LED độc bản, Nothing OS 2.5 thuần khiết, Snapdragon 8+ Gen 1</p>
</div>
<div class="mt-space-md pt-space-sm flex items-center justify-between border-t-0">
<div>
<div class="font-price-card text-price-card text-primary font-bold">14.990.000₫</div>
<div class="font-price-strikethrough text-price-strikethrough text-secondary line-through">18.490.000₫</div>
</div>
<button class="h-9 px-4 rounded-lg bg-surface-container-high hover:bg-primary-container hover:text-on-primary text-text-main font-label-button text-label-button transition-colors" onclick="window.location.href='<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html'">
            Mua Ngay
          </button>
</div>
</div>
</div>
</section>
<!-- SECTION 7: KHO MÁY CŨ TUYỂN CHỌN ĐỘC BẢN (PRE-OWNED VAULT) -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-lg" id="preowned-vault">
<div class="rounded-2xl bg-surface-pure p-space-md lg:p-space-lg shadow-sm">
<div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm mb-space-md">
<div>
<div class="flex items-center gap-2">
<span class="px-2 py-0.5 rounded bg-primary-container text-on-primary font-label-badge text-label-badge font-bold">CHỈ CÓ 1 CÂY DUY NHẤT</span>
<span class="text-secondary font-body-sm text-body-sm">Đã test 68 bước độc quyền PhoneX</span>
</div>
<h2 class="font-headline-lg text-headline-lg text-text-main tracking-tight mt-1">Kho Máy Cũ Tuyển Chọn (Pre-Owned Grade A)</h2>
</div>
<a class="inline-flex items-center gap-1 font-label-button text-label-button text-primary hover:text-primary-hover" data-path="preowned-vault" href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>">
          Xem toàn bộ 142 máy sẵn sàng bàn giao
          <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
<!-- Unique Card 1 -->
<div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
<div>
<div class="flex items-center justify-between font-mono text-xs text-secondary mb-2">
<span class="px-2 py-0.5 rounded bg-surface-container font-bold text-text-main">MÃ: #USED-8821</span>
<span class="text-primary font-bold">Sạc 72 lần</span>
</div>
<div class="relative w-full aspect-[4/3] bg-surface-container-low rounded-lg p-space-sm flex items-center justify-center overflow-hidden mb-space-sm">
<span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed-variant font-label-badge text-label-badge font-bold">Pin Zin 98%</span>
<img class="w-full h-full object-contain hover:scale-105 transition-transform duration-300" alt="Detailed real inspection shot of iPhone 15 Pro Max titanium natural grade A pristine back and bezel edge test" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAvPpLinqYu2mtmN0x0jvdHymXKKDxMxgR4GUz4VPin-wnfYsKJMjU5KOHbE2nom9fZUQYlEvKbi5N4-mx48qjB9ZBd0sDVGD8Jk0D0N06AEeHGnlPF-zV9XSDsPjjC5fS68gtrOkpQ9hZcD5n4XvfqHyima4ZdjtUoJrgAqKLTITErd9s2_61SMrk3tiCsx6IGSP3nLjB83kEfaIcHbYErwWlngjgLi3bV1UHJej3kt2Js_D4UpTCk"/>
</div>
<h4 class="font-headline-sm text-headline-sm text-text-main">iPhone 15 Pro Max 256GB</h4>
<div class="flex items-center gap-2 mt-1">
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">Titan Tự Nhiên</span>
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">Grade A (99%)</span>
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">VN/A</span>
</div>
<p class="font-body-sm text-body-sm text-secondary mt-2">Ngoại hình không trầy xước, camera nguyên bản, màn hình sáng đều không lưu ảnh.</p>
</div>
<div class="pt-space-md mt-space-md border-t-0 flex items-center justify-between">
<div>
<div class="font-headline-sm text-headline-sm text-primary font-bold">24.490.000₫</div>
<div class="font-body-sm text-body-sm text-secondary">Bảo hành 12T nguồn + màn</div>
</div>
<button class="h-10 px-4 rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button transition-colors" onclick="window.location.href='<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html'">
              Đặt Cọc &amp; Giữ Máy
            </button>
</div>
</div>
<!-- Unique Card 2 -->
<div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
<div>
<div class="flex items-center justify-between font-mono text-xs text-secondary mb-2">
<span class="px-2 py-0.5 rounded bg-surface-container font-bold text-text-main">MÃ: #USED-9932</span>
<span class="text-primary font-bold">Sạc 28 lần</span>
</div>
<div class="relative w-full aspect-[4/3] bg-surface-container-low rounded-lg p-space-sm flex items-center justify-center overflow-hidden mb-space-sm">
<span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed-variant font-label-badge text-label-badge font-bold">Pin Zin 100%</span>
<img class="w-full h-full object-contain hover:scale-105 transition-transform duration-300" alt="Real inspection shot of Samsung Galaxy S24 Ultra titanium gray mint condition screen and pen slot" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBQVxYGo99Ni3Bo9kw8hK1gncdjMlgDR81Gyxss8-6mGMzvhbYmHdffwlQmodVzRM3oI7YLHSWun3cnzXEkxQfaifUYeegfPZEdQ5TYMO_kujpGcPqRM3YJGklhZ8n9X8-rl3BEz7KWs6fOFiWrJsIeqcr98cMEzk_kl4-lbB7qvOWZWW5Z4BGSWwIscj_pyl7IqO4488_cW3OiUPxjwppiNGe0flndsdJtKw8TnD3YAoS8-LxG1ffx"/>
</div>
<h4 class="font-headline-sm text-headline-sm text-text-main">Galaxy S24 Ultra 512GB</h4>
<div class="flex items-center gap-2 mt-1">
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">Titan Xám</span>
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">Grade A (99%)</span>
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">SSVN</span>
</div>
<p class="font-body-sm text-body-sm text-secondary mt-2">Máy lướt như mới, nguyên hộp phụ kiện chính hãng, còn bảo hành Samsung Care+ 6 tháng.</p>
</div>
<div class="pt-space-md mt-space-md border-t-0 flex items-center justify-between">
<div>
<div class="font-headline-sm text-headline-sm text-primary font-bold">22.890.000₫</div>
<div class="font-body-sm text-body-sm text-secondary">Bảo hành 12T nguồn + màn</div>
</div>
<button class="h-10 px-4 rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button transition-colors" onclick="window.location.href='<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html'">
              Đặt Cọc &amp; Giữ Máy
            </button>
</div>
</div>
<!-- Unique Card 3 -->
<div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
<div>
<div class="flex items-center justify-between font-mono text-xs text-secondary mb-2">
<span class="px-2 py-0.5 rounded bg-surface-container font-bold text-text-main">MÃ: #USED-7410</span>
<span class="text-primary font-bold">Sạc 110 lần</span>
</div>
<div class="relative w-full aspect-[4/3] bg-surface-container-low rounded-lg p-space-sm flex items-center justify-center overflow-hidden mb-space-sm">
<span class="absolute top-2 left-2 z-10 px-2 py-0.5 rounded bg-primary-fixed text-on-primary-fixed-variant font-label-badge text-label-badge font-bold">Pin Zin 96%</span>
<img class="w-full h-full object-contain hover:scale-105 transition-transform duration-300" alt="iPhone 14 Pro Max deep purple grade A inspected refurbished studio shot on white background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBA7s1V8mIdMBF7XRj1uOtSJCic_UZ_b1LcOjQGHfjbK0ZXD8COOY-dTn0t5zZNQqvqBpyPU2XQrA6syYB3plUpgensBu0-jIKKKmNOEWdX4VNVMp28nQpbrWVmWFlczO_tGv65MR_n8txrsk0xRqCEDTkmjPXV3EKjKuWA8sYv0J14bpPcSrGemuzlRaQI4pJIpPocUqDmGhKswTjG6MumXduiOq-UwxhH-GeFZf5L5ILbDEOGFzqR"/>
</div>
<h4 class="font-headline-sm text-headline-sm text-text-main">iPhone 14 Pro Max 128GB</h4>
<div class="flex items-center gap-2 mt-1">
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">Tím Đậm (Deep Purple)</span>
<span class="text-xs px-2 py-0.5 rounded bg-surface-container text-secondary">Grade A+</span>
</div>
<p class="font-body-sm text-body-sm text-secondary mt-2">Dòng máy giữ giá tốt nhất, FaceID siêu nhạy, viền thép bóng không cấn móp.</p>
</div>
<div class="pt-space-md mt-space-md border-t-0 flex items-center justify-between">
<div>
<div class="font-headline-sm text-headline-sm text-primary font-bold">18.990.000₫</div>
<div class="font-body-sm text-body-sm text-secondary">Bảo hành 12T nguồn + màn</div>
</div>
<button class="h-10 px-4 rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button transition-colors" onclick="window.location.href='<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html'">
              Đặt Cọc &amp; Giữ Máy
            </button>
</div>
</div>
</div>
</div>
</section>
<!-- SECTION 8: WIDGET ĐỊNH GIÁ THU CŨ LÊN ĐỜI 60 GIÂY -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-lg" id="trade-in-calculator">
<div class="bg-surface-pure rounded-2xl p-space-lg lg:p-space-xl shadow-sm">
<div class="max-w-3xl mb-space-lg">
<span class="font-label-badge text-label-badge text-primary uppercase font-bold tracking-wider">Trợ Giá Trực Tiếp Đến 3.000.000₫</span>
<h2 class="font-headline-lg text-headline-lg text-text-main tracking-tight mt-1">Công Cụ Định Giá Thu Cũ Lên Đời 60 Giây</h2>
<p class="font-body-regular text-body-regular text-secondary mt-1">Không giữ máy, không phân biệt máy xách tay hay chính hãng. Định giá ngay tức thì với AI chuẩn xác.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">
<!-- Interactive Step Selector (9 Cols) -->
<div class="lg:col-span-7 space-y-space-md">
<!-- Step 1 -->
<div>
<label class="block font-label-button text-label-button text-text-main mb-2">Bước 1: Chọn thương hiệu thiết bị của bạn</label>
<div class="grid grid-cols-4 gap-2">
<button class="h-11 rounded-lg bg-primary-container text-on-primary font-label-button text-label-button flex items-center justify-center">Apple</button>
<button class="h-11 rounded-lg bg-surface-container-low hover:bg-surface-container text-text-main font-label-button text-label-button flex items-center justify-center" onclick="window.location.href='<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>'">Samsung</button>
<button class="h-11 rounded-lg bg-surface-container-low hover:bg-surface-container text-text-main font-label-button text-label-button flex items-center justify-center" onclick="window.location.href='<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>'">Xiaomi</button>
<button class="h-11 rounded-lg bg-surface-container-low hover:bg-surface-container text-text-main font-label-button text-label-button flex items-center justify-center">Hãng Khác</button>
</div>
</div>
<!-- Step 2 -->
<div>
<label class="block font-label-button text-label-button text-text-main mb-2">Bước 2: Chọn dòng máy &amp; Dung lượng bộ nhớ</label>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
<select class="h-11 px-3 bg-surface-container-low rounded-lg font-body-sm text-body-sm text-text-main focus:outline-none focus:ring-1 focus:ring-primary-container">
<option>iPhone 14 Pro Max</option>
<option>iPhone 14 Pro</option>
<option>iPhone 13 Pro Max</option>
<option>iPhone 15 Pro Max</option>
</select>
<select class="h-11 px-3 bg-surface-container-low rounded-lg font-body-sm text-body-sm text-text-main focus:outline-none focus:ring-1 focus:ring-primary-container">
<option>256GB</option>
<option>128GB</option>
<option>512GB</option>
<option>1TB</option>
</select>
</div>
</div>
<!-- Step 3 -->
<div>
<label class="block font-label-button text-label-button text-text-main mb-2">Bước 3: Tình trạng ngoại hình &amp; chức năng</label>
<div class="space-y-2">
<label class="flex items-center gap-3 p-3 rounded-lg bg-surface-container-low cursor-pointer hover:bg-surface-container transition-colors">
<input checked="" class="text-primary-container focus:ring-0 w-4 h-4" name="condition" type="radio"/>
<div class="flex-1">
<div class="font-label-button text-label-button text-text-main">Loại 1: Đẹp 99% - Máy hoạt động hoàn hảo, không trầy xước</div>
<div class="font-body-sm text-body-sm text-secondary">Màn hình đẹp, pin trên 85%, đầy đủ chức năng FaceID/Vân tay.</div>
</div>
</label>
<label class="flex items-center gap-3 p-3 rounded-lg bg-surface-container-low cursor-pointer hover:bg-surface-container transition-colors">
<input class="text-primary-container focus:ring-0 w-4 h-4" name="condition" type="radio"/>
<div class="flex-1">
<div class="font-label-button text-label-button text-text-main">Loại 2: Đẹp 95% - Trầy xước nhẹ viền kính, không cấn móp</div>
<div class="font-body-sm text-body-sm text-secondary">Màn hình không ám ố, chức năng ổn định 100%.</div>
</div>
</label>
</div>
</div>
</div>
<!-- Calculator Result Card (5 Cols) -->
<div class="lg:col-span-5 bg-surface-container-low rounded-xl p-space-md lg:p-space-lg flex flex-col justify-between">
<div>
<h3 class="font-headline-sm text-headline-sm text-text-main pb-space-sm border-b-0">Bảng Tính Giá Trị Lên Đời</h3>
<div class="space-y-space-sm mt-space-sm">
<div class="flex justify-between font-body-sm text-body-sm text-secondary">
<span>Thiết bị thu vào:</span>
<span class="font-label-button text-label-button text-text-main">iPhone 14 Pro Max 256GB</span>
</div>
<div class="flex justify-between font-body-sm text-body-sm text-secondary">
<span>Phân loại tình trạng:</span>
<span class="font-label-button text-label-button text-text-main">Loại 1 (Đẹp 99%)</span>
</div>
<div class="flex justify-between font-body-sm text-body-sm text-secondary">
<span>Giá thu cơ bản:</span>
<span class="font-label-button text-label-button text-text-main">16.500.000₫</span>
</div>
<div class="flex justify-between font-body-sm text-body-sm text-primary font-bold">
<span>Trợ giá PhoneX VIP:</span>
<span>+3.000.000₫</span>
</div>
<div class="p-3 bg-surface-pure rounded-lg mt-space-md">
<div class="font-body-sm text-body-sm text-secondary">Tổng số tiền bạn nhận được:</div>
<div class="font-headline-lg text-headline-lg text-primary font-bold mt-1">19.500.000₫</div>
<p class="font-body-sm text-body-sm text-secondary mt-1">Trừ thẳng vào giá mua iPhone 18 Pro Max hoặc Galaxy S25 Ultra.</p>
</div>
</div>
</div>
<button class="mt-space-md w-full h-12 rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button shadow-sm transition-colors flex items-center justify-center gap-2" onclick="window.location.href='<?php echo esc_url(home_url("/thu-cu-doi-moi/")); ?>'">
<span class="material-symbols-outlined text-[20px]">bolt</span>
            Lên Đời Ngay Trong 60s
          </button>
</div>
</div>
</div>
</section>
<!-- SECTION 9: CHỌN ĐIỆN THOẠI THEO NHU CẦU -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-lg">
<div class="mb-space-md">
<span class="font-label-badge text-label-badge text-primary uppercase font-bold tracking-wider">Trợ Lý Mua Sắm Cá Nhân Hóa</span>
<h2 class="font-headline-lg text-headline-lg text-text-main tracking-tight mt-1">Chọn Smartphone Theo Nhu Cầu Của Bạn</h2>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-gutter">
<!-- Feature 1 -->
<a class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between" data-path="deals" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html">
<div>
<div class="w-12 h-12 rounded-xl bg-surface-container-high group-hover:bg-primary/10 flex items-center justify-center text-primary mb-space-sm transition-colors">
<span class="material-symbols-outlined text-[28px]">videocam</span>
</div>
<h4 class="font-headline-sm text-headline-sm text-text-main group-hover:text-primary transition-colors">Chụp Ảnh &amp; Vlog</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Camera cảm biến 1-inch, chống rung OIS quang học, màu Leica/Zeiss chân thực.</p>
</div>
<span class="inline-flex items-center gap-1 font-label-badge text-label-badge text-primary font-bold mt-4">
          14 mẫu flagship
          <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
</span>
</a>
<!-- Feature 2 -->
<a class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between" data-path="deals" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html">
<div>
<div class="w-12 h-12 rounded-xl bg-surface-container-high group-hover:bg-primary/10 flex items-center justify-center text-primary mb-space-sm transition-colors">
<span class="material-symbols-outlined text-[28px]">sports_esports</span>
</div>
<h4 class="font-headline-sm text-headline-sm text-text-main group-hover:text-primary transition-colors">Cày Game Nặng</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Snapdragon 8 Elite, tản nhiệt buồng hơi lớn, tần số quét màn hình 144Hz.</p>
</div>
<span class="inline-flex items-center gap-1 font-label-badge text-label-badge text-primary font-bold mt-4">
          9 mẫu hiệu năng
          <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
</span>
</a>
<!-- Feature 3 -->
<a class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between" data-path="deals" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html">
<div>
<div class="w-12 h-12 rounded-xl bg-surface-container-high group-hover:bg-primary/10 flex items-center justify-center text-primary mb-space-sm transition-colors">
<span class="material-symbols-outlined text-[28px]">battery_charging_full</span>
</div>
<h4 class="font-headline-sm text-headline-sm text-text-main group-hover:text-primary transition-colors">Pin Trâu 2 Ngày</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Dung lượng cực đại 6000mAh+, chip tối ưu tiết kiệm pin, sạc nhanh 120W.</p>
</div>
<span class="inline-flex items-center gap-1 font-label-badge text-label-badge text-primary font-bold mt-4">
          12 mẫu pin khủng
          <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
</span>
</a>
<!-- Feature 4 -->
<a class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between" data-path="deals" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/used-detail/index.html">
<div>
<div class="w-12 h-12 rounded-xl bg-surface-container-high group-hover:bg-primary/10 flex items-center justify-center text-primary mb-space-sm transition-colors">
<span class="material-symbols-outlined text-[28px]">devices_fold</span>
</div>
<h4 class="font-headline-sm text-headline-sm text-text-main group-hover:text-primary transition-colors">Màn Gập AI</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Thời thượng, gọn nhẹ, đa nhiệm song song với bộ tính năng Galaxy AI thông minh.</p>
</div>
<span class="inline-flex items-center gap-1 font-label-badge text-label-badge text-primary font-bold mt-4">
          6 mẫu gập cao cấp
          <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
</span>
</a>
<!-- Feature 5 -->
<a class="bg-surface-pure rounded-xl p-space-md shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between" data-path="deals" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html">
<div>
<div class="w-12 h-12 rounded-xl bg-surface-container-high group-hover:bg-primary/10 flex items-center justify-center text-primary mb-space-sm transition-colors">
<span class="material-symbols-outlined text-[28px]">school</span>
</div>
<h4 class="font-headline-sm text-headline-sm text-text-main group-hover:text-primary transition-colors">HSSV Trợ Giá</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Giảm thêm 500k khi xuất trình thẻ sinh viên, trả góp không cần chứng minh thu nhập.</p>
</div>
<span class="inline-flex items-center gap-1 font-label-badge text-label-badge text-primary font-bold mt-4">
          Xem chính sách HSSV
          <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
</span>
</a>
</div>
</section>
<!-- SECTION 10: ƯU ĐÃI THANH TOÁN -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-md">
<div class="bg-gradient-to-r from-surface-pure via-surface-container-low to-surface-pure rounded-2xl p-space-md lg:p-space-lg shadow-sm">
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter items-center">
<div class="flex items-center gap-space-md p-space-sm">
<div class="w-12 h-12 rounded-xl bg-primary-fixed text-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[28px]">qr_code_scanner</span>
</div>
<div>
<div class="font-headline-sm text-headline-sm text-text-main">Giảm ngay 500.000₫</div>
<p class="font-body-sm text-body-sm text-secondary mt-0.5">Khi quét thanh toán qua VNPAY-QR đơn hàng từ 15 triệu.</p>
</div>
</div>
<div class="flex items-center gap-space-md p-space-sm">
<div class="w-12 h-12 rounded-xl bg-surface-container-high text-text-main flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[28px]">credit_card</span>
</div>
<div>
<div class="font-headline-sm text-headline-sm text-text-main">Hoàn tiền 2.000.000₫</div>
<p class="font-body-sm text-body-sm text-secondary mt-0.5">Mở mới thẻ tín dụng đối tác (Techcombank, VPBank, Shinhan Bank).</p>
</div>
</div>
<div class="flex items-center gap-space-md p-space-sm">
<div class="w-12 h-12 rounded-xl bg-primary-fixed text-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[28px]">account_balance_wallet</span>
</div>
<div>
<div class="font-headline-sm text-headline-sm text-text-main">Trả Góp 0% Duyệt 5 Phút</div>
<p class="font-body-sm text-body-sm text-secondary mt-0.5">Thủ tục chỉ cần CCCD gắn chip, không gọi người thân thẩm định.</p>
</div>
</div>
</div>
</div>
</section>
<!-- SECTION 11: PHONEX LAB & TIN TỨC CÔNG NGHỆ -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-lg">
<div class="flex items-center justify-between mb-space-md">
<div>
<span class="font-label-badge text-label-badge text-primary uppercase font-bold tracking-wider">Chuyên Sâu Điện Thoại</span>
<h2 class="font-headline-lg text-headline-lg text-text-main tracking-tight mt-1">PhoneX Lab &amp; Đánh Giá Công Nghệ</h2>
</div>
<a class="hidden sm:inline-flex items-center gap-1 font-label-button text-label-button text-primary hover:text-primary-hover" data-path="promotions" href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/promotions/promotions/index.html">
        Tất cả bài viết
        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
<!-- Article 1 -->
<article class="bg-surface-pure rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between">
<div>
<div class="w-full h-48 overflow-hidden bg-surface-container-low">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Close up photography of mobile microchips Snapdragon 8 Elite and Apple A19 Pro on futuristic blue electronic circuit board" src="https://lh3.googleusercontent.com/aida-public/AB6AXuABkYKvKU87uhADeOeJWYMAHRa4qNYOsgKlDGG-ubrBeOHavipaSGvV2dZr3I_lYYUYwCYNgIL-zztO-ATkblMuov_8vqGA1CsvxssGpOo7P0_l_LPpILFh9pEp6pyw6ab7hBdzI7CFbENMdXwmtg-YcQbS-dX1RJd6soV_UdETPn189nuOYhUQZ_kKbH9qN8fuSzpXwiEYObBXqRT2O1WZj01CfkMjRWYD6fvSGAbJVZf6ia5x016I"/>
</div>
<div class="p-space-md">
<div class="flex items-center gap-2 font-label-badge text-label-badge text-secondary mb-2">
<span class="text-primary font-bold">SO SÁNH CHIP</span>
<span>•</span>
<span>15 phút đọc</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-main group-hover:text-primary transition-colors line-clamp-2">
              Apple A19 Pro vs Snapdragon 8 Elite: Cuộc Chiến Tiến Trình 2nm AI Toàn Diện
            </h3>
<p class="font-body-sm text-body-sm text-secondary mt-2 line-clamp-2">
              Đánh giá chi tiết hiệu năng ray-tracing và thời lượng pin thực tế sau 72 giờ stress-test liên tục tại phòng thí nghiệm PhoneX Lab.
            </p>
</div>
</div>
<div class="px-space-md pb-space-md font-label-button text-label-button text-primary flex items-center gap-1">
          Đọc bài đánh giá
          <span class="material-symbols-outlined text-[16px]">chevron_right</span>
</div>
</article>
<!-- Article 2 -->
<article class="bg-surface-pure rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between">
<div>
<div class="w-full h-48 overflow-hidden bg-surface-container-low">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Macro photo showing optical camera zoom lens mechanism inside a titanium modern flagship smartphone" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjY-eWlO8QapByp-ewBHY8hGiTC6W3IZI9f7jxs6ws36W0ryHyKla4TGA5Zbq435cc9XKMQovC524YVV7SZDpV1ACex4aXoeVs7LFUZgK6vk4pNiEgUsM8HDaqGngxN1nXnONntU0z3j0h2to287nUSM-LBqKgyvNS2jGNFJ0e5fpEyhLnEo0-u-0qRol8QhPV7jY87YkQiqS9dhiArtFUjdJU1YkkIhPR4sgCjBkubO_hQhDdraQ0"/>
</div>
<div class="p-space-md">
<div class="flex items-center gap-2 font-label-badge text-label-badge text-secondary mb-2">
<span class="text-primary font-bold">CAMERA TEST</span>
<span>•</span>
<span>8 phút đọc</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-main group-hover:text-primary transition-colors line-clamp-2">
              Thử Nghiệm Camera 200MP Của Galaxy S25 Ultra Trong Điều Kiện Ánh Sáng Yếu
            </h3>
<p class="font-body-sm text-body-sm text-secondary mt-2 line-clamp-2">
              Cảm biến thế hệ mới xử lý nhiễu hạt và thuật toán phơi sáng đêm cải tiến như thế nào so với thế hệ S24 Ultra tiền nhiệm?
            </p>
</div>
</div>
<div class="px-space-md pb-space-md font-label-button text-label-button text-primary flex items-center gap-1">
          Đọc bài đánh giá
          <span class="material-symbols-outlined text-[16px]">chevron_right</span>
</div>
</article>
<!-- Article 3 -->
<article class="bg-surface-pure rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between">
<div>
<div class="w-full h-48 overflow-hidden bg-surface-container-low">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Technician inspecting an open pre-owned smartphone under microscope in clean tech lab environment" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAp_MpPfx2BLgyzTx8x-mZJNzzawInEM7PXNwYKVxzCu_yj67R3jszCaVzpPR2CHO2PXWEGnb5ecONImteypRDlLYI8SgXWJiI-LNU0F8GncwD-ymxK9-X2C1wRIn_F7w5IGalxX2fKcSUHxTTCAM_tMlfOzKvPMS7IOS86LSyyOrcxD0p7g6CkkhQinVzKD9nr_5ccXXgwfNTbCf4u6RF8ZwPn6vXS4cJpKqn60n3Y1txZyKLohMtM"/>
</div>
<div class="p-space-md">
<div class="flex items-center gap-2 font-label-badge text-label-badge text-secondary mb-2">
<span class="text-primary font-bold">CẨM NANG MÁY CŨ</span>
<span>•</span>
<span>10 phút đọc</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-main group-hover:text-primary transition-colors line-clamp-2">
              Quy Trình Kiểm Tra 68 Bước: Cách PhoneX Loại Bỏ 100% Máy Ép Kính &amp; Pin Kém
            </h3>
<p class="font-body-sm text-body-sm text-secondary mt-2 line-clamp-2">
              Bật mí toàn bộ thiết bị đo xung nhịp bo mạch và tiêu chuẩn chẩn đoán máy cũ độc quyền bảo vệ quyền lợi người mua.
            </p>
</div>
</div>
<div class="px-space-md pb-space-md font-label-button text-label-button text-primary flex items-center gap-1">
          Đọc bài đánh giá
          <span class="material-symbols-outlined text-[16px]">chevron_right</span>
</div>
</article>
</div>
</section>
<!-- SECTION 12: HỆ THỐNG 128 CỬA HÀNG & SHOWROOM TRẢI NGHIỆM -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-lg">
<div class="bg-surface-pure rounded-2xl p-space-md lg:p-space-lg shadow-sm">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-center">
<!-- Store info (5 Cols) -->
<div class="lg:col-span-5 space-y-space-md">
<div>
<span class="font-label-badge text-label-badge text-primary uppercase font-bold tracking-wider">Hạ Tầng Dịch Vụ</span>
<h2 class="font-headline-lg text-headline-lg text-text-main tracking-tight mt-1">Trải Nghiệm Tại 128 Showroom Toàn Quốc</h2>
<p class="font-body-sm text-body-sm text-secondary mt-1">
              Đến và cầm trên tay trực tiếp tất cả các dòng Flagship hàng đầu, kiểm tra máy cũ công khai cùng kỹ thuật viên chuyên sâu.
            </p>
</div>
<div class="space-y-space-xs font-body-sm text-body-sm">
<div class="p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors">
<div class="font-label-button text-label-button text-text-main">Showroom Flagship Hà Nội:</div>
<div class="text-secondary mt-0.5">58 Thái Hà, Q. Đống Đa &amp; 102 Cầu Giấy (Mở cửa 8h - 22h)</div>
</div>
<div class="p-space-sm rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors">
<div class="font-label-button text-label-button text-text-main">Showroom Flagship TP.HCM:</div>
<div class="text-secondary mt-0.5">136 Nguyễn Thái Học, Quận 1 &amp; 379 Võ Văn Tần, Quận 3</div>
</div>
</div>
<div class="flex items-center gap-space-sm pt-space-xs">
<a class="h-11 px-space-md rounded-lg bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button flex items-center justify-center gap-1.5 transition-colors" href="tel:18006868">
<span class="material-symbols-outlined text-[18px]">call</span>
              Hotline 1800.6868 (Miễn Phí)
            </a>
<a class="h-11 px-space-md rounded-lg bg-surface-container-low hover:bg-surface-container text-text-main font-label-button text-label-button flex items-center justify-center transition-colors" data-path="store-network" href="<?php echo esc_url(home_url("/showroom/")); ?>">
              Tìm showroom gần nhất
            </a>
</div>
</div>
<!-- Visual Map Display (7 Cols) -->
<div class="lg:col-span-7">
<div class="w-full h-80 rounded-xl bg-cover bg-center overflow-hidden shadow-inner relative flex items-end p-space-md" data-location="Ho Chi Minh City, Vietnam" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAaDw8ItDZ4rR7aaEEJZpXJIt7W6YWZGqRj2_n1KfCI8nwONquaJzCCOT5oxDjYoOSt7H-HEW-AcdVtRzs44plX_S85ed3n418kFVwDQMANEtQrsYB9Cl99ENqxaTd8FRTcTBpOm-t0w_t6cbIbgcIMOK7vRjOXmt69SaTxO4XO8U3KebcobLqZILNjAxkvwHiX6_aiQJhGFKT2ma3QpOu4iKsS2YfQdAli98IQIDe_Mkb9mB6J5YdB');">
<div class="bg-surface-pure/95 backdrop-blur-md p-space-sm rounded-lg shadow-sm flex items-center gap-3">
<div class="w-3 h-3 rounded-full bg-primary-container animate-ping"></div>
<span class="font-body-sm text-body-sm text-text-main font-medium">128 Cửa hàng đang phục vụ khách mua sắm hôm nay</span>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- SECTION 13: 4 CAM KẾT VÀNG & CHÍNH SÁCH BẢO HÀNH -->
<section class="w-full max-w-7xl mx-auto px-margin py-space-lg mb-space-xl">
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
<!-- Commitment 1 -->
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm flex items-start gap-space-sm">
<div class="w-10 h-10 rounded-lg bg-primary-fixed text-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[24px]">verified</span>
</div>
<div>
<h4 class="font-headline-sm text-headline-sm text-text-main">Kiểm Định 68 Bước</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Đảm bảo máy nguyên zin, chưa qua sửa chữa bo mạch hay thay màn linh kiện.</p>
</div>
</div>
<!-- Commitment 2 -->
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm flex items-start gap-space-sm">
<div class="w-10 h-10 rounded-lg bg-primary-fixed text-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[24px]">battery_saver</span>
</div>
<div>
<h4 class="font-headline-sm text-headline-sm text-text-main">Báo Chuẩn Pin &amp; Ảnh Thật</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Ảnh thực tế từng cây máy, cam kết số lần sạc và dung lượng pin zin đúng 100%.</p>
</div>
</div>
<!-- Commitment 3 -->
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm flex items-start gap-space-sm">
<div class="w-10 h-10 rounded-lg bg-primary-fixed text-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[24px]">sync</span>
</div>
<div>
<h4 class="font-headline-sm text-headline-sm text-text-main">1 Đổi 1 Trong 30 Ngày</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Lỗi phần cứng do nhà sản xuất là đổi ngay máy tương đương, không giam máy kiểm tra.</p>
</div>
</div>
<!-- Commitment 4 -->
<div class="bg-surface-pure rounded-xl p-space-md shadow-sm flex items-start gap-space-sm">
<div class="w-10 h-10 rounded-lg bg-primary-fixed text-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[24px]">security</span>
</div>
<div>
<h4 class="font-headline-sm text-headline-sm text-text-main">Bảo Hành Nguồn &amp; Màn</h4>
<p class="font-body-sm text-body-sm text-secondary mt-1">Gói bảo hành toàn diện cả màn hình, camera và nguồn trong suốt 12 tháng sử dụng.</p>
</div>
</div>
</div>
</section>

<!-- SECTION 14: PHONEX 46-SCREEN UI REVIEW & NAVIGATION HUB -->
<section id="phonex-ui-hub" class="w-full bg-gradient-to-b from-gray-50 to-gray-100 border-t border-b border-gray-200 py-12 px-4 my-8">
  <div class="max-w-7xl mx-auto">
    <!-- Header banner -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
      <div>
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-100 text-red-700 font-bold text-sm uppercase tracking-wider mb-2">
          <span class="material-symbols-outlined text-[18px]">visibility</span>
          Trung Tâm Kiểm Tra Giao Diện PhoneX
        </div>
        <h2 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">
          Sơ Đồ Điều Hướng &amp; Kiểm Tra 46 Màn Hình Giao Diện
        </h2>
        <p class="text-base md:text-lg text-gray-600 mt-2 max-w-3xl leading-relaxed">
          Bấm trực tiếp vào bất kỳ trang nào dưới đây để kiểm tra thiết kế, bố cục responsive và trải nghiệm người dùng trước khi bàn giao.
        </p>
      </div>
      <div class="flex items-center gap-3">
        <a href="<?php echo esc_url(get_template_directory_uri()); ?>/dev-pages.html" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold text-sm md:text-base shadow-sm hover:shadow transition-all flex items-center gap-2">
          <span class="material-symbols-outlined text-[18px]">dashboard</span>
          Mở Dashboard 46 Trang (Site Map)
        </a>
      </div>
    </div>

    <!-- 6 Module Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200/80 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
            <h3 class="font-extrabold text-gray-900 text-base md:text-lg flex items-center gap-2">🛒 Mua Sắm & Đơn Hàng</h3>
            <span class="text-xs md:text-sm font-bold px-3 py-1 rounded-full bg-red-100 text-red-700">15 trang</span>
          </div>
          <ul class="space-y-1">
            
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/home/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Trang chủ Flagship</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("shop") : home_url("/shop/")); ?>" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Tất cả sản phẩm</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/product-detail/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Chi tiết máy mới</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/used-detail/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Chi tiết máy cũ 99%</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/series/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Dòng máy iPhone 18</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/brand/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Thương hiệu Apple VN/A</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/search/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Kết quả tìm kiếm</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/search-filter/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Bộ lọc chuyên sâu</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/compare/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">So sánh cấu hình</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(function_exists("wc_get_cart_url") ? wc_get_cart_url() : home_url("/cart/")); ?>" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Giỏ hàng & Ưu đãi</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/checkout/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Thanh toán đặt hàng</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/click-collect/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Nhận tại cửa hàng</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/order-success/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Đặt hàng thành công</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(home_url("/tra-cuu-don-hang/")); ?>" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Tra cứu đơn hàng</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/shop/order-detail/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Chi tiết đơn hàng</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
          </ul>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200/80 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
            <h3 class="font-extrabold text-gray-900 text-base md:text-lg flex items-center gap-2">🔄 Thu Cũ Đổi Mới / Trade-in</h3>
            <span class="text-xs md:text-sm font-bold px-3 py-1 rounded-full bg-amber-100 text-amber-800">9 trang</span>
          </div>
          <ul class="space-y-1">
            
              <li>
                <a href="<?php echo esc_url(home_url("/thu-cu-doi-moi/")); ?>" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Trang chủ Thu cũ đổi mới</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/trade-in/device-selection/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Chọn thiết bị cần bán</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/trade-in/valuation/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Khảo sát tình trạng máy</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/trade-in/valuation-result/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Báo giá thu mua</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/trade-in/sell-registration/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Đăng ký bán máy</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/trade-in/sell-success/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Gửi yêu cầu thành công</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/trade-in/tradein-result/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Tính bù tiền Trade-in</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/trade-in/tradein-tracking/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Tra cứu hồ sơ bằng SĐT</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/trade-in/tradein-detail/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Chi tiết hồ sơ Thu cũ</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
          </ul>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200/80 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
            <h3 class="font-extrabold text-gray-900 text-base md:text-lg flex items-center gap-2">🏢 Hệ Thống 128 Cửa Hàng</h3>
            <span class="text-xs md:text-sm font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-700">8 trang</span>
          </div>
          <ul class="space-y-1">
            
              <li>
                <a href="<?php echo esc_url(home_url("/showroom/")); ?>" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Danh sách 128 Showroom</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/stores/store-detail/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Chi tiết Showroom</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/stores/find-store-stock/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Tìm cửa hàng còn máy</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/stores/stock-check/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Kiểm tra tồn kho</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/stores/reserve-store/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Đặt giữ máy tại shop</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/stores/reserve-success/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Giữ máy thành công</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/stores/reserve-tracking/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Tra cứu phiếu giữ máy</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/stores/used-phones/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Máy cũ theo cửa hàng</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
          </ul>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200/80 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
            <h3 class="font-extrabold text-gray-900 text-base md:text-lg flex items-center gap-2">👤 Tài Khoản Khách Hàng</h3>
            <span class="text-xs md:text-sm font-bold px-3 py-1 rounded-full bg-purple-100 text-purple-700">8 trang</span>
          </div>
          <ul class="space-y-1">
            
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/account/login-phone-otp/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Đăng nhập SĐT + OTP</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("myaccount") : home_url("/my-account/")); ?>" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Trung tâm tài khoản VIP</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/account/profile/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Hồ sơ cá nhân</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/account/addresses/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Sổ địa chỉ nhận hàng</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/account/my-orders/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Đơn hàng của tôi</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/account/my-tradein/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Hồ sơ Trade-in của tôi</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/account/favorites/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Sản phẩm yêu thích</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/account/notifications/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Trung tâm thông báo</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
          </ul>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200/80 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
            <h3 class="font-extrabold text-gray-900 text-base md:text-lg flex items-center gap-2">🛡️ Bảo Hành Điện Tử</h3>
            <span class="text-xs md:text-sm font-bold px-3 py-1 rounded-full bg-green-100 text-green-700">4 trang</span>
          </div>
          <ul class="space-y-1">
            
              <li>
                <a href="<?php echo esc_url(home_url("/bao-hanh/")); ?>" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Tra cứu bảo hành IMEI/SĐT</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/warranty/warranty-devices/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Danh sách thiết bị</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/warranty/warranty-request/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Tạo yêu cầu hẹn sửa chữa</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/warranty/warranty-detail/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Chi tiết tiến độ xử lý</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
          </ul>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200/80 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
            <h3 class="font-extrabold text-gray-900 text-base md:text-lg flex items-center gap-2">🎁 Khuyến Mãi & Ưu Đãi</h3>
            <span class="text-xs md:text-sm font-bold px-3 py-1 rounded-full bg-rose-100 text-rose-700">2 trang</span>
          </div>
          <ul class="space-y-1">
            
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/promotions/promotions/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Tổng hợp chương trình Hot</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
              <li>
                <a href="<?php echo esc_url(get_template_directory_uri()); ?>/pages/promotions/promotion-detail/index.html" class="group flex items-center justify-between py-2.5 px-3 rounded-xl hover:bg-red-50 text-gray-800 hover:text-red-600 transition-colors text-sm md:text-[15px] font-semibold">
                  <span class="truncate">Chi tiết ưu đãi mở bán</span>
                  <span class="text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all text-sm md:text-base font-bold">&rarr;</span>
                </a>
              </li>
          </ul>
        </div>
    </div>
  </div>
</section>

<!-- Floating Quick Navigator Button (Bottom-Right) -->
<div class="fixed bottom-20 md:bottom-6 right-4 z-40">
  <a href="#phonex-ui-hub" class="px-5 py-3 bg-gray-900/90 hover:bg-black text-white text-sm font-bold rounded-full shadow-lg backdrop-blur-md flex items-center gap-2 border border-gray-700 active:scale-95 transition-all">
    <span class="material-symbols-outlined text-red-500 text-[18px]">grid_view</span>
    <span>Duyệt 46 Trang UI</span>
    <span class="bg-red-600 text-white text-[10px] px-1.5 py-0.2 rounded-full font-extrabold">46</span>
  </a>
</div>

</div></main>

<?php
get_footer();
