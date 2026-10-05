<?php
/**
 * The template for displaying the footer in PhoneX WordPress Theme
 *
 * @package PhoneX
 */
?>

<!-- PhoneX Flagship Unified Footer (Desktop, Tablet & Mobile - Stitch Visual Parity) -->
<footer class="w-full bg-white border-t border-[#E5E7EB] mt-16 pt-12 pb-24 md:pb-12 text-[#222222] font-sans" data-component="footer">
  <div class="max-w-[1440px] mx-auto px-4">
    <!-- Top 5-Column Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 pb-10 border-b border-[#E5E7EB]">
      <!-- Col 1 & 2: Brand Information & Hotline -->
      <div class="lg:col-span-2 space-y-4">
        <div class="flex items-center gap-2.5">
          <span class="text-3xl font-black text-[#222222] tracking-tight leading-none">Phone<span class="text-[#e60012]">X</span></span>
          <span class="text-xs font-bold uppercase tracking-wider bg-[#f8f9fb] text-[#374151] border border-[#E5E7EB] px-2.5 py-1 rounded-md">128 Showroom Toàn Quốc</span>
        </div>
        <p class="text-sm text-[#374151] leading-relaxed max-w-md">
          PhoneX là hệ thống thu mua, kiểm định phân Grade và phân phối sỉ điện thoại cũ chuẩn quốc tế hàng đầu Việt Nam. Cam kết 100% kiểm định công khai 30 bước, không ép giá, thanh toán chuyển khoản trong 5 phút.
        </p>
        <div class="space-y-2 text-sm">
          <div class="text-[#222222]">Tổng đài thu mua &amp; định giá: <strong class="text-[#e60012] font-black text-base">1800.6868</strong> (Miễn phí 8:00 - 21:30)</div>
          <div class="text-[#222222]">Hỗ trợ kỹ thuật &amp; Kiểm định: <strong class="text-[#222222] font-bold text-sm">1800.6869</strong></div>
          <div class="text-[#222222]">Hợp tác B2B &amp; Khách sỉ: <strong class="text-[#222222] font-bold text-sm">1800.6870</strong> (wholesale@phonex.vn)</div>
        </div>
      </div>

      <!-- Col 3: Chính sách & Dịch vụ -->
      <div class="space-y-3.5">
        <h4 class="text-base font-extrabold text-[#222222] uppercase tracking-wider">Thu Mua &amp; Dịch Vụ</h4>
        <ul class="space-y-2.5 text-sm text-[#374151] font-medium">
          <li><a href="<?php echo esc_url(home_url('/thu-mua-dien-thoai/')); ?>" class="hover:text-[#e60012] transition-colors text-[#e60012] font-bold">Trung tâm thu mua điện thoại cũ</a></li>
          <li><a href="<?php echo esc_url(home_url('/kho-may-cu/')); ?>" class="hover:text-[#e60012] transition-colors text-[#b7000c] font-bold">Kho máy cũ &amp; Bán sỉ Like New 99%</a></li>
          <li><a href="<?php echo esc_url(home_url('/tra-gop/')); ?>" class="hover:text-[#e60012] transition-colors text-[#e60012] font-bold">Mua trả góp 0% &amp; Thu cũ lên đời</a></li>
          <li><a href="<?php echo esc_url(home_url('/dinh-gia-dien-thoai/')); ?>" class="hover:text-[#e60012] transition-colors">Công cụ định giá tự động 30s</a></li>
          <li><a href="<?php echo esc_url(home_url('/bang-gia-thu-mua/')); ?>" class="hover:text-[#e60012] transition-colors">Bảng giá thu mua mới nhất</a></li>
          <li><a href="<?php echo esc_url(home_url('/quy-trinh-thu-mua/')); ?>" class="hover:text-[#e60012] transition-colors">Quy trình kiểm định 7 bước</a></li>
          <li><a href="<?php echo esc_url(home_url('/tieu-chuan-kiem-dinh/')); ?>" class="hover:text-[#e60012] transition-colors">Tiêu chuẩn Grade A / B / C / D</a></li>
          <li><a href="<?php echo esc_url(home_url('/tra-cuu-yeu-cau/')); ?>" class="hover:text-[#e60012] transition-colors">Tra cứu tiến độ phiếu thu mua</a></li>
        </ul>
      </div>

      <!-- Col 4: Hệ thống cửa hàng -->
      <div class="space-y-3.5">
        <h4 class="text-base font-extrabold text-[#222222] uppercase tracking-wider">Hệ Thống Showroom</h4>
        <ul class="space-y-2.5 text-sm text-[#374151]">
          <li><strong class="text-[#222222] font-semibold">Hà Nội:</strong> 48 Điểm thu mua (Thái Hà, Cầu Giấy...)</li>
          <li><strong class="text-[#222222] font-semibold">TP. Hồ Chí Minh:</strong> 56 Điểm thu mua (Nguyễn Thái Học, Q.1...)</li>
          <li><strong class="text-[#222222] font-semibold">Đà Nẵng &amp; Miền Trung:</strong> 14 Điểm thu mua</li>
          <li><strong class="text-[#222222] font-semibold">Dịch vụ thu tận nhà:</strong> Có mặt sau 60 phút</li>
          <li><a href="<?php echo esc_url(home_url('/tra-cuu-yeu-cau/')); ?>" class="text-[#e60012] font-bold hover:underline inline-flex items-center gap-1 mt-1 text-sm">Tra cứu phiếu thu mua &rarr;</a></li>
        </ul>
      </div>

      <!-- Col 5: Chứng nhận uy tín & Bản tin -->
      <div class="space-y-3.5">
        <h4 class="text-base font-extrabold text-[#222222] uppercase tracking-wider">Chứng Nhận &amp; Uy Tín</h4>
        <div class="space-y-2.5">
          <div class="p-3 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB] flex items-center gap-3">
            <span class="material-symbols-outlined text-[#e60012] text-[28px]">verified</span>
            <div>
              <div class="text-xs font-black text-[#222222] tracking-wide">KIỂM ĐỊNH 30 BƯỚC CHUẨN HÓA</div>
              <div class="text-xs text-[#374151] mt-0.5">Tiêu chuẩn quốc tế Grade A/B/C/D</div>
            </div>
          </div>
          <div class="p-3 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB] flex items-center gap-3">
            <span class="material-symbols-outlined text-[#198754] text-[28px]">security</span>
            <div>
              <div class="text-xs font-black text-[#222222] tracking-wide">BẢO MẬT DỮ LIỆU DOD 5220.22-M</div>
              <div class="text-xs text-[#374151] mt-0.5">Xóa vĩnh viễn dữ liệu cá nhân</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Copyright & Payment Methods -->
    <div class="pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-[#374151]">
      <div>
        &copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. Hệ thống thu mua và bán sỉ điện thoại PhoneX Việt Nam.
      </div>
      <div class="flex items-center gap-3 text-xs">
        <span class="font-bold text-[#222222]">Giải ngân tức thì:</span>
        <span class="px-2.5 py-1 bg-[#f8f9fb] border border-[#E5E7EB] rounded-md font-bold text-[#222222]">Chuyển khoản 24/7</span>
        <span class="px-2.5 py-1 bg-[#f8f9fb] border border-[#E5E7EB] rounded-md font-bold text-[#222222]">Mọi ngân hàng</span>
        <span class="px-2.5 py-1 bg-[#f8f9fb] border border-[#E5E7EB] rounded-md font-bold text-[#222222]">Tiền mặt</span>
      </div>
    </div>
  </div>

  <!-- Mobile Bottom Navigation Bar (Elevated Floating Center Hero for Valuation) -->
  <?php
  $current_uri = untrailingslashit( strtok( $_SERVER['REQUEST_URI'] ?? '', '?' ) );
  $home_path   = untrailingslashit( wp_parse_url( home_url(), PHP_URL_PATH ) );
  $rel_path    = ! empty( $home_path ) && 0 === strpos( $current_uri, $home_path ) ? substr( $current_uri, strlen( $home_path ) ) : $current_uri;
  $rel_path    = '/' . ltrim( $rel_path, '/' );

  $is_home    = ( '/' === $rel_path || '' === $rel_path );
  $is_thumua  = ( 0 === strpos( $rel_path, '/thu-mua-dien-thoai' ) );
  $is_dinhgia = ( 0 === strpos( $rel_path, '/dinh-gia' ) );
  $is_khomay  = ( 0 === strpos( $rel_path, '/kho-may-cu' ) || 0 === strpos( $rel_path, '/may-doi-tra' ) || 0 === strpos( $rel_path, '/dien-thoai-cu' ) );
  $is_banggia = ( 0 === strpos( $rel_path, '/bang-gia' ) || 0 === strpos( $rel_path, '/gia-thu' ) );
  ?>
  <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-t border-[#E5E7EB] shadow-[0_-4px_20px_rgba(0,0,0,0.08)] pb-safe" aria-label="<?php esc_attr_e('Thanh điều hướng di động', 'phonex'); ?>">
    <div class="h-16 px-1.5 grid grid-cols-5 items-center relative">
      <!-- 1. Trang chủ -->
      <a href="<?php echo esc_url(home_url('/')); ?>" class="flex flex-col items-center justify-center h-full gap-0.5 <?php echo $is_home ? 'text-[#e60012] font-black' : 'text-gray-600 hover:text-[#e60012] font-semibold'; ?> transition-colors">
        <span class="material-symbols-outlined text-[23px]">home</span>
        <span class="text-[11px] leading-tight">Trang chủ</span>
      </a>

      <!-- 2. Thu mua -->
      <a href="<?php echo esc_url(home_url('/thu-mua-dien-thoai/')); ?>" class="flex flex-col items-center justify-center h-full gap-0.5 <?php echo $is_thumua ? 'text-[#e60012] font-black' : 'text-gray-600 hover:text-[#e60012] font-semibold'; ?> transition-colors">
        <span class="material-symbols-outlined text-[23px]">currency_exchange</span>
        <span class="text-[11px] leading-tight">Thu mua</span>
      </a>

      <!-- 3. NÚT NỔI TRỌNG TÂM: ĐỊNH GIÁ 30S (Center Elevated Floating Button) -->
      <a href="<?php echo esc_url(home_url('/dinh-gia-dien-thoai/')); ?>" class="relative -top-3.5 flex flex-col items-center justify-center group focus:outline-none" aria-label="<?php esc_attr_e('Định giá điện thoại ngay trong 30 giây', 'phonex'); ?>">
        <div class="w-[52px] h-[52px] rounded-full bg-gradient-to-tr from-[#e60012] via-[#FF001F] to-[#ff4757] text-white flex items-center justify-center shadow-[0_6px_18px_rgba(230,0,18,0.45)] border-[3.5px] border-white transition-all transform group-hover:scale-105 active:scale-95 group-hover:shadow-[0_8px_24px_rgba(230,0,18,0.6)]">
          <span class="material-symbols-outlined text-[27px]">calculate</span>
        </div>
        <span class="text-[10.5px] font-black tracking-tight <?php echo $is_dinhgia ? 'text-[#b7000c] underline' : 'text-[#e60012]'; ?> mt-0.5 whitespace-nowrap">
          Định giá 30s
        </span>
      </a>

      <!-- 4. Kho máy -->
      <a href="<?php echo esc_url(home_url('/kho-may-cu/')); ?>" class="flex flex-col items-center justify-center h-full gap-0.5 <?php echo $is_khomay ? 'text-[#e60012] font-black' : 'text-gray-600 hover:text-[#e60012] font-semibold'; ?> transition-colors">
        <span class="material-symbols-outlined text-[23px]">inventory_2</span>
        <span class="text-[11px] leading-tight">Kho máy</span>
      </a>

      <!-- 5. Bảng giá -->
      <a href="<?php echo esc_url(home_url('/bang-gia-thu-mua/')); ?>" class="flex flex-col items-center justify-center h-full gap-0.5 <?php echo $is_banggia ? 'text-[#e60012] font-black' : 'text-gray-600 hover:text-[#e60012] font-semibold'; ?> transition-colors">
        <span class="material-symbols-outlined text-[23px]">table_chart</span>
        <span class="text-[11px] leading-tight">Bảng giá</span>
      </a>
    </div>
  </nav>
</footer>

<?php require_once get_template_directory() . '/inc/modal-specs.php'; ?>
<?php 
$condition_modal = get_template_directory() . '/template-parts/modal-condition-valuation.php';
if ( file_exists( $condition_modal ) ) {
    require_once $condition_modal;
}
?>

<?php 
$installment_modal = get_template_directory() . '/template-parts/modal-installment.php';
if ( file_exists( $installment_modal ) ) {
    require_once $installment_modal;
}
?>

<?php 
$scroll_top = get_template_directory() . '/template-parts/scroll-to-top.php';
if ( file_exists( $scroll_top ) ) {
    require_once $scroll_top;
}
?>

<?php wp_footer(); ?>
</body>
</html>
