 @push('scripts')
     <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

     <script>
         window.onload = function() {
             let swiper;

             function initSwiper() {
                 swiper = new Swiper('.swiper', {
                     loop: true,
                     autoplay: {
                         delay: 3500,
                         pauseOnMouseEnter: true,
                         disableOnInteraction: false,
                     },
                     centeredSlides: true,
                     slidesPerView: 'auto',
                     grabCursor: true,
                     spaceBetween: 30,
                 });
             }

             function destroySwiper() {
                 if (swiper !== undefined && swiper !== null) {
                     swiper.destroy();
                     swiper = null;
                 }
             }

             // Check width on load and resize
             function checkWidth() {
                 if (window.innerWidth <= 1024) {
                     initSwiper();
                 } else {
                     destroySwiper();
                 }
             }

             // Initial check
             checkWidth();

             // Event listener for window resize
             window.addEventListener('resize', checkWidth);
         }
     </script>
 @endpush
