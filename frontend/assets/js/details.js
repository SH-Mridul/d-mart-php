"use strict";

document.addEventListener("DOMContentLoaded", function () {
    const productData = JSON.parse(localStorage.getItem("selectedProduct"));

    if (productData) {
        document.getElementById("productId").textContent = `Product ID: ${productData.id}`;
        document.getElementById("productImage").src = productData.imageUrl;
        document.getElementById("productName").textContent = productData.name;
        document.getElementById("productPrice").textContent = `৳${productData.price}`;
    }
});


// function addToCart() {
//     // Get product details
//     const productId = document.getElementById("productId").innerText.replace("Product ID: ", "");
//     const productName = document.getElementById("productName").innerText;
//     const productPrice = document.getElementById("productPrice").innerText;
//     const productImage = document.getElementById("productImage").src; // Get image URL
//     const productSize = document.getElementById("shoeSize").value;
//     const productQuantity = 1; // Default quantity

//     // Create product object
//     const product = {
//         id: productId,
//         name: productName,
//         price: productPrice,
//         image: productImage,
//         size: productSize,
//         quantity: productQuantity,
//     };

//     // Get cart from local storage
//     let cart = JSON.parse(localStorage.getItem("cart")) || [];

//     // Check if the product is already in the cart
//     const existingProductIndex = cart.findIndex(item => item.id === product.id && item.size === product.size);

//     if (existingProductIndex > -1) {
//         // Update quantity if product is already in the cart
//         cart[existingProductIndex].quantity += productQuantity;
//     } else {
//         // Add new product to cart
//         cart.push(product);
//     }

//     // Save updated cart to local storage
//     localStorage.setItem("cart", JSON.stringify(cart));

//     // Show alert that item has been added
//     alert(`${product.name} has been added to your cart.`);
//     location.reload();
// }




function addToCart() {
    // Get current user information
    const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));

    if (!currentUser) {
        alert("Please log in to add items to your cart.");
        window.location.href = "login.html";
        return;
    }

    // Create a unique cart key using the user's email
    const cartKey = `cart_${currentUser.email}`;

    // Get cart for the specific user from local storage
    let cart = JSON.parse(localStorage.getItem(cartKey)) || [];

    // Get product details
    const productId = document.getElementById("productId").innerText.replace("Product ID: ", "");
    const productName = document.getElementById("productName").innerText;
    const productPrice = document.getElementById("productPrice").innerText;
    const productImage = document.getElementById("productImage").src;
    const productSize = document.getElementById("shoeSize").value;
    const productQuantity = 1; // Default quantity

    // Create product object
    const product = {
        id: productId,
        name: productName,
        price: productPrice,
        image: productImage,
        size: productSize,
        quantity: productQuantity
    };

    // Check if the product is already in the cart
    const existingProductIndex = cart.findIndex(item =>
        item.id === product.id && item.size === product.size
    );

    if (existingProductIndex > -1) {
        // Update quantity if product is already in the cart
        cart[existingProductIndex].quantity += productQuantity;
    } else {
        // Add new product to cart
        cart.push(product);
    }

    // Save updated cart for this user to local storage
    localStorage.setItem(cartKey, JSON.stringify(cart));

    // Show alert that item has been added
    alert(`${product.name} has been added to your cart.`);
    location.reload();
}
