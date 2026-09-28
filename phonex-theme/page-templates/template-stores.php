<?php
/**
 * Template Name: PhoneX Hệ Thống Cửa Hàng (Showrooms)
 *
 * @package PhoneX
 */

get_header();
?>

<main class="w-full pt-6 md:pt-8 bg-surface"><div class="flex flex-col w-full">
<!-- Top Breadcrumb -->
<section class="w-full bg-surface-pure border-b border-border-subtle py-3">
<div class="max-w-7xl mx-auto px-6">
<nav class="flex items-center gap-2 font-body-sm text-body-sm text-secondary">
<a class="hover:text-primary-container transition-colors flex items-center gap-1" href="#">
<span class="material-symbols-outlined text-[16px]">home</span>
          Trang chủ
        </a>
<span class="text-tertiary-fixed-dim">/</span>
<span class="text-text-main font-semibold">Hệ thống showroom PhoneX</span>
<span class="text-tertiary-fixed-dim">/</span>
<span class="text-primary-container font-medium">Toàn quốc (128 điểm trải nghiệm)</span>
</nav>
</div>
</section>
<!-- Header Banner & Quick Stats -->
<section class="w-full bg-surface py-space-xl">
<div class="max-w-7xl mx-auto px-6">
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pb-6 border-b border-border-subtle">
<div class="max-w-3xl">
<div class="inline-flex items-center gap-2 px-3 py-1 bg-primary-fixed/40 text-primary-container rounded-full font-label-badge text-label-badge uppercase tracking-wider mb-3">
<span class="w-2 h-2 rounded-full bg-primary-container animate-pulse"></span>
            Mạng Lưới Bán Lẻ &amp; Bảo Hành Uỷ Quyền Toàn Diện
          </div>
<h1 class="font-headline-xl text-headline-xl text-text-main font-bold tracking-tight">
            Hệ Thống Cửa Hàng &amp; Showroom Trải Nghiệm PhoneX
          </h1>
<p class="font-body-regular text-body-regular text-secondary mt-3">
            128 Showroom đạt tiêu chuẩn Flagship Store &amp; Apple/Samsung Authorised Service Hub trải dài 63 tỉnh thành. Khách hàng trực tiếp trải nghiệm máy nguyên bản, hỗ trợ định giá thu cũ 10 phút và nhận hàng hỏa tốc trong 1 giờ.
          </p>
