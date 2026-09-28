<?php
/**
 * Template Name: PhoneX Tra Cứu Bảo Hành (Warranty)
 *
 * @package PhoneX
 */

get_header();
?>

<main class="w-full pt-28 bg-surface"><div class="flex flex-col w-full">
<!-- Top Ambient Glow -->
<div class="relative w-full overflow-hidden">
<div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[980px] h-[360px] bg-gradient-to-b from-primary/10 via-primary/5 to-transparent blur-3xl pointer-events-none"></div>
<!-- Main Container Block (Target 1280px-1320px) -->
<div class="max-w-7xl mx-auto px-6 py-6 flex flex-col gap-8">
<!-- 1. Breadcrumb -->
<nav class="flex items-center gap-2 text-secondary font-body-sm text-body-sm">
<a class="hover:text-primary-container transition-colors flex items-center gap-1" href="#">
<span class="material-symbols-outlined text-base">home</span>
          Trang chủ
        </a>
<span class="material-symbols-outlined text-sm text-secondary-fixed-dim">chevron_right</span>
<a class="hover:text-primary-container transition-colors" href="#">Dịch vụ khách hàng</a>
<span class="material-symbols-outlined text-sm text-secondary-fixed-dim">chevron_right</span>
<span class="text-on-surface font-semibold">Tra cứu bảo hành điện tử công khai</span>
</nav>
<!-- 2. Hero Section & Inquiry Card -->
<section class="relative rounded-2xl bg-surface-pure shadow-sm p-8 lg:p-10 flex flex-col items-center text-center">
<!-- Live Verified Badge -->
<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary-fixed text-primary font-label-badge text-label-badge mb-4">
<span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">verified_user</span>
          TRUNG TÂM TRA CỨU ĐIỆN TỬ TOÀN QUỐC 24/7
        </div>
<h1 class="font-headline-xl text-headline-xl text-text-main max-w-3xl tracking-tight mb-3">
          Tra Cứu Bảo Hành Điện Tử Smartphone PhoneX
        </h1>
<p class="font-body-regular text-body-regular text-secondary max-w-2xl mb-8">
          Dành cho khách hàng chưa đăng nhập. Nhập số điện thoại mua hàng để kiểm tra thời hạn bảo hành, lịch sử sửa chữa và các gói PhoneX Care+ mà không cần mang theo hóa đơn giấy.
        </p>
<!-- Centered Search Form -->
<div class="w-full max-w-3xl bg-surface-container-low rounded-xl p-3 shadow-inner">
<form class="flex flex-col sm:flex-row items-center gap-2.5" id="warrantySearchForm" onsubmit="event.preventDefault();">
<div class="relative flex-1 w-full">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-secondary text-2xl">call</span>
<input class="w-full h-12 pl-12 pr-4 bg-surface-pure rounded-lg text-on-surface font-body-regular text-body-regular placeholder:text-secondary outline-none focus:bg-surface-pure transition-all shadow-sm" id="phoneInput" placeholder="Nhập số điện thoại đặt hàng (Ví dụ: 0988 888 686)" type="tel" value="0988 888 686"/>
</div>
<button class="w-full sm:w-auto h-12 px-8 bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button rounded-lg flex items-center justify-center gap-2 shadow-md transition-all active:scale-[0.98] shrink-0" type="submit">
<span class="material-symbols-outlined text-xl">search</span>
              Tra Cứu Ngay
            </button>
</form>
<!-- Security Toggle & Privacy Notice -->
<div class="mt-3.5 pt-3.5 flex flex-col md:flex-row md:items-center justify-between gap-3 text-left px-2">
<label class="flex items-center gap-2.5 cursor-pointer group">
<input class="w-4 h-4 rounded text-primary-container accent-primary-container cursor-pointer" id="otpCheckbox" type="checkbox"/>
<span class="font-body-sm text-body-sm text-on-surface group-hover:text-primary-container transition-colors">
                Bật xác thực bảo mật OTP nâng cao (Bảo vệ thông tin cá nhân &amp; địa chỉ đầy đủ)
              </span>
</label>
<span class="font-label-badge text-label-badge text-secondary bg-surface-container px-2.5 py-1 rounded self-start md:self-auto">
              Chế độ xem nhanh: Số điện thoại đang ẩn 3 số giữa
            </span>
