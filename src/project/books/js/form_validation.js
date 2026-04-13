let submitBtn = document.getElementById('submit_btn');
let bookForm = document.getElementById('book_form');
let errorSummaryTop = document.getElementById('error_summary_top');

let titleInput = document.getElementById('title');
let authorInput = document.getElementById('author');
let yearInput = document.getElementById('year');
let isbnInput = document.getElementById('isbn');
let publisherIdInput = document.getElementById('publisher_id');
let descriptionInput = document.getElementById('description');
let formatIdsInput = document.getElementsByName('format_ids[]');
let coverInput = document.getElementById('coverfilename');

let titleError = document.getElementById('title_error');
let releaseDateError = document.getElementById('release_date_error');
let genreIdError = document.getElementById('genre_id_error');
let descriptionError = document.getElementById('description_error');
let platformIdsError = document.getElementById('platform_ids_error');
let imageError = document.getElementById('image_error');

let errors = {};

submitBtn.addEventListener('click', onSubmitForm);

function addError(fieldName, message) {
    errors[fieldName] = message;
}

function showErrorSummaryTop() {
    const messages = Object.values(errors);
    if (messages.length === 0) {
        errorSummaryTop.style.display = 'none';
        errorSummaryTop.innerHTML = '';
        return;
    }
    errorSummaryTop.innerHTML =
        '<strong>Please fix the following:</strong><ul>' +
        messages
            .map(function (m) {
                return '<li>' + m + '</li>';
            })
            .join('') +
        '</ul>';
    errorSummaryTop.style.display = 'block';
}

function showFieldErrors() {
    titleError.innerHTML = errors.title || '';
    releaseDateError.innerHTML = errors.year || '';
    genreIdError.innerHTML = errors.publisher_id || '';
    descriptionError.innerHTML = errors.description || '';
    platformIdsError.innerHTML = errors.format_ids || '';
    imageError.innerHTML = errors.cover || '';
}

function isRequired(value) {
    return String(value).trim() !== '';
}

function isMinLength(value, min) {
    return String(value).trim().length >= min;
}

function isMaxLength(value, max) {
    return String(value).trim().length <= max;
}

function onSubmitForm(evt) {
    evt.preventDefault();

    errors = {};

    let titleMin = titleInput.dataset.minlength || 3;
    let titleMax = titleInput.dataset.maxlength || 255;
    let descMin = 10;

    // Title Validation
    if(!isRequired(titleInput.value)){
        addError('title','Title is required!');
    } else if(!isMinLength(titleInput.value, titleMin)){
        addError('title', 'Title must be at least '+ titleMin +' characters!');
    } else if(!isMaxLength(titleInput.value , titleMax)){
        addError('title','Title must be at most' + titleMax +'characters!');
    }

    // release date
    if(!isRequired(releaseDateInput.value)){
        addError('year', 'Year is required!');
    }

    // genre
    if(!isRequired(publsiherIdInput.value)){
        addError('publsiher' , 'Publisher is required');
    }

    // description
    if(!isRequired(descriptionInput.value)){
        addError('description' , 'Description is required');
    }else if (!isMinLength(descriptionInput.value, descMin)){
        addError('description', `Description needs to be at least ${descMin} characters`);
    }

    // platforms
    let platformChecked = false;
    for(let i=0; i < platformIdsInput.length; i++){
        if(platformIdsInput[i].checked){
            platformChecked = true;
            break;
        } 
    }
    if(!platformChecked){
        addError('platform_ids','Select at least one platform.')
    }

    // image
    if(imageInput.files.length === 0){
        addError('image', 'Image is required.')
    }


    showFieldErrors();
    showErrorSummaryTop();

    if(Object.keys(errors).length === 0){
        // gameForm.submit();
        alert('Form data valid');
    }
}