</div>
<button class="shrink-0 flex items-center gap-2.5 px-5 py-3 bg-surface-pure hover:bg-surface-container text-text-main rounded-lg font-label-button text-label-button shadow-sm transition-all border border-border-subtle group" onclick="window.location.href='<?php echo esc_url(home_url("/showroom/")); ?>'" type="button">
<span class="relative flex h-3 w-3">
<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
<span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
</span>
<span class="group-hover:text-primary-container transition-colors">Tìm showroom gần tôi nhất (GPS)</span>
<span class="material-symbols-outlined text-[18px] text-primary-container">near_me</span>
</button>
</div>
<!-- Quick Metrics Strip -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
<div class="bg-surface-pure p-4 rounded-xl shadow-sm flex items-center gap-4">
<div class="w-12 h-12 rounded-lg bg-primary-fixed/30 flex items-center justify-center text-primary-container">
<span class="material-symbols-outlined text-[26px]">storefront</span>
</div>
<div>
<div class="font-headline-sm text-headline-sm text-text-main">128 Điểm</div>
<div class="font-body-sm text-body-sm text-secondary">Cửa hàng toàn quốc</div>
</div>
</div>
<div class="bg-surface-pure p-4 rounded-xl shadow-sm flex items-center gap-4">
<div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center text-text-main">
<span class="material-symbols-outlined text-[26px]">map</span>
</div>
<div>
<div class="font-headline-sm text-headline-sm text-text-main">63 / 63</div>
<div class="font-body-sm text-body-sm text-secondary">Tỉnh thành phủ sóng</div>
</div>
</div>
<div class="bg-surface-pure p-4 rounded-xl shadow-sm flex items-center gap-4">
<div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center text-text-main">
<span class="material-symbols-outlined text-[26px]">verified</span>
</div>
<div>
<div class="font-headline-sm text-headline-sm text-text-main">PhoneX CareLab</div>
<div class="font-body-sm text-body-sm text-secondary">Phòng sạch chuẩn 5 sao</div>
</div>
</div>
<div class="bg-surface-pure p-4 rounded-xl shadow-sm flex items-center gap-4">
<div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center text-text-main">
<span class="material-symbols-outlined text-[26px]">schedule</span>
</div>
<div>
<div class="font-headline-sm text-headline-sm text-text-main">08:00 - 21:30</div>
<div class="font-body-sm text-body-sm text-secondary">Mở cửa xuyên lễ &amp; Tết</div>
</div>
</div>
</div>
</div>
</section>
<!-- Filter & Store Search Console -->
<section class="w-full bg-surface-pure border-y border-border-subtle sticky top-28 z-30 shadow-sm">
<div class="max-w-7xl mx-auto px-6 py-5">
<div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
<!-- City Select -->
<div class="md:col-span-3">
<label class="block font-label-badge text-label-badge text-secondary uppercase mb-1">Tỉnh / Thành phố</label>
<div class="relative">
<select class="w-full h-11 pl-3.5 pr-8 bg-surface rounded-lg font-body-sm text-body-sm text-text-main appearance-none focus:outline-none focus:bg-surface-pure focus:ring-1 focus:ring-primary-container cursor-pointer transition-all">
<option selected="">Hà Nội (38 cửa hàng)</option>
<option>TP. Hồ Chí Minh (52 cửa hàng)</option>
<option>Đà Nẵng (12 cửa hàng)</option>
<option>Cần Thơ (8 cửa hàng)</option>
<option>Hải Phòng (6 cửa hàng)</option>
<option>Bình Dương (5 cửa hàng)</option>
<option>Toàn bộ 63 tỉnh thành</option>
</select>
<span class="material-symbols-outlined pointer-events-none absolute right-3 top-3 text-secondary text-[18px]">keyboard_arrow_down</span>
</div>
</div>
<!-- District Select -->
<div class="md:col-span-3">
<label class="block font-label-badge text-label-badge text-secondary uppercase mb-1">Quận / Huyện</label>
<div class="relative">
<select class="w-full h-11 pl-3.5 pr-8 bg-surface rounded-lg font-body-sm text-body-sm text-text-main appearance-none focus:outline-none focus:bg-surface-pure focus:ring-1 focus:ring-primary-container cursor-pointer transition-all">
<option selected="">Tất cả quận / huyện tại Hà Nội</option>
<option>Quận Đống Đa (6 showroom)</option>
<option>Quận Cầu Giấy (5 showroom)</option>
<option>Quận Hoàn Kiếm (3 showroom)</option>
<option>Quận Ba Đình (4 showroom)</option>
<option>Quận Hai Bà Trưng (4 showroom)</option>
<option>Quận Thanh Xuân (4 showroom)</option>
<option>Quận Hà Đông (4 showroom)</option>
</select>
<span class="material-symbols-outlined pointer-events-none absolute right-3 top-3 text-secondary text-[18px]">keyboard_arrow_down</span>
</div>
</div>
<!-- Search Bar by Street / Store -->
<div class="md:col-span-6">
<label class="block font-label-badge text-label-badge text-secondary uppercase mb-1">Tìm theo tên đường, toà nhà hoặc số điện thoại</label>
<div class="relative flex items-center">
<input class="w-full h-11 pl-4 pr-28 bg-surface rounded-lg font-body-sm text-body-sm text-text-main focus:bg-surface-pure focus:outline-none focus:ring-1 focus:ring-primary-container transition-all" placeholder="Ví dụ: 124 Thái Hà, Cầu Giấy, 024.7300..." type="text" value="Thái Hà"/>
<button class="absolute right-1.5 px-4 h-8 bg-primary-container hover:bg-primary-hover text-on-primary rounded font-label-button text-label-button flex items-center gap-1.5 transition-colors" type="button">
<span class="material-symbols-outlined text-[16px]">search</span>
<span>Tìm kiếm</span>
</button>
</div>
</div>
</div>
<!-- Feature Badges Filter Pills -->
<div class="flex items-center gap-2 overflow-x-auto pt-3 mt-3 border-t border-border-subtle/70">
<span class="font-label-badge text-label-badge text-secondary uppercase whitespace-nowrap mr-1">Tiện ích:</span>
<button class="px-3 py-1.5 rounded-full font-label-badge text-label-badge bg-primary-container text-on-primary font-bold flex items-center gap-1 whitespace-nowrap shadow-sm" type="button">
<span class="material-symbols-outlined text-[14px]">check</span>
          Flagship có bàn trải nghiệm
        </button>
<button class="px-3 py-1.5 rounded-full font-label-badge text-label-badge bg-surface hover:bg-surface-container text-secondary hover:text-text-main flex items-center gap-1 whitespace-nowrap transition-colors" type="button">
<span class="material-symbols-outlined text-[14px]">build</span>
          Trung tâm CareLab uỷ quyền
        </button>