</div>
</div>
<!-- Quick Member Sync Card -->
<div class="mt-6 flex items-center gap-2 font-body-sm text-body-sm text-secondary bg-surface-container-low px-4 py-2 rounded-full">
<span class="material-symbols-outlined text-primary-container text-base">loyalty</span>
<span>Khách hàng thân thiết?</span>
<a class="text-primary-container font-semibold hover:underline" href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink("myaccount") : home_url("/my-account/")); ?>">Đăng nhập tài khoản</a>
<span>để đồng bộ tự động và nhận thông báo nhắc hạn bảo hành qua Zalo/SMS.</span>
</div>
</section>
<!-- 3. Result Summary Dashboard -->
<section class="flex flex-col gap-4">
<!-- Live Status Bar -->
<div class="flex flex-wrap items-center justify-between gap-3 bg-surface-pure rounded-xl p-4 shadow-sm">
<div class="flex items-center gap-3">
<span class="relative flex h-3 w-3">
<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-container opacity-75"></span>
<span class="relative inline-flex rounded-full h-3 w-3 bg-primary-container"></span>
</span>
<span class="font-body-regular text-body-regular text-secondary">
              Kết quả tra cứu cho số điện thoại: 
              <span class="font-title-product text-title-product text-text-main font-bold ml-1 tracking-wider">0988 ••• 686</span>
</span>
<span class="px-2 py-0.5 rounded bg-surface-container font-label-badge text-label-badge text-secondary uppercase">
              Chính chủ xác thực
            </span>
</div>
<div class="flex items-center gap-2 font-body-sm text-body-sm text-secondary">
<span class="material-symbols-outlined text-base">update</span>
            Dữ liệu đồng bộ theo thời gian thực: 28/03/2025 - 14:35
          </div>
</div>
<!-- 4 Stat Metric Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
<div class="bg-surface-pure rounded-xl p-5 shadow-sm flex items-center justify-between">
<div>
<p class="font-label-badge text-label-badge text-secondary uppercase">Tổng thiết bị</p>
<p class="font-headline-md text-headline-md text-text-main mt-0.5">04 <span class="font-body-sm text-body-sm text-secondary font-normal">máy</span></p>
</div>
<div class="w-12 h-12 rounded-xl bg-surface-container-low flex items-center justify-center text-text-main">
<span class="material-symbols-outlined text-2xl">devices</span>
</div>
</div>
<div class="bg-surface-pure rounded-xl p-5 shadow-sm flex items-center justify-between">
<div>
<p class="font-label-badge text-label-badge text-secondary uppercase">Đang bảo hành</p>
<p class="font-headline-md text-headline-md text-primary-container mt-0.5">03 <span class="font-body-sm text-body-sm text-secondary font-normal">máy</span></p>
</div>
<div class="w-12 h-12 rounded-xl bg-primary-fixed flex items-center justify-center text-primary">
<span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">verified</span>
</div>
</div>
<div class="bg-surface-pure rounded-xl p-5 shadow-sm flex items-center justify-between">
<div>
<p class="font-label-badge text-label-badge text-secondary uppercase">Đã hết hạn</p>
<p class="font-headline-md text-headline-md text-secondary mt-0.5">01 <span class="font-body-sm text-body-sm text-secondary font-normal">máy</span></p>
</div>
<div class="w-12 h-12 rounded-xl bg-surface-container-low flex items-center justify-center text-secondary">
<span class="material-symbols-outlined text-2xl">event_busy</span>
</div>
</div>
<div class="bg-surface-pure rounded-xl p-5 shadow-sm flex items-center justify-between">
<div>
<p class="font-label-badge text-label-badge text-secondary uppercase">Gói Care+ VIP</p>
<p class="font-headline-md text-headline-md text-on-surface mt-0.5">02 <span class="font-body-sm text-body-sm text-secondary font-normal">gói</span></p>
</div>
<div class="w-12 h-12 rounded-xl bg-surface-container-high flex items-center justify-center text-primary-container">
<span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
</div>
</div>
</div>
</section>
<!-- 4. Filter Segment -->
<section class="flex flex-wrap items-center justify-between gap-4 pt-2">
<div class="inline-flex p-1 bg-surface-container-low rounded-xl gap-1">
<button class="px-4 py-2 rounded-lg bg-surface-pure text-primary-container font-label-button text-label-button shadow-sm">
            Tất cả (4)
          </button>
<button class="px-4 py-2 rounded-lg text-secondary hover:text-on-surface font-label-button text-label-button transition-colors" onclick="window.location.href='<?php echo esc_url(home_url("/bao-hanh/")); ?>'">
            Đang bảo hành (3)
          </button>
<button class="px-4 py-2 rounded-lg text-secondary hover:text-on-surface font-label-button text-label-button transition-colors">
            Đã hết hạn (1)
          </button>
<button class="px-4 py-2 rounded-lg text-secondary hover:text-on-surface font-label-button text-label-button transition-colors">
            Có gói Care+ (2)
          </button>
