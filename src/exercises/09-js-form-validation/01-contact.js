let submitBtn = document.getElementById('submit_btn');
let commentForm = document.getElementById('comment_form');
let nameInput = document.getElementById('name');

let nameError = document.getElementById("name_error")

submitBtn.addEventListener('click', onSubmitForm);

function onSubmitForm(evt) {
    console.log(evt);
    evt.preventDefault();

    const name= nameInput.value.trim();
    if (name === ''){
        console.log("Name is required")
        nameError.innerHTML = "Name is required"
    }
}