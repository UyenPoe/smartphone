<?php
/**
 * Template Name: PhoneX Mua Điện Thoại Trả Góp 0% & Thu Cũ Lên Đời
 *
 * Dedicated Full-Page Installment & Trade-in Calculator (Không dùng popup)
 *
 * @package PhoneX
 */

get_header();

// =========================================================================
// 1. RESOLVE SELECTED PRODUCT FROM QUERY PARAMS OR DB
// =========================================================================
$prod_id = intval( $_GET['id'] ?? ( $_GET['product_id'] ?? 0 ) );
$product = null;

$display_title = '';
$price_num     = 0;
$old_num       = 0;
$img_src       = '';
$condition     = 'Grade A 99%';
$battery       = 'Pin 95% - 100%';
$brand         = 'Apple';
$prod_link     = '';

if ( $prod_id > 0 && class_exists( 'WooCommerce' ) ) {
	$product = wc_get_product( $prod_id );
	if ( $product ) {
		$display_title = get_the_title( $prod_id );
		$price_current = (float) $product->get_price();
		$price_reg     = (float) $product->get_regular_price();
		$price_sale    = (float) $product->get_sale_price();

		$cur_p = $price_sale > 0 ? $price_sale : $price_current;
		$old_p = $price_reg > 0 ? $price_reg : ( $cur_p * 1.25 );

		$price_num = $cur_p;
		$old_num   = $old_p;

		$condition = get_post_meta( $prod_id, '_condition', true ) ?: ( get_post_meta( $prod_id, '_grade_label', true ) ?: 'Grade A 99%' );
		$battery   = get_post_meta( $prod_id, '_battery', true ) ?: 'Pin 95% - 100%';
		$brand     = get_post_meta( $prod_id, '_phonex_brand', true ) ?: 'Apple';

		$img_rel = get_post_meta( $prod_id, '_phonex_image_rel', true );
		if ( ! empty( $img_rel ) ) {
			$img_src = get_template_directory_uri() . '/' . ltrim( $img_rel, '/' );
		} else {
			$img_src = get_the_post_thumbnail_url( $prod_id, 'medium_large' ) ?: get_the_post_thumbnail_url( $prod_id, 'full' );
		}
		$prod_link = get_permalink( $prod_id );
	}
}

// Fallback to query params if not resolved by ID
if ( empty( $display_title ) && ! empty( $_GET['product'] ) ) {
	$display_title = sanitize_text_field( $_GET['product'] );
	$price_num     = floatval( $_GET['price'] ?? 0 );
	$old_num       = $price_num > 0 ? ( $price_num * 1.25 ) : 0;
	$img_src       = esc_url( $_GET['img'] ?? '' );
	$condition     = sanitize_text_field( $_GET['grade'] ?? 'Grade A 99%' );
}

// Fallback to top featured phone in inventory
if ( empty( $display_title ) ) {
	$default_query = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => array( 'kho-may-cu', 'dien-thoai-cu' ),
				'operator' => 'IN',
			),
		),
	) );

	if ( $default_query->have_posts() ) {
		while ( $default_query->have_posts() ) {
			$default_query->the_post();
			$d_id    = get_the_ID();
			$d_prod  = wc_get_product( $d_id );
			$display_title = get_the_title();
			$price_num     = (float) $d_prod->get_price();
			$old_num       = (float) $d_prod->get_regular_price() ?: ( $price_num * 1.25 );
			$condition     = get_post_meta( $d_id, '_condition', true ) ?: 'Grade A 99%';
			$battery       = get_post_meta( $d_id, '_battery', true ) ?: 'Pin 95% - 100%';
			$brand         = get_post_meta( $d_id, '_phonex_brand', true ) ?: 'Apple';
			$img_src       = get_the_post_thumbnail_url( $d_id, 'medium_large' );
			$prod_link     = get_permalink( $d_id );
			$prod_id       = $d_id;
		}
		wp_reset_postdata();
	} else {
		$display_title = 'iPhone 15 Pro Max 256GB Like New 99%';
		$price_num     = 24500000;
		$old_num       = 29990000;
		$img_src       = get_template_directory_uri() . '/assets/images/placeholder.jpg';
		$prod_link     = home_url( '/kho-may-cu/' );
	}
}

if ( empty( $img_src ) ) {
	$img_src = get_template_directory_uri() . '/assets/images/placeholder.jpg';
}

$discount_pct = ( $old_num > $price_num && $old_num > 0 ) ? round( ( ( $old_num - $price_num ) / $old_num ) * 100 ) : 0;
$saving_num   = max( 0, $old_num - $price_num );

// Load phone catalog for switching products (Top 60 products)
$inventory_picker = array();
$picker_query = new WP_Query( array(
	'post_type'      => 'product',
	'post_status'    => 'publish',
	'posts_per_page' => 60,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'tax_query'      => array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => array( 'kho-may-cu', 'dien-thoai-cu' ),
			'operator' => 'IN',
		),
	),
) );
if ( $picker_query->have_posts() ) {
	while ( $picker_query->have_posts() ) {
		$picker_query->the_post();
		$pk_id   = get_the_ID();
		$pk_prod = wc_get_product( $pk_id );
		if ( ! $pk_prod ) continue;
		$pk_cur  = (float) $pk_prod->get_price();
		$inventory_picker[] = array(
			'id'        => $pk_id,
			'title'     => get_the_title(),
			'price'     => $pk_cur,
			'price_fmt' => number_format( $pk_cur, 0, ',', '.' ) . '₫',
			'grade'     => get_post_meta( $pk_id, '_condition', true ) ?: 'Grade A 99%',
			'img'       => get_the_post_thumbnail_url( $pk_id, 'thumbnail' ) ?: $img_src,
			'link'      => get_permalink( $pk_id ),
		);
	}
	wp_reset_postdata();
}
?>