<button class="px-3 py-1.5 rounded-full font-label-badge text-label-badge bg-surface hover:bg-surface-container text-secondary hover:text-text-main flex items-center gap-1 whitespace-nowrap transition-colors" onclick="window.location.href='<?php echo esc_url(home_url("/thu-cu-doi-moi/")); ?>'" type="button">
<span class="material-symbols-outlined text-[14px]">currency_exchange</span>
          Thu cũ thẩm định 10 phút
        </button>
<button class="px-3 py-1.5 rounded-full font-label-badge text-label-badge bg-surface hover:bg-surface-container text-secondary hover:text-text-main flex items-center gap-1 whitespace-nowrap transition-colors" type="button">
<span class="material-symbols-outlined text-[14px]">directions_car</span>
          Có bãi đỗ ô tô miễn phí
        </button>
<button class="px-3 py-1.5 rounded-full font-label-badge text-label-badge bg-surface hover:bg-surface-container text-secondary hover:text-text-main flex items-center gap-1 whitespace-nowrap transition-colors" type="button">
<span class="material-symbols-outlined text-[14px]">schedule</span>
          Mở cửa đến 21:30+
        </button>
</div>
</div>
</section>
<!-- Main Split-Screen Section -->
<section class="w-full max-w-7xl mx-auto px-6 py-space-xl">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
<!-- LEFT COLUMN: Store List Directory (5/12 cols) -->
<div class="lg:col-span-5 space-y-4">
<div class="flex items-center justify-between pb-1">
<span class="font-label-button text-label-button text-text-main font-bold">
            Hiển thị 4 trên 38 showroom tại Hà Nội
          </span>
<span class="font-body-sm text-body-sm text-secondary">Sắp xếp theo: <strong class="text-text-main font-semibold">Gần bạn nhất</strong></span>
</div>
<!-- Store Card 1: ACTIVE FLAGSHIP -->
<article class="bg-surface-pure rounded-xl p-5 shadow-md border-2 border-primary-container relative transition-all">
<div class="flex items-start justify-between gap-2 mb-2.5">
<div class="flex flex-wrap gap-1.5">
<span class="px-2 py-0.5 rounded font-label-badge text-[10px] bg-primary-container text-on-primary uppercase font-bold tracking-wide">
                Flagship 5 Sao
              </span>
<span class="px-2 py-0.5 rounded font-label-badge text-[10px] bg-surface-container text-text-main font-semibold">
                CareLab VIP
              </span>
<span class="px-2 py-0.5 rounded font-label-badge text-[10px] bg-emerald-100 text-emerald-800 font-semibold flex items-center gap-1">
<span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Đang mở cửa
              </span>
</div>
<span class="font-label-badge text-label-badge text-primary-container font-bold shrink-0">
              1.2 km
            </span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-main hover:text-primary-container cursor-pointer transition-colors leading-snug">
            PhoneX Flagship Store Thái Hà - Hà Nội
          </h3>
<div class="mt-3 space-y-2 font-body-sm text-body-sm text-secondary">
<div class="flex items-start gap-2.5">
<span class="material-symbols-outlined text-[18px] text-primary-container shrink-0 mt-0.5">location_on</span>
<p class="text-text-main">
<strong class="font-semibold">124 - 126 Phố Thái Hà</strong>, P. Trung Liệt, Q. Đống Đa, Hà Nội
              </p>
</div>
<div class="flex items-center gap-2.5">
<span class="material-symbols-outlined text-[18px] text-secondary shrink-0">call</span>
<div>
<span>Bán hàng: </span>
<a class="font-semibold text-primary-container hover:underline" href="tel:02473006868">024.7300.6868</a>
<span class="mx-1 text-tertiary-fixed-dim">|</span>
<span>Kỹ thuật: <strong class="text-text-main">0914.888.777</strong></span>
</div>
</div>
<div class="flex items-center gap-2.5">
<span class="material-symbols-outlined text-[18px] text-secondary shrink-0">cloud_download</span>
<span>08:00 - 21:30 (Mở cửa tất cả ngày trong tuần)</span>
</div>
</div>
<!-- Services Available Chips -->
<div class="mt-4 pt-3 border-t border-border-subtle">
<p class="font-label-badge text-label-badge text-secondary uppercase mb-2">Trải nghiệm &amp; Cơ sở vật chất:</p>
<div class="grid grid-cols-2 gap-2 font-body-sm text-[12px] text-text-main">
<div class="flex items-center gap-1.5">
<span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                Bàn máy iPhone 18 &amp; S25 Ultra
              </div>
<div class="flex items-center gap-1.5">
<span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                Thẩm định thu cũ 10 phút
              </div>
<div class="flex items-center gap-1.5">
<span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                Bãi ô tô rộng rãi miễn phí
              </div>
