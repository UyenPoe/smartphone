<?php
/**
 * Global PhoneX Product Specifications Modal
 *
 * Provides a standardized TGDD-style Specs Modal for ALL products across the site:
 * - Phones (Full 6-section spec groups from TGDD: Screen, CPU, RAM/ROM, Camera, Battery, Connectivity)
 * - Used Phones (Grading, Battery Health, Warranty, Storage, Screen)
 * - Accessories (Cables, Chargers, Cases, Audio, Mice, Keyboards, Network, Bags, Fans...)
 *
 * @package PhoneX
 */
?>
<!-- GLOBAL SPECS MODAL -->
<div id="pxGlobalSpecsModal" class="modal-backdrop fixed inset-0 z-[999999] hidden items-center justify-center p-3 sm:p-4 bg-black/60 backdrop-blur-xs font-sans" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 999999; background-color: rgba(0,0,0,0.65); align-items: center; justify-content: center; box-sizing: border-box;" role="dialog" aria-modal="true" aria-labelledby="pxSpecsModalTitle">
  <div class="modal-container relative w-full max-w-[680px] max-h-[90vh] bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-[#E5E7EB]">
    
    <!-- Modal Header -->
    <div class="p-4 sm:p-5 border-b border-[#E5E7EB] bg-gradient-to-r from-[#fff5f5] via-white to-white flex items-center justify-between gap-3 shrink-0">
      <div class="flex items-center gap-3 min-w-0">
        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-[#f8f9fb] border border-[#E5E7EB] p-1.5 shrink-0 flex items-center justify-center overflow-hidden">
          <img id="pxSpecsModalImg" src="" alt="" class="w-full h-full object-contain" onerror="this.onerror=null; this.src='<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.jpg' ); ?>';" />
        </div>
        <div class="min-w-0">
          <div class="flex items-center gap-1.5 mb-0.5">
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-[4px] bg-[#ffdad5] text-[#b7000c] text-[11px] font-bold uppercase tracking-wider">
              <span class="material-symbols-outlined text-[13px]">info</span> Thông số kỹ thuật
            </span>
            <span id="pxSpecsModalBrand" class="text-[12px] font-semibold text-[#5f5e5e]"></span>
          </div>
          <h3 id="pxSpecsModalTitle" class="text-[15px] sm:text-[17px] font-bold text-[#222222] line-clamp-1 leading-snug"></h3>
          <div class="flex items-baseline gap-2 mt-0.5">
            <span id="pxSpecsModalPrice" class="text-[16px] sm:text-[18px] font-bold text-[#e60012]"></span>
            <span id="pxSpecsModalOldPrice" class="text-[12px] sm:text-[13px] text-[#5f5e5e] line-through"></span>
            <span id="pxSpecsModalDiscount" class="text-[11px] font-bold text-white bg-[#e60012] px-1.5 py-0.5 rounded hidden"></span>
          </div>
        </div>
      </div>
      <button type="button" id="pxSpecsModalClose" class="w-9 h-9 rounded-full bg-[#f8f9fb] hover:bg-[#ffdad5] text-[#5f5e5e] hover:text-[#b7000c] flex items-center justify-center shrink-0 transition-colors cursor-pointer" aria-label="Đóng">
        <span class="material-symbols-outlined text-[20px]">close</span>
      </button>
    </div>

    <!-- Modal Body (Scrollable Specs Content) -->
    <div id="pxSpecsModalBody" class="p-4 sm:p-6 overflow-y-auto flex-1 space-y-4 text-sm scrollbar-thin">
      <!-- Dynamic specs tables / lists will be injected here -->
    </div>

    <!-- Modal Footer -->
    <div class="p-3.5 sm:p-4 border-t border-[#E5E7EB] bg-[#f8f9fb] flex items-center justify-between gap-3 shrink-0">
      <button type="button" id="pxSpecsModalCloseBtn" class="min-h-[44px] px-5 rounded-[8px] border border-[#E5E7EB] bg-white hover:bg-gray-100 text-[#222222] font-semibold text-[13px] sm:text-[14px] transition-colors cursor-pointer">
        Đóng
      </button>
      <a id="pxSpecsModalCta" href="<?php echo esc_url( home_url('/lien-he/') ); ?>" class="flex-1 min-h-[44px] px-6 rounded-[8px] bg-[#b7000c] hover:bg-[#C90010] text-white font-semibold text-[14px] sm:text-[15px] transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer text-center">
        <span class="material-symbols-outlined text-[18px]">shopping_bag</span>
        Đặt mua ngay
      </a>
    </div>

  </div>
</div>

<script>
(function() {
  const modal = document.getElementById('pxGlobalSpecsModal');
  if (!modal) return;

  const modalImg = document.getElementById('pxSpecsModalImg');
  const modalBrand = document.getElementById('pxSpecsModalBrand');
  const modalTitle = document.getElementById('pxSpecsModalTitle');
  const modalPrice = document.getElementById('pxSpecsModalPrice');
  const modalOldPrice = document.getElementById('pxSpecsModalOldPrice');
  const modalDiscount = document.getElementById('pxSpecsModalDiscount');
  const modalBody = document.getElementById('pxSpecsModalBody');
  const modalCta = document.getElementById('pxSpecsModalCta');
  const closeBtn = document.getElementById('pxSpecsModalClose');
  const closeBtnFooter = document.getElementById('pxSpecsModalCloseBtn');

  function closeModal() {
    modal.style.display = 'none';
    modal.classList.remove('is-open', 'active', 'flex');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
  }

  function openModal(data) {
    if (!data) return;

    modalTitle.textContent = data.name || 'Thông số sản phẩm';
    if (modalBrand) modalBrand.textContent = data.brand ? ('• ' + data.brand) : '';
    if (modalImg) {
      modalImg.src = data.image || '';
      modalImg.alt = data.name || '';
    }

    // Price
    const priceNum = parseFloat(data.price) || 0;
    const oldPriceNum = parseFloat(data.price_old || data.old_price) || 0;
    const discountNum = parseInt(data.discount_pct || data.discount) || 0;

    if (modalPrice) {
      modalPrice.textContent = priceNum > 0 ? (new Intl.NumberFormat('vi-VN').format(priceNum) + '₫') : 'Liên hệ';
    }
    if (modalOldPrice) {
      if (oldPriceNum > priceNum && oldPriceNum > 0) {
        modalOldPrice.textContent = new Intl.NumberFormat('vi-VN').format(oldPriceNum) + '₫';
        modalOldPrice.classList.remove('hidden');
        modalOldPrice.style.display = 'inline';
      } else {
        modalOldPrice.classList.add('hidden');
        modalOldPrice.style.display = 'none';
      }
    }
    if (modalDiscount) {
      if (discountNum > 0) {
        modalDiscount.textContent = '-' + discountNum + '%';
        modalDiscount.classList.remove('hidden');
        modalDiscount.style.display = 'inline';
      } else {
        modalDiscount.classList.add('hidden');
        modalDiscount.style.display = 'none';
      }
    }

    // CTA Link
    if (modalCta) {
      const ctaUrl = data.permalink || ('<?php echo esc_url( home_url('/lien-he/') ); ?>?product=' + encodeURIComponent(data.name || ''));
      modalCta.href = ctaUrl;
    }

    // Render Body Specs
    let html = '';

    // Case 1: spec_groups (Structured TGDD specs groups for phones)
    if (Array.isArray(data.spec_groups) && data.spec_groups.length > 0) {
      data.spec_groups.forEach((group, gIdx) => {
        let groupIcon = 'tune';
        const gNameLower = (group.group || '').toLowerCase();
        if (gNameLower.includes('cấu hình') || gNameLower.includes('bộ nhớ') || gNameLower.includes('cpu')) groupIcon = 'memory';
        else if (gNameLower.includes('camera') || gNameLower.includes('màn hình')) groupIcon = 'photo_camera';
        else if (gNameLower.includes('pin') || gNameLower.includes('sạc')) groupIcon = 'battery_charging_full';
        else if (gNameLower.includes('tiện ích') || gNameLower.includes('bảo mật')) groupIcon = 'verified_user';
        else if (gNameLower.includes('kết nối') || gNameLower.includes('sim') || gNameLower.includes('wifi')) groupIcon = 'cell_tower';
        else if (gNameLower.includes('thiết kế') || gNameLower.includes('chất liệu')) groupIcon = 'devices';

        html += `
          <div class="rounded-xl border border-[#E5E7EB] overflow-hidden bg-white shadow-2xs mb-3.5">
            <div class="px-4 py-2.5 bg-[#f8f9fb] border-b border-[#E5E7EB] flex items-center gap-2">
              <span class="material-symbols-outlined text-[18px] text-[#e60012]">${groupIcon}</span>
              <h4 class="font-bold text-[#222222] text-[14px] uppercase tracking-wide">${group.group || 'Thông số'}</h4>
            </div>
            <div class="divide-y divide-[#E5E7EB]">
        `;
        if (Array.isArray(group.items)) {
          group.items.forEach((item, iIdx) => {
            const bgClass = iIdx % 2 === 0 ? 'bg-white' : 'bg-[#fcfdfd]';
            html += `
              <div class="grid grid-cols-1 sm:grid-cols-3 p-3 text-[13px] ${bgClass} gap-1 sm:gap-2">
                <span class="text-[#5f5e5e] font-medium sm:col-span-1">${item.name}</span>
                <span class="text-[#222222] font-semibold sm:col-span-2">${item.value}</span>
              </div>
            `;
          });
        }
        html += `</div></div>`;
      });
    }
    // Case 2: summary_specs object
    else if (data.summary_specs && typeof data.summary_specs === 'object' && Object.keys(data.summary_specs).length > 0) {
      const s = data.summary_specs;
      const labels = {
        screen: 'Màn hình',
        os: 'Hệ điều hành',
        cpu: 'Chip xử lý (CPU)',
        ram: 'RAM',
        storage: 'Bộ nhớ trong',
        camera_rear: 'Camera sau',
        camera_front: 'Camera trước',
        battery: 'Dung lượng pin',
        charge: 'Công nghệ sạc',
        sim: 'SIM & Mạng',
        material: 'Chất liệu & Trọng lượng',
        security: 'Bảo mật',
        waterproof: 'Kháng nước / bụi'
      };
      html += `
        <div class="rounded-xl border border-[#E5E7EB] overflow-hidden bg-white shadow-2xs mb-3.5">
          <div class="px-4 py-2.5 bg-[#f8f9fb] border-b border-[#E5E7EB] flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] text-[#e60012]">smartphone</span>
            <h4 class="font-bold text-[#222222] text-[14px] uppercase tracking-wide">Bảng thông số kỹ thuật</h4>
          </div>
          <div class="divide-y divide-[#E5E7EB]">
      `;
      let i = 0;
      for (const [key, label] of Object.entries(labels)) {
        if (s[key]) {
          const bg = i % 2 === 0 ? 'bg-white' : 'bg-[#fcfdfd]';
          html += `
            <div class="grid grid-cols-1 sm:grid-cols-3 p-3 text-[13px] ${bg} gap-1 sm:gap-2">
              <span class="text-[#5f5e5e] font-medium sm:col-span-1">${label}</span>
              <span class="text-[#222222] font-semibold sm:col-span-2">${s[key]}</span>
            </div>
          `;
          i++;
        }
      }
      html += `</div></div>`;
    }
    // Case 3: specs array of bullet points (Accessories, Used Phones, etc.)
    else if (Array.isArray(data.specs) && data.specs.length > 0) {
      html += `
        <div class="rounded-xl border border-[#E5E7EB] overflow-hidden bg-white shadow-2xs mb-3.5">
          <div class="px-4 py-2.5 bg-[#f8f9fb] border-b border-[#E5E7EB] flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] text-[#e60012]">featured_play_list</span>
            <h4 class="font-bold text-[#222222] text-[14px] uppercase tracking-wide">Đặc điểm kỹ thuật nổi bật</h4>
          </div>
          <div class="p-3.5 space-y-2.5">
      `;
      data.specs.forEach(spec => {
        html += `
          <div class="flex items-start gap-2.5 text-[13px] text-[#222222]">
            <span class="material-symbols-outlined text-[#198754] text-[18px] shrink-0 mt-0.5">check_circle</span>
            <span class="leading-relaxed font-medium">${spec}</span>
          </div>
        `;
      });
      html += `</div></div>`;
    }
    // Case 4: specs as single string or comma separated
    else if (typeof data.specs === 'string' && data.specs.trim()) {
      const parts = data.specs.split(/[•,\n\r]+/).map(s => s.trim()).filter(Boolean);
      html += `
        <div class="rounded-xl border border-[#E5E7EB] overflow-hidden bg-white shadow-2xs mb-3.5">
          <div class="px-4 py-2.5 bg-[#f8f9fb] border-b border-[#E5E7EB] flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] text-[#e60012]">info</span>
            <h4 class="font-bold text-[#222222] text-[14px] uppercase tracking-wide">Thông số sản phẩm</h4>
          </div>
          <div class="p-3.5 space-y-2.5">
      `;
      parts.forEach(part => {
        html += `
          <div class="flex items-start gap-2.5 text-[13px] text-[#222222]">
            <span class="material-symbols-outlined text-[#e60012] text-[18px] shrink-0 mt-0.5">verified</span>
            <span class="leading-relaxed font-medium">${part}</span>
          </div>
        `;
      });
      html += `</div></div>`;
    }
    else {
      html = `
        <div class="p-8 text-center text-[#5f5e5e]">
          <span class="material-symbols-outlined text-[44px] text-gray-300 block mb-2">info</span>
          <p class="font-semibold text-base">Sản phẩm chính hãng nguyên seal fullbox.</p>
          <p class="text-xs text-gray-400 mt-1">Bảo hành 12 tháng chính hãng toàn quốc, lỗi 1 đổi 1 trong 30 ngày.</p>
        </div>
      `;
    }

    // Add commitment box in specs modal (PhoneX Warranty & Authenticity)
    html += `
      <div class="rounded-xl p-3.5 bg-[#fff1f0] border border-[#ffb4aa]/60 flex items-center justify-between gap-3 text-[12px] sm:text-[13px] text-[#5f5e5e]">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-[#b7000c] text-[22px] shrink-0">verified_user</span>
          <span><strong>100% Chính Hãng</strong> &bull; Bảo hành 12 tháng &bull; Đổi mới 30 ngày &bull; Giao siêu tốc 1H</span>
        </div>
      </div>
    `;

    modalBody.innerHTML = html;

    // Display modal (Bulletproof display)
    modal.style.display = 'flex';
    modal.classList.add('is-open', 'active', 'flex');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  window.openPhoneXSpecsModal = openModal;
  window.closePhoneXSpecsModal = closeModal;

  // Resilient Data Extractor
  function extractProductData(btn) {
    if (!btn) return null;
    
    // 1. Direct data-product attribute
    try {
      const raw = btn.getAttribute('data-product');
      if (raw) return JSON.parse(raw);
    } catch (e) {
      console.warn('JSON parse error on data-product:', e);
    }

    // 2. Global lookup by phone ID
    const card = btn.closest('.phone-item, .px-prod-card, .charger-item, .cable-item, .case-item');
    const pid = btn.getAttribute('data-phone-id') || btn.getAttribute('data-id') || (card && (card.getAttribute('data-phone-id') || card.getAttribute('data-id')));
    
    if (pid && Array.isArray(window.pxPhoneSpecsCatalog)) {
      const found = window.pxPhoneSpecsCatalog.find(x => String(x.id) === String(pid));
      if (found) return found;
    }

    // 3. Global lookup by product name
    const title = btn.getAttribute('data-name') || (card && (card.getAttribute('data-name') || card.querySelector('h3, h4')?.textContent?.trim()));
    if (title && Array.isArray(window.pxPhoneSpecsCatalog)) {
      const cleanTitle = title.toLowerCase().replace(/^(điện thoại|dtdd)\s+/i, '').trim();
      const found = window.pxPhoneSpecsCatalog.find(x => {
        const xTitle = (x.name || '').toLowerCase().replace(/^(điện thoại|dtdd)\s+/i, '').trim();
        return xTitle === cleanTitle || cleanTitle.includes(xTitle) || xTitle.includes(cleanTitle);
      });
      if (found) return found;
    }

    // 4. Fallback: extract from card DOM
    if (card) {
      const cardTitle = card.querySelector('h3, h4, .prod-title')?.textContent?.trim() || '';
      const cardImg = card.querySelector('img')?.getAttribute('src') || '';
      const priceText = card.querySelector('.text-[#e60012], .price-sale, .price')?.textContent?.trim() || '';
      const specsTag = card.querySelector('.open-specs-modal-btn, [data-specs]')?.textContent?.trim() || '';
      if (cardTitle) {
        return {
          name: cardTitle,
          image: cardImg,
          price: parseFloat(priceText.replace(/[^\d]/g, '')) || 0,
          specs: specsTag ? [specsTag] : []
        };
      }
    }

    return null;
  }

  // Global Click Delegator using Capture Phase to prevent premature link navigation
  document.addEventListener('click', function(e) {
    // 1. Clicked on or inside .open-specs-modal-btn
    const btn = e.target.closest('.open-specs-modal-btn');
    if (btn) {
      e.preventDefault();
      e.stopPropagation();
      const data = extractProductData(btn);
      if (data) openModal(data);
      return;
    }

    // 2. Clicked on a product card (.phone-item, etc.)
    const card = e.target.closest('.phone-item, .px-prod-card, .charger-item, .cable-item, .case-item');
    if (card) {
      // If clicked on "Đặt mua ngay" or checkout link, let it proceed
      const buyBtn = e.target.closest('a[href*="lien-he"], button.fs-product-buy-btn, [data-buy-btn], .px-ds-btn-cta');
      if (buyBtn && (buyBtn.textContent.includes('mua ngay') || buyBtn.textContent.includes('Mua ngay'))) {
        return;
      }

      // If clicked on image, title, or specs pill
      const targetIsVisual = e.target.closest('img, h3, h4, .specs-tag, span[title*="thông số"]');
      if (targetIsVisual) {
        const trigger = card.querySelector('.open-specs-modal-btn') || card;
        const data = extractProductData(trigger);
        if (data) {
          e.preventDefault();
          e.stopPropagation();
          openModal(data);
        }
      }
    }
  }, true);

  if (closeBtn) closeBtn.addEventListener('click', closeModal);
  if (closeBtnFooter) closeBtnFooter.addEventListener('click', closeModal);
  
  modal.addEventListener('click', function(e) {
    if (e.target === modal) closeModal();
  });
  
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && modal.style.display === 'flex') {
      closeModal();
    }
  });

})();
</script>
