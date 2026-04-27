let submitBtn = document.getElementById('submit_btn');
let bookForm = document.getElementById('book_form');
let errorSummaryTop = document.getElementById('error_summary_top');

let titleInput = document.getElementById('title');
let authorInput = document.getElementById('author');
let yearInput = document.getElementById('year');
let isbnInput = document.getElementById('isbn');
let publisherIdInput = document.getElementById('publisher');
let descriptionInput = document.getElementById('description');
let formatIdsInput = document.getElementsByName('format_ids[]');
let coverInput = document.getElementById('cover_filename');

let titleError = document.getElementById('title_error');
let authorError = document.getElementById('author_error');
let yearError = document.getElementById('year_error');
let isbnError = document.getElementById('isbn_error');
let publisherIdError = document.getElementById('publisher_id_error');
let descriptionError = document.getElementById('description_error');
let formatIdError = document.getElementById('format_id_error');
let coverfilenameError = document.getElementById('cover_filename_error');

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
    authorError.innerHTML = errors.author || '';
    yearError.innerHTML = errors.year || '';
    isbnError.innerHTML = errors.isbn || '';
    publisherIdError.innerHTML = errors.publisher_id || '';
    descriptionError.innerHTML = errors.description || '';
    formatIdError.innerHTML = errors.format_ids || '';
    coverfilenameError.innerHTML = errors.cover_filename || '';

    console.log(errors)
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
    let isbnMin = isbnInput.dataset.mininteger || 13;
    let isbnMax = isbnInput.dataset.maxinteger || 13;
    let descMin = 10;

    // Title Validation
    if(!isRequired(titleInput.value)){
        addError('title','Title is required!');
    } else if(!isMinLength(titleInput.value, titleMin)){
        addError('title', 'Title must be at least '+ titleMin +' characters!');
    } else if(!isMaxLength(titleInput.value , titleMax)){
        addError('title','Title must be at most' + titleMax +'characters!');
    }
    // Author
    if(!isRequired(authorInput.value)){
        addError('author', 'Author is required!');
    }

    // Year
    if(!isRequired(yearInput.value)){
        addError('year', 'Year is required!');
    }
    //ISBN
    if(!isRequired(isbnInput.value)){
        addError('isbn','ISBN is required!');
    } else if(!isMinLength(isbnInput.value, isbnMin)){
        addError('isbn', 'ISBN must be at least '+ isbnMin +' characters!');
    } else if(!isMinLength(isbnInput.value, isbnMax)){
        addError('isbn', 'ISBN must be at least '+ isbnMax +' characters!');
    }


    // Publisher
    if(!isRequired(publisherIdInput.value)){
        addError('publisher' , 'Publisher is required');
    }

    // description
    if(!isRequired(descriptionInput.value)){
        addError('description' , 'Description is required');
    }else if (!isMinLength(descriptionInput.value, descMin)){
        addError('description', `Description needs to be at least ${descMin} characters`);
    }

    // Format
    let formatIdChecked = false;
    for(let i=0; i < formatIdsInput.length; i++){
        if(formatIdsInput[i].checked){
            formatIdChecked = true;
            break;
        } 
    }
    if(!formatIdChecked){
        addError('format_','Select at least one format.')
    }

    // image
    if(coverInput.files.length === 0){
        addError('cover_filename', 'Image is required.')
    }


    showFieldErrors();
    

    if(Object.keys(errors).length === 0){
        bookForm.submit();
    }
}