<div class="flex items-center gap-1.5">
<span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                Cà phê &amp; nước ép đón tiếp
              </div>
</div>
</div>
<!-- Stock Pill -->
<div class="mt-3 bg-surface p-2.5 rounded-lg flex items-center justify-between font-body-sm text-[12px]">
<span class="text-secondary">Tình trạng máy mẫu:</span>
<span class="text-emerald-700 font-semibold flex items-center gap-1">
<span class="w-2 h-2 rounded-full bg-emerald-500"></span>
              Đầy đủ 100% phiên bản trải nghiệm
            </span>
</div>
<!-- Actions -->
<div class="mt-4 grid grid-cols-3 gap-2">
<button class="py-2.5 px-2 text-center rounded-lg font-label-button text-label-button border border-primary-container text-primary-container hover:bg-primary-fixed/20 transition-colors" type="button">
              Chi tiết
            </button>
<button class="py-2.5 px-2 text-center rounded-lg font-label-button text-label-button bg-surface-container hover:bg-surface-container-high text-text-main transition-colors flex items-center justify-center gap-1" type="button">
<span class="material-symbols-outlined text-[16px]">directions</span>
              Chỉ đường
            </button>
<button class="py-2.5 px-2 text-center rounded-lg font-label-button text-label-button bg-primary-container hover:bg-primary-hover text-on-primary transition-colors" type="button">
              Đặt lịch hẹn
            </button>
</div>
</article>
<!-- Store Card 2: CAU GIAY -->
<article class="bg-surface-pure rounded-xl p-5 shadow-sm hover:shadow-md transition-all border border-border-subtle hover:border-surface-dim">
<div class="flex items-start justify-between gap-2 mb-2">
<div class="flex flex-wrap gap-1.5">
<span class="px-2 py-0.5 rounded font-label-badge text-[10px] bg-surface-container text-text-main font-semibold">
                Showroom Trải Nghiệm
              </span>
<span class="px-2 py-0.5 rounded font-label-badge text-[10px] bg-primary-fixed/40 text-primary-container font-semibold">
                Trade-in Thu Cũ
              </span>
</div>
<span class="font-label-badge text-label-badge text-secondary">
              3.8 km
            </span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-main hover:text-primary-container cursor-pointer transition-colors">
            PhoneX Premium Hub Cầu Giấy
          </h3>
<div class="mt-2.5 space-y-1.5 font-body-sm text-body-sm text-secondary">
<div class="flex items-start gap-2">
<span class="material-symbols-outlined text-[18px] text-secondary shrink-0 mt-0.5">location_on</span>
<p class="text-text-main">
<strong class="font-semibold">240 Đường Cầu Giấy</strong>, P. Quan Hoa, Q. Cầu Giấy, Hà Nội
              </p>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-[18px] text-secondary shrink-0">call</span>
<span>Hotline: <strong class="text-text-main">024.7300.6869</strong> (08:00 - 21:30)</span>
</div>
</div>
<div class="mt-4 flex items-center gap-3">
<button class="flex-1 py-2 rounded-lg font-label-button text-label-button border border-border-subtle hover:border-primary-container hover:text-primary-container transition-colors text-text-main" onclick="window.location.href='<?php echo esc_url(home_url("/showroom/")); ?>'" type="button">
              Xem chi tiết showroom
            </button>
<button class="px-4 py-2 rounded-lg font-label-button text-label-button bg-surface-container hover:bg-surface-container-high text-text-main transition-colors flex items-center gap-1" type="button">
<span class="material-symbols-outlined text-[16px]">navigation</span>
              Chỉ đường
            </button>
</div>
</article>
<!-- Store Card 3: ROYAL CITY -->
<article class="bg-surface-pure rounded-xl p-5 shadow-sm hover:shadow-md transition-all border border-border-subtle hover:border-surface-dim">
<div class="flex items-start justify-between gap-2 mb-2">
<div class="flex flex-wrap gap-1.5">
<span class="px-2 py-0.5 rounded font-label-badge text-[10px] bg-secondary-container text-text-main font-semibold">
                Trong TTTM Vincom
              </span>
<span class="px-2 py-0.5 rounded font-label-badge text-[10px] bg-surface-container text-text-main font-semibold">
                Mở đến 22:00
              </span>
</div>
<span class="font-label-badge text-label-badge text-secondary">
              4.5 km
            </span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-main hover:text-primary-container cursor-pointer transition-colors">
            PhoneX Showroom Royal City Thanh Xuân
          </h3>
