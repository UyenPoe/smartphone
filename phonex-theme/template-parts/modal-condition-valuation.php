<?php
/**
 * PhoneX Condition & Valuation Modal (Popup Tình Trạng Máy Cũ)
 * Matches fastmobile specification and user design
 *
 * @package PhoneX
 */
?>
<div id="pxConditionModal" class="fixed inset-0 z-[999] hidden items-center justify-center p-3 sm:p-4 md:p-6 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="pxConditionModalTitle">
  <!-- Backdrop -->
  <div class="fixed inset-0 bg-black/65 backdrop-blur-xs transition-opacity duration-300" onclick="PhoneXConditionPopup.close()"></div>

  <!-- Modal Container -->
  <div class="relative w-full max-w-4xl bg-white rounded-2xl md:rounded-3xl shadow-2xl z-10 overflow-hidden border border-gray-100 transition-all duration-300 transform scale-95 opacity-0 my-auto" id="pxConditionModalBox">
    
    <!-- Top Close Button (Red Circle with white horizontal line / close icon) -->
    <button 
      type="button" 
      onclick="PhoneXConditionPopup.close()" 
      class="absolute top-3.5 right-3.5 sm:top-5 sm:right-5 z-20 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#ff4d4f] hover:bg-[#e60012] text-white flex items-center justify-center shadow-md transition-all duration-200 cursor-pointer hover:scale-105"
      aria-label="Đóng popup"
      title="Đóng popup"
    >
      <span class="material-symbols-outlined text-[19px] sm:text-[21px] font-bold">remove</span>
    </button>

    <!-- STEP 1: CHỌN TÌNH TRẠNG MÁY -->
    <div id="pxConditionStep1" class="p-5 sm:p-7 md:p-8">
      <!-- Title -->
      <h2 id="pxConditionModalTitle" class="text-xl sm:text-2xl md:text-[26px] font-black text-gray-900 tracking-tight text-center uppercase mb-6 sm:mb-8">
        TÌNH TRẠNG MÁY CŨ
      </h2>

      <!-- 2-Column Body Layout -->
      <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-start">
        
        <!-- Left: Phone Image Showcase -->
        <div class="md:col-span-4 flex flex-col items-center justify-center p-4 bg-gray-50/70 rounded-2xl border border-gray-100/90 shadow-2xs self-stretch">
          <div class="relative w-full max-w-[200px] h-[220px] sm:h-[260px] md:h-[280px] flex items-center justify-center">
            <img 
              id="pxPopupPhoneImg" 
              src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/phones/generic-phone.png' ); ?>" 
              alt="Hình ảnh điện thoại" 
              class="max-w-full max-h-full object-contain drop-shadow-lg transition-transform duration-300 hover:scale-105 select-none" 
            />
          </div>
          <div id="pxPopupPhoneBadge" class="mt-3 text-[11px] font-bold text-gray-600 bg-white px-2.5 py-1 rounded-full border border-gray-200 shadow-2xs text-center">
            Kiểm định 30 bước PhoneX
          </div>
        </div>

        <!-- Right: Model Details & 5 Condition Options -->
        <div class="md:col-span-8 flex flex-col justify-between">
          
          <div class="text-sm sm:text-base text-gray-800 leading-snug">
            Tên sản phẩm: <strong id="pxPopupPhoneName" class="font-extrabold text-gray-900 text-base sm:text-lg">Apple iPhone 17 Pro Max 512GB</strong>
          </div>

          <div class="text-sm sm:text-base font-bold text-gray-900 mt-2.5 mb-3">
            Vui lòng lựa chọn tình trạng máy
          </div>

          <!-- 5 Condition Options List -->
          <div class="space-y-2.5" id="pxConditionList">
            
            <!-- Loại 1 (Active default) -->
            <div 
              class="px-condition-item cursor-pointer p-3 sm:p-3.5 rounded-xl border-2 border-[#ff4d4f] bg-red-50/20 text-gray-900 text-xs sm:text-sm leading-relaxed transition-all shadow-2xs relative"
              data-type="1"
              data-ratio="1.0"
              onclick="PhoneXConditionPopup.selectType(1)"
            >
              <div class="font-medium text-gray-800">
                <strong class="font-bold text-gray-900">Loại 1:</strong> Máy chính hãng VN, màn hình đẹp, ngoại hình như mới, đầy đủ hộp và phụ kiện, thời gian kích hoạt không quá 90 ngày.
              </div>
            </div>

            <!-- Loại 2 -->
            <div 
              class="px-condition-item cursor-pointer p-3 sm:p-3.5 rounded-xl border border-gray-200 hover:border-gray-300 bg-white text-gray-700 text-xs sm:text-sm leading-relaxed transition-all relative"
              data-type="2"
              data-ratio="0.88"
              onclick="PhoneXConditionPopup.selectType(2)"
            >
              <div class="font-medium text-gray-800">
                <strong class="font-bold text-gray-900">Loại 2:</strong> Máy hoạt động mượt mà, ổn định; màn hình hiển thị đẹp, thân máy còn mới.
              </div>
            </div>

            <!-- Loại 3 -->
            <div 
              class="px-condition-item cursor-pointer p-3 sm:p-3.5 rounded-xl border border-gray-200 hover:border-gray-300 bg-white text-gray-700 text-xs sm:text-sm leading-relaxed transition-all relative"
              data-type="3"
              data-ratio="0.78"
              onclick="PhoneXConditionPopup.selectType(3)"
            >
              <div class="font-medium text-gray-800">
                <strong class="font-bold text-gray-900">Loại 3:</strong> Chức năng hoạt động đầy đủ, màn hình đẹp, thân máy trầy xước nhẹ.
              </div>
            </div>

            <!-- Loại 4 -->
            <div 
              class="px-condition-item cursor-pointer p-3 sm:p-3.5 rounded-xl border border-gray-200 hover:border-gray-300 bg-white text-gray-700 text-xs sm:text-sm leading-relaxed transition-all relative"
              data-type="4"
              data-ratio="0.65"
              onclick="PhoneXConditionPopup.selectType(4)"
            >
              <div class="font-medium text-gray-800">
                <strong class="font-bold text-gray-900">Loại 4:</strong> Máy hoạt động ổn định, màn hình trầy nhẹ, thân máy cấn móp nhẹ.
              </div>
            </div>

            <!-- Loại 5 -->
            <div 
              class="px-condition-item cursor-pointer p-3 sm:p-3.5 rounded-xl border border-gray-200 hover:border-gray-300 bg-white text-gray-700 text-xs sm:text-sm leading-relaxed transition-all relative"
              data-type="5"
              data-ratio="0.45"
              onclick="PhoneXConditionPopup.selectType(5)"
            >
              <div class="font-medium text-gray-800">
                <strong class="font-bold text-gray-900">Loại 5:</strong> Lỗi nhiều chức năng, màn hình hư nặng (đen, sọc, bầm sâu...) tuy nhiên máy vẫn còn nguồn và kiểm tra được.
              </div>
            </div>

          </div>

          <!-- Price Display -->
          <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between flex-wrap gap-2">
            <div class="text-sm sm:text-base text-gray-800">
              Giá thu mua dự kiến: <strong id="pxPopupPhonePrice" class="text-xl sm:text-2xl font-black text-[#ff4d4f] ml-1 tracking-tight">26.831.500₫</strong>
            </div>
            <span class="text-[11px] font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-0.5 rounded-full">
              Thanh toán chuyển khoản 5 phút
            </span>
          </div>

          <!-- Notes -->
          <div class="mt-3 text-xs text-gray-600 space-y-0.5 leading-relaxed">
            <div class="font-bold text-gray-900">Lưu ý:</div>
            <p class="italic text-gray-600">
              Lưu ý: Giá thu mua áp dụng cho dung lượng pin &gt; 85% &amp; số lần sạc ít hơn 400 lần (ngoài ra giá mua có thể trừ chi phí thay pin).
            </p>
          </div>

        </div>

      </div>

      <!-- Action Buttons (Dual: Booking + Detailed SEO Page) -->
      <div class="mt-7 sm:mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 border-t border-gray-100 pt-5">
        <button 
          type="button" 
          id="pxPopupNextBtn"
          onclick="PhoneXConditionPopup.nextStep()" 
          class="w-full sm:w-auto min-w-[200px] px-8 py-3.5 rounded-xl bg-[#ff4d4f] hover:bg-[#e60012] text-white font-black text-sm uppercase tracking-wider shadow-md hover:shadow-lg transition-all cursor-pointer text-center"
        >
          TIẾP TỤC ĐẶT LỊCH THU MUA
        </button>

        <a 
          id="pxPopupDetailLink"
          href="#" 
          class="w-full sm:w-auto px-6 py-3.5 rounded-xl border border-gray-300 hover:border-[#ff4d4f] text-gray-700 hover:text-[#ff4d4f] font-bold text-xs sm:text-sm inline-flex items-center justify-center gap-1.5 transition-colors bg-white text-center"
          title="Xem trang chi tiết và thông số kỹ thuật đầy đủ"
        >
          <span>Xem chi tiết &amp; thông số</span>
          <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </a>
      </div>
    </div>

    <!-- STEP 2: THÔNG TIN TIẾP NHẬN THU MUA -->
    <div id="pxConditionStep2" class="hidden p-5 sm:p-7 md:p-8">
      <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
        <button type="button" onclick="PhoneXConditionPopup.prevStep()" class="inline-flex items-center gap-1 text-xs font-bold text-gray-600 hover:text-[#ff4d4f] transition-colors cursor-pointer">
          <span class="material-symbols-outlined text-[18px]">arrow_back</span>
          <span>Chọn lại tình trạng máy</span>
        </button>
        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Bước 2 / 2</span>
      </div>

      <!-- Summary Card of Selected Valuation -->
      <div class="p-4 rounded-2xl bg-red-50/50 border border-red-100/90 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
          <img id="pxStep2PhoneImg" src="" alt="" class="w-14 h-14 object-contain bg-white rounded-xl p-1 border border-gray-200" />
          <div>
            <div id="pxStep2PhoneName" class="font-black text-gray-900 text-sm sm:text-base"></div>
            <div id="pxStep2ConditionText" class="text-xs text-gray-600 font-semibold mt-0.5"></div>
          </div>
        </div>
        <div class="text-left sm:text-right">
          <div class="text-xs text-gray-600 font-bold">Số tiền nhận được:</div>
          <div id="pxStep2PhonePrice" class="text-xl sm:text-2xl font-black text-[#ff4d4f]"></div>
        </div>
      </div>

      <!-- Customer Info Form -->
      <form id="pxConditionBookingForm" onsubmit="PhoneXConditionPopup.submitForm(event)" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-800 mb-1.5">Họ và tên của bạn *</label>
            <input 
              type="text" 
              name="customer_name" 
              id="pxBookName" 
              required 
              placeholder="Ví dụ: Nguyễn Văn A" 
              class="w-full h-11 px-3.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:border-[#ff4d4f] focus:ring-2 focus:ring-red-100 outline-none"
            />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-800 mb-1.5">Số điện thoại / Zalo nhận tiền *</label>
            <input 
              type="tel" 
              name="customer_phone" 
              id="pxBookPhone" 
              required 
              placeholder="Ví dụ: 0912 345 678" 
              pattern="[0-9]{10,11}"
              class="w-full h-11 px-3.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:border-[#ff4d4f] focus:ring-2 focus:ring-red-100 outline-none"
            />
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-800 mb-1.5">Hình thức giao dịch thuận tiện nhất *</label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-gray-200 hover:border-[#ff4d4f] bg-white cursor-pointer transition-colors has-[:checked]:border-[#ff4d4f] has-[:checked]:bg-red-50/20">
              <input type="radio" name="trade_type" value="home" checked class="text-[#ff4d4f] focus:ring-[#ff4d4f]" />
              <div class="text-xs">
                <strong class="font-bold text-gray-900 block">Kỹ thuật viên đến thu tận nhà (60 phút)</strong>
                <span class="text-gray-500">Miễn phí kiểm định &amp; chuyển khoản tại chỗ</span>
              </div>
            </label>

            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-gray-200 hover:border-[#ff4d4f] bg-white cursor-pointer transition-colors has-[:checked]:border-[#ff4d4f] has-[:checked]:bg-red-50/20">
              <input type="radio" name="trade_type" value="store" class="text-[#ff4d4f] focus:ring-[#ff4d4f]" />
              <div class="text-xs">
                <strong class="font-bold text-gray-900 block">Mang máy đến Showroom PhoneX</strong>
                <span class="text-gray-500">Hệ thống 128 cửa hàng toàn quốc</span>
              </div>
            </label>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-800 mb-1.5">Địa chỉ giao dịch hoặc Showroom gần bạn (Tùy chọn)</label>
          <input 
            type="text" 
            name="customer_address" 
            id="pxBookAddress" 
            placeholder="Ví dụ: 123 Nguyễn Thị Minh Khai, Quận 1, TP.HCM" 
            class="w-full h-11 px-3.5 rounded-xl border border-gray-200 text-sm text-gray-900 focus:border-[#ff4d4f] focus:ring-2 focus:ring-red-100 outline-none"
          />
        </div>

        <div class="pt-3 text-center">
          <button 
            type="submit" 
            class="w-full sm:w-auto min-w-[260px] px-8 py-3.5 rounded-xl bg-[#ff4d4f] hover:bg-[#e60012] text-white font-black text-sm sm:text-base uppercase tracking-wider shadow-lg hover:shadow-xl transition-all cursor-pointer transform hover:-translate-y-0.5"
          >
            XÁC NHẬN BÁN MÁY &amp; NHẬN TIỀN
          </button>
          <p class="text-[11px] text-gray-500 mt-2 font-medium">
            PhoneX cam kết bảo mật 100% thông tin &amp; bảo toàn dữ liệu cá nhân trên thiết bị.
          </p>
        </div>
      </form>
    </div>

    <!-- STEP 3: THÀNH CÔNG -->
    <div id="pxConditionStep3" class="hidden p-6 sm:p-10 text-center">
      <div class="w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-4">
        <span class="material-symbols-outlined text-[36px]">check_circle</span>
      </div>
      <h3 class="text-xl sm:text-2xl font-black text-gray-900 mb-2">Đăng Ký Thu Mua Thành Công!</h3>
      <p class="text-sm text-gray-600 max-w-md mx-auto mb-6">
        Chuyên viên kiểm định PhoneX đã tiếp nhận yêu cầu và sẽ gọi điện cho bạn trong <strong>5 phút</strong> để xác nhận thời gian nhận tiền.
      </p>

      <div class="inline-block p-4 rounded-2xl bg-gray-50 border border-gray-200 text-left text-xs text-gray-700 max-w-sm w-full mb-6">
        <div class="flex justify-between py-1 border-b border-gray-200/60">
          <span class="text-gray-500">Mã phiếu thu:</span>
          <strong class="font-bold text-gray-900" id="pxSuccessCode">PX-99882</strong>
        </div>
        <div class="flex justify-between py-1 border-b border-gray-200/60">
          <span class="text-gray-500">Thiết bị:</span>
          <strong class="font-bold text-gray-900" id="pxSuccessName"></strong>
        </div>
        <div class="flex justify-between py-1 border-b border-gray-200/60">
          <span class="text-gray-500">Tình trạng:</span>
          <strong class="font-bold text-gray-900" id="pxSuccessCond">Loại 1</strong>
        </div>
        <div class="flex justify-between py-1 pt-1.5">
          <span class="text-gray-500 font-bold">Số tiền chuyển khoản:</span>
          <strong class="font-black text-[#ff4d4f] text-sm" id="pxSuccessPrice"></strong>
        </div>
      </div>

      <div>
        <button 
          type="button" 
          onclick="PhoneXConditionPopup.close()" 
          class="px-8 py-2.5 rounded-xl bg-gray-900 hover:bg-black text-white font-bold text-xs sm:text-sm uppercase tracking-wider transition-colors cursor-pointer"
        >
          Hoàn tất &amp; Đóng
        </button>
      </div>
    </div>

  </div>
</div>

<!-- PhoneX Condition Popup Controller Script -->
<script>
window.PhoneXConditionPopup = (function() {
  var currentProduct = {
    name: 'Apple iPhone 17 Pro Max 512GB',
    price: 26831500,
    image: '',
    brand: 'Apple',
    specs: ''
  };
  var currentType = 1;
  var currentRatio = 1.0;

  var ratios = {
    1: 1.0,
    2: 0.88,
    3: 0.78,
    4: 0.65,
    5: 0.45
  };

  var conditionTexts = {
    1: 'Loại 1 (Máy VN, đẹp như mới, đủ hộp)',
    2: 'Loại 2 (Mượt mà, ổn định, thân máy mới)',
    3: 'Loại 3 (Hoạt động tốt, trầy xước nhẹ)',
    4: 'Loại 4 (Màn trầy nhẹ, cấn móp nhẹ)',
    5: 'Loại 5 (Lỗi chức năng / màn hỏng còn nguồn)'
  };

  function formatVnd(val) {
    var num = Math.round(Number(val) / 1000) * 1000;
    return num.toLocaleString('vi-VN') + '₫';
  }

  function getCalculatedPrice() {
    if (currentProduct['p' + currentType] && Number(currentProduct['p' + currentType]) > 0) {
      return Number(currentProduct['p' + currentType]);
    }
    var base = Number(currentProduct.price) || 20000000;
    var ratio = ratios[currentType] || 1.0;
    return Math.round((base * ratio) / 10000) * 10000;
  }

  function updatePriceDisplay() {
    var priceEl = document.getElementById('pxPopupPhonePrice');
    if (priceEl) {
      priceEl.textContent = formatVnd(getCalculatedPrice());
    }
  }

  function selectType(typeNum) {
    currentType = Number(typeNum) || 1;
    var items = document.querySelectorAll('.px-condition-item');
    items.forEach(function(item) {
      var t = Number(item.getAttribute('data-type'));
      if (t === currentType) {
        item.className = 'px-condition-item cursor-pointer p-3 sm:p-3.5 rounded-xl border-2 border-[#ff4d4f] bg-red-50/20 text-gray-900 text-xs sm:text-sm leading-relaxed transition-all shadow-2xs relative';
      } else {
        item.className = 'px-condition-item cursor-pointer p-3 sm:p-3.5 rounded-xl border border-gray-200 hover:border-gray-300 bg-white text-gray-700 text-xs sm:text-sm leading-relaxed transition-all relative';
      }
    });
    updatePriceDisplay();
  }

  function open(prod) {
    if (prod) {
      currentProduct = {
        name: prod.name || prod.raw_name || 'Điện thoại thông minh',
        price: Number(prod.price || prod.base_buyback_price) || 20000000,
        image: prod.image || prod.image_url || '<?php echo esc_url( get_template_directory_uri() . '/assets/images/phones/generic-phone.png' ); ?>',
        brand: prod.brand || 'Khác',
        specs: prod.specs || '',
        url: prod.url || '',
        p1: prod.p1,
        p2: prod.p2,
        p3: prod.p3,
        p4: prod.p4,
        p5: prod.p5
      };
    }

    // Clean name from [Grade ...] tag if present
    var displayName = currentProduct.name.replace(/^\[[^\]]+\]\s*/, '');

    var nameEl = document.getElementById('pxPopupPhoneName');
    var imgEl = document.getElementById('pxPopupPhoneImg');
    if (nameEl) nameEl.textContent = displayName;
    if (imgEl && currentProduct.image) imgEl.src = currentProduct.image;

    var detailLink = document.getElementById('pxPopupDetailLink');
    if (detailLink) {
      if (currentProduct.url) {
        detailLink.href = currentProduct.url;
        detailLink.classList.remove('hidden');
      } else {
        detailLink.classList.add('hidden');
      }
    }

    // Reset to step 1
    currentType = 1;
    selectType(1);

    var step1 = document.getElementById('pxConditionStep1');
    var step2 = document.getElementById('pxConditionStep2');
    var step3 = document.getElementById('pxConditionStep3');
    if (step1) step1.classList.remove('hidden');
    if (step2) step2.classList.add('hidden');
    if (step3) step3.classList.add('hidden');

    var modal = document.getElementById('pxConditionModal');
    var box = document.getElementById('pxConditionModalBox');
    if (modal && box) {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';
      setTimeout(function() {
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
      }, 20);
    }
  }

  function close() {
    var modal = document.getElementById('pxConditionModal');
    var box = document.getElementById('pxConditionModalBox');
    if (modal && box) {
      box.classList.remove('scale-100', 'opacity-100');
      box.classList.add('scale-95', 'opacity-0');
      setTimeout(function() {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
      }, 200);
    }
  }

  function nextStep() {
    var step1 = document.getElementById('pxConditionStep1');
    var step2 = document.getElementById('pxConditionStep2');
    if (!step1 || !step2) return;

    var displayName = currentProduct.name.replace(/^\[[^\]]+\]\s*/, '');
    var finalPrice = getCalculatedPrice();

    var s2Name = document.getElementById('pxStep2PhoneName');
    var s2Img = document.getElementById('pxStep2PhoneImg');
    var s2Cond = document.getElementById('pxStep2ConditionText');
    var s2Price = document.getElementById('pxStep2PhonePrice');

    if (s2Name) s2Name.textContent = displayName;
    if (s2Img) s2Img.src = currentProduct.image;
    if (s2Cond) s2Cond.textContent = 'Phân loại kiểm định: ' + (conditionTexts[currentType] || 'Loại 1');
    if (s2Price) s2Price.textContent = formatVnd(finalPrice);

    step1.classList.add('hidden');
    step2.classList.remove('hidden');
  }

  function prevStep() {
    var step1 = document.getElementById('pxConditionStep1');
    var step2 = document.getElementById('pxConditionStep2');
    if (step1 && step2) {
      step2.classList.add('hidden');
      step1.classList.remove('hidden');
    }
  }

  function submitForm(e) {
    if (e && e.preventDefault) e.preventDefault();
    var name = document.getElementById('pxBookName')?.value || 'Quý khách';
    var phone = document.getElementById('pxBookPhone')?.value || '';

    if (!phone) {
      alert('Vui lòng nhập số điện thoại hoặc Zalo để PhoneX liên hệ chuyển khoản!');
      return;
    }

    var code = 'PX-' + Math.floor(10000 + Math.random() * 90000);
    var finalPrice = getCalculatedPrice();

    var step2 = document.getElementById('pxConditionStep2');
    var step3 = document.getElementById('pxConditionStep3');
    if (step2 && step3) {
      step2.classList.add('hidden');
      step3.classList.remove('hidden');

      var cCode = document.getElementById('pxSuccessCode');
      var cName = document.getElementById('pxSuccessName');
      var cCond = document.getElementById('pxSuccessCond');
      var cPrice = document.getElementById('pxSuccessPrice');

      if (cCode) cCode.textContent = code;
      if (cName) cName.textContent = currentProduct.name.replace(/^\[[^\]]+\]\s*/, '');
      if (cCond) cCond.textContent = conditionTexts[currentType] || 'Loại 1';
      if (cPrice) cPrice.textContent = formatVnd(finalPrice);
    }
  }

  // Keyboard escape listener
  document.addEventListener('keydown', function(evt) {
    if (evt.key === 'Escape') {
      close();
    }
  });

  return {
    open: open,
    close: close,
    selectType: selectType,
    nextStep: nextStep,
    prevStep: prevStep,
    submitForm: submitForm
  };
})();
</script>
