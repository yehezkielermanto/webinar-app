document.addEventListener("DOMContentLoaded", function () {
    const tmenu = document.getElementById("toggle-menu");
    const sidebar = document.getElementById("hmenu");
    tmenu.addEventListener("click", function () {
        sidebar.hidden = !sidebar.hidden;
    });

});

async function downcert(filename, event_id) {
    try {
        const response = await fetch(`/webinar-app/donwload-certificate.php?l=${filename}&e=${event_id}`);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
    } catch (error) {
        console.error("Error fetching data:", error);
        return null;
    }
}
