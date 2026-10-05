<?php
/**
 * PhoneX Installment & Trade-in Calculator Modal
 *
 * Bảng Tính / Giỏ Hàng Trả Góp 0% & Thu Cũ Lên Đời
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!-- =========================================================================
     PHONEX SMART INSTALLMENT & TRADE-IN CALCULATOR MODAL
     ========================================================================= -->
<div id="pxInstallmentModal"
     class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-black/65 backdrop-blur-xs p-2 sm:p-4 overflow-y-auto"
     role="dialog"
     aria-modal="true"
     aria-labelledby="pxInstallmentModalTitle">

  <div class="relative w-full max-w-xl bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden my-auto max-h-[94vh] flex flex-col transition-all transform scale-100">

    <!-- Modal Header -->
    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-[#FFF0F2] via-white to-red-50/50">
      <div class="flex items-center gap-3 min-w-0">
        <div class="w-12 h-12 rounded-xl bg-white border border-[#ffdad5] p-1 flex items-center justify-center shrink-0 shadow-2xs">
          <img id="pxInstImg" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>" alt="" class="w-full h-full object-contain" />
        </div>
        <div class="min-w-0">
          <div class="flex items-center gap-1.5 flex-wrap">
            <span class="text-[10.5px] font-black text-[#b7000c] bg-white border border-[#ffdad5] px-2 py-0.5 rounded-full uppercase shadow-2xs">Trả góp 0% Lãi Suất</span>
            <span id="pxInstGradeBadge" class="text-[10.5px] font-bold text-[#198754] bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">Grade A 99%</span>
          </div>
          <h3 id="pxInstallmentModalTitle" class="text-[15px] sm:text-[16px] font-black text-[#1F1F1F] leading-tight mt-1 truncate">
            Điện thoại Like New 99%
          </h3>
          <div class="text-[13px] font-extrabold text-[#e60012] mt-0.5">
            Giá bán: <span id="pxInstPriceDisplay">0₫</span>
          </div>
        </div>
      </div>
      <button type="button"
              onclick="pxCloseInstallmentModal()"
              class="w-8 h-8 rounded-full bg-white hover:bg-gray-100 border border-gray-200 text-gray-500 hover:text-gray-800 flex items-center justify-center transition-colors shrink-0 shadow-2xs cursor-pointer"
              aria-label="Đóng bảng tính trả góp">
        <span class="material-symbols-outlined text-[18px]">close</span>
      </button>
    </div>

    <!-- Modal Scrollable Body -->
    <div id="pxInstBody" class="p-4 sm:p-5 overflow-y-auto flex-1 space-y-4 text-[#1F1F1F]">

      <!-- ================= STEP 1: TRADE-IN TOGGLE ================= -->
      <div class="rounded-xl border border-amber-200 bg-amber-50/40 p-3 sm:p-3.5 transition-all">
        <label class="flex items-start gap-2.5 cursor-pointer select-none">
          <input type="checkbox" id="pxTradeInToggle" onchange="pxCalculateInstallment()" class="w-4 h-4 mt-0.5 rounded text-[#e60012] focus:ring-[#e60012] accent-[#e60012] cursor-pointer" />
          <div class="flex-1">
            <div class="flex items-center gap-1.5 flex-wrap">
              <span class="text-[13.5px] font-bold text-gray-900">Thu cũ đổi mới (Trừ thẳng vào tiền trả trước)</span>
              <span class="text-[10px] font-extrabold text-white bg-[#e60012] px-2 py-0.5 rounded-full">Trợ giá 500K</span>
            </div>
            <p class="text-[11.5px] text-gray-600 mt-0.5 leading-snug">
              Bạn có máy cũ muốn bán lại? Bù chênh lệch hoặc <strong>trả góp 0đ</strong> nếu giá trị máy cũ cao hơn tiền trả trước!
            </p>
          </div>
        </label>

        <!-- Collapsible Trade-In Inputs -->
        <div id="pxTradeInFields" class="hidden mt-3 pt-3 border-t border-amber-200/80 space-y-2.5">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div>
              <label class="block text-[11.5px] font-bold text-gray-700 mb-1">Thương hiệu máy cũ:</label>
              <select id="pxTradeInBrand" onchange="pxAutoSuggestTradeInVal()" class="w-full text-xs font-semibold bg-white border border-gray-300 rounded-lg px-2.5 py-1.5 focus:border-[#e60012] outline-none">
                <option value="Apple">Apple (iPhone)</option>
                <option value="Samsung">Samsung</option>
                <option value="Xiaomi">Xiaomi / Redmi</option>
                <option value="OPPO">OPPO</option>
                <option value="Khác">Hãng khác</option>
              </select>
            </div>
            <div>
              <label class="block text-[11.5px] font-bold text-gray-700 mb-1">Dòng máy cũ của bạn:</label>
              <input type="text" id="pxTradeInModel" placeholder="VD: iPhone 11 64GB..." oninput="pxCalculateInstallment()" class="w-full text-xs font-semibold bg-white border border-gray-300 rounded-lg px-2.5 py-1.5 focus:border-[#e60012] outline-none" />
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div>
              <label class="block text-[11.5px] font-bold text-gray-700 mb-1">Tình trạng máy cũ:</label>
              <select id="pxTradeInCondition" onchange="pxAutoSuggestTradeInVal()" class="w-full text-xs font-semibold bg-white border border-gray-300 rounded-lg px-2.5 py-1.5 focus:border-[#e60012] outline-none">
                <option value="Grade A 99%">Grade A (Đẹp như mới 99%)</option>
                <option value="Grade B 98%">Grade B (Trầy nhẹ viền 98%)</option>
                <option value="Grade C 95%">Grade C (Cũ/Cấn xước 95%)</option>
              </select>
            </div>
            <div>
              <label class="block text-[11.5px] font-bold text-gray-700 mb-1">Định giá PhoneX thu lại (VNĐ):</label>
              <input type="number" id="pxTradeInVal" value="3000000" step="500000" oninput="pxCalculateInstallment()" class="w-full text-xs font-bold text-[#e60012] bg-white border border-gray-300 rounded-lg px-2.5 py-1.5 focus:border-[#e60012] outline-none" />
            </div>
          </div>
          <div class="text-[11px] text-amber-800 font-semibold flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px]">info</span>
            <span>Định giá ước tính đã cộng thêm 500.000₫ trợ giá độc quyền PhoneX.</span>
          </div>
        </div>
      </div>

      <!-- ================= STEP 2: DOWN PAYMENT & TERM PILLS ================= -->
      <div class="space-y-3">
        <!-- Down Payment Selector -->
        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label class="text-[12.5px] font-extrabold text-gray-800">1. Số tiền trả trước mong muốn:</label>
            <span id="pxDownPaymentAmountText" class="text-[12.5px] font-black text-[#e60012]">0₫ (0%)</span>
          </div>
          <div class="grid grid-cols-5 gap-1.5" id="pxDownPaymentPills">
            <button type="button" onclick="pxSetDownPaymentPct(0, this)" class="px-down-pill active py-1.5 text-center text-xs font-bold rounded-lg border border-[#e60012] bg-[#FFF0F2] text-[#e60012] transition-all">0% (0đ)</button>
            <button type="button" onclick="pxSetDownPaymentPct(10, this)" class="px-down-pill py-1.5 text-center text-xs font-bold rounded-lg border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all">10%</button>
            <button type="button" onclick="pxSetDownPaymentPct(20, this)" class="px-down-pill py-1.5 text-center text-xs font-bold rounded-lg border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all">20%</button>
            <button type="button" onclick="pxSetDownPaymentPct(30, this)" class="px-down-pill py-1.5 text-center text-xs font-bold rounded-lg border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all">30%</button>
            <button type="button" onclick="pxSetDownPaymentPct(50, this)" class="px-down-pill py-1.5 text-center text-xs font-bold rounded-lg border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all">50%</button>
          </div>
        </div>

        <!-- Term Months Selector -->
        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label class="text-[12.5px] font-extrabold text-gray-800">2. Kỳ hạn vay góp:</label>
            <span id="pxTermMonthsText" class="text-[12.5px] font-black text-gray-800">6 tháng (0% Lãi)</span>
          </div>
          <div class="grid grid-cols-4 gap-1.5" id="pxTermPills">
            <button type="button" onclick="pxSetTermMonths(3, this)" class="px-term-pill py-1.5 text-center text-xs font-bold rounded-lg border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all">3 tháng</button>
            <button type="button" onclick="pxSetTermMonths(6, this)" class="px-term-pill active py-1.5 text-center text-xs font-bold rounded-lg border border-[#e60012] bg-[#FFF0F2] text-[#e60012] transition-all">6 tháng</button>
            <button type="button" onclick="pxSetTermMonths(9, this)" class="px-term-pill py-1.5 text-center text-xs font-bold rounded-lg border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all">9 tháng</button>
            <button type="button" onclick="pxSetTermMonths(12, this)" class="px-term-pill py-1.5 text-center text-xs font-bold rounded-lg border border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300 transition-all">12 tháng</button>
          </div>
        </div>
      </div>

      <!-- ================= FINANCIAL CALCULATION SUMMARY CARD ================= -->
      <div class="rounded-xl border border-red-200 bg-gradient-to-br from-[#FFF0F2] via-white to-red-50/60 p-3.5 shadow-2xs space-y-2">
        <div class="flex items-center justify-between text-xs text-gray-600 font-medium">
          <span>Giá máy chọn mua:</span>
          <span id="pxCalcProductPrice" class="font-bold text-gray-800">0₫</span>
        </div>
        <div id="pxCalcTradeInRow" class="hidden flex items-center justify-between text-xs text-[#c2410c] font-medium">
          <span>Trừ thu cũ đổi mới:</span>
          <span id="pxCalcTradeInDeduct" class="font-bold">-0₫</span>
        </div>
        <div class="flex items-center justify-between text-xs text-gray-600 font-medium">
          <span>Tiền trả trước thanh toán ngay:</span>
          <span id="pxCalcActualDown" class="font-bold text-gray-800">0₫</span>
        </div>
        <div class="flex items-center justify-between text-xs text-gray-600 font-medium">
          <span>Số tiền vay còn lại:</span>
          <span id="pxCalcLoanAmount" class="font-bold text-gray-800">0₫</span>
        </div>
        <div class="pt-2 border-t border-[#ffdad5] flex items-center justify-between">
          <div>
            <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Góp mỗi tháng chỉ:</div>
            <div class="text-[10px] text-green-700 font-bold flex items-center gap-1">
              <span class="material-symbols-outlined text-[12px]">verified</span> 0% Lãi suất • Phí hồ sơ 0đ
            </div>
          </div>
          <div class="text-right">
            <span id="pxCalcMonthlyPayment" class="text-lg sm:text-xl font-black text-[#e60012]">0₫</span>
            <span class="text-xs font-bold text-gray-600">/tháng</span>
          </div>
        </div>
      </div>

      <!-- ================= STEP 3: LEAD REGISTRATION FORM ================= -->
      <form id="pxInstallmentForm" onsubmit="pxSubmitInstallmentLead(event)" class="space-y-3 pt-1">
        <input type="hidden" id="pxLeadProductName" name="product_name" value="" />
        <input type="hidden" id="pxLeadProductPrice" name="product_price" value="0" />
        <input type="hidden" id="pxLeadDownPaymentPct" name="down_payment_pct" value="0" />
        <input type="hidden" id="pxLeadDownPaymentVal" name="down_payment_val" value="0" />
        <input type="hidden" id="pxLeadTermMonths" name="term_months" value="6" />
        <input type="hidden" id="pxLeadMonthlyPayment" name="monthly_payment" value="0" />

        <!-- Approval Method Selection -->
        <div>
          <label class="block text-[12px] font-bold text-gray-800 mb-1.5">3. Hình thức làm hồ sơ &amp; duyệt:</label>
          <div class="grid grid-cols-3 gap-1.5 text-center">
            <label class="cursor-pointer border border-gray-200 rounded-lg p-2 bg-gray-50 hover:bg-[#FFF0F2] transition-colors flex flex-col items-center justify-center gap-1" id="labelIdCccd">
              <input type="radio" name="customer_id_type" value="cccd" checked onchange="pxUpdateIdTypeStyle(this)" class="accent-[#e60012]" />
              <span class="text-[11.5px] font-bold text-gray-800 leading-tight">Duyệt CCCD</span>
              <span class="text-[9.5px] text-gray-500">5 phút qua Zalo</span>
            </label>
            <label class="cursor-pointer border border-gray-200 rounded-lg p-2 bg-gray-50 hover:bg-[#FFF0F2] transition-colors flex flex-col items-center justify-center gap-1" id="labelIdCreditCard">
              <input type="radio" name="customer_id_type" value="credit_card" onchange="pxUpdateIdTypeStyle(this)" class="accent-[#e60012]" />
              <span class="text-[11.5px] font-bold text-gray-800 leading-tight">Thẻ tín dụng</span>
              <span class="text-[9.5px] text-gray-500">0% Lãi suất</span>
            </label>
            <label class="cursor-pointer border border-gray-200 rounded-lg p-2 bg-gray-50 hover:bg-[#FFF0F2] transition-colors flex flex-col items-center justify-center gap-1" id="labelIdB2B">
              <input type="radio" name="customer_id_type" value="b2b_credit" onchange="pxUpdateIdTypeStyle(this)" class="accent-[#e60012]" />
              <span class="text-[11.5px] font-bold text-gray-800 leading-tight">Đại lý nhập sỉ</span>
              <span class="text-[9.5px] text-gray-500">Công nợ 15-30 ngày</span>
            </label>
          </div>
        </div>

        <!-- Contact Fields -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
          <div>
            <label class="block text-[11.5px] font-bold text-gray-800 mb-1">Họ và tên của bạn <span class="text-red-500">*</span></label>
            <input type="text" id="pxLeadCustName" required placeholder="Ví dụ: Nguyễn Văn An" class="w-full text-xs font-semibold bg-white border border-gray-300 rounded-lg px-3 py-2 focus:border-[#e60012] focus:ring-1 focus:ring-[#e60012] outline-none" />
          </div>
          <div>
            <label class="block text-[11.5px] font-bold text-gray-800 mb-1">Số điện thoại / Zalo <span class="text-red-500">*</span></label>
            <input type="tel" id="pxLeadCustPhone" required placeholder="09xx xxx xxx" class="w-full text-xs font-semibold bg-white border border-gray-300 rounded-lg px-3 py-2 focus:border-[#e60012] focus:ring-1 focus:ring-[#e60012] outline-none" />
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
          <div>
            <label class="block text-[11.5px] font-bold text-gray-800 mb-1">Tỉnh / Thành phố:</label>
            <select id="pxLeadCustCity" class="w-full text-xs font-semibold bg-white border border-gray-300 rounded-lg px-3 py-2 focus:border-[#e60012] outline-none">
              <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh (56 Showroom)</option>
              <option value="Hà Nội">Hà Nội (48 Showroom)</option>
              <option value="Đà Nẵng">Đà Nẵng (14 Showroom)</option>
              <option value="Bình Dương">Bình Dương</option>
              <option value="Đồng Nai">Đồng Nai</option>
              <option value="Cần Thơ">Cần Thơ</option>
              <option value="Hải Phòng">Hải Phòng</option>
              <option value="Tỉnh thành khác">Tỉnh thành khác (Giao tận nơi)</option>
            </select>
          </div>
          <div>
            <label class="block text-[11.5px] font-bold text-gray-800 mb-1">Ghi chú (màu sắc / giờ gọi):</label>
            <input type="text" id="pxLeadNotes" placeholder="VD: Gọi sau 18h, tư vấn qua Zalo..." class="w-full text-xs font-semibold bg-white border border-gray-300 rounded-lg px-3 py-2 focus:border-[#e60012] outline-none" />
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                id="pxSubmitLeadBtn"
                class="w-full min-h-[46px] py-2.5 px-4 rounded-xl bg-[#e60012] hover:bg-[#b7000c] text-white font-black text-sm uppercase tracking-wide transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer">
          <span class="material-symbols-outlined text-[19px]">assignment_turned_in</span>
          <span id="pxSubmitLeadBtnText">XÁC NHẬN ĐĂNG KÝ TRẢ GÓP 0% (DUYỆT 5 PHÚT)</span>
        </button>

        <div class="text-center text-[10.5px] text-gray-500 font-medium">
          🔒 Bảo mật thông tin tuyệt đối • Không thẩm định gọi người thân • Trả kết quả duyệt nhanh
        </div>
      </form>
    </div>

    <!-- Success View -->
    <div id="pxInstSuccessView" class="hidden p-6 sm:p-8 text-center flex-col items-center justify-center space-y-4 my-auto">
      <div class="w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto shadow-sm">
        <span class="material-symbols-outlined text-[36px]">check_circle</span>
      </div>
      <div>
        <h4 class="text-lg font-black text-gray-900">Đăng Ký Hồ Sơ Trả Góp Thành Công!</h4>
        <div class="inline-block mt-1.5 px-3 py-1 rounded-full bg-red-50 border border-red-200 text-[#e60012] text-xs font-black" id="pxSuccessLeadCode">
          MÃ HỒ SƠ: #PX-TG-XXXXX
        </div>
      </div>
      <p class="text-xs sm:text-sm text-gray-600 max-w-md mx-auto leading-relaxed">
        Cảm ơn <strong id="pxSuccessCustName" class="text-gray-900">Quý khách</strong>! Chuyên viên tài chính PhoneX đã tiếp nhận hồ sơ và sẽ liên hệ hoặc kết bạn Zalo qua số điện thoại <strong id="pxSuccessCustPhone" class="text-[#e60012]"></strong> trong vòng <strong>5 phút</strong> để hướng dẫn duyệt online.
      </p>
      <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-2.5 w-full">
        <a id="pxSuccessZaloLink" href="https://zalo.me/18006868" target="_blank" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-[#0068ff] hover:bg-[#0054cc] text-white text-xs font-bold inline-flex items-center justify-center gap-1.5 shadow-xs transition-colors">
          <span>Nhắn tin Zalo PhoneX ngay</span>
          <span class="material-symbols-outlined text-[16px]">chat</span>
        </a>
        <button type="button" onclick="pxCloseInstallmentModal()" class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold transition-colors">
          Đóng cửa sổ
        </button>
      </div>
    </div>

  </div>
</div>

<script>
(function() {
  'use strict';

  var currentProduct = {
    title: 'Điện thoại Like New',
    price: 10000000,
    img: '',
    grade: 'Grade A 99%',
    downPct: 0,
    termMonths: 6,
    hasTradeIn: false,
    tradeInVal: 0
  };

  window.pxOpenInstallmentModal = function(title, price, img, grade) {
    currentProduct.title = title || 'Điện thoại Like New';
    currentProduct.price = Number(price) > 0 ? Number(price) : 10000000;
    currentProduct.img = img || '';
    currentProduct.grade = grade || 'Grade A 99%';
    currentProduct.downPct = 0;
    currentProduct.termMonths = 6;

    var modal = document.getElementById('pxInstallmentModal');
    var titleEl = document.getElementById('pxInstallmentModalTitle');
    var priceEl = document.getElementById('pxInstPriceDisplay');
    var imgEl = document.getElementById('pxInstImg');
    var gradeEl = document.getElementById('pxInstGradeBadge');
    var body = document.getElementById('pxInstBody');
    var successView = document.getElementById('pxInstSuccessView');

    if (titleEl) titleEl.textContent = currentProduct.title;
    if (priceEl) priceEl.textContent = currentProduct.price.toLocaleString('vi-VN') + '₫';
    if (imgEl && currentProduct.img) imgEl.src = currentProduct.img;
    if (gradeEl) gradeEl.textContent = currentProduct.grade;

    // Reset view
    if (body) body.classList.remove('hidden');
    if (successView) successView.classList.add('hidden');

    // Reset pills
    pxSetDownPaymentPct(0);
    pxSetTermMonths(6);

    // Auto check if trade-in was requested
    var tiToggle = document.getElementById('pxTradeInToggle');
    if (tiToggle) {
      tiToggle.checked = false;
      var tiFields = document.getElementById('pxTradeInFields');
      if (tiFields) tiFields.classList.add('hidden');
    }

    pxCalculateInstallment();

    if (modal) modal.classList.remove('hidden');
  };

  window.pxCloseInstallmentModal = function() {
    var modal = document.getElementById('pxInstallmentModal');
    if (modal) modal.classList.add('hidden');
  };

  window.pxSetDownPaymentPct = function(pct, btn) {
    currentProduct.downPct = pct;
    var pills = document.querySelectorAll('.px-down-pill');
    pills.forEach(function(p) {
      p.classList.remove('active', 'border-[#e60012]', 'bg-[#FFF0F2]', 'text-[#e60012]');
      p.classList.add('border-gray-200', 'bg-gray-50', 'text-gray-700');
    });
    if (btn) {
      btn.classList.add('active', 'border-[#e60012]', 'bg-[#FFF0F2]', 'text-[#e60012]');
      btn.classList.remove('border-gray-200', 'bg-gray-50', 'text-gray-700');
    }
    pxCalculateInstallment();
  };

  window.pxSetTermMonths = function(term, btn) {
    currentProduct.termMonths = term;
    var pills = document.querySelectorAll('.px-term-pill');
    pills.forEach(function(p) {
      p.classList.remove('active', 'border-[#e60012]', 'bg-[#FFF0F2]', 'text-[#e60012]');
      p.classList.add('border-gray-200', 'bg-gray-50', 'text-gray-700');
    });
    if (btn) {
      btn.classList.add('active', 'border-[#e60012]', 'bg-[#FFF0F2]', 'text-[#e60012]');
      btn.classList.remove('border-gray-200', 'bg-gray-50', 'text-gray-700');
    }
    var termText = document.getElementById('pxTermMonthsText');
    if (termText) termText.textContent = term + ' tháng (0% Lãi)';
    pxCalculateInstallment();
  };

  window.pxAutoSuggestTradeInVal = function() {
    var brand = document.getElementById('pxTradeInBrand') ? document.getElementById('pxTradeInBrand').value : 'Apple';
    var cond = document.getElementById('pxTradeInCondition') ? document.getElementById('pxTradeInCondition').value : 'Grade A';
    var baseVal = 3500000;

    if (brand === 'Apple') baseVal = 5500000;
    else if (brand === 'Samsung') baseVal = 4000000;
    else if (brand === 'Xiaomi') baseVal = 3000000;
    else if (brand === 'OPPO') baseVal = 2500000;

    if (cond.indexOf('98%') !== -1) baseVal *= 0.85;
    if (cond.indexOf('95%') !== -1) baseVal *= 0.7;

    var valInput = document.getElementById('pxTradeInVal');
    if (valInput) valInput.value = Math.round(baseVal / 100000) * 100000;

    pxCalculateInstallment();
  };

  window.pxCalculateInstallment = function() {
    var price = currentProduct.price;
    var tiToggle = document.getElementById('pxTradeInToggle');
    var tiFields = document.getElementById('pxTradeInFields');
    var hasTradeIn = tiToggle ? tiToggle.checked : false;

    if (tiFields) {
      if (hasTradeIn) {
        tiFields.classList.remove('hidden');
      } else {
        tiFields.classList.add('hidden');
      }
    }

    var tradeInVal = 0;
    if (hasTradeIn) {
      var valInput = document.getElementById('pxTradeInVal');
      tradeInVal = valInput ? (parseFloat(valInput.value) || 0) : 0;
    }
    currentProduct.tradeInVal = tradeInVal;
    currentProduct.hasTradeIn = hasTradeIn;

    // Standard down payment from price
    var nominalDown = Math.round((price * currentProduct.downPct) / 100);

    // If trade-in is active, deduct tradeInVal from price or down payment
    var netPriceAfterTradeIn = Math.max(0, price - tradeInVal);

    // Actual down payment to pay in cash
    var actualDown = Math.max(0, nominalDown - tradeInVal);

    // Remaining loan amount to be financed
    var loanAmount = Math.max(0, (price - tradeInVal) - actualDown);
    if (loanAmount === 0 && netPriceAfterTradeIn > 0) {
      loanAmount = netPriceAfterTradeIn;
    }

    // Monthly payment (0% interest)
    var term = currentProduct.termMonths || 6;
    var monthly = Math.round(loanAmount / term);

    // Update DOM
    var downText = document.getElementById('pxDownPaymentAmountText');
    if (downText) {
      downText.textContent = nominalDown.toLocaleString('vi-VN') + '₫ (' + currentProduct.downPct + '%)';
    }

    var prodPriceEl = document.getElementById('pxCalcProductPrice');
    if (prodPriceEl) prodPriceEl.textContent = price.toLocaleString('vi-VN') + '₫';

    var tiRow = document.getElementById('pxCalcTradeInRow');
    var tiDeductEl = document.getElementById('pxCalcTradeInDeduct');
    if (tiRow && tiDeductEl) {
      if (hasTradeIn && tradeInVal > 0) {
        tiRow.classList.remove('hidden');
        tiDeductEl.textContent = '- ' + tradeInVal.toLocaleString('vi-VN') + '₫';
      } else {
        tiRow.classList.add('hidden');
      }
    }

    var actualDownEl = document.getElementById('pxCalcActualDown');
    if (actualDownEl) {
      actualDownEl.textContent = actualDown.toLocaleString('vi-VN') + '₫' + (hasTradeIn && tradeInVal > nominalDown ? ' (Đã trừ xong máy cũ)' : '');
    }

    var loanEl = document.getElementById('pxCalcLoanAmount');
    if (loanEl) loanEl.textContent = loanAmount.toLocaleString('vi-VN') + '₫';

    var monthlyEl = document.getElementById('pxCalcMonthlyPayment');
    if (monthlyEl) monthlyEl.textContent = monthly.toLocaleString('vi-VN') + '₫';

    // Store in hidden fields for lead submission
    var hName = document.getElementById('pxLeadProductName');
    var hPrice = document.getElementById('pxLeadProductPrice');
    var hDownPct = document.getElementById('pxLeadDownPaymentPct');
    var hDownVal = document.getElementById('pxLeadDownPaymentVal');
    var hTerm = document.getElementById('pxLeadTermMonths');
    var hMonthly = document.getElementById('pxLeadMonthlyPayment');

    if (hName) hName.value = currentProduct.title;
    if (hPrice) hPrice.value = price;
    if (hDownPct) hDownPct.value = currentProduct.downPct;
    if (hDownVal) hDownVal.value = actualDown;
    if (hTerm) hTerm.value = term;
    if (hMonthly) hMonthly.value = monthly;
  };

  window.pxUpdateIdTypeStyle = function(radio) {
    var b2bRadio = document.getElementById('labelIdB2B');
    var cccdRadio = document.getElementById('labelIdCccd');
    var cardRadio = document.getElementById('labelIdCreditCard');
    var btnText = document.getElementById('pxSubmitLeadBtnText');

    [cccdRadio, cardRadio, b2bRadio].forEach(function(l){ if(l) l.classList.remove('border-[#e60012]', 'bg-[#FFF0F2]'); });

    if (radio && radio.parentElement) {
      radio.parentElement.classList.add('border-[#e60012]', 'bg-[#FFF0F2]');
    }

    if (radio.value === 'b2b_credit') {
      if (btnText) btnText.textContent = 'ĐĂNG KÝ CÔNG NỢ BÁN SỈ 15–30 NGÀY';
    } else {
      if (btnText) btnText.textContent = 'XÁC NHẬN ĐĂNG KÝ TRẢ GÓP 0% (DUYỆT 5 PHÚT)';
    }
  };

  window.pxSubmitInstallmentLead = function(e) {
    e.preventDefault();

    var btn = document.getElementById('pxSubmitLeadBtn');
    var btnText = document.getElementById('pxSubmitLeadBtnText');
    if (btn) btn.disabled = true;
    if (btnText) btnText.textContent = 'Đang xử lý hồ sơ...';

    var custName = document.getElementById('pxLeadCustName').value;
    var custPhone = document.getElementById('pxLeadCustPhone').value;
    var custCity = document.getElementById('pxLeadCustCity').value;
    var notes = document.getElementById('pxLeadNotes').value;

    var idType = 'cccd';
    var radios = document.getElementsByName('customer_id_type');
    for (var i = 0; i < radios.length; i++) {
      if (radios[i].checked) { idType = radios[i].value; break; }
    }

    var leadType = (idType === 'b2b_credit') ? 'b2b_wholesale' : (currentProduct.hasTradeIn ? 'tradein_installment' : 'installment_retail');

    var fd = new FormData();
    fd.append('action', 'phonex_submit_installment_lead');
    fd.append('lead_type', leadType);
    fd.append('customer_name', custName);
    fd.append('customer_phone', custPhone);
    fd.append('customer_city', custCity);
    fd.append('customer_id_type', idType);
    fd.append('product_name', currentProduct.title);
    fd.append('product_price', currentProduct.price);
    fd.append('down_payment_pct', currentProduct.downPct);
    fd.append('down_payment_val', document.getElementById('pxLeadDownPaymentVal').value);
    fd.append('term_months', currentProduct.termMonths);
    fd.append('monthly_payment', document.getElementById('pxLeadMonthlyPayment').value);
    fd.append('has_tradein', currentProduct.hasTradeIn ? 1 : 0);
    fd.append('tradein_brand', document.getElementById('pxTradeInBrand') ? document.getElementById('pxTradeInBrand').value : '');
    fd.append('tradein_model', document.getElementById('pxTradeInModel') ? document.getElementById('pxTradeInModel').value : '');
    fd.append('tradein_condition', document.getElementById('pxTradeInCondition') ? document.getElementById('pxTradeInCondition').value : '');
    fd.append('tradein_valuation', currentProduct.tradeInVal);
    fd.append('notes', notes);

    fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
      method: 'POST',
      body: fd
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
      if (btn) btn.disabled = false;
      if (res.success) {
        var body = document.getElementById('pxInstBody');
        var successView = document.getElementById('pxInstSuccessView');
        var codeEl = document.getElementById('pxSuccessLeadCode');
        var nameEl = document.getElementById('pxSuccessCustName');
        var phoneEl = document.getElementById('pxSuccessCustPhone');
        var zaloLink = document.getElementById('pxSuccessZaloLink');

        if (body) body.classList.add('hidden');
        if (successView) successView.classList.remove('hidden');
        if (codeEl) codeEl.textContent = 'MÃ HỒ SƠ: #' + res.data.lead_code;
        if (nameEl) nameEl.textContent = custName;
        if (phoneEl) phoneEl.textContent = custPhone;
        if (zaloLink) zaloLink.href = 'https://zalo.me/' + custPhone.replace(/[^0-9]/g, '');
      } else {
        alert(res.data.message || 'Có lỗi xảy ra, vui lòng thử lại.');
        if (btnText) btnText.textContent = 'XÁC NHẬN ĐĂNG KÝ TRẢ GÓP 0%';
      }
    })
    .catch(function(err) {
      if (btn) btn.disabled = false;
      if (btnText) btnText.textContent = 'XÁC NHẬN ĐĂNG KÝ TRẢ GÓP 0%';
      alert('Không thể kết nối máy chủ. Vui lòng liên hệ hotline 1800.6868.');
    });
  };

  // Close modal when clicking backdrop
  document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('pxInstallmentModal');
    if (modal) {
      modal.addEventListener('click', function(e) {
        if (e.target === modal) {
          pxCloseInstallmentModal();
        }
      });
    }
  });

})();
</script>