</div>
<div class="flex items-center gap-2 text-secondary font-body-sm text-body-sm">
<span class="material-symbols-outlined text-lg">info</span>
          Bảo hành chính hãng 100% tại trung tâm bảo hành ủy quyền PhoneX và Hãng
        </div>
</section>
<!-- 5. Product & Warranty Cards List -->
<section class="flex flex-col gap-6">
<!-- Device 1: iPhone 16 Pro Max -->
<article class="bg-surface-pure rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6 lg:p-7 flex flex-col gap-6">
<div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
<div class="flex items-center gap-5">
<div class="w-24 h-24 rounded-xl bg-surface-container-low p-2 shrink-0 flex items-center justify-center">
<img class="w-full h-full object-contain" alt="Close up studio photograph of an Apple iPhone 16 Pro Max in Desert Titanium finish, clean white background, premium minimalist lighting, crisp tech device presentation, sharp edges, metallic sheen" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCpD5tJrU60VVn07xVVUfjmPeSwSxDYdu-ynNYHpTjala5g6WNTmRsapOhSCLpKafbwcIVlJf1A930gUIwto3oG97cIZ9FV_XJWuLlmwAS2OHuRlA7MJcp9HDeLVxzepiorXCvTbkG7BQGYCGlPFy-itg-KkpjMM4V30VQ7XKiOLH6oDY7hlXVASX6wZCqxKZJooTuC5jnM7aSJE0X8vPaGNrGy_UKnn00KkoJ7brLs1TJXANGpoaPL"/>
</div>
<div class="flex flex-col">
<div class="flex flex-wrap items-center gap-2 mb-1.5">
<span class="px-2.5 py-0.5 rounded-full bg-primary-container text-on-primary font-label-badge text-label-badge uppercase tracking-wide">
                    ĐANG HIỆU LỰC - BẢO VỆ TOÀN DIỆN
                  </span>
<span class="px-2 py-0.5 rounded bg-surface-container text-secondary font-label-badge text-label-badge">
                    Mới 100% Nguyên Seal VN/A
                  </span>
</div>
<h2 class="font-headline-sm text-headline-sm text-text-main">
                  iPhone 16 Pro Max 256GB Desert Titanium VN/A
                </h2>
<div class="flex flex-wrap items-center gap-4 mt-2 font-body-sm text-body-sm text-secondary">
<div class="flex items-center gap-1.5">
<span>IMEI:</span>
<span class="font-semibold text-text-main font-mono">35689210984112</span>
<button class="text-secondary hover:text-primary-container p-0.5 transition-colors" onclick="navigator.clipboard.writeText('35689210984112'); alert('Đã sao chép IMEI 35689210984112');" title="Sao chép IMEI">
<span class="material-symbols-outlined text-sm">content_copy</span>
</button>
</div>
<span>•</span>
<div>Serial: <span class="font-semibold text-text-main font-mono">H9X4M288LPO</span></div>
<span>•</span>
<div>Ngày kích hoạt: <span class="font-semibold text-text-main">28/03/2025</span></div>
</div>
</div>
</div>
<!-- Time Indicator & Progress -->
<div class="w-full lg:w-72 bg-surface-container-low rounded-xl p-4 flex flex-col justify-between shrink-0">
<div class="flex items-center justify-between text-secondary font-body-sm text-body-sm mb-1.5">
<span>Thời hạn còn lại:</span>
<span class="font-title-product text-title-product text-primary-container font-bold">Còn 364 ngày</span>
</div>
<!-- Progress Bar -->
<div class="w-full h-2 rounded-full bg-surface-container-high overflow-hidden">
<div class="h-full bg-primary-container rounded-full" style="width: 99.7%;"></div>
</div>
<div class="flex items-center justify-between text-secondary font-label-badge text-label-badge mt-2">
<span>Từ: 28/03/2025</span>
<span>Đến: 28/03/2026</span>
</div>
</div>
</div>
<!-- Coverage Benefits Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-3 bg-surface-container-low rounded-xl p-4">
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary-container mt-0.5">verified_user</span>
<div class="flex flex-col">
<span class="font-label-button text-label-button text-text-main">Gói AppleCare Chính Hãng</span>
<span class="font-body-sm text-body-sm text-secondary">Bảo hành phần cứng 12 tháng tại các trung tâm AASP toàn cầu</span>
</div>
</div>
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary-container mt-0.5">swap_horiz</span>
<div class="flex flex-col">
<span class="font-label-button text-label-button text-text-main">PhoneX Care VIP 1 Đổi 1</span>
<span class="font-body-sm text-body-sm text-secondary">Đổi máy mới nguyên seal ngay lập tức nếu lỗi từ nhà sản xuất trong 365 ngày</span>
</div>
</div>
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary-container mt-0.5">home_repair_service</span>
<div class="flex flex-col">
<span class="font-label-button text-label-button text-text-main">Bảo hành tận nơi 60 Phút</span>
<span class="font-body-sm text-body-sm text-secondary">Kỹ thuật viên đến kiểm tra và tiếp nhận máy tại nhà khu vực nội thành</span>
</div>
</div>
</div>
<!-- Bottom Actions -->
<div class="flex flex-wrap items-center justify-between gap-3 pt-2">
<div class="flex items-center gap-2 text-secondary font-body-sm text-body-sm">
<span class="material-symbols-outlined text-base">pin_drop</span>
              Địa điểm bảo hành ưu tiên: Showroom PhoneX 142 Thái Hà, Đống Đa, Hà Nội
            </div>
