document.addEventListener("DOMContentLoaded", function() {
    function isMobile() {
        return window.innerWidth <= 768;
    }
    // toggle advanced search button
    const toggleAdvS = document.getElementById("toggle-advs");

    toggleAdvS.addEventListener("click", function() {
        const advS = document.getElementById("as-dialog");
        if (advS.style.display === "none") {
            advS.style.display = "block";
        } else {
            advS.style.display = "none";
        }
        console.log("toggle the advanced search");
    });

    // search button
    const searchBut = document.getElementById("sbut");
    searchBut.addEventListener("click", function() {
        console.log("do search");
    });
    const prevBut = document.getElementById("prev-but");
    const currentPage = document.getElementById("current-page");
    const nextBut = document.getElementById("next-but");
    prevBut.addEventListener("click", function() {
        console.log("prev page");
    });
    nextBut.addEventListener("click", function() {
        console.log("next page");
    });

    // modify profile button
    let editMode = false;
    const email = document.getElementById("email");
    const phone = document.getElementById("phone");
    const name = document.getElementById("name");
    const instansi = document.getElementById("instansi");
    const saveEdit = document.getElementById("save-edit");
    const curEmail = email.innerText;
    const curPhone = phone.innerText;
    const curName = name.innerText;
    const curInstansi = instansi.innerText;

    const modProfile = document.getElementById("editbtn");
    modProfile.addEventListener("click", function() {
        editMode = !editMode;
        if (editMode) {
            email.innerHTML = `<input class="inp-edit-mode" type="text" value="${curEmail}">`;
            phone.innerHTML = `<input class="inp-edit-mode" type="text" value="${curPhone}">`;
            name.innerHTML = `<input  class="inp-edit-mode" type="text" value="${curName}">`;
            instansi.innerHTML = `<input class="inp-edit-mode" type="text" value="${curInstansi}">`;
            saveEdit.style.display = "block";
        } else {
            email.innerHTML = curEmail;
            phone.innerHTML = curPhone;
            name.innerHTML = curName;
            instansi.innerHTML = curInstansi;
            saveEdit.style.display = "none";
        }
    });

    // card hover effect
    const hoverEls = document.querySelectorAll(".card");
    hoverEls.forEach((hoverEl) => {
        hoverEl.addEventListener("mouseover", function () {
            if (isMobile()) {
                return;
            }
            const newEl = document.createElement("div");
            //newEl.textContent = hoverEl.textContent;
            newEl.innerHTML = hoverEl.innerHTML;
            newEl.style.position = "absolute";
            newEl.style.background = "rgba(255, 255, 255, 1)";
            newEl.style.padding = "5px";
            newEl.style.borderRadius = "12px";
            newEl.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.2)";
            newEl.style.pointerEvents = "none";
            newEl.style.width = "200px";
            document.body.appendChild(newEl);
            const moveHandler = (event) => {
                newEl.style.left = `${event.pageX + 10}px`;
                newEl.style.top = `${event.pageY + 10}px`;
            };
            document.addEventListener("mousemove", moveHandler);
            hoverEl.addEventListener("mouseout", function () {
                newEl.remove();
                document.removeEventListener("mousemove", moveHandler);
                console.log("removing");
            }, { once: true });
        });
    });
});

