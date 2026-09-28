
(function(){
 const root = document.documentElement.getAttribute("data-phonex-root") || "";
 const R = {"home": "pages/shop/home/index.html", "products": "pages/shop/products/index.html", "product-detail": "pages/shop/product-detail/index.html", "cart": "pages/shop/cart/index.html", "checkout": "pages/shop/checkout/index.html", "order-success": "pages/shop/order-success/index.html", "order-tracking": "pages/shop/order-tracking/index.html", "order-detail": "pages/shop/order-detail/index.html", "search": "pages/shop/search/index.html", "compare": "pages/shop/compare/index.html", "sell-phone": "pages/trade-in/sell-phone/index.html", "device-selection": "pages/trade-in/device-selection/index.html", "valuation": "pages/trade-in/valuation/index.html", "valuation-result": "pages/trade-in/valuation-result/index.html", "sell-registration": "pages/trade-in/sell-registration/index.html", "sell-success": "pages/trade-in/sell-success/index.html", "tradein-tracking": "pages/trade-in/tradein-tracking/index.html", "tradein-detail": "pages/trade-in/tradein-detail/index.html", "tradein-result": "pages/trade-in/tradein-result/index.html", "account": "pages/account/account/index.html", "login": "pages/account/login-phone-otp/index.html", "my-orders": "pages/account/my-orders/index.html", "favorites": "pages/account/favorites/index.html", "warranty": "pages/warranty/warranty-lookup/index.html", "stores": "pages/stores/stores/index.html", "promotions": "pages/promotions/promotions/index.html"};
 const go=(key)=>{ if(R[key]) location.href=root+R[key]; };
 const text=(el)=>(el.innerText||el.textContent||"").trim().toLowerCase();
 const rules=[
  [/trang chủ|home/, "home"], [/điện thoại|sản phẩm|products?/, "products"],
  [/thu cũ|đổi mới|trade.?in/, "sell-phone"], [/bán máy/, "sell-phone"],
  [/giỏ hàng|cart/, "cart"], [/thanh toán|checkout/, "checkout"],
  [/tra cứu.*đơn|đơn hàng/, "order-tracking"], [/bảo hành/, "warranty"],
  [/cửa hàng|store/, "stores"], [/khuyến mãi|ưu đãi|promotion/, "promotions"],
  [/tài khoản|đăng nhập|account/, "account"], [/yêu thích|favorite/, "favorites"],
  [/so sánh|compare/, "compare"], [/tìm kiếm|search/, "search"]
 ];
 document.addEventListener("click",e=>{
   const el=e.target.closest("a,button,[role=button]");
   if(!el) return;
   if(el.tagName==="A" && el.getAttribute("href") && !["#","javascript:void(0)"].includes(el.getAttribute("href"))) return;
   const s=(text(el)+" "+(el.getAttribute("aria-label")||"")+" "+(el.getAttribute("title")||"")).toLowerCase();
   for(const [rx,key] of rules){ if(rx.test(s)){ e.preventDefault(); go(key); return; } }
   if(/mua ngay|buy now|thêm vào giỏ/.test(s)){ e.preventDefault(); go("cart"); return; }
   if(/xem chi tiết|chi tiết sản phẩm|xem sản phẩm/.test(s)){ e.preventDefault(); go("product-detail"); return; }
   if(/định giá ngay|định giá máy/.test(s)){ e.preventDefault(); go("valuation"); return; }
 });
 window.PhoneXNav={go,routes:R};
})();
