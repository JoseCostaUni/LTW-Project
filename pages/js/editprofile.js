document.addEventListener('DOMContentLoaded', function() {
    const reveal_button = document.getElementById("profile-picture");
    reveal_button.addEventListener("change", previewAndUploadImage);
});

function previewAndUploadImage(event) {
    let file = event.target.files[0];
    let formData = new FormData();
    let csrf_token = document.getElementById("csrf_token");
    formData.append('profile_image', file);
    formData.append('csrf_token', csrf_token.value);

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../../db_handler/upload_image.php');
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            let imageUrl = xhr.responseText + '?' + Math.random();
            document.getElementById('profile-image').src = imageUrl;
        } else {
            console.error(xhr.responseText);
        }
    };
    xhr.send(formData);
}
