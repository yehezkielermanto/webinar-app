<?php
include 'koneksi.php';

$eventID = $_GET["event_id"];

$resEventFeedbackTemplate = $koneksi->query("SELECT * FROM event_feedback_templates WHERE event_id = '$eventID'");
$eventFeedbackTemplate = mysqli_fetch_assoc($resEventFeedbackTemplate);

if ($eventFeedbackTemplate != null) {
    $feedbackTemplateID = $eventFeedbackTemplate["id"];
}

// echo $eventFeedbackTemplate["field"];

if (isset($_POST["json"])) {
    $json = $_POST["json"];

    if ($eventFeedbackTemplate == null) {
        $koneksi->query("INSERT INTO event_feedback_templates (field, event_id, `status`) VALUES ('$json', '$eventID', 1)");
    } else {
        $koneksi->query("UPDATE event_feedback_templates SET field = '$json' WHERE event_id = '$eventID'");
    }
}
?>

<!--
    This page is to demonstrate how to create a feedback template for a webinar.
    Please integrate this to the existing admin system with proper changes.

    Access this page by placing "?event_id=[id]" at the end of the URL.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Create Feedback Template | DEBUG</title>
</head>
<body>
    <div class="w-10/12 mx-auto my-4" id="add_div">
        <button
            type="button"
            class="bg-blue-500 text-white px-2 py-1 rounded-full min-w-20"
            onclick="toggleFormDisplay(true)">
            ADD
        </button>
    </div>
    <form
        name="new_entry"
        id="new_entry"
        class="w-10/12 mx-auto my-4"
        method="post"
        onsubmit="return handleSubmit()">
        <div class="mb-2">
            <label for="category" class="text-sm">Category</label>
            <input
                type="text"
                name="category"
                id="category"
                class="w-full border border-gray-300 rounded-md px-2 py-1"
                placeholder="Leaving it blank will put the question in an empty category">
        </div>

        <div class="mb-2">
            <label for="html_name" class="text-sm">HTML Name <span class="text-red-500 font-bold">*</span></label>
            <input
                type="text"
                name="html_name"
                id="html_name"
                class="w-full border border-gray-300 rounded-md px-2 py-1"
                placeholder="Must be unique and usable for an HTML name and ID"
                required>
        </div>

        <div class="mb-2">
            <p class="text-sm flex-grow">Required? <span class="text-red-500 font-bold">*</span></p>
            <div class="flex">
                <div class="flex items-center mr-4">
                    <input
                        type="radio"
                        name="required"
                        value="true"
                        id="radio_true"
                        class="mr-1"
                        required>
                    <label for="radio_true">Required</label>
                </div>
                <div class="flex items-center">
                    <input
                        type="radio"
                        name="required"
                        value="false"
                        id="radio_false"
                        class="mr-1"
                        required>
                    <label for="radio_false">Optional</label>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <label for="question" class="text-sm">Display Question <span class="text-red-500 font-bold">*</span></label>
            <input
                type="text"
                name="question"
                id="question"
                class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                placeholder="Question to be displayed to the participants"
                required>
        </div>

        <div class="mb-2">
            <label for="input_type" class="text-sm">Input Type <span class="text-red-500 font-bold">*</span></label>
            <br />
            <select
                name="input_type"
                id="input_type"
                class="w-1/2 border border-gray-300 rounded-md px-2 py-1 mb-2"
                onchange="changeInputType()"
                required>
                <option value="none" selected disabled>- Choose an input type -</option>
                <optgroup label="Basic Input">
                    <option value="text">Short Text</option>
                    <option value="number">Number</option>
                    <option value="textarea">Paragraph</option>
                </optgroup>
                <optgroup label="Choice Input">
                    <option value="radio">Radio Button</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="select">Dropdown</option>
                </optgroup>
                <optgroup label="Others">
                    <option value="radio_scale">Linear Scale</option>
                </optgroup>
            </select>
        </div>

        <div id="extraForm"></div>

        <div class="mb-2">
            <button
                type="button"
                id="cancel_button"
                class="bg-red-500 text-white px-2 py-1 rounded-full min-w-20"
                onclick="toggleFormDisplay(false)">
                CANCEL
            </button>
            <button
                type="submit"
                class="bg-blue-500 text-white px-2 py-1 rounded-full min-w-20">
                SUBMIT
            </button>
        </div>
    </form>
    <div id="table"></div>
    <form name="finish" id="finish" action="#" method="post" class="w-10/12 mx-auto my-4">
        <input type="hidden" name="json" id="json" value="">

        <div class="flex justify-end">
            <button
                type="submit"
                class="bg-green-500 text-white px-2 py-1 rounded-full min-w-20"
                onclick="document.getElementById('json').value = JSON.stringify(jsonData)">
                FINISH
            </button>
        </div>
    </form>

    <script>
        const form = document.getElementById('new_entry');
        const addDiv = document.getElementById('add_div');

        jsonData = JSON.parse('<?php echo (isset($_POST['json'])) ? $_POST["json"] : ($eventFeedbackTemplate != null ? $eventFeedbackTemplate["field"] : "[]"); ?>');

        console.log(jsonData);

        const table = document.getElementById('table');
        const extraForm = document.getElementById('extraForm');

        let isEditing = false;
        let editingCategory = "";
        let editingIndex = -1;

        const toggleFormDisplay = (show) => {
            if (show) {
                form.classList.remove('hidden');
                addDiv.classList.add('hidden');
            } else {
                let f = document.forms['new_entry'];
                f.reset();

                extraForm.innerHTML = "";
                isEditing = false;
                editingCategory = "";
                editingIndex = -1;

                form.classList.add('hidden');
                addDiv.classList.remove('hidden');
            }
        }

        const changeInputType = () => {
            let extra = "";

            const inputType = document.getElementById('input_type').value;

            if (inputType == "number" || inputType == "radio_scale") {
                extra += `
                <div class="mb-2 flex">
                    <div class="flex-grow mr-2">
                        <label for="min_value" class="text-sm">Min Value <span class="text-red-500 font-bold">*</span></label>
                        <input
                            type="number"
                            name="min_value"
                            id="min_value"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                            min="0"
                            max="100"
                            required>
                    </div>
                    <div class="flex-grow mr-2">
                        <label for="max_value" class="text-sm">Max Value <span class="text-red-500 font-bold">*</span></label>
                        <input
                            type="number"
                            name="max_value"
                            id="max_value"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                            min="0"
                            max="100"
                            required>
                    </div>
                </div>
                `;

                if (inputType == "radio_scale") {
                    extra += `
                    <div class="mb-2 flex">
                        <div class="flex-grow mr-2">
                            <label for="min_label" class="text-sm">Min Label <span class="text-red-500 font-bold">*</span></label>
                            <input
                                type="text"
                                name="min_label"
                                id="min_label"
                                class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                                placeholder="ex: Highly Disagree"
                                required>
                        </div>
                        <div class="flex-grow mr-2">
                            <label for="max_label" class="text-sm">Max Label <span class="text-red-500 font-bold">*</span></label>
                            <input
                                type="text"
                                name="max_label"
                                id="max_label"
                                class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                                placeholder="ex: Highly Agree"
                                required>
                        </div>
                    </div>
                    `;
                }
            } else if (inputType == "radio" || inputType == "checkbox" || inputType == "select") {
                extra += `
                <div class="mb-2">
                    <label for="options" class="text-sm">Options <span class="text-red-500 font-bold">*</span></label>
                    <input
                        type="text"
                        name="options"
                        id="options"
                        class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                        placeholder="Separate each option with comma and space (e.g. ', ')"
                        required>
                </div>
                `;
            }

            extraForm.innerHTML = extra;
        }

        const changeTableData = () => {
            let tableData = "";

            jsonData.forEach(element => {
                tableData += `
                    <div class="my-4 w-10/12 mx-auto">
                        <h2 class="text-2xl font-bold mb-2">${element.category != "" ? element.category : "<i>- Untitled -</i>"}</h2>
                `;

                element.entries.forEach((entry, index) => {
                    //console.log(entry);

                    tableData += `
                        <div class="flex">
                            <div class="flex-grow">
                                <h3>${entry.question}</h3>
                                <p class="text-sm text-gray-500">${entry.html_name} - ${entry.required ? "Required" : "Optional"} - ${entry.input_type}</p>
                            </div>
                            <div class="ml-2">
                                <button
                                    type="button"
                                    class="bg-blue-500 text-white px-2 py-1 rounded-full min-w-20"
                                    onclick = "prepareEditing('${element.category}', ${index})">
                                    EDIT
                                </button>
                                <button
                                    type="button"
                                    class="bg-red-500 text-white px-2 py-1 rounded-full min-w-20"
                                    onclick = "prepareDeleting('${element.category}', ${index})">
                                    DELETE
                                </button>
                            </div>
                        </div>
                    `;

                    if (index != element.entries.length - 1) {
                        tableData += `<hr class="my-2">`;
                    }
                });

                tableData += `</div>`;
            });

            if (jsonData.length == 0) {
                tableData = "<p class='text-center'>- No data is available. Go make one right now! -</p>";
            }

            table.innerHTML = tableData;
        }

        const prepareEditing = (category, index) => {
            isEditing = true;
            editingCategory = category;
            editingIndex = index;

            let data = jsonData.find(element => element.category == category).entries[index];

            toggleFormDisplay(true);

            let f = document.forms['new_entry'];

            f['category'].value = category;
            f['html_name'].value = data.html_name;
            f['required'].value = data.required ? "true" : "false";
            f['question'].value = data.question;
            f['input_type'].value = data.input_type;

            changeInputType();

            if (data.input_type == "number") {
                f['min_value'].value = data.num_range_low;
                f['max_value'].value = data.num_range_high;
            } else if (data.input_type == "radio_scale") {
                f['min_value'].value = data.radio_range_low;
                f['max_value'].value = data.radio_range_high;
                f['min_label'].value = data.radio_label_low;
                f['max_label'].value = data.radio_label_high;
            } else if (data.input_type == "radio") {
                f['options'].value = data.radio_options.join(", ");
            } else if (data.input_type == "checkbox") {
                f['options'].value = data.checkbox_options.join(", ");
            } else if (data.input_type == "select") {
                f['options'].value = data.select_options.join(", ");
            }

            console.log(f);
        }

        const prepareDeleting = (category, index) => {
            // remove the particular entry
            jsonData.find(element => element.category == category).entries.splice(index, 1);

            // remove the category if there is no entry left
            if (jsonData.find(element => element.category == category).entries.length == 0) {
                jsonData = jsonData.filter(element => element.category != category);
            }

            changeTableData();
        }

        const handleSubmit = () => {
            let f = document.forms['new_entry'];

            // general data needed for a question
            let obj = {
                html_name: f['html_name'].value,
                required: f['required'].value == "true",
                question: f['question'].value,
                input_type: f['input_type'].value,
            }

            // additional data for specific input types
            if (obj.input_type == "number") {
                obj.num_range_low = f['min_value'].value;
                obj.num_range_high = f['max_value'].value;

                if (obj.num_range_high < obj.num_range_low) {
                    alert("Max Value must be greater than Min Value.");
                    return false;
                }
            } else if (obj.input_type == "radio_scale") {
                obj.radio_range_low = f['min_value'].value;
                obj.radio_range_high = f['max_value'].value;
                obj.radio_label_low = f['min_label'].value;
                obj.radio_label_high = f['max_label'].value;

                if (obj.num_range_high < obj.num_range_low) {
                    alert("Max Value must be greater than Min Value.");
                    return false;
                }
            } else if (obj.input_type == "radio") {
                obj.radio_options = f['options'].value.split(", ");
            } else if (obj.input_type == "checkbox") {
                obj.checkbox_options = f['options'].value.split(", ");
            } else if (obj.input_type == "select") {
                obj.select_options = f['options'].value.split(", ");
            }

            // check if html_name is a duplicate
            if (!isEditing) {
                if (jsonData.find(element => element.category == f['category'].value) != undefined) {
                    if (jsonData.find(element => element.category == f['category'].value).entries.find(element => element.html_name == obj.html_name) != undefined) {
                        alert("HTML Name is already used in this category. Please use another name.");
                        return false;
                    }
                }
            }

            if (isEditing) {
                // replace the old data with the new one
                if (f['category'].value != editingCategory) {
                    // move to a new category if the category is changed
                    jsonData.find(element => element.category == editingCategory).entries.splice(editingIndex, 1);

                    if (jsonData.find(element => element.category == f['category'].value) == undefined) {
                        jsonData.push({ category: f['category'].value, entries: [] });
                    } else {
                        jsonData.find(element => element.category == f['category'].value).entries.push(obj);
                    }
                } else {
                    jsonData.find(element => element.category == editingCategory).entries[editingIndex] = obj;
                }
            } else {
                //check if the category name exists
                if (jsonData.find(element => element.category == f['category'].value) == undefined) {
                    jsonData.push({ category: f['category'].value, entries: [obj] });
                } else {
                    jsonData.find(element => element.category == f['category'].value).entries.push(obj);
                }
            }

            toggleFormDisplay(false);
            changeTableData();

            isEditing = false;
            editingCategory = "";
            editingIndex = -1;

            return false;
        }

        toggleFormDisplay(false);
        changeTableData();

        console.log(jsonData);
    </script>
</body>
</html>