<div class="mt-2.5 space-y-1.5 font-body-sm text-body-sm text-secondary">
<div class="flex items-start gap-2">
<span class="material-symbols-outlined text-[18px] text-secondary shrink-0 mt-0.5">location_on</span>
<p class="text-text-main">
<strong class="font-semibold">Tầng B2-R3-12 Vincom Mega Mall Royal City</strong>, 72A Nguyễn Trãi, Thanh Xuân, Hà Nội
              </p>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-[18px] text-secondary shrink-0">call</span>
<span>Hotline: <strong class="text-text-main">024.7300.6870</strong> (09:30 - 22:00)</span>
</div>
</div>
<div class="mt-4 flex items-center gap-3">
<button class="flex-1 py-2 rounded-lg font-label-button text-label-button border border-border-subtle hover:border-primary-container hover:text-primary-container transition-colors text-text-main" onclick="window.location.href='<?php echo esc_url(home_url("/showroom/")); ?>'" type="button">
              Xem chi tiết showroom
            </button>
<button class="px-4 py-2 rounded-lg font-label-button text-label-button bg-surface-container hover:bg-surface-container-high text-text-main transition-colors flex items-center gap-1" type="button">
<span class="material-symbols-outlined text-[16px]">navigation</span>
              Chỉ đường
            </button>
</div>
</article>
<!-- Store Card 4: NGUYEN THAI HOC (HCMC Flagship Spotlight) -->
<article class="bg-surface-pure rounded-xl p-5 shadow-sm hover:shadow-md transition-all border border-border-subtle hover:border-surface-dim">
<div class="flex items-start justify-between gap-2 mb-2">
<div class="flex flex-wrap gap-1.5">
<span class="px-2 py-0.5 rounded font-label-badge text-[10px] bg-primary-container text-on-primary font-bold">
                Flagship Sài Gòn
              </span>
<span class="px-2 py-0.5 rounded font-label-badge text-[10px] bg-surface-container text-text-main font-semibold">
                TT Bảo Hành Uỷ Quyền
              </span>
</div>
<span class="font-label-badge text-label-badge text-secondary">
              TP. Hồ Chí Minh
            </span>
</div>
<h3 class="font-headline-sm text-headline-sm text-text-main hover:text-primary-container cursor-pointer transition-colors">
            PhoneX Flagship Nguyễn Thái Học - Quận 1
          </h3>
<div class="mt-2.5 space-y-1.5 font-body-sm text-body-sm text-secondary">
<div class="flex items-start gap-2">
<span class="material-symbols-outlined text-[18px] text-secondary shrink-0 mt-0.5">location_on</span>
<p class="text-text-main">
<strong class="font-semibold">136 Nguyễn Thái Học</strong>, P. Phạm Ngũ Lão, Quận 1, TP. Hồ Chí Minh
              </p>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-[18px] text-secondary shrink-0">call</span>
<span>Hotline: <strong class="text-text-main">028.7300.6868</strong> (08:00 - 22:00)</span>
</div>
</div>
<div class="mt-4 flex items-center gap-3">
<button class="flex-1 py-2 rounded-lg font-label-button text-label-button border border-border-subtle hover:border-primary-container hover:text-primary-container transition-colors text-text-main" onclick="window.location.href='<?php echo esc_url(home_url("/showroom/")); ?>'" type="button">
              Xem chi tiết showroom
            </button>
<button class="px-4 py-2 rounded-lg font-label-button text-label-button bg-surface-container hover:bg-surface-container-high text-text-main transition-colors flex items-center gap-1" type="button">
<span class="material-symbols-outlined text-[16px]">navigation</span>
              Chỉ đường
            </button>