<div class="flex flex-wrap items-center gap-2.5">
<button class="px-4 py-2 bg-surface-container-low hover:bg-surface-container text-text-main font-label-button text-label-button rounded-lg transition-colors">
                Xem chi tiết quyền lợi
              </button>
<button class="px-4 py-2 bg-surface-pure hover:bg-surface-container-low text-primary-container font-label-button text-label-button rounded-lg transition-colors shadow-sm">
                Đặt lịch KTV đến nhà trong 60p
              </button>
<button class="px-5 py-2 bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button rounded-lg transition-colors shadow-sm flex items-center gap-2" onclick="window.location.href='<?php echo esc_url(home_url("/bao-hanh/")); ?>'">
<span class="material-symbols-outlined text-base">build</span>
                Yêu cầu bảo hành / Sửa chữa
              </button>
</div>
</div>
</article>
<!-- Device 2: Samsung Galaxy S25 Ultra -->
<article class="bg-surface-pure rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6 lg:p-7 flex flex-col gap-6">
<div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
<div class="flex items-center gap-5">
<div class="w-24 h-24 rounded-xl bg-surface-container-low p-2 shrink-0 flex items-center justify-center">
<img class="w-full h-full object-contain" alt="Samsung Galaxy S25 Ultra in Titanium Silver Shadow showing rear quadruple camera matrix with S-Pen placed beside, pure neutral bright backdrop, commercial photography style, high key lighting, crisp reflections" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBIQCxAWutlJkraI6a5zVgptu7IE81PXpp50-iGV-4ZRCnzRGtEcPoxUtdb1GvwerNc6M2UTK9sXrM506NYkV5kG51goJJnfb9hPUyAuunGDCKNNP-PB-JZzqlFuymhKPhjWtd0ZSqfs7yOe-OgDkDUHI2nC0Vy7m3x09hP3_fBltYL8hC1NFofKWSbIreVo1jWxgHl8SO2n5u6AauP1jRKFnkCvTwiRtPzlTo-g_8YOLfXuN0xgpPR"/>
</div>
<div class="flex flex-col">
<div class="flex flex-wrap items-center gap-2 mb-1.5">
<span class="px-2.5 py-0.5 rounded-full bg-primary-container text-on-primary font-label-badge text-label-badge uppercase tracking-wide">
                    ĐANG HIỆU LỰC
                  </span>
<span class="px-2 py-0.5 rounded bg-surface-container text-secondary font-label-badge text-label-badge">
                    Samsung Care+ 12T Kèm Máy
                  </span>
</div>
<h2 class="font-headline-sm text-headline-sm text-text-main">
                  Samsung Galaxy S25 Ultra 512GB Titanium Silver Shadow
                </h2>
