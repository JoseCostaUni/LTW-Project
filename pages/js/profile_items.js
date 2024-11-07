let csrf_token = ""

document.addEventListener('DOMContentLoaded', function() {
    csrf_token = document.getElementById('csrf_token');
    const ratings = document.getElementById("ratings-link");
    ratings.addEventListener("click", hideItems);

    function hideItems(event) {
        const items = document.getElementById("items-section");
        const item_count = document.getElementById("item-count");
        items.style.display = 'none';
        item_count.style.display = 'none';

        const itemSold = document.getElementById("items-sold-section");
        const itemSold_count = document.getElementById("items-sold-count");
        itemSold.style.display = 'none';
        itemSold_count.style.display = 'none';

        const reviews = document.getElementById("reviews-section");
        const reviews_count = document.getElementById("reviews-count");
        reviews.style.display = 'flex';
        reviews_count.style.display = 'flex';

        const purchases = document.getElementById("purchases-section");
        const purchases_count = document.getElementById("purchases-count");
        purchases.style.display = 'none';
        purchases_count.style.display = 'none';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const ratings = document.getElementById("purchases-link");
    ratings.addEventListener("click", hideItems);

    function hideItems(event) {
        const items = document.getElementById("items-section");
        const item_count = document.getElementById("item-count");
        items.style.display = 'none';
        item_count.style.display = 'none';

        const itemSold = document.getElementById("items-sold-section");
        const itemSold_count = document.getElementById("items-sold-count");
        itemSold.style.display = 'none';
        itemSold_count.style.display = 'none';

        const reviews = document.getElementById("reviews-section");
        const reviews_count = document.getElementById("reviews-count");
        reviews.style.display = 'none';
        reviews_count.style.display = 'none';

        const purchases = document.getElementById("purchases-section");
        const purchases_count = document.getElementById("purchases-count");
        purchases.style.display = 'flex';
        purchases_count.style.display = 'flex';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const ratings = document.getElementById("listings-link");
    ratings.addEventListener("click", hideItems);

    function hideItems(event) {
        const items = document.getElementById("items-section");
        const item_count = document.getElementById("item-count");
        items.style.display = 'flex';
        item_count.style.display = 'flex';

        const reviews = document.getElementById("reviews-section");
        const reviews_count = document.getElementById("reviews-count");
        reviews.style.display = 'none';
        reviews_count.style.display = 'none';


        const itemSold = document.getElementById("items-sold-section");
        const itemSold_count = document.getElementById("items-sold-count");
        itemSold.style.display = 'none';
        itemSold_count.style.display = 'none';

        const purchases = document.getElementById("purchases-section");
        const purchases_count = document.getElementById("purchases-count");
        purchases.style.display = 'none';
        purchases_count.style.display = 'none';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const ratings = document.getElementById("items-sold");

    ratings.addEventListener("click", hideItems);

    function hideItems(event) {
        const items = document.getElementById("items-section");
        const item_count = document.getElementById("item-count");
        items.style.display = 'none';
        item_count.style.display = 'none';

        const reviews = document.getElementById("reviews-section");
        const reviews_count = document.getElementById("reviews-count");
        reviews.style.display = 'none';
        reviews_count.style.display = 'none';


        const itemSold = document.getElementById("items-sold-section");
        const itemSold_count = document.getElementById("items-sold-count");
        itemSold.style.display = 'flex';
        itemSold_count.style.display = 'flex';

        const purchases = document.getElementById("purchases-section");
        const purchases_count = document.getElementById("purchases-count");
        purchases.style.display = 'none';
        purchases_count.style.display = 'none';

    }
});


document.addEventListener("DOMContentLoaded", function() {
    let editProfileButton = document.getElementById("edit_profile");

    editProfileButton.addEventListener("click", function() {
        window.location.href = "editprofile.php";
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('log_out').addEventListener('click', function() {
        window.location.href = '../../db_handler/action_logout.php';
    });
});

function handleAcceptProposalClick(event) {
    let button = event.target;
    let itemId = button.getAttribute('data-item-id');
    
    let itemContainer = button.parentElement;

    let price = itemContainer.querySelector('p').textContent;

    let xhr = new XMLHttpRequest();

    xhr.open('POST', '../../db_handler/action_change_price.php', true);
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            console.log('Proposal changed:', xhr.responseText);
            location.reload();
        } else {
            console.error('Error changing proposal:', xhr.statusText);
            location.reload();
        }
    };

    xhr.send('itemId=' + encodeURIComponent(itemId)
        + '&type=' + encodeURIComponent("accept")
        + '&csrf_token=' + encodeURIComponent(csrf_token.value)
    );
}

function handleRejectProposalClick(event) {
    let button = event.target;
    let itemId = button.getAttribute('data-item-id');
    
    let itemContainer = button.parentElement;

    let price = itemContainer.querySelector('p').textContent;

    let xhr = new XMLHttpRequest();

    xhr.open('POST', '../../db_handler/action_change_price.php', true);
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            console.log('Proposal changed:', xhr.responseText);
            location.reload();
        } else {
            console.error('Error changing proposal:', xhr.statusText);
            location.reload();
            
        }
    };

    xhr.send('itemId=' + encodeURIComponent(itemId)
        + '&type=' + encodeURIComponent("reject")
        + '&csrf_token=' + encodeURIComponent(csrf_token.value)
    );

}

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('accept-proposal')) {
        handleAcceptProposalClick(event);
    }

    if(event.target.classList.contains('reject-proposal')) {
        handleRejectProposalClick(event);
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const allItems = document.querySelectorAll('.item');

    allItems.forEach(item => {
        item.addEventListener('click', function() {
            let itemImage = item.querySelector('img');
            let imageHref = itemImage.getAttribute('src');
            let itemId = parseInt(imageHref.split('/').pop().split('-')[0]);
            window.location.href = 'itemPageUserProfile.php?item=' + itemId;
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const viewOrderButton = document.querySelectorAll(".view-order");
    viewOrderButton.forEach(order => {
        order.addEventListener('click', function() {
            const orderId = order.getAttribute('data-order-id');
            window.location.href = 'shipping_form.php?order=' + orderId;
        });
    });
});
