"use strict";

document.getElementById("loginForm").addEventListener("submit", function (event) {
    event.preventDefault();

    // Clear previous error messages
    document.getElementById("emailError").textContent = "";
    document.getElementById("passwordError").textContent = "";

    // Get the input values
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    let valid = true;

    // Validate email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email) {
        document.getElementById("emailError").textContent = "Email is required.";
        document.getElementById("emailError").style.color = "red";
        valid = false;
    } else if (!emailPattern.test(email)) {
        document.getElementById("emailError").textContent = "Please enter a valid email address.";
        document.getElementById("emailError").style.color = "red";
        valid = false;
    }

    // Validate password
    if (!password) {
        document.getElementById("passwordError").textContent = "Password is required.";
        document.getElementById("passwordError").style.color = "red";
        valid = false;
    }

    if (valid) {
        document.getElementById("loginForm").submit(); // Submit the form programmatically
    }
});