<div class="flex flex-wrap items-center gap-4 mt-2 font-body-sm text-body-sm text-secondary">
<div class="flex items-center gap-1.5">
<span>IMEI:</span>
<span class="font-semibold text-text-main font-mono">35981204882190</span>
<button class="text-secondary hover:text-primary-container p-0.5 transition-colors" onclick="navigator.clipboard.writeText('35981204882190'); alert('Đã sao chép IMEI 35981204882190');" title="Sao chép IMEI">
<span class="material-symbols-outlined text-sm">content_copy</span>
</button>
</div>
<span>•</span>
<div>Serial: <span class="font-semibold text-text-main font-mono">R5CW1098AKL</span></div>
<span>•</span>
<div>Ngày mua: <span class="font-semibold text-text-main">28/03/2025</span></div>
</div>
</div>
</div>
<!-- Time Indicator -->
<div class="w-full lg:w-72 bg-surface-container-low rounded-xl p-4 flex flex-col justify-between shrink-0">
<div class="flex items-center justify-between text-secondary font-body-sm text-body-sm mb-1.5">
<span>Thời hạn còn lại:</span>
<span class="font-title-product text-title-product text-primary-container font-bold">Còn 364 ngày</span>
</div>
<div class="w-full h-2 rounded-full bg-surface-container-high overflow-hidden">
<div class="h-full bg-primary-container rounded-full" style="width: 99.7%;"></div>
</div>
<div class="flex items-center justify-between text-secondary font-label-badge text-label-badge mt-2">
<span>Từ: 28/03/2025</span>
<span>Hết hạn: 28/03/2026</span>
</div>
</div>
</div>
<!-- Bottom Actions -->
<div class="flex flex-wrap items-center justify-between gap-3 pt-2">
<div class="flex items-center gap-2 text-secondary font-body-sm text-body-sm">
<span class="material-symbols-outlined text-base">shield</span>
              Quyền lợi: Hỗ trợ bảo hành rơi vỡ, vào nước theo chính sách Samsung Care+
            </div>
<div class="flex flex-wrap items-center gap-2.5">
<button class="px-4 py-2 bg-surface-container-low hover:bg-surface-container text-text-main font-label-button text-label-button rounded-lg transition-colors">
                Hỗ trợ kỹ thuật từ xa
              </button>
<button class="px-5 py-2 bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button rounded-lg transition-colors shadow-sm flex items-center gap-2" onclick="window.location.href='<?php echo esc_url(home_url("/thu-cu-doi-moi/")); ?>'">
<span class="material-symbols-outlined text-base">currency_exchange</span>
                Định giá Trade-in lên đời
              </button>
</div>
</div>
</article>
<!-- Device 3: iPhone 15 Pro Max (Like New) -->
<article class="bg-surface-pure rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6 lg:p-7 flex flex-col gap-6">
<div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
<div class="flex items-center gap-5">
<div class="w-24 h-24 rounded-xl bg-surface-container-low p-2 shrink-0 flex items-center justify-center">
<img class="w-full h-full object-contain" alt="Apple iPhone 15 Pro Max Natural Titanium, tilted profile on immaculate neutral white background, showing clean brushed titanium band, pristine screen, studio lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA7CaHcuOFqfJiq27TWE_QDnutb5jYxtgZ6wOpLMAU7hovRpvZNDzMkATOq7RJzK7JkIXY1nfAFllEZqD6Qqstgf4A6jv_MLkZVtSKs4aqSzd47qug1KjCt23Sl800Y4a95x9p5EqC9ulOvBKLaTnMh-nWpjgoJKj4w9pkQK7QJuQqCZ070tvWR4IPmh6LS1_6ItQ2pPGY7A5eZhP_rm6ukWZJWCHbW3Gcp2Ps-TJxwLfl235HY9IOa"/>
</div>
<div class="flex flex-col">
<div class="flex flex-wrap items-center gap-2 mb-1.5">
<span class="px-2.5 py-0.5 rounded-full bg-primary-container text-on-primary font-label-badge text-label-badge uppercase tracking-wide">
                    ĐANG HIỆU LỰC - 1 ĐỔI 1 TRONG 30 NGÀY
                  </span>
