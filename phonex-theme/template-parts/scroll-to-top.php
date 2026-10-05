<?php
/**
 * Template part for the Scroll to Top button
 *
 * @package PhoneX
 */
?>
<!-- PhoneX Scroll To Top Component with Circular Scroll Progress -->
<div id="phonexScrollTopWrap" class="group fixed right-4 bottom-20 md:right-8 md:bottom-8 z-40 transition-all duration-300 transform translate-y-6 opacity-0 pointer-events-none">
  <!-- Tooltip for Desktop -->
  <div class="hidden md:block absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2.5 py-1 bg-gray-900/90 backdrop-blur-sm text-white text-[11px] font-bold rounded-lg shadow-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
    Lên đầu trang
    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900/90"></div>
  </div>

  <button 
    type="button" 
    id="phonexScrollTopBtn" 
    class="relative w-11 h-11 md:w-12 md:h-12 rounded-full bg-white/95 backdrop-blur-md shadow-[0_4px_20px_rgba(0,0,0,0.12)] border border-gray-200/90 hover:border-[#FF001F] text-gray-700 hover:text-white hover:bg-[#FF001F] flex items-center justify-center transition-all duration-300 active:scale-90 focus:outline-none focus:ring-2 focus:ring-[#FF001F]/40 cursor-pointer"
    aria-label="<?php esc_attr_e( 'Cuộn lên đầu trang', 'phonex' ); ?>"
    title="<?php esc_attr_e( 'Cuộn lên đầu trang', 'phonex' ); ?>"
  >
    <!-- SVG Circular Progress Indicator -->
    <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none p-0.5" viewBox="0 0 48 48">
      <!-- Background track -->
      <circle 
        cx="24" 
        cy="24" 
        r="20" 
        stroke="currentColor" 
        stroke-width="2.5" 
        fill="transparent" 
        class="text-gray-200/80 group-hover:text-white/20 transition-colors"
      />
      <!-- Active Progress fill -->
      <circle 
        id="phonexScrollProgressCircle"
        cx="24" 
        cy="24" 
        r="20" 
        stroke="#FF001F" 
        stroke-width="2.5" 
        stroke-linecap="round"
        fill="transparent" 
        stroke-dasharray="125.66" 
        stroke-dashoffset="125.66" 
        class="group-hover:stroke-white transition-colors duration-200"
      />
    </svg>

    <!-- Up Arrow Icon -->
    <span class="material-symbols-outlined text-[22px] md:text-[24px] group-hover:-translate-y-0.5 transition-transform duration-200 relative z-10">
      arrow_upward
    </span>
  </button>
</div>

<script>
(function() {
  const wrap = document.getElementById('phonexScrollTopWrap');
  const btn = document.getElementById('phonexScrollTopBtn');
  const progressCircle = document.getElementById('phonexScrollProgressCircle');
  if (!wrap || !btn || !progressCircle) return;

  const circumference = 2 * Math.PI * 20; // ~125.66
  progressCircle.style.strokeDasharray = circumference.toString();
  progressCircle.style.strokeDashoffset = circumference.toString();

  let ticking = false;

  function updateScroll() {
    const scrollY = window.pageYOffset || document.documentElement.scrollTop;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;

    // Show/hide button after 280px
    if (scrollY > 280) {
      wrap.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-6');
      wrap.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
    } else {
      wrap.classList.add('opacity-0', 'pointer-events-none', 'translate-y-6');
      wrap.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
    }

    // Update progress circle
    if (docHeight > 0) {
      const progress = Math.min(Math.max(scrollY / docHeight, 0), 1);
      const offset = circumference - (progress * circumference);
      progressCircle.style.strokeDashoffset = offset.toString();
    }

    ticking = false;
  }

  window.addEventListener('scroll', function() {
    if (!ticking) {
      window.requestAnimationFrame(updateScroll);
      ticking = true;
    }
  }, { passive: true });

  btn.addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  // Initial check
  updateScroll();
})();
</script>
