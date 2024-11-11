"use strict";

document.addEventListener("DOMContentLoaded", function () {
    const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));
    const isLoginPage = window.location.pathname.includes("login.html");

    // If no user is logged in and not on the login page, redirect to login
    if (!currentUser && !isLoginPage) {
        window.location.href = "./login.html";
    }
    // If a user is logged in and on the login page, redirect to the homepage
    else if (currentUser && isLoginPage) {
        window.location.href = "./index.html"; // Replace with your home page URL
    }
});
