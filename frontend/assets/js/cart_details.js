// Retrieve the current user's information from session storage
const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));

if (!currentUser) {
    alert("Please log in to view your cart.");
    window.location.href = "login.html"; // Redirect if user is not logged in
}

// Create a unique cart key for the current user
const cartKey = `cart_${currentUser.email}`;
const cart = JSON.parse(localStorage.getItem(cartKey)) || [];

function updateCart() {
    const cartItemsContainer = document.getElementById('cart_items');
    cartItemsContainer.innerHTML = ''; // Clear existing items
    let totalPrice = 0;

    // Check if the cart is empty
    if (cart.length === 0) {
        cartItemsContainer.innerHTML = `<tr><th colspan="6" style="text-align:center; color:#ec644b;">Your cart is empty.</th></tr>`;
        return; // Exit if no items in the cart
    }

    // Iterate through each item in the cart
    cart.forEach(item => {
        // Remove the currency symbol and convert to a float
        const itemPrice = parseFloat(item.price.replace('৳', '')) || 0;
        const itemQuantity = parseInt(item.quantity) || 1;
        const itemTotal = itemPrice * itemQuantity;
        totalPrice += itemTotal;

        // Build the HTML for each cart item
        cartItemsContainer.innerHTML += `
                <tr>
                    <th><img src="${item.image}" width="100" height="100" alt="${item.name}"></th>
                    <th>${item.size}</th>
                    <th>${itemQuantity}</th>
                    <th>৳${itemPrice.toFixed(2)}</th>
                    <th>৳${itemTotal.toFixed(2)}</th>
                    <th><button class="remove-btn" onclick="removeFromCart('${item.id}', '${item.size}')">Remove</button></th>
                </tr>
            `;
    });

    // Display total price at the end of the cart
    cartItemsContainer.innerHTML += `
            <tr>
                <th colspan="5">Total Price:</th>
                <th>৳${totalPrice.toFixed(2)}</th>
            </tr>
        `;

    // Update the total price and item count displayed on the page
    document.getElementById("cart_price").innerText = `৳${totalPrice.toFixed(2)}`;
    document.getElementById("cart_item").innerText = cart.length;
}

function removeFromCart(productId, productSize) {
    // Filter out the item that matches the ID and size to remove it
    const updatedCart = cart.filter(item => !(item.id === productId && item.size === productSize));
    // Update local storage with the new cart for the current user
    localStorage.setItem(cartKey, JSON.stringify(updatedCart));
    // Refresh the cart display
    updateCart();
    alert("Item removed from cart");
    window.location.reload();
}

function checkout() {
    const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
    if (totalQuantity > 0) {
        alert(`Thank you for being with us,${currentUser.name}!`);
        // Clear the user's cart from local storage
        localStorage.removeItem(cartKey);
        window.location.reload();
    } else {
        alert("Upps! Your cart is empty!");
    }
}

// Initial load to display the cart
updateCart();