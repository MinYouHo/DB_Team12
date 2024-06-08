/*!
* Start Bootstrap - Modern Business v5.0.7 (https://startbootstrap.com/template-overviews/modern-business)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-modern-business/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project
document.getElementById('navbarDropdown').addEventListener('click', function(event) {
    event.preventDefault();
    var loginRegisterForm = document.getElementById('login-register-form');
    if (loginRegisterForm.style.display === 'none' || loginRegisterForm.style.display === '') {
        loginRegisterForm.style.display = 'block';
    } else {
        loginRegisterForm.style.display = 'none';
    }
});
