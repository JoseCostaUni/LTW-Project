setTimeout(function() {
    let loaderMessage = document.querySelector('.loader-message');
    loaderMessage.textContent = "Creating shipping form reference";
}, 3000);

setTimeout(function() {
    let loaderMessage = document.querySelector('.loader-message');
    loaderMessage.textContent = "All done";
}, 8000);

setTimeout(function() {
    window.location.href = "../pages/homepage.php";
}, 10000);