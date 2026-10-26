/**
 * PhoneX Trade-in & Buyback Floating Widget
 * Lightweight Embeddable Script (< 5KB) for Partner Websites
 *
 * @version 1.0.0
 * @author PhoneX Team
 */
(function() {
  'use strict';

  if (window.PhoneXWidgetInitialized) return;
  window.PhoneXWidgetInitialized = true;

  // 1. Detect current script and config attributes
  var scripts = document.getElementsByTagName('script');
  var currentScript = scripts[scripts.length - 1];
  for (var i = 0; i < scripts.length; i++) {
    if (scripts[i].src && scripts[i].src.indexOf('phonex-widget.js') !== -1) {
      currentScript = scripts[i];
      break;
    }
  }

  var partnerId = currentScript ? (currentScript.getAttribute('data-partner') || 'PARTNER_DEFAULT') : 'PARTNER_DEFAULT';
  var position  = currentScript ? (currentScript.getAttribute('data-position') || 'right-bottom') : 'right-bottom';
  var btnText   = currentScript ? (currentScript.getAttribute('data-text') || 'Định Giá Máy Cũ') : 'Định Giá Máy Cũ';
  var themeColor= currentScript ? (currentScript.getAttribute('data-theme') || '#e60012') : '#e60012';

  var baseUrl = 'https://smartphone.taichinhtaithanh.com';
  if (currentScript && currentScript.src) {
    var match = currentScript.src.match(/^(https?:\/\/[^\/]+)/);
    if (match) baseUrl = match[1];
  }

  // 2. Inject Styles
  var style = document.createElement('style');
  style.innerHTML = '\
    .phonex-float-btn {\
      position: fixed; z-index: 999998; display: flex; items-center; gap: 8px; \
      background: ' + themeColor + '; color: #ffffff; padding: 10px 18px; border-radius: 50px; \
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; \
      font-size: 13px; font-weight: 700; box-shadow: 0 4px 20px rgba(230,0,18,0.35); \
      cursor: pointer; border: none; outline: none; transition: all 0.25s ease; \
      ' + (position === 'left-bottom' ? 'left: 20px;' : 'right: 20px;') + ' bottom: 24px;\
    }\
    .phonex-float-btn:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 6px 24px rgba(230,0,18,0.45); }\
    .phonex-modal-overlay {\
      position: fixed; inset: 0; background: rgba(0,0,0,0.65); backdrop-filter: blur(4px); \
      z-index: 999999; display: none; align-items: center; justify-content: center; padding: 16px; \
    }\
    .phonex-modal-content {\
      position: relative; width: 100%; max-width: 680px; height: 90vh; max-height: 820px; \
      background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.3); \
    }\
    .phonex-modal-close {\
      position: absolute; top: 12px; right: 12px; z-index: 10; width: 32px; height: 32px; \
      background: #f1f2f4; border-radius: 50%; border: none; font-size: 18px; cursor: pointer; \
      display: flex; align-items: center; justify-content: center; color: #333; \
    }\
    .phonex-modal-close:hover { background: #e60012; color: #fff; }\
    .phonex-iframe-container { width: 100%; height: 100%; border: none; }\
  ';
  document.head.appendChild(style);

  // 3. Inject Floating Button
  var btn = document.createElement('button');
  btn.className = 'phonex-float-btn';
  btn.setAttribute('type', 'button');
  btn.innerHTML = '<span style="font-size:16px;">🔄</span><span>' + btnText + '</span>';
  document.body.appendChild(btn);

  // 4. Inject Modal Container
  var overlay = document.createElement('div');
  overlay.className = 'phonex-modal-overlay';
  overlay.innerHTML = '\
    <div class="phonex-modal-content">\
      <button class="phonex-modal-close" type="button" aria-label="Close">&times;</button>\
      <iframe class="phonex-iframe-container" src="" allow="clipboard-write"></iframe>\
    </div>\
  ';
  document.body.appendChild(overlay);

  var modalContent = overlay.querySelector('.phonex-modal-content');
  var closeBtn     = overlay.querySelector('.phonex-modal-close');
  var iframe       = overlay.querySelector('iframe');

  function openWidget() {
    if (!iframe.src || iframe.src === 'about:blank') {
      iframe.src = baseUrl + '/dinh-gia-dien-thoai/?embed=true&partner=' + encodeURIComponent(partnerId);
    }
    overlay.style.display = 'flex';
  }

  function closeWidget() {
    overlay.style.display = 'none';
  }

  btn.addEventListener('click', openWidget);
  closeBtn.addEventListener('click', closeWidget);
  overlay.addEventListener('click', function(e) {
    if (e.target === overlay) closeWidget();
  });

  // Global helper API
  window.PhoneXConnect = {
    openValuation: function(opts) {
      opts = opts || {};
      var partner = opts.partner || partnerId;
      var model   = opts.model ? ('&model=' + encodeURIComponent(opts.model)) : '';
      iframe.src = baseUrl + '/dinh-gia-dien-thoai/?embed=true&partner=' + encodeURIComponent(partner) + model;
      overlay.style.display = 'flex';
    },
    closeValuation: closeWidget
  };
})();
