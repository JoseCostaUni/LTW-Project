let phone_number_value_save = "";
let email_value_save = "";
let isContentHiddenEmail = true;
let isContentHiddenPassword = true;
let csrf_token = "";

function sanitizeInput(input) {
    return DOMPurify.sanitize(input);
}

function toggleHeartColor(wishlistItems) {
    let heartIcons = document.querySelectorAll('.fa-heart');

    heartIcons.forEach(function (icon) {
        icon.addEventListener('click', function () {
            let itemId = icon.getAttribute('data-item-id');

            let isInWishlist = wishlistItems.includes(parseInt(itemId)); 
            console.log(isInWishlist)
            const xhr = new XMLHttpRequest();

            xhr.open('POST', isInWishlist ? '../../db_handler/action_remove_wishlist.php' : '../../db_handler/action_add_wishlist.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    console.log(xhr.responseText);
            
                    let response = JSON.parse(xhr.responseText);
                    console.log(response);
                    let updatedWishlistItems = response.wishlistItems;
            
                    wishlistItems = updatedWishlistItems;
                    console.log(wishlistItems);
                    if (updatedWishlistItems.includes(parseInt(itemId))) {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                        if (!wishlistItems.includes(parseInt(itemId))) {
                            wishlistItems.push(parseInt(itemId));
                        }
                    }  else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                    }
            
                    console.log(`Item ${itemId} toggled`);
                }
            };
            
            

            xhr.send('itemId=' + encodeURIComponent(itemId) + '&csrf_token=' + encodeURIComponent(csrf_token.value));
        });
    });
}
function fetchItemsAndUpdateHearts(wishlistItems) {
    const xhr = new XMLHttpRequest();
    
    xhr.open('GET', '../../db_handler/action_get_all_wishlisted_items.php', true);
    
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            let wishlistItemsResult = JSON.parse(xhr.responseText);
            
            
            wishlistItemsResult.forEach(function(item) {
                let itemElement = document.querySelector('.fa-heart[data-item-id="' + item + '"]');
                if (itemElement && !wishlistItems.includes(itemElement)) {
                    itemElement.classList.remove('fa-regular');
                    itemElement.classList.add('fa-solid');
                    wishlistItems.push(parseInt(item));
                }
            });

            toggleHeartColor(wishlistItems);
        }
    };

    xhr.send();
}

document.addEventListener("DOMContentLoaded", function () {
    let wishlistItems = [];
    fetchItemsAndUpdateHearts(wishlistItems);
    csrf_token = document.getElementById("csrf_token");
});


