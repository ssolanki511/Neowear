var swiper = new Swiper(".hero-swiper", {
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});

var swiper = new Swiper(".recent-swiper", {
  slidesPerView: 4,
  spaceBetween: 30,
  navigation: {
    nextEl: ".recent-button-next",
    prevEl: ".recent-button-prev",
  },
  scrollbar: {
    el: ".recent-scrollbar",
    hide: false,
  },
});

var swiper = new Swiper(".feature-swiper", {
  slidesPerView: 4,
  spaceBetween: 30,
  navigation: {
    nextEl: ".feature-button-next",
    prevEl: ".feature-button-prev",
  },
  scrollbar: {
    el: ".feature-scrollbar",
    hide: false,
  },
});

const AllWishlistBtn = document.querySelectorAll('.wishlist-btn');

AllWishlistBtn.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const productId = btn.getAttribute('data-product-id');

        fetch(`/addToWishlist/${productId}`, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
          document.querySelectorAll('.error-box').forEach(el => el.remove());
          // Create new message box
          const box = document.createElement('div');
          box.classList.add('error-box', data.success ?'success' : 'error');
          box.innerHTML = `<p>${data.message}</p>`;
          document.body.appendChild(box);

            // Auto hide after 5s
          setTimeout(() => {
            box.style.display = 'none';
          }, 5000);

          if (data.success) {
            const btns = document.querySelectorAll(`.wishlist-btn[data-product-id="${data.product_id}"]`);
            btns.forEach(btn => {
              if (data.toggled) {
                btn.innerHTML = `<i class="fa-solid fa-heart" style="color:#ff0000;"></i>`;
              } else {
                btn.innerHTML = `<i class="fa-regular fa-heart"></i>`;
              }
            });
          }
        })
        .catch(error => console.error("Error:", error));
    });
});