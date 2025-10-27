document.addEventListener('DOMContentLoaded', function () {
    const quantityInputs = document.querySelectorAll('.quantity-input');

    quantityInputs.forEach(input => {
        input.addEventListener('change', function () {
            const cartItemId = this.dataset.cartId;
            const newQuantity = parseInt(this.value);

            const maxQuantity = parseInt(this.getAttribute('max'));

            if (newQuantity < 1) {
                // alert("Quantity cannot be less than 1.");
                showErrorMessage(`Quantity cannot be less than 1.`);
                this.value = 1;
                return;
            }

            if (newQuantity > maxQuantity) {
                showErrorMessage(`Only ${maxQuantity} item's available for this size`);
                this.value = maxQuantity;
                return;
            }

            fetch(updateCarURL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRFToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    cart_item_id: cartItemId,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update subtotal for the changed item
                    const itemSubtotalEl = document.getElementById('subtotal-' + cartItemId);
                    if (itemSubtotalEl) itemSubtotalEl.textContent = '₹' + data.item_subtotal;

                    // Update summary
                    const subtotalEl = document.querySelector('.summary-subtotal');
                    const taxEl = document.querySelector('.summary-tax');
                    const totalEl = document.querySelector('.summary-total');
                    const totalHiddenInput = document.querySelector('.summary-total-hidden');

                    if (subtotalEl) subtotalEl.textContent = '₹' + data.subtotal;
                    if (taxEl) taxEl.textContent = '₹' + data.tax;
                    if (totalEl) totalEl.textContent = '₹' + data.total;
                    if (totalHiddenInput) totalHiddenInput.value = data.total;
                } else {
                    alert(data.message || 'Failed to update quantity.');
                    // Reset input to previous valid value
                    window.location.reload(); // Optional: Force reload to reflect correct quantity
                }
            })
            .catch(error => {
                console.error(error);
                alert('Something went wrong. Please try again.');
            });
        });
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