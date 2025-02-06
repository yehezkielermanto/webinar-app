document.addEventListener("DOMContentLoaded", function () {
    const tmenu = document.getElementById("toggle-menu");
    const sidebar = document.getElementById("hmenu");
    tmenu.addEventListener("click", function () {
        sidebar.hidden = !sidebar.hidden;
    });

    const notifMenu = document.getElementById("toggle-notif");
    const theMenu = document.getElementById("notif-menu");
    notifMenu.addEventListener("click", function() {
        theMenu.hidden = !theMenu.hidden;
    });
});
