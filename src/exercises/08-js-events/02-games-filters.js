let applyBtn = document.getElementById('apply_filters');
let clearBtn = document.getElementById('clear_filters');

let form = document.getElementById("filters");

let cards = document.querySelector("filters")

applyBtn.addEventListener('click', (event) => {
    event.preventDefault();
    appplyFilters();
})
clearBtn.addEventListener('click', (event) => {
    event.preventDefault();
    clearFilters();
})

function appplyFilters(){
    let filters = getFilters();
    let matches = [];
    for (let i = 0; i != cards.length;i++){
        let card = cards[i];
        matches[i] = cardMatches(card, filters);
    }
    console.log(matches);
}

function cardMatches(crd, fltrs){
    console.log(crd.dataset.title.fltrs.titleFilter);
    return crd.dataset.title.toLowerCase().includes(fltrs.titleFilter);
}

function getFilters(){
    const titleEl = form.elements['title_filter'];
    const genreEl = form.elements['genre_filter'];
    const platformEl = form.elements['platform_filter'];
    const sortEl = form.elements['sort_by'];

    let titleFilter = (titleEl.value || '').trim().toLowerCase();
    let genreFilter = genreEl.value || '';
    let platformFilter = platformEl.value || '';
    let sortBy = sortEl.value || 'title_asc';

    return{
        "titleFilter" : titleFilter,
        "genreFilter" : genreFilter,
        "platformFilter" : platformFilter,
        "sortBy" : sortBy

    };
}

function clearFilters(){
    let filters = getFilters();
    
}