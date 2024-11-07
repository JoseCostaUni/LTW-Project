let csrf_token = "";

document.addEventListener('DOMContentLoaded', function () {
    let cartItems = [];
    csrf_token = document.getElementById("csrf_token");

    function fetchItemsAndUpdateCart() {
        console.log('Fetching items and updating cart...');
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../../db_handler/action_get_all_cart_items.php', true);

        xhr.onload = function () {
            console.log('XHR onload function triggered.');
            if (xhr.status >= 200 && xhr.status < 300) {
                console.log('XHR status is successful:', xhr.status);
                let cartResult = JSON.parse(xhr.responseText);
                console.log('Cart Result:', cartResult);
                cartResult.forEach(function(item) {
                    let itemElement = document.querySelector('.fa-cart-shopping[data-item-id="' + item + '"]');
                    if (itemElement && !cartItems.includes(parseInt(item))) {
                        itemElement.classList.remove('fa-cart-shopping');
                        itemElement.classList.add('fa-check');
                        cartItems.push(parseInt(item));
                    }
                });
                console.log('Cart Items after update:', cartItems);
                addToCart();
            } else {
                console.error('Error fetching items:', xhr.status);
            }
        };

        xhr.onerror = function () {
            console.error('Error fetching items: Network error.');
        };

        xhr.send();
    }

    function addToCart() {
        console.log('Adding click event listeners to cart items...');
        let cartIcon = document.querySelectorAll('.fa-cart-shopping');
        let checkIcon = document.querySelectorAll('.fa-check');


        cartIcon.forEach(function (cart) {
            cart.addEventListener('click', function () {
                let itemId = cart.getAttribute('data-item-id');
                console.log('Clicked item ID:', itemId);
                let isInCart = cartItems.includes(parseInt(itemId));


                const xhr = new XMLHttpRequest();
                xhr.open('POST', isInCart ? '../../db_handler/action_remove_cart.php' : '../../db_handler/action_add_shoppingcart.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        let response = JSON.parse(xhr.responseText);
                        let updatedCartItems = response.shoppingcartitems;
                        console.log('Updated Cart Items:', updatedCartItems);
                        if (updatedCartItems.includes(parseInt(itemId))) {
                            cart.classList.remove('fa-cart-shopping');
                            cart.classList.add('fa-check');
                            if (!cartItems.includes(parseInt(itemId))) {
                                cartItems.push(parseInt(itemId));
                            }
                        } else {
                            cart.classList.add('fa-cart-shopping');
                            cart.classList.remove('fa-check');
                            cartItems = cartItems.filter(item => item !== parseInt(itemId));
                        }
                        console.log('Updated Cart Items:', cartItems);
                    } else {
                        console.error('Error adding/removing item from cart:', xhr.status);
                    }
                };

                xhr.onerror = function () {
                    console.error('Error adding/removing item from cart: Network error.');
                };

                xhr.send('itemId=' + encodeURIComponent(itemId)
                + '&csrf_token=' + encodeURIComponent(csrf_token.value));
            });
        });
        checkIcon.forEach(function (cart) {
            cart.addEventListener('click', function () {
                let itemId = cart.getAttribute('data-item-id');
                console.log('Clicked item ID:', itemId);
                let isInCart = cartItems.includes(parseInt(itemId));


                const xhr = new XMLHttpRequest();
                xhr.open('POST', isInCart ? '../../db_handler/action_remove_cart.php' : '../../db_handler/action_add_shoppingcart.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        let response = JSON.parse(xhr.responseText);
                        let updatedCartItems = response.shoppingcartitems;
                        console.log('Updated Cart Items:', updatedCartItems);
                        if (updatedCartItems.includes(parseInt(itemId))) {
                            cart.classList.remove('fa-cart-shopping');
                            cart.classList.add('fa-check');
                            if (!cartItems.includes(parseInt(itemId))) {
                                cartItems.push(parseInt(itemId));
                            }
                        } else {
                            cart.classList.add('fa-cart-shopping');
                            cart.classList.remove('fa-check');
                            cartItems = cartItems.filter(item => item !== parseInt(itemId));
                        }
                        console.log('Updated Cart Items:', cartItems);
                    } else {
                        console.error('Error adding/removing item from cart:', xhr.status);
                    }
                };

                xhr.onerror = function () {
                    console.error('Error adding/removing item from cart: Network error.');
                };

                xhr.send('itemId=' + encodeURIComponent(itemId)
                + '&csrf_token=' + encodeURIComponent(csrf_token.value));
            });
        });
    }

    function initWishlistActions() {
        console.log('Initializing wishlist actions...');
        let removeWishlist = document.querySelectorAll('.fa-heart');

        removeWishlist.forEach(function (icon) {
            icon.addEventListener('click', function () {
                const itemId = icon.getAttribute('data-item-id');

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../../db_handler/action_remove_wishlist.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        const itemElement = icon.closest('.item');
                        itemElement.remove();
                    } else {
                        console.error('Error removing item from wishlist:', xhr.status);
                    }
                };

                xhr.onerror = function () {
                    console.error('Error removing item from wishlist: Network error.');
                };

                xhr.send('itemId=' + encodeURIComponent(itemId)
                + '&csrf_token=' + encodeURIComponent(csrf_token.value));
            });
        });
    }

    function sorting() {
        console.log('Sorting wishlist items...');
        const sortingSelect = document.getElementById('sorting');

        sortingSelect.addEventListener('change', function() {
            const sortBy = this.value;

            console.log('Sorting By:', sortBy);

            const wishlistItems = document.querySelectorAll('.item');
            const wishlistItemsArray = Array.from(wishlistItems);

            const compareItems = (a, b) => {
                const nameA = a.querySelector('.item_descriptors h3').textContent.toLowerCase();
                const nameB = b.querySelector('.item_descriptors h3').textContent.toLowerCase();
                const priceTextA = a.querySelector('.item_descriptors p:nth-of-type(1)').textContent.replace('Price: $', '').replace(/[^0-9.-]+/g, '');
                const priceTextB = b.querySelector('.item_descriptors p:nth-of-type(1)').textContent.replace('Price: $', '').replace(/[^0-9.-]+/g, '');
                const priceA = parseFloat(priceTextA);
                const priceB = parseFloat(priceTextB);

                switch (sortBy) {
                    case 'alphabetical':
                        return nameA.localeCompare(nameB);
                    case 'price-low-to-high':
                        return priceA - priceB;
                    case 'price-high-to-low':
                        return priceB - priceA;
                    default:
                        return 0;
                }
            };

            wishlistItemsArray.sort(compareItems);

            const wishlistContainer = document.querySelector('.wishlist-items');
            wishlistContainer.innerHTML =
            wishlistContainer.innerHTML = '';
            wishlistItemsArray.forEach(item => wishlistContainer.appendChild(item));

            console.log('Wishlist Items after sorting:', wishlistItemsArray);
        });
    }

    console.log('Starting initialization...');
    fetchItemsAndUpdateCart();
    initWishlistActions();
    sorting();
});
