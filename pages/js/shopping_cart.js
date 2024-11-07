let csrf_token = "";

document.addEventListener('DOMContentLoaded', function () {
    csrf_token = document.getElementById("csrf_token");
    const removeButtons = document.querySelectorAll('.Remove_cart');

    removeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const itemId = button.getAttribute('data-item-id');
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../db_handler/action_remove_cart.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const itemElement = button.closest('.item');
                    itemElement.remove();
                    UpdatePrice();
                    
                } else {
                    console.error('Erro ao remover item do carrinho');
                }
            };

            xhr.send('itemId=' + encodeURIComponent(itemId)
            + '&csrf_token=' + encodeURIComponent(csrf_token.value));

        });
    });

    UpdatePrice();

    const shippingSelect = document.querySelector('.shipping select');
    const paymentSelect = document.querySelector('.payment-method select');

    shippingSelect.addEventListener('change', function () {
        UpdatePrice();
    });
    
    paymentSelect.addEventListener('change', function () {
        UpdatePrice();
    });

    const checkoutButton = document.querySelector('.checkout-button');
    checkoutButton.addEventListener('click', function () {

        let shoppingItems = document.querySelectorAll('.item');

        let shoppingItemIds = [];

        shoppingItems.forEach(function(item) {
            let itemId = item.querySelector('.Remove_cart').getAttribute('data-item-id');
            shoppingItemIds.push(itemId);
        });

        const shippingMethod = document.querySelector('.shipping select').value;

        const paymentMethod = document.querySelector('.payment-method select').value;

        const totalPrice = document.querySelector('.total-price-value').textContent.replace(/.$/,"");

        let json_itemIds = JSON.stringify(shoppingItemIds);

        let formData = new FormData();

        formData.append("paymentMethod",paymentMethod);
        formData.append("shippingMethod",shippingMethod);
        formData.append("totalPrice",totalPrice);
        formData.append("jsonItemIds",json_itemIds);
        formData.append("csrf_token", csrf_token.value);
    
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../db_handler/action_checkout.php', true);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                console.log('Checkout successful');
                window.location.href = '../pages/loader.php';
            } else {
                console.error('Error during checkout');
            }
        };

        xhr.send(formData);
    });
    
});

function UpdatePrice() {
    let itemPrices = document.querySelectorAll('.item p');
    let totalPrice = 0;
    UpdateItemCount();

    itemPrices.forEach(function(price) {
        let priceValue = parseFloat(price.textContent.replace('Price: ', '').replace('€', ''));
        totalPrice += priceValue;
    });

    let itemIds = [];
    let removeButtons = document.querySelectorAll('.Remove_cart');
    removeButtons.forEach(function(button) {
        let itemId = button.getAttribute('data-item-id');
        itemIds.push(itemId);
    });

    let totalItemPriceElement = document.querySelector('.total-item-price-value');
    totalItemPriceElement.textContent = totalPrice.toFixed(2) + '€';

    const shippingMethod = document.querySelector('.shipping select').value;

    const paymentMethod = document.querySelector('.payment-method select').value;

    if(itemIds.length != 0){
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../../db_handler/action_get_locations.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                let distances = JSON.parse(xhr.responseText);

                console.log(distances);

                let totalDistanceCost = 0;

                distances.forEach(function(distance) {
                    totalDistanceCost += distance * 0.01 * calculateShippingPrice(shippingMethod);

                totalPrice += totalDistanceCost;

                if(itemPrices.length != 0){
                    totalPrice += calculatePaymentMethodPrice(paymentMethod);
                }
            
                let totalPriceElement = document.querySelector('.total-price-value');
                totalPriceElement.textContent = totalPrice.toFixed(2) + '€';    
                    
                });

            } else {
                console.error('Error getting locations');
            }
        };

        xhr.send('itemIds=' + JSON.stringify(itemIds)
        + '&csrf_token=' + encodeURIComponent(csrf_token.value));
    }
}

function UpdateItemCount(){
    let itemCount = document.querySelectorAll('.item').length;
    let itemCountElement = document.querySelector('.item-count-value');
    itemCountElement.textContent = itemCount;
}


function calculateShippingPrice(method) {
    switch(method) {
        case 'standard':
            return 5.00;
        case 'express':
            return 10.00;
        case 'next-day':
            return 15.00;
        case 'international':
            return 20.00;
        default:
            return 0;
    }
}

function calculatePaymentMethodPrice(method) {
    switch(method) {
        case 'credit-card':
            return 0.50;
        case 'paypal':
            return 0.75;
        case 'apple-pay':
            return 0.60;
        case 'mb-way':
            return 0.40;
        default:
            return 0;
    }
}