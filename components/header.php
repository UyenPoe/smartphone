<?php
/**
 * The header template for PhoneX WordPress Theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- PhoneX WordPress Header Component -->
<header class="pxH" data-component="header">
  <div class="pxHT">
    <button class="pxMenu" type="button" aria-label="<?php esc_attr_e('Mở menu', 'phonex'); ?>" onclick="this.closest('.pxH').classList.toggle('open')">☰</button>
    <a class="pxLogo" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    <div class="pxSearch">
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="display:flex;width:100%;">
        <input type="search" name="s" placeholder="<?php esc_attr_e('Bạn cần tìm điện thoại gì?', 'phonex'); ?>" value="<?php echo get_search_query(); ?>">
        <button type="submit" style="border:0;background:none;cursor:pointer;"><span class="pxSearchBtn">Tìm</span></button>
      </form>
    </div>
    <div class="pxAct">
      <a href="<?php echo esc_url(home_url('/tra-cuu/')); ?>">Tra cứu</a>
      <a href="<?php echo esc_url(home_url('/tai-khoan/')); ?>">Tài khoản</a>
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>">Giỏ hàng (<?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>)</a>
    </div>
  </div>
  <nav class="pxNav" aria-label="<?php esc_attr_e('Điều hướng chính', 'phonex'); ?>">
    <div class="pxNavI">
      <?php
      if (has_nav_menu('primary')) {
        wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'items_wrap' => '%3$s'));
      } else {
        echo '<a href="' . esc_url(home_url('/shop/')) . '">Điện thoại</a>';
        echo '<a href="' . esc_url(home_url('/thu-cu-doi-moi/')) . '">Thu cũ đổi mới</a>';
        echo '<a href="' . esc_url(home_url('/khuyen-mai/')) . '">Khuyến mãi</a>';
        echo '<a href="' . esc_url(home_url('/cua-hang/')) . '">Cửa hàng</a>';
        echo '<a href="' . esc_url(home_url('/bao-hanh/')) . '">Bảo hành</a>';
      }
      ?>
    </div>
  </nav>
</header>