</div>
</article>
<!-- Pagination Bar -->
<div class="pt-4 flex items-center justify-between">
<span class="font-body-sm text-body-sm text-secondary">Trang 1 / 10</span>
<div class="flex items-center gap-1.5">
<button class="w-9 h-9 rounded-lg bg-surface-container hover:bg-surface-container-high flex items-center justify-center text-text-main font-semibold transition-colors disabled:opacity-40" disabled="">
<span class="material-symbols-outlined text-[18px]">chevron_left</span>
</button>
<button class="w-9 h-9 rounded-lg bg-primary-container text-on-primary font-bold text-body-sm">1</button>
<button class="w-9 h-9 rounded-lg bg-surface-pure hover:bg-surface-container text-text-main font-semibold text-body-sm transition-colors border border-border-subtle">2</button>
<button class="w-9 h-9 rounded-lg bg-surface-pure hover:bg-surface-container text-text-main font-semibold text-body-sm transition-colors border border-border-subtle">3</button>
<span class="px-1 text-secondary">...</span>
<button class="w-9 h-9 rounded-lg bg-surface-pure hover:bg-surface-container text-text-main font-semibold text-body-sm transition-colors border border-border-subtle">10</button>
<button class="w-9 h-9 rounded-lg bg-surface-container hover:bg-surface-container-high flex items-center justify-center text-text-main font-semibold transition-colors">
<span class="material-symbols-outlined text-[18px]">chevron_right</span>
</button>
</div>
</div>
</div>
<!-- RIGHT COLUMN: Interactive Map & Live Spotlight (7/12 cols) -->
<div class="lg:col-span-7 sticky top-52 space-y-4">
<!-- Interactive Simulated Map Container -->
<div class="relative w-full h-[620px] rounded-2xl overflow-hidden shadow-lg bg-surface-container border border-border-subtle">
<!-- Real Location Map Background -->
<div class="w-full h-full bg-cover bg-center" data-location="124 Thai Ha, Dong Da, Hanoi, Vietnam" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDaJvFEKjv8QCqZJQcM5jVV0LtbFSNF26DU5mqNvUBC5hVMLvHocLt0rPQ5qXLjaV7DE9SjrOQMHIAPH2X0bOHMOuABeCTgwgHjFhlvWQlN1DR02OpDpOm7Omn2XcCy5jlDsLCkb1kDEJSSlY36B-6sPytBd_2BuXRYYtluREvoQe5MVr5IarRuTOV7XQAfOakF3aq1HhwfAjxynjLcY0vNXupxxOXnmSrsL55sdT8e9CSEHdqNHswz')"></div>
<!-- Ambient UI Overlay Grid Lines / Mock GIS Layer -->
<div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/20 pointer-events-none"></div>
<!-- Top Map Controls Bar -->
<div class="absolute top-4 left-4 right-4 flex items-center justify-between pointer-events-auto">
<div class="bg-surface-pure/95 backdrop-blur px-3.5 py-2 rounded-xl shadow-md border border-border-subtle flex items-center gap-2 text-text-main">
<span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
<span class="font-label-badge text-label-badge uppercase font-bold text-text-main">GPS PhoneX Live Radar</span>
<span class="text-tertiary-fixed-dim">|</span>
<span class="font-body-sm text-[12px] text-secondary">Khu vực Đống Đa - Ba Đình</span>
</div>
<div class="flex items-center gap-2">
<button class="w-10 h-10 rounded-xl bg-surface-pure/95 backdrop-blur hover:bg-surface-pure text-text-main shadow-md flex items-center justify-center border border-border-subtle transition-transform active:scale-95" title="Định vị lại">
<span class="material-symbols-outlined text-[20px] text-primary-container">my_location</span>
</button>
<button class="w-10 h-10 rounded-xl bg-surface-pure/95 backdrop-blur hover:bg-surface-pure text-text-main shadow-md flex items-center justify-center border border-border-subtle transition-transform active:scale-95" title="Chế độ toàn màn hình">
<span class="material-symbols-outlined text-[20px]">fullscreen</span>
</button>
</div>
</div>
<!-- Map Pins Simulation -->
<!-- Active Pin: 124 Thai Ha -->
<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 flex flex-col items-center">
<!-- Pulsing Halo -->
<div class="absolute -inset-4 bg-primary-container/20 rounded-full animate-ping pointer-events-none"></div>
<!-- Pin Badge -->
<div class="bg-primary-container text-on-primary font-bold px-3 py-1 rounded-full shadow-xl flex items-center gap-1.5 text-[12px] whitespace-nowrap cursor-pointer transform hover:scale-105 transition-transform">
<span class="material-symbols-outlined text-[14px]">stars</span>
              124 Thái Hà (Flagship)
            </div>
<div class="w-4 h-4 bg-primary-container rotate-45 -mt-2 shadow-lg"></div>
<div class="w-3 h-3 rounded-full bg-on-background/70 mt-1 blur-xs"></div>
</div>
<!-- Surrounding Inactive Pins -->
<div class="absolute top-[35%] left-[28%] z-10 flex flex-col items-center cursor-pointer group">
<div class="bg-surface-pure/90 hover:bg-primary-container text-text-main hover:text-on-primary font-semibold px-2 py-0.5 rounded shadow text-[11px] whitespace-nowrap transition-colors">
              Cầu Giấy
            </div>
<div class="w-2.5 h-2.5 bg-surface-pure/90 group-hover:bg-primary-container rotate-45 -mt-1 shadow"></div>
</div>
<div class="absolute bottom-[30%] left-[38%] z-10 flex flex-col items-center cursor-pointer group">
<div class="bg-surface-pure/90 hover:bg-primary-container text-text-main hover:text-on-primary font-semibold px-2 py-0.5 rounded shadow text-[11px] whitespace-nowrap transition-colors">
              Royal City
            </div>
