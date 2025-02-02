var jsonData = [];
var editableData = [];
var current_sort = "title";
var current_sby = "DESC";
var page = 1;
var display = 2;

document.addEventListener("DOMContentLoaded", function () {
    async function fetchCard() {
        try {
            const response = await fetch(`/profile/get-particaped-event.php?sortwith=${current_sby}&sortby=${current_sort}&inc-feedback=0`);
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
    async function filter_event(filter) {
        editableData = [];
        if (filter.length <= 0) {
            const cContainer = document.getElementById("c-container");
            cContainer.innerHTML = "";
            renderCard(jsonData);
            return;
        }

        if (filter.sortwith !== current_sort ||
            filter.sortby !== current_sby) {
            current_sby = filter.sortwith;
            current_sort = filter.sortby;
            jsonData = await fetchCard();
        }
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

        page = 1;
        const currentPage = document.getElementById("current-page");
        const totalPages = Math.ceil(editableData.length / display);
        currentPage.innerText = `${page}/${totalPages}`;
        const cContainer = document.getElementById("c-container");
        cContainer.innerHTML = "";
        if (editableData.length <= 0) {
            cContainer.innerHTML = "<p>Tidak ada event yang sesuai.</p>";
        }
        renderCard(editableData.slice(0, display));
    }


    function renderCard(data) {
        const cContainer = document.getElementById("c-container");
        for (let i = 0; i < data.length; i++) {
            const card = data[i];
            // outer card
            let outterDiv = document.createElement("div");
            outterDiv.classList.add("outter-card");

            // setup card anchor
            let cardAnchor = document.createElement("a");
            cardAnchor.href = `/extra/webinar/index.php?event_id=${card.event_id}`;

            // setup card div
            cardAnchor.classList.add("card-link");
            let cardDiv = document.createElement("div");
            cardDiv.classList.add("card");
            cardDiv.innerHTML = `
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
            `;
            
            cardAnchor.appendChild(cardDiv);
            outterDiv.appendChild(cardAnchor);

            // setup feedback btn
            if (card.feedback_given == 0) {
                let feedbackBtn = document.createElement("div");
                feedbackBtn.classList.add("feedback-btn");
                feedbackBtn.innerHTML = `
                    <button class="feedback-btn-btn">Berikan Feedback</button>
                `;
                outterDiv.appendChild(feedbackBtn);
            }
            cContainer.appendChild(outterDiv);

            // card hover effect
            cardDiv.addEventListener("mouseover", function () {
                if (isMobile()) {
                    return;
                }
                const newEl = document.createElement("div");
                newEl.innerHTML = `
                    <div class="card-upper">
                        <div class="wimg-container">
                            <img class="responsive-image2" src="${card.poster_url}"/>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <p class="m-f bold-f mb-5 mb-0">${card.title}</p>
                        <p class="s-f mb-0">${card.date}</p>
                        <p class="s-f mb-0">${card.speaker}</p>
                        <p class="s-f mb-0">${card.description}</p>
                    </div>
                `;
                newEl.style.position = "absolute";
                newEl.style.background = "rgba(255, 255, 255, 1)";
                newEl.style.padding = "5px";
                newEl.style.borderRadius = "12px";
                newEl.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.2)";
                newEl.style.pointerEvents = "none";
                newEl.style.width = "200px";
                newEl.style.maxHeight = "300px";
                newEl.style.overflow = "hidden";
                document.body.appendChild(newEl);
                const moveHandler = (event) => {
                    newEl.style.left = `${event.pageX + 10}px`;
                    newEl.style.top = `${event.pageY + 10}px`;
                };
                document.addEventListener("mousemove", moveHandler);
                cardDiv.addEventListener(
                    "mouseout",
                    function () {
                        newEl.remove();
                        document.removeEventListener("mousemove", moveHandler);
                    },
                    { once: true },
                );
            });
        }

        //const hoverEls = document.querySelectorAll(".card");
        //hoverEls.forEach((hoverEl) => function(){});
    }

    async function createCard() {
        jsonData = await fetchCard();
        if (jsonData) {
            editableData = jsonData;
            const newData = editableData.slice(0, display);
            renderCard(newData);
            const totalPages = Math.ceil(editableData.length / display);
            currentPage.innerText = `${page}/${totalPages}`;
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
    const currentPage = document.getElementById("current-page");
    const nextBut = document.getElementById("next-but");
    prevBut.addEventListener("click", function () {
        if (page > 1) {
            page -= 1;
            const totalPages = Math.ceil(editableData.length / display);
            currentPage.innerText = `${page}/${totalPages}`;
            const cContainer = document.getElementById("c-container");
            cContainer.innerHTML = "";
            renderCard(editableData.slice((page - 1) * display, page * display));
        }
    });

    nextBut.addEventListener("click", function () {
        if (page * display < editableData.length) {
            page += 1;
            const totalPages = Math.ceil(editableData.length / display);
            currentPage.innerText = `${page}/${totalPages}`;
            const cContainer = document.getElementById("c-container");
            cContainer.innerHTML = "";
            renderCard(editableData.slice((page - 1) * display, page * display));
        }
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
        sidebar.hidden = !sidebar.hidden;
    });

    // profile change
    // IDEA: how about adding uploading indicator?
    const profile = document.getElementById("change-profile");
    profile.addEventListener("click", function() {
        let input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = e => { 
            let file = e.target.files[0]; 

            // Add file type validation
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file');
                return;
            }

            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function() {
                // Ensure we have complete data
                if (reader.result) {
                    fetch('/profile/save_profile.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            image: reader.result,  // This will be the complete base64 data URL
                            filename: file.name
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                alert('Profile image uploaded successfully!');
                                location.reload();
                            } else {
                                alert('Error uploading profile image: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error uploading profile image');
                        });
                }
            };

            reader.onerror = function() {
                console.error('File reading error:', reader.error);
                alert('Error reading file');
            };
        }
        input.click();
    });
    createCard();
});
