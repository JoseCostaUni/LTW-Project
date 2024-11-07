
document.addEventListener("DOMContentLoaded", function() {

    const logoutLinks = document.getElementById('logout1');
    
    logoutLinks.addEventListener('click', function(event) {
            event.preventDefault(); 
            window.location.href = '../../db_handler/action_enter_another_account.php';
        });
    
    const logoutLinks2 = document.getElementById('exit1');
    logoutLinks2.addEventListener('click', function(event) {
            event.preventDefault(); 
            window.location.href = '../../db_handler/action_exit.php';
        });
});