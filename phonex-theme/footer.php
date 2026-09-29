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
          <span class="text-xs font-bold uppercase tracking-wider bg-[#f8f9fb] text-[#5f5e5e] border border-[#E5E7EB] px-2.5 py-1 rounded-md">128 Showroom Toàn Quốc</span>
        </div>
        <p class="text-sm text-[#5f5e5e] leading-relaxed max-w-md">
          PhoneX là hệ thống bán lẻ smartphone uỷ quyền chính hãng chuẩn quốc tế hàng đầu Việt Nam. Cam kết 100% thiết bị nguyên seal hộp, chính sách bảo hành 1 đổi 1 trong 30 ngày và dịch vụ thu cũ đổi mới giá cao nhất thị trường.
        </p>
        <div class="space-y-2 text-sm">
          <div class="text-[#222222]">Tổng đài tư vấn bán hàng: <strong class="text-[#e60012] font-black text-base">1800.6868</strong> (Miễn phí 8:00 - 21:30)</div>
          <div class="text-[#222222]">Hỗ trợ kỹ thuật &amp; Bảo hành: <strong class="text-[#222222] font-bold text-sm">1800.6869</strong></div>
          <div class="text-[#222222]">Khiếu nại &amp; Hợp tác: <strong class="text-[#222222] font-bold text-sm">1800.6870</strong> (contact@phonex.vn)</div>
        </div>
      </div>

      <!-- Col 3: Chính sách & Dịch vụ -->
      <div class="space-y-3.5">
        <h4 class="text-base font-extrabold text-[#222222] uppercase tracking-wider">Chính Sách &amp; Hỗ Trợ</h4>
        <ul class="space-y-2.5 text-sm text-[#5f5e5e] font-medium">
          <li><a href="<?php echo esc_url(home_url('/bao-hanh/')); ?>" class="hover:text-[#e60012] transition-colors">Bảo hành 12 tháng 1 đổi 1</a></li>
          <li><a href="<?php echo esc_url(home_url('/bao-hanh/')); ?>" class="hover:text-[#e60012] transition-colors">Chính sách đổi trả trong 30 ngày</a></li>
          <li><a href="<?php echo esc_url(home_url('/tra-cuu-don-hang/')); ?>" class="hover:text-[#e60012] transition-colors">Chính sách giao hàng siêu tốc 1h</a></li>
          <li><a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="hover:text-[#e60012] transition-colors">Phương thức thanh toán &amp; trả góp 0%</a></li>
          <li><a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>" class="hover:text-[#e60012] transition-colors text-[#e60012] font-bold">Quy định thu cũ đổi mới (Trade-in)</a></li>
        </ul>
      </div>

      <!-- Col 4: Hệ thống cửa hàng -->
      <div class="space-y-3.5">
        <h4 class="text-base font-extrabold text-[#222222] uppercase tracking-wider">Hệ Thống Showroom</h4>
        <ul class="space-y-2.5 text-sm text-[#5f5e5e]">
          <li><strong class="text-[#222222] font-semibold">Hà Nội:</strong> 48 Showroom (58 Thái Hà, 102 Cầu Giấy...)</li>
          <li><strong class="text-[#222222] font-semibold">TP. Hồ Chí Minh:</strong> 56 Showroom (136 Nguyễn Thái Học, Q.1...)</li>
          <li><strong class="text-[#222222] font-semibold">Đà Nẵng &amp; Miền Trung:</strong> 14 Showroom (88 Nguyễn Văn Linh...)</li>
          <li><strong class="text-[#222222] font-semibold">Cần Thơ &amp; Miền Tây:</strong> 10 Showroom</li>
          <li><a href="<?php echo esc_url(home_url('/showroom/')); ?>" class="text-[#e60012] font-bold hover:underline inline-flex items-center gap-1 mt-1 text-sm">Tìm showroom gần nhất &rarr;</a></li>
        </ul>
      </div>

      <!-- Col 5: Chứng nhận uy tín & Bản tin -->
      <div class="space-y-3.5">
        <h4 class="text-base font-extrabold text-[#222222] uppercase tracking-wider">Chứng Nhận &amp; Uy Tín</h4>
        <div class="space-y-2.5">
          <div class="p-3 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB] flex items-center gap-3">
            <span class="material-symbols-outlined text-[#e60012] text-[28px]">verified</span>
            <div>
              <div class="text-xs font-black text-[#222222] tracking-wide">ĐÃ ĐĂNG KÝ BỘ CÔNG THƯƠNG</div>
              <div class="text-xs text-[#5f5e5e] mt-0.5">Giấy phép số: 0108963282</div>
            </div>
          </div>
          <div class="p-3 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB] flex items-center gap-3">
            <span class="material-symbols-outlined text-[#198754] text-[28px]">security</span>
            <div>
              <div class="text-xs font-black text-[#222222] tracking-wide">BẢO MẬT SSL 256-BIT</div>
              <div class="text-xs text-[#5f5e5e] mt-0.5">Thanh toán mã hóa tuyệt đối</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Copyright & Payment Methods -->
    <div class="pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-[#5f5e5e]">
      <div>
        &copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. Bản quyền thuộc về Công ty Cổ phần Bán lẻ PhoneX Việt Nam.
      </div>
      <div class="flex items-center gap-3 text-xs">
        <span class="font-bold text-[#222222]">Thanh toán:</span>
        <span class="px-2.5 py-1 bg-[#f8f9fb] border border-[#E5E7EB] rounded-md font-bold text-[#222222]">Visa / Mastercard</span>
        <span class="px-2.5 py-1 bg-[#f8f9fb] border border-[#E5E7EB] rounded-md font-bold text-[#222222]">VNPay</span>
        <span class="px-2.5 py-1 bg-[#f8f9fb] border border-[#E5E7EB] rounded-md font-bold text-[#222222]">MoMo</span>
        <span class="px-2.5 py-1 bg-[#f8f9fb] border border-[#E5E7EB] rounded-md font-bold text-[#222222]">Apple Pay</span>
      </div>
    </div>
  </div>

  <!-- Mobile Bottom Navigation Bar (Stitch 390px App-like Bar with Bigger Fonts) -->
  <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-t border-[#E5E7EB] shadow-[0_-4px_20px_rgba(0,0,0,0.08)] pb-safe" aria-label="<?php esc_attr_e('Thanh điều hướng di động', 'phonex'); ?>">
    <div class="h-16 px-2 grid grid-cols-5 items-center">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="flex flex-col items-center justify-center h-full gap-1 text-[#5f5e5e] hover:text-[#e60012] transition-colors">
        <span class="material-symbols-outlined text-[24px]">home</span>
        <span class="text-xs font-bold leading-tight">Trang chủ</span>
      </a>
      <a href="<?php echo esc_url(home_url('/dien-thoai/')); ?>" class="flex flex-col items-center justify-center h-full gap-1 text-[#e60012] transition-colors">
        <span class="material-symbols-outlined text-[24px]">smartphone</span>
        <span class="text-xs font-bold leading-tight">Điện thoại</span>
      </a>
      <a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>" class="flex flex-col items-center justify-center h-full gap-1 text-[#5f5e5e] hover:text-[#e60012] transition-colors">
        <span class="material-symbols-outlined text-[24px]">sync_alt</span>
        <span class="text-xs font-black leading-tight">Thu cũ</span>
      </a>
      <a href="<?php echo esc_url(home_url('/khuyen-mai/')); ?>" class="flex flex-col items-center justify-center h-full gap-1 text-[#FF9800] transition-colors">
        <span class="material-symbols-outlined text-[24px]">local_offer</span>
        <span class="text-xs font-bold leading-tight">Ưu đãi</span>
      </a>
      <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/tai-khoan/')); ?>" class="flex flex-col items-center justify-center h-full gap-1 text-[#5f5e5e] hover:text-[#e60012] transition-colors">
        <span class="material-symbols-outlined text-[24px]">person</span>
        <span class="text-xs font-bold leading-tight">Tài khoản</span>
      </a>
    </div>
  </nav>
</footer>

<?php wp_footer(); ?>
</body>
</html>
