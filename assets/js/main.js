(() => {
  const CART_KEY='phonex_cart_v1', FAV_KEY='phonex_favorites_v1';
  const read=(k,f=[])=>{try{return JSON.parse(localStorage.getItem(k))||f}catch{return f}};
  const write=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
  const cart=()=>read(CART_KEY,[]);
  const refresh=()=>document.querySelectorAll('[data-cart-count]').forEach(el=>el.textContent=cart().reduce((n,i)=>n+(i.qty||1),0));
  window.PhoneX={
    getCart:cart,
    addToCart(productId,variant={}){const items=cart();const key=productId+'|'+(variant.storage||'')+'|'+(variant.color||'');let item=items.find(x=>x.key===key);if(item)item.qty=(item.qty||1)+1;else items.push({key,productId,qty:1,...variant});write(CART_KEY,items);refresh();return items},
    removeFromCart(key){write(CART_KEY,cart().filter(x=>x.key!==key));refresh()},
    toggleFavorite(productId){const f=read(FAV_KEY,[]);const i=f.indexOf(productId);i>=0?f.splice(i,1):f.push(productId);write(FAV_KEY,f);return f.includes(productId)},
    searchProducts:async(q)=>{const u=new URL('../../../data/products.json',location.href);const rows=await fetch(u).then(r=>r.json());q=(q||'').toLowerCase().trim();return rows.filter(p=>[p.name,p.brand,...(p.storage||[])].join(' ').toLowerCase().includes(q));}
  };
  document.addEventListener('click',e=>{const a=e.target.closest('[data-add-cart]');if(a){PhoneX.addToCart(a.dataset.addCart);a.textContent='Đã thêm';}const f=e.target.closest('[data-favorite]');if(f)f.textContent=PhoneX.toggleFavorite(f.dataset.favorite)?'♥':'♡';});
  refresh();
})();
