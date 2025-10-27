const lenis = new Lenis({
  smooth: true,
  lerp:0.1,
});
function raf(time) {
  lenis.raf(time);
  requestAnimationFrame(raf);
}
requestAnimationFrame(raf);

const body = document.querySelector('body');

const menu_container = document.querySelector('.container .menu-container');
const menu_btn = document.querySelector('.menu .menu_open');
const menu_close = document.querySelector('.menu .menu_close');
const main = document.querySelector('body main');

menu_btn.addEventListener('click', () => {
  gsap.to(menu_container, {
    left: 0,
    duration: 0.2,
  });
  gsap.to(menu_btn,{
    display:'none',
    y:10,
    opacity:0,
  });
  gsap.to(menu_close,{
    display:'block',
    delay:0.5,
    opacity:1,
    y:0,
  });
});
menu_close.addEventListener('click', () => {
  gsap.to(menu_container, {
    left: '-120%',
    duration: 0.2,
  });
  gsap.to(menu_close,{
    display:'none',
    y:10,
    opacity:0,
  })
  gsap.to(menu_btn,{
    display:'block',
    delay:0.5,
    opacity:1,
    y:0,
  })
});

document.getElementById('search-product').addEventListener('input', function (e) {
  e.preventDefault();
  let keyword = this.value.trim();
  let list_box = document.querySelector('.search-list-box');

  if(keyword.length < 0){
    list_box.style.display = 'none';
  }

  fetch(`/search-products?keyword=${encodeURIComponent(keyword)}`)
  .then(response => response.json())
  .then(data => {
    let list = document.querySelector('.search-list');
    
    list_box.style.display = 'block';
    list.innerHTML = '';

    if (!Array.isArray(data) || data.length === 0) {
      list_box.style.display = 'none';
      return;
    }

    data.forEach(product => {
      list.innerHTML += `
        <li class="search-item"><p>${product.name}</p></li>
        <hr class="search-item-list">
      `;
    });
  })
  .catch(error => {
    console.error('Fetch error:', error);
  });
});

document.querySelector('.search-list').addEventListener('click', function(e) {
  // Check if the clicked element (or its parent) is a search-item
  let item = e.target.closest('.search-item');
  let list_box = document.querySelector('.search-list-box');
  
  if (item) {
    let productName = item.querySelector('p').textContent;

    document.getElementById('search-product').value = productName;

    // Optionally, hide the search list after selection
    list_box.style.display = 'none';
  }
});