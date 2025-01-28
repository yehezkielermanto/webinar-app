var jsonData = [];
var editableData = [];

document.addEventListener("DOMContentLoaded", function () {
    async function fetchCard() {
        try {
            const response = await fetch("/profile/get-particaped-event.php");
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json(); // Parse JSON from the response
            return data; // Return the JSON object
        } catch (error) {
            console.error("Error fetching data:", error);
            return null;
        }
    }

    //function filter_event(filter) {
    //    editableData = [];
    //    for (let i = 0; i < jsonData.length; i++) {
    //        const current = jsonData[i];
    //        const fStartTime = parseInt(filter.before.replace(/-/g, ""), 10);
    //        const fEndTime = parseInt(filter.after.replace(/-/g, ""), 10);
    //        if (current.title.toLowerCase().includes(filter.query.toLowerCase()) ||
    //            current.speaker.toLowerCase().includes(filter.query.toLowerCase()) ||
    //            current.description.toLowerCase().includes(filter.query.toLowerCase())
    //        ) {
    //            const eventDate = parseInt(current.date.replace(/-/g, ""), 10);
    //            let addCurrentEvent = false;
    //
    //            if (!isNaN(fStartTime) && fStartTime <= eventDate) {
    //                addCurrentEvent = true;
    //            }
    //            if (!isNaN(fEndTime) && fEndTime >= eventDate) {
    //                addCurrentEvent = true;
    //            }
    //
    //
    //            if (addCurrentEvent) {
    //                editableData.push(current);
    //            }
    //        }
    //    }
    //    const cContainer = document.getElementById("c-container");
    //    cContainer.innerHTML = "";
    //    renderCard(editableData);
    //}
    function filter_event(filter) {
        editableData = [];
        for (let i = 0; i < jsonData.length; i++) {
            const current = jsonData[i];
            const fStartTime = parseInt(filter.before?.replace(/-/g, ""), 10);
            const fEndTime = parseInt(filter.after?.replace(/-/g, ""), 10);
            const eventDate = parseInt(current.date.replace(/-/g, ""), 10);

            if (
                current.title.toLowerCase().includes(filter.query.toLowerCase()) ||
                    current.speaker.toLowerCase().includes(filter.query.toLowerCase()) ||
                    current.description.toLowerCase().includes(filter.query.toLowerCase())
            ) {
                const isWithinRange =
                    (isNaN(fStartTime) || fStartTime <= eventDate) &&
                        (isNaN(fEndTime) || fEndTime >= eventDate);

                if (isWithinRange) {
                    editableData.push(current);
                }
            }
        }

        const cContainer = document.getElementById("c-container");
        cContainer.innerHTML = "";
        renderCard(editableData);
    }


    function renderCard(data) {
        const cContainer = document.getElementById("c-container");
        for (let i = 0; i < data.length; i++) {
            const card = data[i];
            cContainer.innerHTML += `
                <div class="card">
                <div class="card-upper">
                <div class="wimg-container">
                <img class="responsive-image2" src="${card.poster_url}"/>
                </div>
                </div>
                <div class="card-bottom">
                <p class="m-f bold-f mb-5 mb-0">${card.title}</p>
                <p class="s-f mb-0">${card.date}</p>
                <p class="s-f mb-0">${card.speaker}</p>
                <div class="card-status">
                <p class="xs-f">${card.event_role}</p>
                </div>
                </div>
                </div>
                `;
        }

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
                hoverEl.addEventListener(
                    "mouseout",
                    function () {
                        newEl.remove();
                        document.removeEventListener("mousemove", moveHandler);
                        console.log("removing");
                    },
                    { once: true },
                );
            });
        });
    }

    async function createCard() {
        jsonData = await fetchCard();
        if (jsonData) {
            renderCard(jsonData);
        } else {
            console.log("No data fetched or an error occurred.");
        }
    }

    function isMobile() {
        return window.innerWidth <= 768;
    }
    // toggle advanced search button
    const toggleAdvS = document.getElementById("toggle-advs");

    toggleAdvS.addEventListener("click", function () {
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
    const sBar = document.getElementById("search");
    const beforeDate = document.getElementById("before");
    const afterDate = document.getElementById("after");
    searchBut.addEventListener("click", function () {
        const sort = document.querySelector('input[name="sort"]:checked').value;
        const sortBy = document.querySelector('input[name="sortby"]:checked').value;
        const filter = {
            query : sBar.value,
            before: beforeDate.value,
            after: afterDate.value, 
            sortwith: sort,
            sortby: sortBy,
        };
        filter_event(filter);
    });
    const prevBut = document.getElementById("prev-but");
    // TODO add pagination support.
    const currentPage = document.getElementById("current-page");
    const nextBut = document.getElementById("next-but");
    prevBut.addEventListener("click", function () {
        console.log("prev page");
    });
    nextBut.addEventListener("click", function () {
        console.log("next page");
    });

    // modify profile button
    let editMode = false;
    const email = document.getElementById("email");
    const phone = document.getElementById("phone");
    const name = document.getElementById("name");
    const address = document.getElementById("address");
    const instansi = document.getElementById("instansi");
    const saveEdit = document.getElementById("save-edit");
    const curEmail = email.innerText;
    const curPhone = phone.innerText;
    const curName = name.innerText;
    const curInstansi = instansi.innerText;
    const curAddress = address.innerText;

    const modProfile = document.getElementById("editbtn");
    modProfile.addEventListener("click", function () {
        editMode = !editMode;
        if (editMode) {
            //email.innerHTML = `<input id="email" class="inp-edit-mode" type="text" value="${curEmail}">`;
            phone.innerHTML = `<input id="ed-phone" class="inp-edit-mode" type="text" value="${curPhone}">`;
            name.innerHTML = `<input  id="ed-name" class="inp-edit-mode" type="text" value="${curName}">`;
            instansi.innerHTML = `<input id="ed-inst" class="inp-edit-mode" type="text" value="${curInstansi}">`;
            address.innerHTML = `<input id="ed-addr" class="inp-edit-mode" type="text" value="${curAddress}">`;
            saveEdit.style.display = "block";
        } else {
            email.innerHTML = curEmail;
            phone.innerHTML = curPhone;
            name.innerHTML = curName;
            instansi.innerHTML = curInstansi;
            address.innerText = curAddress;
            saveEdit.style.display = "none";
        }
    });

    // save change
    saveEdit.addEventListener("click", function () {
        const newPhone = document.getElementById("ed-phone").value;
        const newName = document.getElementById("ed-name").value;
        const newInstansi = document.getElementById("ed-inst").value;
        const newAddress = document.getElementById("ed-addr").value;

        // Create a form dynamically
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "/profile/ubah-profile.php";

        // Add input fields to the form
        const emailInput = document.createElement("input");
        emailInput.type = "hidden";
        emailInput.name = "email";
        emailInput.value = curEmail;
        form.appendChild(emailInput);
        const phoneInput = document.createElement("input");
        phoneInput.type = "hidden";
        phoneInput.name = "phone";
        phoneInput.value = newPhone;
        form.appendChild(phoneInput);
        const nameInput = document.createElement("input");
        nameInput.type = "hidden";
        nameInput.name = "name";
        nameInput.value = newName;
        form.appendChild(nameInput);
        const instansiInput = document.createElement("input");
        instansiInput.type = "hidden";
        instansiInput.name = "instansi";
        instansiInput.value = newInstansi;
        form.appendChild(instansiInput);
        const addressInput = document.createElement("input");
        addressInput.type = "hidden";
        addressInput.name = "alamat";
        addressInput.value = newAddress;
        form.appendChild(addressInput);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    });

    // logout
    const logoutBut = document.getElementById("logoutbtn");
    logoutBut.addEventListener("click", function () {
        window.location.href = "/logout.php";
    });

    // hamburg menu
    const hamburgBtn = document.getElementById("toggle-menu");
    const sidebar = document.getElementById("hmenu");
    hamburgBtn.addEventListener("click", function() {
        console.log("hello");
        sidebar.hidden = !sidebar.hidden;
    });
    createCard();
});
