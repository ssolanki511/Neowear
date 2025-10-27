const profile_menu_button = document.querySelector('.menu-button');
const profile_menu = document.querySelector('.profile-top .edit-box');
profile_menu_button.addEventListener('click', (e) => {
    e.preventDefault();
    if(getComputedStyle(profile_menu).visibility == 'hidden'){
        profile_menu.style.visibility = 'visible';
    }else{
        profile_menu.style.visibility = 'hidden';
    }
})

const swiper = new Swiper(".mySwiper", {
    autoHeight: false,
    allowTouchMove: false,
});
const tabs = document.querySelectorAll(".tab-btn");
tabs.forEach((tab, i) => {
    tab.addEventListener("click", () => {
        swiper.slideTo(i);
        tabs.forEach(t => t.classList.remove("active"));
        tab.classList.add("active");
    });
});

// document.querySelectorAll(".expand-btn").forEach(btn => {
//     btn.addEventListener("click", () => {
//         btn.classList.toggle("active");

//         // find the parent row
//         let row = btn.closest("tr");
//         let nextRow = row.nextElementSibling;

//         // show all consecutive details-row until the next main row
//         while (nextRow && nextRow.classList.contains("details-row")) {
//             nextRow.style.display = nextRow.style.display === "table-row" ? "none" : "table-row";
//             nextRow = nextRow.nextElementSibling;
//         }
//     });
// });
document.querySelector(".product-table").addEventListener("click", function (e) {
    if (e.target.closest(".expand-btn")) {
        const btn = e.target.closest(".expand-btn");
        btn.classList.toggle("active");

        let row = btn.closest("tr");
        let nextRow = row.nextElementSibling;

        if (nextRow && nextRow.classList.contains("details-row")) {
            nextRow.style.display = nextRow.style.display === "table-row" ? "none" : "table-row";
        }
    }
});

document.getElementById("image-file").addEventListener("change", function() {
    document.getElementById("uploadForm").submit();
});

document.getElementById("input-search").addEventListener("input", function(e) {
    e.preventDefault();
    let keyword = this.value.trim();

    fetch(`/search-orders?q=${encodeURIComponent(keyword)}`)
        .then(res => res.json())
        .then(data => {
            const container = document.querySelector(".product-table tbody");
            container.innerHTML = "";

            if (data.length === 0) {
                container.innerHTML = '<tr><td colspan="7"><p class="empty-order">No product found.</p></td></tr>';
                return;
            }

            data.forEach(order => {
                let itemsHtml = '';
                order.order_items.forEach(item => {
                    itemsHtml += `
                        <tr>
                            <td class="product-link-box">
                                <div class="img-box">
                                    ${item.product_image ? `<img src="/images/product_images/${item.product_image}" alt="Product Image">` : '<i class="fa-solid fa-gift order-gift"></i>'}
                                </div>
                                <p>${item.product_name}</p>
                            </td>
                            <td>${item.quantity}</td>
                            <td>₹${item.price}</td>
                            <td>₹${item.price * item.quantity}</td>
                        </tr>
                    `;
                });

                container.innerHTML += `
                    <tr>
                        <td>
                          <div class="expanded-container">
                            <button class="expand-btn">
                                <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g id="SVGRepo_iconCarrier"> <path d="M16.1795 3.26875C15.7889 2.87823 15.1558 2.87823 14.7652 3.26875L8.12078 9.91322C6.94952 11.0845 6.94916 12.9833 8.11996 14.155L14.6903 20.7304C15.0808 21.121 15.714 21.121 16.1045 20.7304C16.495 20.3399 16.495 19.7067 16.1045 19.3162L9.53246 12.7442C9.14194 12.3536 9.14194 11.7205 9.53246 11.33L16.1795 4.68297C16.57 4.29244 16.57 3.65928 16.1795 3.26875Z" fill="#0F0F0F"/> </g>    
                                </svg>
                            </button>
                          </div>
                        </td>
                        <td>${order.o_id}</td>
                        <td>${new Date(order.created_at).toLocaleDateString()}</td>
                        <td>${order.order_items.length}</td>
                        <td>₹${order.total_amount}</td>
                        <td><span class="status shipped">${order.o_status}</span></td>
                        <td><button class="btn btn-cancel">Cancel</button></td>
                    </tr>
                    <tr class="details-row">
                        <td colspan="7">
                            <div class="order-details-box">
                                <table class="order-table inner">
                                    <tr>
                                        <th>Shipping address</th>
                                        <th>Name</th>
                                        <th>Phone number</th>
                                        <th>Payment method</th>
                                    </tr>
                                    <tr>
                                        <td>${order.o_address}</td>
                                        <td>${order.u_name}</td>
                                        <td>${order.o_phone_number}</td>
                                        <td>${order.o_payment_method}</td>
                                    </tr>
                                </table>
                                <div class="product-table-wrapper">
                                    <table class="order-table product-inner-table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty.</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>${itemsHtml}</tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(err => {
            console.error("Search error:", err);
        });
});
