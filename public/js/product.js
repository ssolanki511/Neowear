// product swiper
var swiper = new Swiper(".mySwiper", {
  spaceBetween: 10,
  slidesPerView: 4,
  freeMode: true,
  loop: true,
  watchSlidesProgress: true,
});

var swiper2 = new Swiper(".mySwiper2", {
  spaceBetween: 10,
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  thumbs: {
    swiper: swiper,
  },
  effect: "fade",
});

// product zoom effect
const mainSwiper = document.querySelector('.mySwiper2');
const zoomBox = document.querySelector('.zoom-box .product-zoom');
  
mainSwiper.addEventListener('mousemove', function(e) {
  const swiperSlide = e.target.closest('.swiper-slide');
  if (!swiperSlide) return;

  const img = swiperSlide.querySelector('img');
  if (!img) return;
  
  // Show zoom box
  document.querySelector('.zoom-box').style.display = 'block';
  
  // Get position and dimensions
  const rect = img.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const y = e.clientY - rect.top;
  
  // // Calculate percentage position
  const xPercent = (x / rect.width) * 100;
  const yPercent = (y / rect.height) * 100;
  
  // Set zoomed image background
  zoomBox.style.backgroundImage = `url(${img.src})`;
  zoomBox.style.backgroundPosition = `${xPercent}% ${yPercent}%`;
});

mainSwiper.addEventListener('mouseleave', function() {
  document.querySelector('.zoom-box').style.display = 'none';
});

//quantity controler
// quantity_box = document.querySelector('.number-quantity');

// quantity_box.addEventListener('change', (e) => {
//   e.preventDefault();
//   if(quantity_box.value.trim() == '' || parseInt(quantity_box.value.trim(), 10) < 0){
//     quantity_box.value = '0';
//   }
// })

// document.querySelector('.number-left').addEventListener('click', (e) => {
//   e.preventDefault();
//   if(quantity_box.value > 1){
//     quantity_box.value = parseInt(quantity_box.value, 10) - 1;
//   }
// })

// document.querySelector('.number-right').addEventListener('click', (e) => {
//   e.preventDefault();
//   quantity_box.value = parseInt(quantity_box.value, 10) + 1;
// })

// description show
description_box = document.querySelector('.description-box p');
moreBtn = document.querySelector('.description-box .more-btn');
lessBtn = document.querySelector('.description-box .less-btn');

// Hide more/less buttons if description is 1 or 2 lines
function updateDescriptionButtons() {
  let lineHeight = getComputedStyle(description_box).lineHeight;
  if (lineHeight === "normal" || isNaN(parseFloat(lineHeight))) {
    // Fallback: create a temporary span to measure line height
    const temp = document.createElement("span");
    temp.style.visibility = "hidden";
    temp.style.position = "absolute";
    temp.textContent = "A";
    description_box.appendChild(temp);
    lineHeight = temp.offsetHeight;
    description_box.removeChild(temp);
  } else {
    lineHeight = parseFloat(lineHeight);
  }
  const lines = Math.round(description_box.scrollHeight / lineHeight);
  if (lines <= 2) {
    moreBtn.style.display = 'none';
    lessBtn.style.display = 'none';
    description_box.style.webkitLineClamp = 'unset';
    description_box.style.overflow = 'visible';
  } else {
    moreBtn.style.display = 'inline-block';
    lessBtn.style.display = 'none';
    description_box.style.webkitLineClamp = '2';
    description_box.style.overflow = 'hidden';
  }
}

updateDescriptionButtons();

moreBtn.addEventListener('click', (e) => {
  e.preventDefault();
  description_box.style.webkitLineClamp = 'unset';
  description_box.style.overflow = 'visible';
  moreBtn.style.display = 'none';
  lessBtn.style.display = 'inline-block';
});

lessBtn.addEventListener('click', (e) => {
  e.preventDefault();
  description_box.style.webkitLineClamp = '2';
  description_box.style.overflow = 'hidden';
  lessBtn.style.display = 'none';
  moreBtn.style.display = 'inline-block';
});

document.addEventListener('DOMContentLoaded', () => {
    let maxQty = 0;

    const sizeRadios = document.querySelectorAll('input[name="size"]');
    const quantityInput = document.querySelector('.number-quantity');
    const plusBtn = document.querySelector('.number-right');
    const minusBtn = document.querySelector('.number-left');

    // Fetch max quantity for the selected size
    const fetchMaxQty = async (size) => {
        try {
            const response = await fetch('/get-size-quantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId,
                    size: size
                })
            });

            const data = await response.json();
            maxQty = data.max_quantity ?? 0;

            // Reset quantity to 1 if over max
            if (parseInt(quantityInput.value) > maxQty) {
                quantityInput.value = 1;
            }

        } catch (error) {
            console.error('Error fetching max quantity:', error);
        }
    };

    // Initialize with default selected size
    const selectedSize = document.querySelector('input[name="size"]:checked')?.value;
    if (selectedSize) fetchMaxQty(selectedSize);

    // When size changes
    sizeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            const selected = document.querySelector('input[name="size"]:checked').value;
            fetchMaxQty(selected);
            quantityInput.value = 1;
        });
    });

    // Increase quantity
    plusBtn.addEventListener('click', () => {
        let currentVal = parseInt(quantityInput.value);
        if (currentVal < maxQty) {
            quantityInput.value = currentVal + 1;
        } else {
            showErrorMessage("You’ve reached the max quantity for this size.");
        }
    });

    // Decrease quantity
    minusBtn.addEventListener('click', () => {
        let currentVal = parseInt(quantityInput.value);
        if (currentVal > 1) {
            quantityInput.value = currentVal - 1;
        }
    });
});

function showErrorMessage(message) {
    // Check if an error already exists
    if (document.getElementById('errorBoxJs')) return;

    const errorBox = document.createElement('div');
    errorBox.className = 'error-box error';
    errorBox.id = 'errorBoxJs';
    errorBox.innerHTML = `<p>${message}</p>`;
    document.body.appendChild(errorBox); // or insert in specific div

    // Auto-hide after 3 seconds
    setTimeout(() => {
        const box = document.getElementById('errorBoxJs');
        if (box) box.remove();
    }, 3000);
}