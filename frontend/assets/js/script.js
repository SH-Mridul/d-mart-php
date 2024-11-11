'use strict';



/**
 * navbar toggle
 */

const overlay = document.querySelector("[data-overlay]");
const navOpenBtn = document.querySelector("[data-nav-open-btn]");
const navbar = document.querySelector("[data-navbar]");
const navCloseBtn = document.querySelector("[data-nav-close-btn]");

const navElems = [overlay, navOpenBtn, navCloseBtn];

for (let i = 0; i < navElems.length; i++) {
  navElems[i].addEventListener("click", function () {
    navbar.classList.toggle("active");
    overlay.classList.toggle("active");
  });
}




// window.addEventListener("load", (event) => {

//   const cart = JSON.parse(localStorage.getItem("cart")) || [];
//   const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
//   document.querySelector('#cart_item').textContent = totalQuantity;
//   const user = getCurrentUser();
//   document.querySelector('#loggedInUserName').textContent = user.name;

// });



window.addEventListener("load", (event) => {
  const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));

  if (currentUser) {
    // Create a unique cart key using the user's email
    const cartKey = `cart_${currentUser.email}`;
    const cart = JSON.parse(localStorage.getItem(cartKey)) || [];

    // Calculate total quantity for the specific user's cart
    const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
    document.querySelector('#cart_item').textContent = totalQuantity; // Display total quantity

    // Display the logged-in user's name
    document.querySelector('#loggedInUserName').textContent = currentUser.name;
  } else {
    // Handle case where there is no logged-in user
    document.querySelector('#cart_item').textContent = '0'; // No items if not logged in
    document.querySelector('#loggedInUserName').textContent = 'Guest'; // Or whatever you'd like to show
  }
});





// function cartDetails() {

//   const cart = JSON.parse(localStorage.getItem("cart")) || [];
//   const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
//   if (0 < totalQuantity) {
//     location.replace("./cart_details.html")
//   } else {
//     alert("Cart is empty!");
//   }
// }


function cartDetails() {
  const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));

  if (!currentUser) {
    alert("Please log in to view your cart.");
    window.location.href = "login.html"; // Redirect to login if not logged in
    return;
  }

  // Create a unique cart key using the user's email
  const cartKey = `cart_${currentUser.email}`;
  const cart = JSON.parse(localStorage.getItem(cartKey)) || [];

  const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);

  if (totalQuantity > 0) {
    location.replace("./cart_details.html"); // Redirect to cart details page
  } else {
    alert("Cart is empty!"); // Alert if the cart is empty
  }
}



function getCurrentUser() {
  // Retrieve the current user from sessionStorage
  const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));

  // Check if a user is logged in
  if (currentUser) {
    console.log("Current User Data:", currentUser); // For debugging
    return currentUser;
  } else {
    console.log("No user is currently logged in.");
    return null;
  }
}

function logoutUser() {
  sessionStorage.removeItem("currentUser");
  window.location.href = "login.html";
}
