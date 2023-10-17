form_holder = document.getElementById("form-holder");
newFormHolder = document.getElementById("new-form-holder");

let colour = document.getElementById("colour");
let title = document.getElementById("title");
let description = document.getElementById("description");
colour.addEventListener('input', function (event) {
    colour.style.color = colour.value;
    title.style.color = colour.value;
});

let newColour = document.getElementById("new-colour");
let newTitle = document.getElementById("new-title");
let newDescription = document.getElementById("new-description");
newColour.addEventListener('input', function (event) {
    newColour.style.color = newColour.value;
    newTitle.style.color = newColour.value;
});

function closeForm() {
    form_holder.style.display = "none";
}

function closeNewForm() {
    newFormHolder.style.display = "none";
}

function editRole(id) {
    closeNewForm();
    let form = document.getElementById("update-role-privileges");

    let form_weight = document.getElementById("role-weight-" + id);
    let form_name = document.getElementById("role-name-" + id);
    let form_title = document.getElementById("role-title-" + id);
    let form_colour = document.getElementById("role-colour-" + id);
    let form_description = document.getElementById("role-description-" + id);

    let weight = document.getElementById("weight");
    let colour = document.getElementById("colour");
    let title = document.getElementById("title");
    let description = document.getElementById("description");

    weight.value = form_weight.innerText;
    title.value = form_title.innerText;
    title.style.color = form_colour.innerText;
    colour.value = form_colour.innerText;
    colour.style.color = form_colour.innerText;
    description.value = form_description.innerText;

    let form_title_h3 = document.getElementById('role-update-title')
    form_title_h3.innerHTML = "Update role " + form_name.innerHTML

    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    const privileges = document.querySelectorAll('.option_' + id);
    checkboxes.forEach((checkbox) => {
        checkbox.checked = false;
        for (let i = 0; i < privileges.length; i++) {
            if (checkbox.value === privileges[i].value) {
                checkbox.checked = true;
                break
            }
        }
    });
    document.getElementById('role-id-input').value = id;
    form_holder = document.getElementById("form-holder");
    form_holder.style.display = "flex";
}

function newRole() {
    closeForm();
    let form = document.getElementById('new-role-privileges');
    newFormHolder = document.getElementById("new-form-holder");
    newFormHolder.style.display = "flex";
}
