<?php
include 'koneksi.php';

$eventID = $_GET["event_id"];

$resEventFeedbackTemplate = $koneksi->query("SELECT * FROM event_feedback_template WHERE event_id = '$eventID'");
$eventFeedbackTemplate = mysqli_fetch_assoc($resEventFeedbackTemplate);

$feedbackTemplateID = $eventFeedbackTemplate["feedback_template_id"];
// echo $eventFeedbackTemplate["field"];
?>

<!--
    This page is to demonstrate how to create a feedback template for a webinar.
    Please integrate this to the existing admin system with proper changes.
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
    <form name="new_entry" class="w-10/12 mx-auto my-4" action="" method="post" onsubmit="handleSubmit(event)">
        <div class="mb-2">
            <label for="html_name" class="text-sm">HTML Name</label>
            <input
                type="text"
                name="html_name"
                id="html_name"
                class="w-full border border-gray-300 rounded-md px-2 py-1"
                required>
        </div>

        <div class="mb-2">
            <p class="text-sm flex-grow">Required?</p>
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
            <label for="question" class="text-sm">Display Question</label>
            <input
                type="text"
                name="question"
                id="question"
                class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                required>
        </div>

        <div class="mb-2">
            <label for="input_type" class="text-sm">Input Type</label><br />
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
                type="submit"
                class="bg-blue-500 text-white px-2 py-1 rounded-full min-w-20">
                SUBMIT
            </button>
        </div>
    </form>
    <div id="table"></div>
    <script>
        jsonData = JSON.parse('<?php echo $eventFeedbackTemplate["field"]; ?>');

        let table = document.getElementById('table');
        let extraForm = document.getElementById('extraForm');

        const changeInputType = () => {
            let extra = "";

            let inputType = document.getElementById('input_type').value;

            if (inputType == "number" || inputType == "radio_scale") {
                extra += `
                <div class="mb-2 flex">
                    <div class="flex-grow mr-2">
                        <label for="min_value" class="text-sm">Min Value</label>
                        <input
                            type="number"
                            name="min_value"
                            id="min_value"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                            required>
                    </div>
                    <div class="flex-grow mr-2">
                        <label for="max_value" class="text-sm">Max Value</label>
                        <input
                            type="number"
                            name="max_value"
                            id="max_value"
                            class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                            required>
                    </div>
                </div>
                `;

                if (inputType == "radio_scale") {
                    extra += `
                    <div class="mb-2 flex">
                        <div class="flex-grow mr-2">
                            <label for="min_label" class="text-sm">Min Label</label>
                            <input
                                type="text"
                                name="min_label"
                                id="min_label"
                                class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                                placeholder="ex: Highly Disagree"
                                required>
                        </div>
                        <div class="flex-grow mr-2">
                            <label for="max_label" class="text-sm">Max Label</label>
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
                    <label for="options" class="text-sm">Options</label>
                    <input
                        type="text"
                        name="options"
                        id="options"
                        class="w-full border border-gray-300 rounded-md px-2 py-1 mb-2"
                        placeholder="Separate each option with comma"
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
                            </div>
                        </div>
                    `;

                    if (index != element.entries.length - 1) {
                        tableData += `<hr class="my-2">`;
                    }
                });

                tableData += `</div>`;
            });

            table.innerHTML = tableData;
        }

        const prepareEditing = (category, index) => {
            alert("Editing category " + category + " index " + index);
        }

        const handleSubmit = (e) => {
            e.preventDefault();

            const res = confirm("Are you sure you want to submit this form?");

            if (res) {
                alert("Submitting form...");
            }
        }

        changeTableData();

        console.log(jsonData);
    </script>
</body>
</html>