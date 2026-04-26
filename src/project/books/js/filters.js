function bookFilters() {
    let applyBtn = document.getElementById('apply_filters');
    let clearBtn = document.getElementById('clear_filters');

    let cardsContainer = document.getElementById("book_cards");

    let cards = document.querySelectorAll('.bookCard');

    let form = document.getElementById("filters_books");

    applyBtn.addEventListener('click', (event) => {
        event.preventDefault();
        applyFilters();
    });

    clearBtn.addEventListener('click', (event) => {
        event.preventDefault();
        clearFilters();
    });

    form.addEventListener("submit", (event) => {
        event.preventDefault();
        applyFilters();
    });

    function applyFilters() {
        let filters = getFilters();

        for (let i = 0; i != cards.length; i++) {
            let card = cards[i];
            let match = cardMatches(card, filters);
            card.classList.toggle('hidden', !match);
        }
        let cardsArray = Array.from(cards);
        const sorted = sortCards(cardsArray, filters.sortBy);
        sorted.forEach(card => {
            cardsContainer.appendChild(card);
        });
    }

    function sortCards(cards, sortBy) {
        const list = cards.slice();
        
        list.sort((a, b) => {
            let titleA = a.dataset.title.toLowerCase();
            let titleB = b.dataset.title.toLowerCase();
            let yearA = Number(a.dataset.year);
            let yearB = Number(b.dataset.year);
            if (sortBy === "year_desc") return yearB - yearA;
            if (sortBy === "year_asc") return yearA - yearB;
            return titleA.localeCompare(titleB);
        });

        return list;
    }

    function cardMatches(crd, fltrs) {
        let title = crd.dataset.title.toLowerCase();
        let publisher = crd.dataset.publisher;
        let format = crd.dataset.format;

        let matchTitle    = fltrs.titleFilter    === "" || title.includes(fltrs.titleFilter);
        let matchPublisher    = fltrs.publisherFilter    === "" || publisher === fltrs.publisherFilter;
        let matchFormat = fltrs.formatFilter === "" || format.includes(fltrs.formatFilter);

        return matchTitle && matchPublisher && matchFormat;
    }

    function getFilters() {
        const titleEl = form.elements['title_filter'];
        const publisherEl = form.elements['publisher_filter'];
        const formatEl = form.elements['format_filter'];
        const sortEl = form.elements['sort_by'];

        let titleFilter = (titleEl.value || '').trim().toLowerCase();
        let publisherFilter = publisherEl.value || '';
        let formatFilter = formatEl.value || '';
        let sortBy = sortEl.value || 'title_asc';

        return {
            "titleFilter" : titleFilter,
            "publisherFilter" : publisherFilter,
            "formatFilter" : formatFilter,
            "sortBy" : sortBy
        };
    }

    function clearFilters() {
        form.reset();
        cards.forEach(card => {
            card.classList.remove('hidden');
        });

        let cardsArray = Array.from(cards);
        const sorted = sortCards(cardsArray, "title_asc");

        sorted.forEach(card => {
            cardsContainer.appendChild(card);
        });
    }
}

bookFilters();