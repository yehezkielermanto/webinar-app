document.addEventListener("DOMContentLoaded", function () {
    const tmenu = document.getElementById("toggle-menu");
    const sidebar = document.getElementById("hmenu");
    tmenu.addEventListener("click", function () {
        sidebar.hidden = !sidebar.hidden;
    });

});