document.addEventListener('DOMContentLoaded', function() {
    const prevButton = document.getElementById("prev-image");
    const nextButton = document.getElementById("next-image");
    let currentImageIndex = 1; 

    const itemImage = document.getElementById("item_image");

    id_plus_numberOfphotos = itemImage.className;

    const itemId = itemImage.className.split("-")[0];
    const numberOfPhotos = id_plus_numberOfphotos.split("-")[1];

    console.log(itemId);
    console.log(numberOfPhotos);    
    
    const messageButton = document.getElementById('message_button');
    // Function to toggle heart icon
    function toggleHeart(icon) {
        icon.classList.toggle("fa-heart");
        icon.classList.toggle("fa-heart-filled");
    }

    messageButton.addEventListener('click', function() {
        this.classList.add('clicked');
        
        setTimeout(() => {
            this.classList.remove('clicked');
        }, 100); 
    });

    for (let i = 1; i <= numberOfPhotos; i++) {
        const previewImages = document.getElementsByClassName(`prev-image${i}`);
        console.log(previewImages);
        Array.from(previewImages).forEach(function(previewImage) {
            previewImage.addEventListener('click', function() {
                const imageId = parseInt(this.classList[0].replace("prev-image", ""));
                currentImageIndex = imageId;
                updateImage();
            });
        });
    }

    prevButton.addEventListener("click", function() {
        if (currentImageIndex > 1) {
            currentImageIndex--;
            updateImage();
        }else if(currentImageIndex-1 == 0){
            currentImageIndex = numberOfPhotos;
            updateImage();
        }
    });

    
    nextButton.addEventListener("click", function() {
        if (currentImageIndex < numberOfPhotos) { 
            currentImageIndex++;
            updateImage();
        }else if(currentImageIndex == numberOfPhotos){
            currentImageIndex = 1;
            updateImage();
        }
    });

    
    function updateImage() {
        const itemImage = document.getElementById("item_image");
        itemImage.src = `../assets/items/${itemId}-${currentImageIndex}.png`;
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var phone_number_value = document.getElementById('user_phonenumber');
    var email_value = document.getElementById('user_email');

    phone_number_value_save = phone_number_value.textContent;
    email_value_save = email_value.textContent;
    phone_number_value.textContent = "*".repeat(phone_number_value_save.length);
    email_value.textContent = "*".repeat(email_value_save.length);
});

document.addEventListener('DOMContentLoaded', function() {
    const reveal_button = document.getElementById("reveal-num-button");
    reveal_button.addEventListener("click", toggleContent);

    function toggleContent(event) {
        const phone_number = document.getElementById("user_phonenumber");
        if (isContentHiddenPassword) {
            phone_number.textContent = phone_number_value_save;
            reveal_button.textContent = "Hide Number";
        } else {
            phone_number.textContent = "*".repeat(phone_number_value_save.length);
            reveal_button.textContent = "Reveal Number";
        }
        isContentHiddenPassword = !isContentHiddenPassword;
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const reveal_button = document.getElementById("message_button");
    reveal_button.addEventListener("click", sendMessage);

    function sendMessage() {
        const user_info = document.getElementById("user_info");
        const itemImage = document.getElementById("item_image");
        id_plus_numberOfphotos = itemImage.className;
        const itemId = itemImage.className.split("-")[0];
        let receiverId = user_info.getAttribute('data-user-id');
        console.log(itemId);
        console.log(receiverId);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../db_handler/send_message_item.php', true);

        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                console.log(xhr.responseText);
                window.location.href = "../pages/messages.php";
            }
        };
        xhr.send('receiverId=' + encodeURIComponent(receiverId)
        + '&itemId=' + encodeURIComponent(itemId)
        + '&csrf_token=' + encodeURIComponent(csrf_token.value));
    }
});




/*
const prevPageBtn = document.getElementById("prevPage");
    const nextPageBtn = document.getElementById("nextPage");

    const itemsPerPage = 5;
    let currentPage = 1;

    function displayItems() {
        const items = document.querySelectorAll('.item');
        items.forEach((item, index) => {
            if (index >= (currentPage - 1) * itemsPerPage && index < currentPage * itemsPerPage) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    prevPageBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            displayItems();
        }
    });

    nextPageBtn.addEventListener('click', function() {
        const totalItems = document.querySelectorAll('.item').length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayItems();
        }
    });

    displayItems();
    */


document.addEventListener('DOMContentLoaded', function () {
    const checkoutBtn = document.getElementById('checkoutBtn');
    const cartIcon = document.getElementById('cartIcon');

    checkoutBtn.addEventListener('click', function () {
        checkoutBtn.innerHTML = 'View Cart';
    })
}); 

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("reviewForm").addEventListener("submit", function(event) {
        event.preventDefault();

        function sanitizeInput(input) {
            let div = document.createElement('div');
            div.appendChild(document.createTextNode(input));
            return div.innerHTML;
        }

        let formData = new FormData(this);
        for (let [key, value] of formData.entries()) {
            formData.set(key, sanitizeInput(value));
        }
        formData.append("csrf_token", csrf_token.value);
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "../../db_handler/action_send_review.php", true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                alert(xhr.responseText);
            } else {
                alert("An error occurred while processing your review.");
            }
        };
        xhr.send(formData);
    });
});

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("propose_button").addEventListener("click", function() {
        submitProposal();
    });
});




function submitProposal() {
    let proposalInput = document.getElementById("item_proposal").value;
    let regex = /^\d+(\.\d{1,2})?$/;
    let itemId = document.getElementById("item_image").className.split("-")[0];

    if (!regex.test(proposalInput)) {
        alert("Invalid proposal. Please enter a valid number.");
        document.getElementById("item_proposal").value = "";
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../db_handler/action_propose_item_new_price.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            document.getElementById('item_proposal').style.display = 'none';
            document.getElementById('propose_button').style.display = 'none';
            let successMessage = document.createElement('p');
            successMessage.textContent = 'Proposal sent successfully';
            document.getElementById("button_proposal_container").prepend(successMessage);
        }
    };
    xhr.send("proposal=" + encodeURIComponent(proposalInput)
    + '&itemId=' + encodeURIComponent(itemId)
    + '&csrf_token=' + encodeURIComponent(csrf_token.value)
);
}