<div class="w-2.5 h-2.5 bg-surface-pure/90 group-hover:bg-primary-container rotate-45 -mt-1 shadow"></div>
</div>
<div class="absolute top-[28%] right-[22%] z-10 flex flex-col items-center cursor-pointer group">
<div class="bg-surface-pure/90 hover:bg-primary-container text-text-main hover:text-on-primary font-semibold px-2 py-0.5 rounded shadow text-[11px] whitespace-nowrap transition-colors">
              Hoàn Kiếm
            </div>
<div class="w-2.5 h-2.5 bg-surface-pure/90 group-hover:bg-primary-container rotate-45 -mt-1 shadow"></div>
</div>
<!-- Bottom Floating Detail Flyout for Active Showroom -->
<div class="absolute bottom-4 left-4 right-4 z-20 pointer-events-auto">
<div class="bg-surface-pure rounded-xl p-4 shadow-xl border border-border-subtle flex flex-col sm:flex-row items-center gap-4">
<!-- Real Store Facade Image -->
<div class="w-full sm:w-36 h-28 rounded-lg overflow-hidden shrink-0 bg-surface-container relative">
<img class="w-full h-full object-cover" alt="A modern luxurious two-story PhoneX flagship electronics smartphone showroom at night with floor-to-ceiling glass windows, warm interior ambient lighting, sleek red accent branding, customers testing new smartphones at minimalist wooden demo tables, exterior architectural view in Hanoi." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDiLBBF0O2m2SiovyPOB7P8oAvUtALFOR8FKv1Sb6408mO6F7xWckUsWgfIEClHYIKOh9ldNXmtpyZ_S-Nd2XmLrZNDeULxnx9k29d2xSXNt4HgOHSiJOeS5p0FVHbTXSZcSqYKIWGszPvUVOjkMIuIuuthYZas0ahrOdYzmgjtFz6Bum1_RVczhxAHGcOSAniPYl7Ob7-eQht8jcVrjws5UhYDI4G3Xj57dzAw_PiXKU96kqao-Bvp"/>
<span class="absolute bottom-1 left-1 bg-black/70 text-on-primary px-1.5 py-0.5 rounded text-[10px] font-semibold">Ảnh thực tế</span>
</div>
<!-- Key Highlights & Route CTA -->
<div class="flex-1 min-w-0">
<div class="flex items-center justify-between gap-2">
<h4 class="font-headline-sm text-[16px] text-text-main font-bold truncate">
                    124 Thái Hà, P. Trung Liệt, Đống Đa
                  </h4>
<span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-label-badge text-[10px] font-bold shrink-0">
                    Giao thông thông thoáng
                  </span>
</div>
<p class="font-body-sm text-[13px] text-secondary mt-1">
                  Cách bạn 1.2 km (khoảng 4 phút đi xe máy / ô tô). Có bảo vệ hướng dẫn bãi đỗ ô tô miễn phí trước cửa showroom.
                </p>
<div class="flex flex-wrap items-center gap-4 mt-3 pt-2 border-t border-border-subtle text-body-sm text-[12px]">
<span class="text-text-main font-semibold flex items-center gap-1">
<span class="material-symbols-outlined text-[16px] text-primary-container">support_agent</span>
                    Hỗ trợ nhanh: 1800.6868
                  </span>
<a class="text-primary-container font-semibold hover:underline flex items-center gap-0.5" href="#">
                    Mở với Google Maps 
                    <span class="material-symbols-outlined text-[14px]">north_east</span>
</a>
</div>
</div>
</div>
</div>
</div>
<!-- 24/7 Availability & Direct Support Card -->
<div class="bg-gradient-to-r from-surface-pure to-primary-fixed/20 p-4 rounded-xl border border-border-subtle flex items-center justify-between gap-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-primary-container text-on-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[20px]">inventory_2</span>
</div>
<div>
<p class="font-label-button text-label-button text-text-main">Cần kiểm tra máy cụ thể tại showroom gần nhất?</p>
<p class="font-body-sm text-body-sm text-secondary">Đội ngũ trực showroom giữ hàng trước và chuẩn bị phòng trải nghiệm trong 5 phút.</p>
</div>
</div>
<button class="shrink-0 px-4 py-2.5 bg-primary-container hover:bg-primary-hover text-on-primary rounded-lg font-label-button text-label-button transition-colors whitespace-nowrap" type="button">
            Gọi ngay 1800.6868
          </button>