<span class="px-2 py-0.5 rounded bg-surface-container text-secondary font-label-badge text-label-badge">
                    Máy Cũ Like New 99% (#USED-882)
                  </span>
<span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-badge text-label-badge">
                    Pin zin 98%
                  </span>
</div>
<h2 class="font-headline-sm text-headline-sm text-text-main">
                  iPhone 15 Pro Max 256GB Titan Tự Nhiên
                </h2>
<div class="flex flex-wrap items-center gap-4 mt-2 font-body-sm text-body-sm text-secondary">
<div class="flex items-center gap-1.5">
<span>IMEI:</span>
<span class="font-semibold text-text-main font-mono">35894120984992</span>
<button class="text-secondary hover:text-primary-container p-0.5 transition-colors" onclick="navigator.clipboard.writeText('35894120984992'); alert('Đã sao chép IMEI 35894120984992');" title="Sao chép IMEI">
<span class="material-symbols-outlined text-sm">content_copy</span>
</button>
</div>
<span>•</span>
<div>Gói bảo hành: <span class="font-semibold text-text-main">PhoneX Care+ Máy Cũ</span></div>
<span>•</span>
<div>Ngày mua: <span class="font-semibold text-text-main">15/03/2025</span></div>
</div>
</div>
</div>
<!-- Time Indicator -->
<div class="w-full lg:w-72 bg-surface-container-low rounded-xl p-4 flex flex-col justify-between shrink-0">
<div class="flex items-center justify-between text-secondary font-body-sm text-body-sm mb-1.5">
<span>Thời hạn còn lại:</span>
<span class="font-title-product text-title-product text-primary-container font-bold">Còn 351 ngày</span>
</div>
<div class="w-full h-2 rounded-full bg-surface-container-high overflow-hidden">
<div class="h-full bg-primary-container rounded-full" style="width: 96%;"></div>
</div>
<div class="flex items-center justify-between text-secondary font-label-badge text-label-badge mt-2">
<span>Từ: 15/03/2025</span>
<span>Hết hạn: 15/03/2026</span>
</div>
</div>
</div>
<!-- Bottom Actions -->
<div class="flex flex-wrap items-center justify-between gap-3 pt-2">
<div class="flex items-center gap-2 text-secondary font-body-sm text-body-sm">
<span class="material-symbols-outlined text-base">checklist</span>
              Đã vượt qua bài kiểm tra chất lượng 68 bước tiêu chuẩn PhoneX trước khi xuất bán
            </div>
<div class="flex flex-wrap items-center gap-2.5">
<button class="px-4 py-2 bg-surface-container-low hover:bg-surface-container text-text-main font-label-button text-label-button rounded-lg transition-colors">
                Biên bản thẩm định 68 bước
              </button>
<button class="px-5 py-2 bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button rounded-lg transition-colors shadow-sm flex items-center gap-2">
<span class="material-symbols-outlined text-base">cached</span>
                Yêu cầu đổi máy khác
              </button>
</div>
</div>
</article>
<!-- Device 4: iPhone 13 Pro Max (Expired - Trade-in opportunity) -->
<article class="bg-surface-pure rounded-2xl shadow-sm p-6 lg:p-7 flex flex-col gap-6 opacity-95">
<div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
<div class="flex items-center gap-5">
<div class="w-24 h-24 rounded-xl bg-surface-container-low p-2 shrink-0 flex items-center justify-center grayscale contrast-75">
<img class="w-full h-full object-contain" alt="Apple iPhone 13 Pro Max Sierra Blue diagonal placement on clean solid off-white studio surface, soft shadows, neutral tech product photograph" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBj_jabwlYXDPWNGAb8YeIhlh6IyLLGhEGO7fSUfylZkvhib2ONvP0aevrjq1no7nUpOY-Op83i3jRdSQ0IjqpQFlswtpdkEnEglSrUSjNzPNwhGcwyaTrCMvDNAjTH-i-xn9Aj9t6pr9Y9T9lPYx9BcwEJS95nkSU4k0rMI-YVftj4pc7-rIVP13jT3KbxEkTwnDpvNAj0pqNWsiK7AtpOVxmzL7mPMHGHNytx3TqsbqwLecAtIAdH"/>
</div>
<div class="flex flex-col">
<div class="flex flex-wrap items-center gap-2 mb-1.5">
<span class="px-2.5 py-0.5 rounded-full bg-surface-container-high text-secondary font-label-badge text-label-badge uppercase tracking-wide">
                    ĐÃ HẾT HẠN BẢO HÀNH
                  </span>
<span class="px-2 py-0.5 rounded bg-surface-container text-secondary font-label-badge text-label-badge">
                    Kích hoạt ngày 12/10/2023
                  </span>
</div>
<h2 class="font-headline-sm text-headline-sm text-text-main">
                  iPhone 13 Pro Max 128GB Sierra Blue
                </h2>
<div class="flex flex-wrap items-center gap-4 mt-2 font-body-sm text-body-sm text-secondary">
<div>IMEI: <span class="font-semibold text-text-main font-mono">35489011928374</span></div>
<span>•</span>
<div>Thời gian hết hạn: <span class="font-semibold text-secondary">12/10/2024 (Đã hết 167 ngày)</span></div>
</div>
</div>
</div>
<!-- Inactive Status Indicator -->
<div class="w-full lg:w-72 bg-surface-container-low rounded-xl p-4 flex flex-col justify-between shrink-0">
<div class="flex items-center justify-between text-secondary font-body-sm text-body-sm mb-1.5">
<span>Tình trạng:</span>
<span class="font-title-product text-title-product text-secondary font-semibold">Hết hạn</span>
</div>
<div class="w-full h-2 rounded-full bg-surface-container-high overflow-hidden">
<div class="h-full bg-secondary rounded-full" style="width: 100%;"></div>
</div>
<div class="flex items-center justify-between text-secondary font-label-badge text-label-badge mt-2">
<span>Thời hạn: 12 tháng</span>
<span>Hết hạn: 12/10/2024</span>
</div>
</div>
</div>
<!-- Trade-in Incentive Callout Banner -->
<div class="bg-primary-fixed/30 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-primary-container text-on-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-xl">redeem</span>
</div>
<div>
<p class="font-label-button text-label-button text-primary-container font-bold">
                  Đặc quyền Trade-in Thu Cũ Đổi Mới
                </p>
<p class="font-body-sm text-body-sm text-secondary">
                  Trợ giá thêm ngay <strong class="text-text-main font-semibold">+2.000.000₫</strong> khi nâng cấp lên iPhone 16 Pro Max hoặc giảm <strong class="text-text-main font-semibold">20%</strong> phí thay pin chính hãng Apple.
                </p>
</div>
</div>
<div class="flex items-center gap-2 shrink-0">
<button class="px-4 py-2 bg-surface-pure hover:bg-surface-container-low text-text-main font-label-button text-label-button rounded-lg transition-colors shadow-sm">
                Sửa chữa dịch vụ
              </button>
<button class="px-5 py-2 bg-primary-container hover:bg-primary-hover text-on-primary font-label-button text-label-button rounded-lg transition-colors shadow-sm flex items-center gap-1.5" onclick="window.location.href='<?php echo esc_url(home_url("/thu-cu-doi-moi/")); ?>'">
<span class="material-symbols-outlined text-base">upgrade</span>
                Trade-in lên đời Flagship
              </button>
</div>
</div>
</article>
</section>
<!-- 6. 4-Step 5-Star Warranty Standard Procedure -->
<section class="mt-8 flex flex-col gap-6">
<div class="flex flex-col text-center items-center">
<span class="font-label-badge text-label-badge text-primary font-bold uppercase tracking-wider mb-1">Dịch Vụ Chuẩn 5 Sao</span>
<h2 class="font-headline-lg text-headline-lg text-text-main">
            Quy Trình Tiếp Nhận &amp; Xử Lý Bảo Hành PhoneX Care+
          </h2>
<p class="font-body-regular text-body-regular text-secondary max-w-2xl mt-1">
            Minh bạch tối đa, không cần thủ tục giấy tờ rườm rà. Chúng tôi giải quyết mọi phát sinh trong thời gian ngắn nhất.
          </p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
<!-- Step 1 -->
<div class="bg-surface-pure rounded-xl p-6 shadow-sm flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition-shadow">
<div class="absolute top-2 right-3 font-headline-xl text-headline-xl text-surface-container font-extrabold select-none">
              01
            </div>
<div>
<div class="w-12 h-12 rounded-xl bg-primary-fixed text-primary flex items-center justify-center mb-4">
<span class="material-symbols-outlined text-2xl">search_check</span>
</div>
<h3 class="font-title-product text-title-product text-text-main mb-2">Tra cứu điện tử không giấy tờ</h3>
<p class="font-body-sm text-body-sm text-secondary">
                Chỉ cần đọc số điện thoại hoặc mã IMEI máy. Toàn bộ hồ sơ hóa đơn VAT và bảo hành đều được số hóa đồng bộ.
              </p>
</div>
<div class="mt-4 pt-3 flex items-center gap-1 font-label-badge text-label-badge text-primary">
<span>KHÔNG CẦN HÓA ĐƠN</span>
<span class="material-symbols-outlined text-sm">arrow_forward</span>
</div>
</div>
<!-- Step 2 -->
<div class="bg-surface-pure rounded-xl p-6 shadow-sm flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition-shadow">
<div class="absolute top-2 right-3 font-headline-xl text-headline-xl text-surface-container font-extrabold select-none">
              02
            </div>
<div>
<div class="w-12 h-12 rounded-xl bg-surface-container-low text-text-main flex items-center justify-center mb-4">
<span class="material-symbols-outlined text-2xl">local_shipping</span>
</div>
<h3 class="font-title-product text-title-product text-text-main mb-2">Tiếp nhận tận nơi hoặc Showroom</h3>
<p class="font-body-sm text-body-sm text-secondary">
                Ghé bất kỳ 128 Showroom PhoneX toàn quốc hoặc kỹ thuật viên đến tận nhà tiếp nhận máy trong 60 phút nội thành.
              </p>
</div>
<div class="mt-4 pt-3 flex items-center gap-1 font-label-badge text-label-badge text-primary">
<span>HỆ THỐNG 128 ĐIỂM HẸN</span>
<span class="material-symbols-outlined text-sm">arrow_forward</span>
</div>
</div>
<!-- Step 3 -->
<div class="bg-surface-pure rounded-xl p-6 shadow-sm flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition-shadow">
<div class="absolute top-2 right-3 font-headline-xl text-headline-xl text-surface-container font-extrabold select-none">
              03
            </div>
<div>
<div class="w-12 h-12 rounded-xl bg-surface-container-low text-text-main flex items-center justify-center mb-4">
<span class="material-symbols-outlined text-2xl">phone_iphone</span>
</div>
<h3 class="font-title-product text-title-product text-text-main mb-2">Cấp máy Flagship dùng tạm</h3>
<p class="font-body-sm text-body-sm text-secondary">
                Không lo gián đoạn liên lạc hay công việc. PhoneX lập tức cấp máy tương đương sử dụng hoàn toàn miễn phí khi sửa chữa.
              </p>
</div>
<div class="mt-4 pt-3 flex items-center gap-1 font-label-badge text-label-badge text-primary">
<span>GIỮ KẾT NỐI 24/7</span>
<span class="material-symbols-outlined text-sm">arrow_forward</span>
</div>
</div>
<!-- Step 4 -->
<div class="bg-surface-pure rounded-xl p-6 shadow-sm flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition-shadow">
<div class="absolute top-2 right-3 font-headline-xl text-headline-xl text-surface-container font-extrabold select-none">
              04
            </div>
<div>
<div class="w-12 h-12 rounded-xl bg-surface-container-low text-text-main flex items-center justify-center mb-4">
<span class="material-symbols-outlined text-2xl">published_with_changes</span>
</div>
<h3 class="font-title-product text-title-product text-text-main mb-2">Bàn giao 48h hoặc Đổi Mới</h3>
<p class="font-body-sm text-body-sm text-secondary">
                Hoàn tất thẩm định và trao trả máy trong 48 giờ. Cam kết đổi thiết bị mới nguyên seal nếu không xử lý dứt điểm.
              </p>
</div>
<div class="mt-4 pt-3 flex items-center gap-1 font-label-badge text-label-badge text-primary">
<span>CAM KẾT MINH BẠCH</span>
<span class="material-symbols-outlined text-sm">arrow_forward</span>
</div>
</div>
</div>
</section>
<!-- 7. Emergency Support & Hotline Banner -->
<section class="bg-surface-pure rounded-2xl p-6 lg:p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
<div class="flex items-center gap-4">
<div class="w-14 h-14 rounded-2xl bg-primary-fixed flex items-center justify-center text-primary shrink-0">
<span class="material-symbols-outlined text-3xl">support_agent</span>
</div>
<div>
<div class="flex items-center gap-2">
<span class="font-headline-sm text-headline-sm text-text-main font-bold">Tổng Đài Kỹ Thuật &amp; Bảo Hành 24/7</span>
<span class="px-2 py-0.5 rounded bg-surface-container-low text-primary-container font-label-badge text-label-badge">MIỄN CƯỚC TOÀN QUỐC</span>
</div>
<p class="font-body-regular text-body-regular text-secondary mt-0.5">
              Cần hỗ trợ gấp về tra cứu IMEI, lịch sửa chữa hoặc báo mất máy khẩn cấp? Đội ngũ chuyên viên túc trực liên tục.
            </p>
</div>
</div>
<div class="flex flex-wrap items-center gap-3 shrink-0 w-full md:w-auto">
<a class="flex-1 md:flex-initial h-12 px-6 rounded-xl bg-primary-container hover:bg-primary-hover text-on-primary font-title-product text-title-product flex items-center justify-center gap-2 shadow-md transition-all active:scale-95" href="tel:18006870">
<span class="material-symbols-outlined text-2xl">call</span>
            1800.6870
          </a>
<button class="flex-1 md:flex-initial h-12 px-5 rounded-xl bg-surface-container-low hover:bg-surface-container text-text-main font-label-button text-label-button flex items-center justify-center gap-2 transition-colors">
<span class="material-symbols-outlined text-xl">forum</span>
            Chat Kỹ Thuật Viên
          </button>
</div>
</section>
</div>
</div>
</div>
<script>
  // Simple interactive feedback for search demonstration
  const searchForm = document.getElementById('warrantySearchForm');
  const phoneInput = document.getElementById('phoneInput');

  if (searchForm && phoneInput) {
    searchForm.addEventListener('submit', () => {
      const val = phoneInput.value.trim();
      if (!val) {
        alert('Vui lòng nhập số điện thoại mua hàng để tra cứu bảo hành.');
        phoneInput.focus();
        return;
      }
      // Visual pulse response
      phoneInput.classList.add('bg-primary-fixed/20');
      setTimeout(() => {
        phoneInput.classList.remove('bg-primary-fixed/20');
      }, 400);
    });
  }
</script></main>

<?php
get_footer();