<main class="w-full min-h-screen bg-[#F6F7F9] pb-20 font-sans text-[#1F1F1F]">

  <!-- BREADCRUMBS -->
  <div class="w-full bg-white border-b border-[#E5E7EB]">
    <div class="max-w-[1360px] mx-auto px-4 py-3">
      <nav class="flex items-center gap-2 text-[13px] sm:text-[14px] text-[#374151] font-medium overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#FF001F] transition-colors flex items-center gap-1 font-semibold">
          <span class="material-symbols-outlined text-[17px]">home</span><span>Trang chủ</span>
        </a>
        <span class="text-gray-400 font-bold">/</span>
        <a href="<?php echo esc_url( home_url( '/kho-may-cu/' ) ); ?>" class="hover:text-[#FF001F] transition-colors font-semibold">Kho Máy Cũ</a>
        <span class="text-gray-400 font-bold">/</span>
        <span class="text-[#1F1F1F] font-bold">Mua Điện Thoại Trả Góp 0% &amp; Thu Cũ Lên Đời</span>
      </nav>
    </div>
  </div>

  <!-- HERO HEADER BANNER -->
  <div class="max-w-[1360px] mx-auto px-4 pt-6 pb-2">
    <div class="bg-gradient-to-r from-red-600 via-[#FF001F] to-[#b7000c] rounded-2xl p-6 sm:p-8 text-white shadow-md relative overflow-hidden">
      <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none select-none">
        <span class="material-symbols-outlined text-[240px]">payments</span>
      </div>
      <div class="relative z-10 max-w-3xl">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-xs text-white text-xs font-black uppercase tracking-wider mb-2.5">
          <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
          CHÍNH SÁCH TÀI CHÍNH PHONEX 2026
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight leading-tight">
          Bảng Tính Trả Góp 0% Lãi Suất &amp; Thu Cũ Đổi Mới Lên Đời
        </h1>
        <p class="text-white/90 text-sm sm:text-base mt-2 font-medium leading-relaxed">
          Sở hữu ngay flagship like new 99% nguyên bản với chi phí <strong>trả trước từ 0 đồng</strong>. Trừ trực tiếp giá trị máy cũ vào tiền mua máy, duyệt hồ sơ CCCD online 5 phút không giữ giấy tờ.
        </p>
        <div class="flex flex-wrap gap-2 sm:gap-3 mt-4 text-xs font-bold">
          <span class="inline-flex items-center gap-1 bg-white/15 px-3 py-1.5 rounded-lg border border-white/20">
            <span class="material-symbols-outlined text-[16px]">verified</span> 0% Lãi suất qua Thẻ tín dụng &amp; CCCD
          </span>
          <span class="inline-flex items-center gap-1 bg-white/15 px-3 py-1.5 rounded-lg border border-white/20">
            <span class="material-symbols-outlined text-[16px]">timer</span> Duyệt hồ sơ nhanh trong 5 phút
          </span>
          <span class="inline-flex items-center gap-1 bg-white/15 px-3 py-1.5 rounded-lg border border-white/20">
            <span class="material-symbols-outlined text-[16px]">currency_exchange</span> Trợ giá thu cũ đến 3.000.000₫
          </span>
          <span class="inline-flex items-center gap-1 bg-white/15 px-3 py-1.5 rounded-lg border border-white/20">
            <span class="material-symbols-outlined text-[16px]">security</span> Bảo hành 12 tháng 1 đổi 1
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- MAIN 2-COLUMN INSTALLMENT INTERACTION WORKSPACE -->
  <div class="max-w-[1360px] mx-auto px-4 pt-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

      <!-- LEFT COLUMN (38%): SELECTED PRODUCT CARD & COMMITMENTS -->
      <div class="lg:col-span-5 space-y-5 lg:sticky lg:top-20">

        <!-- Selected Product Card -->
        <div class="bg-white rounded-2xl p-5 border border-[#E5E7EB] shadow-xs space-y-4">
          <div class="flex items-center justify-between pb-3 border-b border-gray-100 flex-wrap gap-2">
            <span class="text-xs font-extrabold text-[#b7000c] bg-[#FFF0F2] px-2.5 py-1 rounded-md uppercase tracking-wider flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-[#e60012]"></span>
              <span>Máy đang chọn mua</span>
            </span>
            <a href="<?php echo esc_url( home_url( '/kho-may-cu/?mode=tra-gop' ) ); ?>"
               class="text-xs font-bold text-[#e60012] hover:text-[#b7000c] bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg border border-red-200/90 flex items-center gap-1.5 transition-colors shadow-2xs">
              <span class="material-symbols-outlined text-[16px]">inventory_2</span>
              <span>Đổi máy khác trong kho &rarr;</span>
            </a>
          </div>

          <div class="flex gap-4 items-center">
            <!-- 1:1 Square Image -->
            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-xl bg-white border border-gray-200 p-2 flex items-center justify-center shrink-0 shadow-2xs">
              <img id="activeProdImg" src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $display_title ); ?>" class="w-full h-full object-contain" />
            </div>

            <!-- Title & Pricing -->
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-1.5 flex-wrap mb-1">
                <span id="activeProdGrade" class="text-[11px] font-bold text-[#b7000c] bg-[#FFF0F2] border border-[#ffdad5] px-2 py-0.5 rounded-[6px]">
                  <?php echo esc_html( $condition ); ?>
                </span>
                <span class="text-[11px] font-bold text-[#198754] bg-green-50 border border-green-200 px-2 py-0.5 rounded-[6px] flex items-center gap-0.5">
                  <span class="material-symbols-outlined text-[13px]">battery_charging_full</span>
                  <span><?php echo esc_html( $battery ); ?></span>
                </span>
              </div>

              <h2 id="activeProdTitle" class="text-base sm:text-lg font-black text-[#1F1F1F] leading-snug line-clamp-2">
                <?php echo esc_html( $display_title ); ?>
              </h2>

              <div class="mt-2 flex items-baseline gap-2 flex-wrap">
                <span class="text-xs text-gray-500 font-semibold">Giá PhoneX:</span>
                <span id="activeProdPrice" class="text-xl font-black text-[#e60012]">
                  <?php echo esc_html( number_format( $price_num, 0, ',', '.' ) ); ?>₫
                </span>
                <?php if ( $discount_pct > 0 ) : ?>
                  <span class="text-[11px] font-bold text-white bg-[#e60012] px-1.5 py-0.5 rounded shadow-2xs">
                    -<?php echo esc_html( $discount_pct ); ?>%
                  </span>
                <?php endif; ?>
              </div>

              <?php if ( $old_num > $price_num ) : ?>
                <div class="text-xs text-gray-500 mt-0.5 font-medium">
                  Giá máy mới: <span class="line-through"><?php echo esc_html( number_format( $old_num, 0, ',', '.' ) ); ?>₫</span>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <?php if ( ! empty( $prod_link ) ) : ?>
            <div class="pt-1">
              <a id="activeProdLink" href="<?php echo esc_url( $prod_link ); ?>" target="_blank" class="w-full text-center py-2 px-3 rounded-lg border border-gray-200 hover:border-[#FF001F] text-xs font-bold text-gray-700 hover:text-[#FF001F] flex items-center justify-center gap-1 transition-colors">
                <span>Xem chi tiết thông số kỹ thuật máy này</span>
                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
              </a>
            </div>
          <?php endif; ?>

          <!-- INLINE QUICK SEARCH SWITCH (Không dùng popup) -->
          <div class="pt-3 border-t border-gray-100 relative" id="inlineSearchContainer">
            <label for="pxInlinePhoneSearch" class="block text-xs font-bold text-gray-700 mb-1.5 flex items-center justify-between">
              <span class="flex items-center gap-1.5 text-[#1F1F1F]">
                <span class="material-symbols-outlined text-[16px] text-[#e60012]">search</span>
                <span>Tìm nhanh model khác trong kho:</span>
              </span>
              <span class="text-[11px] text-gray-400 font-normal">Gõ tên máy</span>
            </label>
            <div class="relative">
              <input type="text"
                     id="pxInlinePhoneSearch"
                     autocomplete="off"
                     oninput="pxFilterInlinePhoneSearch(this.value)"
                     onfocus="pxShowInlineResults(true)"
                     placeholder="Ví dụ: iPhone 14, S23 Ultra, Xiaomi 13..."
                     class="w-full text-xs font-medium border border-gray-200 hover:border-gray-300 focus:border-[#e60012] rounded-xl pl-9 pr-8 py-2.5 outline-none transition-all bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-red-100" />
              <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-[18px] pointer-events-none">phone_iphone</span>
              <button type="button"
                      id="pxInlineClearBtn"
                      onclick="pxClearInlinePhoneSearch()"
                      class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 w-5 h-5 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-600 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-[13px]">close</span>
              </button>
            </div>

            <!-- Autocomplete Suggestion Dropdown (Floating right under input) -->
            <div id="pxInlineSearchResults"
                 class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-gray-200 rounded-xl shadow-xl max-h-72 overflow-y-auto divide-y divide-gray-100 z-30">
              <?php foreach ( $inventory_picker as $pk ) : ?>
                <div class="px-inline-item p-2.5 flex items-center justify-between gap-3 hover:bg-red-50/60 cursor-pointer transition-colors"
                     data-title="<?php echo esc_attr( mb_strtolower( $pk['title'], 'UTF-8' ) ); ?>"
                     onclick="pxSelectPhone(<?php echo esc_attr( json_encode( $pk ) ); ?>)">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-9 h-9 rounded-lg bg-gray-50 border border-gray-100 p-0.5 shrink-0 flex items-center justify-center">
                      <img src="<?php echo esc_url( $pk['img'] ); ?>" alt="" class="w-full h-full object-contain" />
                    </div>
                    <div class="min-w-0">
                      <div class="flex items-center gap-1.5">
                        <span class="text-[9px] font-bold text-[#b7000c] bg-[#FFF0F2] px-1 rounded"><?php echo esc_html( $pk['grade'] ); ?></span>
                      </div>
                      <div class="text-xs font-bold text-gray-900 truncate mt-0.5"><?php echo esc_html( $pk['title'] ); ?></div>
                    </div>
                  </div>
                  <div class="text-right shrink-0">
                    <div class="text-xs font-black text-[#e60012]"><?php echo esc_html( $pk['price_fmt'] ); ?></div>
                    <span class="text-[10px] font-bold text-[#FF001F] hover:underline">Chọn máy &rarr;</span>
                  </div>
                </div>
              <?php endforeach; ?>
              <div id="pxInlineNoResults" class="hidden p-4 text-center text-xs text-gray-500">
                Không tìm thấy máy phù hợp trong kho.
              </div>
            </div>
          </div>
        </div>

        <!-- PhoneX Trust & Guarantee Highlights -->
        <div class="bg-white rounded-2xl p-5 border border-[#E5E7EB] shadow-xs space-y-3.5">
          <h3 class="text-xs font-black text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[#FF001F] text-[18px]">verified_user</span>
            Quyền lợi độc quyền khi mua trả góp PhoneX
          </h3>
          <ul class="text-xs text-gray-700 space-y-2.5 font-medium">
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-[#198754] text-[18px] shrink-0">check_circle</span>
              <span><strong>Không cần trả trước 1 đồng:</strong> Hỗ trợ gói vay 0đ hoặc trừ thẳng giá trị máy cũ lên đời.</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-[#198754] text-[18px] shrink-0">check_circle</span>
              <span><strong>Duyệt online chỉ với CCCD:</strong> Không giữ bản gốc, không chứng minh thu nhập, không gọi phiền người thân.</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-[#198754] text-[18px] shrink-0">check_circle</span>
              <span><strong>Chính sách bảo hành VIP:</strong> 1 đổi 1 trong 30 ngày nếu phát sinh lỗi phần cứng, bảo hành 12 tháng tại 128 Showroom.</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-[#198754] text-[18px] shrink-0">check_circle</span>
              <span><strong>Đại lý nhập sỉ B2B:</strong> Chính sách công nợ gối đầu 15–30 ngày theo lô máy kiểm định Grade A.</span>
            </li>
          </ul>

          <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-gray-600">
            <span>Tổng đài trả góp: <a href="tel:18006868" class="text-[#FF001F] hover:underline">1800.6868</a></span>
            <span>Hỗ trợ B2B: <a href="tel:18006870" class="text-[#FF001F] hover:underline">1800.6870</a></span>
          </div>
        </div>

      </div>

      <!-- RIGHT COLUMN (62%): FULL-PAGE INSTALLMENT CALCULATOR & FORM -->
      <div class="lg:col-span-7 space-y-6">

        <!-- ================= 1. TRADE-IN EXPANDABLE CALCULATOR ================= -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-amber-200 shadow-xs space-y-4">
          <label class="flex items-start gap-3 cursor-pointer select-none">
            <input type="checkbox" id="pageTradeInToggle" onchange="pageCalculate()" class="w-5 h-5 mt-0.5 rounded text-[#e60012] focus:ring-[#e60012] accent-[#e60012] cursor-pointer" />
            <div class="flex-1">
              <div class="flex items-center gap-2 flex-wrap">
                <span class="text-base font-black text-gray-900">Thu Cũ Đổi Mới — Bán lại máy cũ để trừ tiền trả trước</span>
                <span class="text-[11px] font-extrabold text-white bg-[#e60012] px-2.5 py-0.5 rounded-full shadow-2xs">Tặng thêm 500.000₫</span>
              </div>
              <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                Đổi ngay chiếc điện thoại cũ bạn đang dùng để trừ trực tiếp vào số tiền cần trả trước hoặc trừ thẳng vào giá máy. Nếu giá trị máy cũ &gt; số tiền trả trước, bạn nhận máy <strong>trả trước 0 đồng</strong>!
              </p>
            </div>
          </label>

          <!-- Collapsible Trade-In Inputs -->
          <div id="pageTradeInFields" class="hidden pt-4 border-t border-amber-200 space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Thương hiệu máy cũ của bạn:</label>
                <select id="pageTradeInBrand" onchange="pageAutoSuggestTradeIn()" class="w-full text-xs font-semibold bg-gray-50 border border-gray-300 rounded-xl px-3 py-2.5 focus:border-[#e60012] outline-none">
                  <option value="Apple">Apple (iPhone)</option>
                  <option value="Samsung">Samsung</option>
                  <option value="Xiaomi">Xiaomi / Redmi</option>
                  <option value="OPPO">OPPO</option>
                  <option value="Khác">Hãng khác</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Dòng máy cũ đang dùng:</label>
                <input type="text" id="pageTradeInModel" placeholder="VD: iPhone 11 64GB, Galaxy S21..." oninput="pageCalculate()" class="w-full text-xs font-semibold bg-gray-50 border border-gray-300 rounded-xl px-3 py-2.5 focus:border-[#e60012] outline-none" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Tình trạng máy cũ:</label>
                <select id="pageTradeInCondition" onchange="pageAutoSuggestTradeIn()" class="w-full text-xs font-semibold bg-gray-50 border border-gray-300 rounded-xl px-3 py-2.5 focus:border-[#e60012] outline-none">
                  <option value="Grade A 99%">Grade A (Đẹp như mới 99%)</option>
                  <option value="Grade B 98%">Grade B (Trầy nhẹ viền 98%)</option>
                  <option value="Grade C 95%">Grade C (Cũ/Cấn xước 95%)</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Định giá PhoneX thu lại (VNĐ):</label>
                <input type="number" id="pageTradeInVal" value="3500000" step="500000" oninput="pageCalculate()" class="w-full text-sm font-black text-[#e60012] bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 focus:border-[#e60012] outline-none" />
              </div>
            </div>

            <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 font-medium flex items-center gap-2">
              <span class="material-symbols-outlined text-amber-600 text-[18px]">verified</span>
              <span>Định giá ước tính đã tự động cộng thêm <strong>500.000₫ trợ giá lên đời</strong> của PhoneX.</span>
            </div>
          </div>
        </div>

        <!-- ================= 2. INSTALLMENT OPTIONS & CALCULATOR MATRIX ================= -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-[#E5E7EB] shadow-xs space-y-5">
          <h2 class="text-base sm:text-lg font-black text-gray-900 flex items-center gap-2 pb-3 border-b border-gray-100">
            <span class="material-symbols-outlined text-[#FF001F] text-[22px]">calculate</span>
            Bảng Tính Trả Góp 0% Lãi Suất Tùy Chọn
          </h2>

          <!-- Step A: Down Payment -->
          <div>
            <div class="flex items-center justify-between mb-2">
              <label class="text-xs sm:text-sm font-extrabold text-gray-800">1. Chọn mức tiền trả trước:</label>
              <span id="pageDownPaymentText" class="text-xs sm:text-sm font-black text-[#e60012]">0₫ (0%)</span>
            </div>
            <div class="grid grid-cols-5 gap-2" id="pageDownPills">
              <button type="button" onclick="pageSetDownPct(0, this)" class="page-down-pill active py-2 text-center text-xs sm:text-sm font-bold rounded-xl border border-[#e60012] bg-[#FFF0F2] text-[#e60012] transition-all cursor-pointer">0% (0đ)</button>
              <button type="button" onclick="pageSetDownPct(10, this)" class="page-down-pill py-2 text-center text-xs sm:text-sm font-bold rounded-xl border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all cursor-pointer">10%</button>
              <button type="button" onclick="pageSetDownPct(20, this)" class="page-down-pill py-2 text-center text-xs sm:text-sm font-bold rounded-xl border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all cursor-pointer">20%</button>
              <button type="button" onclick="pageSetDownPct(30, this)" class="page-down-pill py-2 text-center text-xs sm:text-sm font-bold rounded-xl border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all cursor-pointer">30%</button>
              <button type="button" onclick="pageSetDownPct(50, this)" class="page-down-pill py-2 text-center text-xs sm:text-sm font-bold rounded-xl border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all cursor-pointer">50%</button>
            </div>
          </div>

          <!-- Step B: Term -->
          <div>
            <div class="flex items-center justify-between mb-2">
              <label class="text-xs sm:text-sm font-extrabold text-gray-800">2. Chọn kỳ hạn vay góp:</label>
              <span id="pageTermText" class="text-xs sm:text-sm font-black text-gray-800">6 tháng (Phổ biến)</span>
            </div>
            <div class="grid grid-cols-4 gap-2" id="pageTermPills">
              <button type="button" onclick="pageSetTerm(3, this)" class="page-term-pill py-2 text-center text-xs sm:text-sm font-bold rounded-xl border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all cursor-pointer">3 tháng</button>
              <button type="button" onclick="pageSetTerm(6, this)" class="page-term-pill active py-2 text-center text-xs sm:text-sm font-bold rounded-xl border border-[#e60012] bg-[#FFF0F2] text-[#e60012] transition-all cursor-pointer">6 tháng</button>
              <button type="button" onclick="pageSetTerm(9, this)" class="page-term-pill py-2 text-center text-xs sm:text-sm font-bold rounded-xl border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all cursor-pointer">9 tháng</button>
              <button type="button" onclick="pageSetTerm(12, this)" class="page-term-pill py-2 text-center text-xs sm:text-sm font-bold rounded-xl border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all cursor-pointer">12 tháng</button>
            </div>
          </div>

          <!-- Step C: Financial Method Tabs -->
          <div>
            <label class="block text-xs sm:text-sm font-extrabold text-gray-800 mb-2">3. Chọn hình thức thẩm định hồ sơ:</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
              <label class="p-3 rounded-xl border border-[#e60012] bg-[#FFF0F2] flex flex-col justify-between gap-1 cursor-pointer transition-all" id="pageLabelIdCccd">
                <div class="flex items-center justify-between">
                  <span class="text-xs font-black text-gray-900">CCCD gắn chip</span>
                  <input type="radio" name="page_id_type" value="cccd" checked onchange="pageUpdateIdType(this)" class="accent-[#e60012]" />
                </div>
                <div class="text-[11px] text-gray-600 mt-1">Duyệt online 5 phút qua Zalo, không giữ giấy tờ.</div>
              </label>

              <label class="p-3 rounded-xl border border-gray-200 bg-gray-50 flex flex-col justify-between gap-1 cursor-pointer transition-all hover:bg-gray-100" id="pageLabelIdCard">
                <div class="flex items-center justify-between">
                  <span class="text-xs font-black text-gray-900">Thẻ tín dụng</span>
                  <input type="radio" name="page_id_type" value="credit_card" onchange="pageUpdateIdType(this)" class="accent-[#e60012]" />
                </div>
                <div class="text-[11px] text-gray-600 mt-1">0% Lãi suất qua Visa/Master 28 ngân hàng.</div>
              </label>

              <label class="p-3 rounded-xl border border-gray-200 bg-gray-50 flex flex-col justify-between gap-1 cursor-pointer transition-all hover:bg-gray-100" id="pageLabelIdB2B">
                <div class="flex items-center justify-between">
                  <span class="text-xs font-black text-purple-700">Đại lý sỉ B2B</span>
                  <input type="radio" name="page_id_type" value="b2b_credit" onchange="pageUpdateIdType(this)" class="accent-[#e60012]" />
                </div>
                <div class="text-[11px] text-gray-600 mt-1">Công nợ gối đầu 15–30 ngày theo lô máy.</div>
              </label>
            </div>
          </div>

          <!-- Financial Calculation Matrix Box -->
          <div class="rounded-2xl border border-red-200 bg-gradient-to-br from-[#FFF0F2] via-white to-red-50/70 p-4 sm:p-5 shadow-2xs space-y-2.5">
            <div class="flex items-center justify-between text-xs sm:text-sm text-gray-700 font-medium">
              <span>Giá máy PhoneX chọn mua:</span>
              <span id="pageCalcProdPrice" class="font-bold text-gray-900"><?php echo esc_html( number_format( $price_num, 0, ',', '.' ) ); ?>₫</span>
            </div>
            <div id="pageCalcTradeInRow" class="hidden flex items-center justify-between text-xs sm:text-sm text-[#c2410c] font-medium">
              <span>Trừ tiền máy cũ (Thu cũ đổi mới):</span>
              <span id="pageCalcTradeInDeduct" class="font-bold">-0₫</span>
            </div>
            <div class="flex items-center justify-between text-xs sm:text-sm text-gray-700 font-medium">
              <span>Tiền trả trước cần thanh toán ngay:</span>
              <span id="pageCalcActualDown" class="font-bold text-gray-900">0₫</span>
            </div>
            <div class="flex items-center justify-between text-xs sm:text-sm text-gray-700 font-medium">
              <span>Số tiền vay còn lại:</span>
              <span id="pageCalcLoanAmount" class="font-bold text-gray-900">0₫</span>
            </div>
            <div class="pt-3 border-t border-[#ffdad5] flex items-center justify-between flex-wrap gap-2">
              <div>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-wide">Số tiền góp mỗi tháng:</div>
                <div class="text-xs text-green-700 font-bold flex items-center gap-1 mt-0.5">
                  <span class="material-symbols-outlined text-[15px]">verified</span> 0% Lãi suất • Phí hồ sơ 0đ
                </div>
              </div>
              <div class="text-right">
                <span id="pageCalcMonthly" class="text-2xl sm:text-3xl font-black text-[#e60012]">0₫</span>
                <span class="text-xs font-bold text-gray-600">/tháng</span>
              </div>
            </div>
          </div>

          <!-- ================= 3. LEAD REGISTRATION FORM ================= -->
          <form id="pageInstallmentForm" onsubmit="pageSubmitLead(event)" class="space-y-4 pt-2">
            <h3 class="text-sm font-black text-gray-900 flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[#FF001F] text-[18px]">person</span>
              Thông tin người đăng ký duyệt hồ sơ online
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-bold text-gray-800 mb-1">Họ và tên của bạn <span class="text-red-500">*</span></label>
                <input type="text" id="pageCustName" required placeholder="Ví dụ: Hoàng Tuấn Long" class="w-full text-xs sm:text-sm font-semibold bg-white border border-gray-300 rounded-xl px-3.5 py-2.5 focus:border-[#e60012] focus:ring-1 focus:ring-[#e60012] outline-none" />
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-800 mb-1">Số điện thoại / Zalo <span class="text-red-500">*</span></label>
                <input type="tel" id="pageCustPhone" required placeholder="09xx xxx xxx" class="w-full text-xs sm:text-sm font-semibold bg-white border border-gray-300 rounded-xl px-3.5 py-2.5 focus:border-[#e60012] focus:ring-1 focus:ring-[#e60012] outline-none" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-bold text-gray-800 mb-1">Tỉnh / Thành phố:</label>
                <select id="pageCustCity" class="w-full text-xs sm:text-sm font-semibold bg-white border border-gray-300 rounded-xl px-3.5 py-2.5 focus:border-[#e60012] outline-none">
                  <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh (56 Showroom)</option>
                  <option value="Hà Nội">Hà Nội (48 Showroom)</option>
                  <option value="Đà Nẵng">Đà Nẵng (14 Showroom)</option>
                  <option value="Bình Dương">Bình Dương</option>
                  <option value="Đồng Nai">Đồng Nai</option>
                  <option value="Cần Thơ">Cần Thơ</option>
                  <option value="Hải Phòng">Hải Phòng</option>
                  <option value="Tỉnh thành khác">Tỉnh thành khác (Giao hàng tận nơi)</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-gray-800 mb-1">Ghi chú (Màu sắc / Giờ gọi):</label>
                <input type="text" id="pageCustNotes" placeholder="VD: Muốn lấy máy màu Titan, gọi sau 18h..." class="w-full text-xs sm:text-sm font-semibold bg-white border border-gray-300 rounded-xl px-3.5 py-2.5 focus:border-[#e60012] outline-none" />
              </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    id="pageSubmitBtn"
                    class="w-full min-h-[50px] py-3 px-6 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-black text-sm sm:text-base uppercase tracking-wide transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer">
              <span class="material-symbols-outlined text-[22px]">assignment_turned_in</span>
              <span id="pageSubmitBtnText">XÁC NHẬN ĐĂNG KÝ HỒ SƠ TRẢ GÓP 0% (DUYỆT 5 PHÚT)</span>
            </button>

            <!-- Success Box -->
            <div id="pageSuccessBox" class="hidden p-5 rounded-2xl bg-green-50 border border-green-200 text-center space-y-2">
              <div class="w-12 h-12 rounded-full bg-green-100 text-green-700 flex items-center justify-center mx-auto">
                <span class="material-symbols-outlined text-[28px]">check_circle</span>
              </div>
              <h4 class="text-base font-black text-green-900">Đăng ký hồ sơ trả góp thành công!</h4>
              <div class="inline-block px-3 py-1 rounded-full bg-white border border-green-200 text-green-800 text-xs font-black" id="pageSuccessLeadCode">
                MÃ HỒ SƠ: #PX-TG-XXXXX
              </div>
              <p class="text-xs text-green-800 leading-relaxed max-w-md mx-auto">
                Chuyên viên tài chính PhoneX sẽ liên hệ hoặc kết bạn Zalo với bạn trong <strong>5 phút</strong> để xác nhận thông tin và hướng dẫn duyệt hồ sơ online.
              </p>
              <div class="pt-2">
                <a id="pageSuccessZaloLink" href="https://zalo.me/18006868" target="_blank" class="px-5 py-2 rounded-xl bg-[#0068ff] text-white text-xs font-bold inline-flex items-center gap-1.5 shadow-xs">
                  <span>Chat Zalo PhoneX Ngay</span>
                  <span class="material-symbols-outlined text-[15px]">chat</span>
                </a>
              </div>
            </div>

            <div class="text-center text-xs text-gray-500 font-medium">
              🔒 Cam kết bảo mật thông tin 100% • Không gọi làm phiền người thân • Thủ tục nhanh gọn
            </div>
          </form>

        </div>

      </div>

    </div>
  </div>

  <!-- PRODUCT PICKER MODAL REMOVED IN FAVOR OF DIRECT LINK & INLINE AUTOCOMPLETE -->

</main>

<script>
(function() {
  'use strict';

  var state = {
    title: <?php echo json_encode( $display_title ); ?>,
    price: <?php echo json_encode( $price_num ); ?>,
    img: <?php echo json_encode( $img_src ); ?>,
    grade: <?php echo json_encode( $condition ); ?>,
    link: <?php echo json_encode( $prod_link ); ?>,
    downPct: 0,
    termMonths: 6,
    hasTradeIn: false,
    tradeInVal: 0,
    idType: 'cccd'
  };

  window.pageSetDownPct = function(pct, btn) {
    state.downPct = pct;
    var pills = document.querySelectorAll('.page-down-pill');
    pills.forEach(function(p) {
      p.classList.remove('active', 'border-[#e60012]', 'bg-[#FFF0F2]', 'text-[#e60012]');
      p.classList.add('border-gray-200', 'bg-gray-50', 'text-gray-700');
    });
    if (btn) {
      btn.classList.add('active', 'border-[#e60012]', 'bg-[#FFF0F2]', 'text-[#e60012]');
      btn.classList.remove('border-gray-200', 'bg-gray-50', 'text-gray-700');
    }
    pageCalculate();
  };

  window.pageSetTerm = function(term, btn) {
    state.termMonths = term;
    var pills = document.querySelectorAll('.page-term-pill');
    pills.forEach(function(p) {
      p.classList.remove('active', 'border-[#e60012]', 'bg-[#FFF0F2]', 'text-[#e60012]');
      p.classList.add('border-gray-200', 'bg-gray-50', 'text-gray-700');
    });
    if (btn) {
      btn.classList.add('active', 'border-[#e60012]', 'bg-[#FFF0F2]', 'text-[#e60012]');
      btn.classList.remove('border-gray-200', 'bg-gray-50', 'text-gray-700');
    }
    var termText = document.getElementById('pageTermText');
    if (termText) termText.textContent = term + ' tháng';
    pageCalculate();
  };

  window.pageAutoSuggestTradeIn = function() {
    var brand = document.getElementById('pageTradeInBrand') ? document.getElementById('pageTradeInBrand').value : 'Apple';
    var cond = document.getElementById('pageTradeInCondition') ? document.getElementById('pageTradeInCondition').value : 'Grade A';
    var baseVal = 4000000;

    if (brand === 'Apple') baseVal = 6000000;
    else if (brand === 'Samsung') baseVal = 4500000;
    else if (brand === 'Xiaomi') baseVal = 3000000;
    else if (brand === 'OPPO') baseVal = 2800000;

    if (cond.indexOf('98%') !== -1) baseVal *= 0.85;
    if (cond.indexOf('95%') !== -1) baseVal *= 0.7;

    var valInput = document.getElementById('pageTradeInVal');
    if (valInput) valInput.value = Math.round(baseVal / 100000) * 100000;

    pageCalculate();
  };

  window.pageCalculate = function() {
    var price = state.price;
    var tiToggle = document.getElementById('pageTradeInToggle');
    var tiFields = document.getElementById('pageTradeInFields');
    var hasTradeIn = tiToggle ? tiToggle.checked : false;

    if (tiFields) {
      tiFields.classList.toggle('hidden', !hasTradeIn);
    }

    var tradeInVal = 0;
    if (hasTradeIn) {
      var valInput = document.getElementById('pageTradeInVal');
      tradeInVal = valInput ? (parseFloat(valInput.value) || 0) : 0;
    }
    state.tradeInVal = tradeInVal;
    state.hasTradeIn = hasTradeIn;

    // Nominal down payment
    var nominalDown = Math.round((price * state.downPct) / 100);

    // Actual cash to pay down
    var actualDown = Math.max(0, nominalDown - tradeInVal);

    // Net loan amount
    var loanAmount = Math.max(0, (price - tradeInVal) - actualDown);
    if (loanAmount === 0 && (price - tradeInVal) > 0) {
      loanAmount = Math.max(0, price - tradeInVal);
    }

    // Monthly payment
    var term = state.termMonths || 6;
    var monthly = Math.round(loanAmount / term);

    // Update DOM
    var downText = document.getElementById('pageDownPaymentText');
    if (downText) {
      downText.textContent = nominalDown.toLocaleString('vi-VN') + '₫ (' + state.downPct + '%)';
    }

    var prodPriceEl = document.getElementById('pageCalcProdPrice');
    if (prodPriceEl) prodPriceEl.textContent = price.toLocaleString('vi-VN') + '₫';

    var tiRow = document.getElementById('pageCalcTradeInRow');
    var tiDeductEl = document.getElementById('pageCalcTradeInDeduct');
    if (tiRow && tiDeductEl) {
      if (hasTradeIn && tradeInVal > 0) {
        tiRow.classList.remove('hidden');
        tiDeductEl.textContent = '- ' + tradeInVal.toLocaleString('vi-VN') + '₫';
      } else {
        tiRow.classList.add('hidden');
      }
    }

    var actualDownEl = document.getElementById('pageCalcActualDown');
    if (actualDownEl) {
      actualDownEl.textContent = actualDown.toLocaleString('vi-VN') + '₫' + (hasTradeIn && tradeInVal > nominalDown ? ' (Đã trừ xong máy cũ)' : '');
    }

    var loanEl = document.getElementById('pageCalcLoanAmount');
    if (loanEl) loanEl.textContent = loanAmount.toLocaleString('vi-VN') + '₫';

    var monthlyEl = document.getElementById('pageCalcMonthly');
    if (monthlyEl) monthlyEl.textContent = monthly.toLocaleString('vi-VN') + '₫';
  };

  window.pageUpdateIdType = function(radio) {
    state.idType = radio.value;
    var lCccd = document.getElementById('pageLabelIdCccd');
    var lCard = document.getElementById('pageLabelIdCard');
    var lB2B = document.getElementById('pageLabelIdB2B');
    var btnText = document.getElementById('pageSubmitBtnText');

    [lCccd, lCard, lB2B].forEach(function(l){
      if (l) {
        l.classList.remove('border-[#e60012]', 'bg-[#FFF0F2]');
        l.classList.add('border-gray-200', 'bg-gray-50');
      }
    });

    if (radio && radio.parentElement && radio.parentElement.parentElement) {
      radio.parentElement.parentElement.classList.add('border-[#e60012]', 'bg-[#FFF0F2]');
      radio.parentElement.parentElement.classList.remove('border-gray-200', 'bg-gray-50');
    }

    if (state.idType === 'b2b_credit') {
      if (btnText) btnText.textContent = 'ĐĂNG KÝ CÔNG NỢ BÁN SỈ B2B (GỐI ĐẦU 15-30 NGÀY)';
    } else {
      if (btnText) btnText.textContent = 'XÁC NHẬN ĐĂNG KÝ HỒ SƠ TRẢ GÓP 0% (DUYỆT 5 PHÚT)';
    }
  };

  window.pageSubmitLead = function(e) {
    e.preventDefault();

    var btn = document.getElementById('pageSubmitBtn');
    var btnText = document.getElementById('pageSubmitBtnText');
    if (btn) btn.disabled = true;
    if (btnText) btnText.textContent = 'Đang gửi hồ sơ...';

    var custName = document.getElementById('pageCustName').value;
    var custPhone = document.getElementById('pageCustPhone').value;
    var custCity = document.getElementById('pageCustCity').value;
    var notes = document.getElementById('pageCustNotes').value;

    var leadType = (state.idType === 'b2b_credit') ? 'b2b_wholesale' : (state.hasTradeIn ? 'tradein_installment' : 'installment_retail');

    var fd = new FormData();
    fd.append('action', 'phonex_submit_installment_lead');
    fd.append('lead_type', leadType);
    fd.append('customer_name', custName);
    fd.append('customer_phone', custPhone);
    fd.append('customer_city', custCity);
    fd.append('customer_id_type', state.idType);
    fd.append('product_name', state.title);
    fd.append('product_price', state.price);
    fd.append('down_payment_pct', state.downPct);
    fd.append('down_payment_val', Math.round((state.price * state.downPct) / 100));
    fd.append('term_months', state.termMonths);
    fd.append('monthly_payment', Math.round(state.price / state.termMonths));
    fd.append('has_tradein', state.hasTradeIn ? 1 : 0);
    fd.append('tradein_brand', document.getElementById('pageTradeInBrand') ? document.getElementById('pageTradeInBrand').value : '');
    fd.append('tradein_model', document.getElementById('pageTradeInModel') ? document.getElementById('pageTradeInModel').value : '');
    fd.append('tradein_condition', document.getElementById('pageTradeInCondition') ? document.getElementById('pageTradeInCondition').value : '');
    fd.append('tradein_valuation', state.tradeInVal);
    fd.append('notes', notes);

    fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
      method: 'POST',
      body: fd
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
      if (btn) btn.disabled = false;
      if (res.success) {
        var box = document.getElementById('pageSuccessBox');
        var codeEl = document.getElementById('pageSuccessLeadCode');
        var zaloLink = document.getElementById('pageSuccessZaloLink');

        if (box) box.classList.remove('hidden');
        if (codeEl) codeEl.textContent = 'MÃ HỒ SƠ: #' + res.data.lead_code;
        if (zaloLink) zaloLink.href = 'https://zalo.me/' + custPhone.replace(/[^0-9]/g, '');

        if (btn) btn.style.display = 'none';
        box.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else {
        alert(res.data.message || 'Lỗi gửi hồ sơ');
        if (btnText) btnText.textContent = 'XÁC NHẬN ĐĂNG KÝ HỒ SƠ TRẢ GÓP 0%';
      }
    })
    .catch(function(err) {
      if (btn) btn.disabled = false;
      if (btnText) btnText.textContent = 'XÁC NHẬN ĐĂNG KÝ HỒ SƠ TRẢ GÓP 0%';
      alert('Không thể kết nối máy chủ. Vui lòng gọi 1800.6868.');
    });
  };

  // Inline quick search & product switch (No popups)
  window.pxFilterInlinePhoneSearch = function(query) {
    var q = (query || '').trim().toLowerCase();
    var container = document.getElementById('pxInlineSearchResults');
    var clearBtn = document.getElementById('pxInlineClearBtn');
    var noResults = document.getElementById('pxInlineNoResults');
    var items = document.querySelectorAll('.px-inline-item');

    if (clearBtn) {
      clearBtn.classList.toggle('hidden', q.length === 0);
    }

    if (container) {
      container.classList.remove('hidden');
    }

    var visibleCount = 0;
    items.forEach(function(item) {
      var title = item.dataset.title || '';
      var matches = q === '' || title.indexOf(q) !== -1;
      item.style.display = matches ? 'flex' : 'none';
      if (matches) visibleCount++;
    });

    if (noResults) {
      noResults.classList.toggle('hidden', visibleCount > 0);
    }
  };

  window.pxShowInlineResults = function(show) {
    var container = document.getElementById('pxInlineSearchResults');
    if (!container) return;
    if (show) {
      container.classList.remove('hidden');
    } else {
      container.classList.add('hidden');
    }
  };

  window.pxClearInlinePhoneSearch = function() {
    var input = document.getElementById('pxInlinePhoneSearch');
    if (input) {
      input.value = '';
      input.focus();
    }
    pxFilterInlinePhoneSearch('');
  };

  // Close dropdown when clicking outside
  document.addEventListener('click', function(e) {
    var searchContainer = document.getElementById('inlineSearchContainer');
    var results = document.getElementById('pxInlineSearchResults');
    if (searchContainer && results && !searchContainer.contains(e.target)) {
      results.classList.add('hidden');
    }
  });

  window.pxSelectPhone = function(prod) {
    state.title = prod.title;
    state.price = prod.price;
    state.img = prod.img;
    state.grade = prod.grade;
    state.link = prod.link;

    var tEl = document.getElementById('activeProdTitle');
    var pEl = document.getElementById('activeProdPrice');
    var iEl = document.getElementById('activeProdImg');
    var gEl = document.getElementById('activeProdGrade');
    var lEl = document.getElementById('activeProdLink');

    if (tEl) tEl.textContent = prod.title;
    if (pEl) pEl.textContent = prod.price_fmt;
    if (iEl) iEl.src = prod.img;
    if (gEl) gEl.textContent = prod.grade;
    if (lEl) lEl.href = prod.link;

    // Reset inline search input and close dropdown
    var input = document.getElementById('pxInlinePhoneSearch');
    if (input) input.value = '';
    var clearBtn = document.getElementById('pxInlineClearBtn');
    if (clearBtn) clearBtn.classList.add('hidden');
    var results = document.getElementById('pxInlineSearchResults');
    if (results) results.classList.add('hidden');

    pageCalculate();
  };

  pageCalculate();
})();
</script>

<?php
get_footer();