</div>
</div>
</div>
</section>
<!-- 4 Guarantees Service Pillars at PhoneX Showrooms -->
<section class="w-full bg-surface-pure border-t border-border-subtle py-space-xl">
<div class="max-w-7xl mx-auto px-6">
<div class="text-center max-w-2xl mx-auto mb-12">
<span class="font-label-badge text-label-badge text-primary-container uppercase tracking-wider font-bold">
          Tiêu Chuẩn Dịch Vụ Vượt Trội
        </span>
<h2 class="font-headline-lg text-headline-lg text-text-main font-bold mt-2">
          4 Đặc Quyền Khi Trải Nghiệm Tại PhoneX
        </h2>
<p class="font-body-regular text-body-regular text-secondary mt-2">
          Mỗi điểm đến thuộc hệ thống 128 cửa hàng đều được vận hành đồng nhất theo tiêu chuẩn 5 sao khắt khe nhất thị trường công nghệ.
        </p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
<!-- Pillar 1 -->
<div class="bg-surface rounded-xl p-6 transition-all hover:-translate-y-1 duration-200">
<div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary flex items-center justify-center mb-4 shadow-sm">
<span class="material-symbols-outlined text-[28px]">devices</span>
</div>
<h3 class="font-title-product text-title-product text-text-main mb-2">
            100% Trải Nghiệm Thực Tế
          </h3>
<p class="font-body-regular text-body-sm text-secondary leading-relaxed">
            Mọi thiết bị từ iPhone cao cấp nhất đến Flagship Android đều sẵn sàng trên bàn trải nghiệm tương tác trực quan, mở đầy đủ tính năng cao cấp không khóa demo.
          </p>
</div>
<!-- Pillar 2 -->
<div class="bg-surface rounded-xl p-6 transition-all hover:-translate-y-1 duration-200">
<div class="w-12 h-12 rounded-xl bg-surface-container text-text-main flex items-center justify-center mb-4 shadow-sm">
<span class="material-symbols-outlined text-[28px]">school</span>
</div>
<h3 class="font-title-product text-title-product text-text-main mb-2">
            Chuyên Viên Chuẩn Hãng
          </h3>
<p class="font-body-regular text-body-sm text-secondary leading-relaxed">
            Đội ngũ tư vấn viên được đào tạo chuyên sâu bởi Apple Master &amp; Samsung Elite, tư vấn trung thực theo nhu cầu thực sự của từng khách hàng.
          </p>
</div>
<!-- Pillar 3 -->
<div class="bg-surface rounded-xl p-6 transition-all hover:-translate-y-1 duration-200">
<div class="w-12 h-12 rounded-xl bg-surface-container text-text-main flex items-center justify-center mb-4 shadow-sm">
<span class="material-symbols-outlined text-[28px]">shield</span>
</div>
<h3 class="font-title-product text-title-product text-text-main mb-2">
            Dán Kính Trọn Đời VIP
          </h3>
<p class="font-body-regular text-body-sm text-secondary leading-relaxed">
            Hội viên VIP PhoneX ghé bất kỳ showroom nào trên toàn quốc đều được dán cường lực cao cấp mới hoàn toàn miễn phí trọn đời không giới hạn số lần.
          </p>
</div>
<!-- Pillar 4 -->
<div class="bg-surface rounded-xl p-6 transition-all hover:-translate-y-1 duration-200">
<div class="w-12 h-12 rounded-xl bg-surface-container text-text-main flex items-center justify-center mb-4 shadow-sm">
<span class="material-symbols-outlined text-[28px]">cleaning_services</span>
</div>
<h3 class="font-title-product text-title-product text-text-main mb-2">
            Bảo Dưỡng Siêu Âm Miễn Phí
          </h3>
<p class="font-body-regular text-body-sm text-secondary leading-relaxed">
            Dịch vụ sao lưu đồng bộ dữ liệu bảo mật tuyệt đối, tạo tài khoản chính chủ và vệ sinh smartphone bằng công nghệ sóng siêu âm chuyên dụng lấy ngay.
          </p>
</div>
</div>
</div>
</section>
<!-- Interactive Store Search Helper Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
      // Micro interaction for store filter selection
      const filterPills = document.querySelectorAll('button[class*="rounded-full"]');
      filterPills.forEach(pill => {
        pill.addEventListener('click', () => {
          if (!pill.classList.contains('bg-primary-container')) {
            filterPills.forEach(p => {
              p.classList.remove('bg-primary-container', 'text-on-primary', 'font-bold');
              p.classList.add('bg-surface', 'text-secondary');
            });
            pill.classList.remove('bg-surface', 'text-secondary');
            pill.classList.add('bg-primary-container', 'text-on-primary', 'font-bold');
          }
        });
      });
    });
  </script>
</div></main>

<?php
get_footer();
