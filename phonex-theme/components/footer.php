<?php
/**
 * The footer template for PhoneX WordPress Theme
 */
?>
<!-- PhoneX WordPress Footer Component -->
<footer class="pxF" data-component="footer">
  <div class="pxFI">
    <div class="pxFG">
      <div class="pxFC">
        <h3><?php bloginfo('name'); ?></h3>
        <p>Điện thoại mới, máy cũ và thu cũ đổi mới chính hãng toàn quốc.</p>
      </div>
      <div class="pxFC">
        <h3>Mua hàng</h3>
        <a href="<?php echo esc_url(home_url('/shop/')); ?>">Điện thoại</a>
        <a href="<?php echo esc_url(home_url('/khuyen-mai/')); ?>">Khuyến mãi</a>
        <a href="<?php echo esc_url(home_url('/tra-cuu-don-hang/')); ?>">Tra cứu đơn hàng</a>
      </div>
      <div class="pxFC">
        <h3>Dịch vụ</h3>
        <a href="<?php echo esc_url(home_url('/dinh-gia/')); ?>">Định giá máy</a>
        <a href="<?php echo esc_url(home_url('/thu-cu-doi-moi/')); ?>">Thu cũ đổi mới</a>
        <a href="<?php echo esc_url(home_url('/bao-hanh/')); ?>">Bảo hành</a>
      </div>
      <div class="pxFC">
        <h3>Hỗ trợ</h3>
        <a href="<?php echo esc_url(home_url('/cua-hang/')); ?>">Hệ thống cửa hàng</a>
        <a href="<?php echo esc_url(home_url('/tai-khoan/')); ?>">Tài khoản thành viên</a>
      </div>
    </div>
    <div class="pxCopy">
      &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Giữ toàn quyền bản quyền.
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
