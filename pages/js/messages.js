let senderId;
let itemId;
let csrf_token;

function sanitizeInput(input) {
    return DOMPurify.sanitize(input);
}

setInterval(function() {fetchMessagesFromSender(senderId);}, 5000);


function displayMessages(messages) {
    let messagesContainer = document.querySelector('.user-messages');
    messagesContainer.innerHTML = '';

    messages.forEach(function(message) {
        let messageDiv = document.createElement('div');

        let receiverId = message.receiver.Id;
        let senderId2 = message.sender.Id;
        let messageText = message.text;
        let timestamp = message.timestamp;

        if(receiverId == senderId){
            messageDiv.classList.add('message-sent');
        }else{
            messageDiv.classList.add('message-received');
        }

        let messageHTML = `
            <h5><img src="../assets/users/${senderId2}.png"> @${message.sender.Username}</h5>
            <div class="message-content">${messageText}</div>
            <div class="message-timestamp">${timestamp}</div>
        `;

        messageDiv.innerHTML = messageHTML;

        messagesContainer.appendChild(messageDiv);
    });

    scrollToBottom();
}

document.addEventListener("DOMContentLoaded", function() {
    csrf_token = document.getElementById("csrf_token");
    let users = document.querySelectorAll('.user-box');
    users.forEach(function(user) {
        user.addEventListener('click', function() {
            senderId = user.getAttribute('data-user-id');
            itemId = user.getAttribute('data-item-id');
            fetchMessagesFromSender(senderId);
        });
    });
});

function fetchMessagesFromSender(senderId) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../../db_handler/fetch_messages.php?senderId=' + senderId + '&itemId=' + itemId, true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            let messages = JSON.parse(xhr.responseText);
            displayMessages(messages);
        }
    };
    xhr.send();
}

document.addEventListener("DOMContentLoaded", function(){
    const messageForm = document.querySelector('.text-box');
    messageForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const messageInput = document.getElementById('user-message-input').value;

        sanitizeInput(messageInput);

        if (messageInput.trim() === '') {
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../db_handler/action_send_message.php', true);

        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                console.log(xhr.responseText);
            }
        };
        xhr.send('message=' + encodeURIComponent(messageInput)
        + '&receiverId=' + encodeURIComponent(senderId)
        + '&itemId=' + encodeURIComponent(itemId)
        + '&csrf_token=' + encodeURIComponent(csrf_token.value));

        const userMessageInput = document.getElementById('user-message-input');

        userMessageInput.value = "";

        fetchMessagesFromSender(senderId);

    });

});

function scrollToBottom() {
    let scrollToBottom = document.querySelector(".user-messages");
    scrollToBottom.scrollTop = scrollToBottom.scrollHeight;
}


function fetchSideMessages() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '../../db_handler/fetch_side_messages.php?' ,true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            let messages = JSON.parse(xhr.responseText);
            displaySideMessages(messages);
        }
    };
    xhr.send();
}

function displaySideMessages(messages) {
    let messagesContainer = document.querySelector('.user-messages');

    messages.forEach(function(message) {
        let sender = message.sender;
        let item = message.itemId;

        let messageDiv = document.createElement('div');
        messageDiv.classList.add('user-box');
        messageDiv.setAttribute('data-user-id', sender.id);
        messageDiv.setAttribute('data-item-id', item.id);

        let userContainer = document.createElement('div');
        userContainer.classList.add('user-container');

        let userImage = document.createElement('img');
        userImage.src = `../assets/users/${sender.id}.png`;
        userImage.alt = sender.username;
        userImage.id = 'user_image';

        let itemImage = document.createElement('img');
        itemImage.src = `../assets/items/${item.id}-1.png`;
        itemImage.alt = item.name;
        itemImage.id = 'item_image';

        let itemName = document.createElement('h4');
        itemName.textContent = item.name;

        let timestamp = document.createElement('h4');
        timestamp.textContent = message.timestamp;

        userContainer.appendChild(userImage);
        userContainer.appendChild(itemImage);
        userContainer.appendChild(itemName);
        userContainer.appendChild(timestamp);

        messageDiv.appendChild(userContainer);

        messagesContainer.appendChild(messageDiv);
    });

    scrollToBottom();
}

