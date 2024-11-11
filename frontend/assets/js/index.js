"use strict";

function storeProductData(productId) {
    localStorage.removeItem("selectedProduct");

    // Get the product item's <li> element
    const productElement = document.getElementById(productId);

    // Retrieve data-id from the <li> element
    const productIdValue = productElement.getAttribute('data-id');

    // Get the image element and retrieve its data-image-url attribute
    const imageElement = document.getElementById(`${productId}_image_url`);
    const imageUrl = imageElement.getAttribute('data-image-url');

    // Retrieve product name and price
    const productName = document.getElementById(`${productId}_name`).textContent;
    const productPrice = document.getElementById(`${productId}_price`).getAttribute('value');

    // Store the latest product data in localStorage
    localStorage.setItem("selectedProduct", JSON.stringify({
        id: productIdValue,
        imageUrl: imageUrl,
        name: productName,
        price: productPrice
    }));

    // Redirect to the details page
    window.location.href = "product-details.html";
}
