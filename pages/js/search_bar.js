

let lastSuggestions = [];
let allItems = [];

user_is_not_logged_in = true;
user_id_ = -1;

let searched_items = [];
let current_filters = {
    "state": new Set(),
    "brand": new Set(),
    "category": new Set(),
    "subCategory": new Set(),
    "tamanho": new Set(),
    "location": null,
    "onlyAdsWithImages": false,
    "delivery": false,
};

 
function sanitizeInput(input) {
    return DOMPurify.sanitize(input);
}

function calculateSuggestions(inputVal , items){
    console.log('beginning suggestions');
    console.log(items);
    console.log(inputVal);

    if(inputVal === null){
        return items;
    }

    if (inputVal.length === 0) {
        return items;
    } else {
        inputVal = inputVal.toLowerCase();
        
        allItemNames = []
        filteredItems = [...items];
        
        for(let i = 0; i < items.length; i++){
            allItemNames.push(items[i][1].toLowerCase());
        }
        
        console.log('all items names');
        console.log(allItemNames);

        let filteredItemsNames = allItemNames.filter(function (item) {
            return item.startsWith(inputVal);
        });

        recommendations = [];

        for(let i = 0; i < filteredItemsNames.length; i++){
            for(let j = 0; j < filteredItems.length; j++){
                if(filteredItems[j][1].toLowerCase() === filteredItemsNames[i]){
                    recommendations.push(filteredItems[j]);
                }
            }
        }

        console.log('reco')
        console.log(recommendations);
    
        return recommendations;
    }
}


function getSuggestions(input , itemNamesJson){
    var itemNames = JSON.parse(itemNamesJson);


    if (input.length < 0) {
        return [];
    } else {
        input = input.toLowerCase();
    
        itemNames = itemNames.map(function (item) {
            return item.toLowerCase();
        });
    
        let filteredItems = itemNames.filter(function (item) {
            return item.startsWith(input);
        });
    
        itemNames = itemNames.filter(function (item) {
            return !item.startsWith(input);
        });
    
        let suggestionsMap = filteredItems.reduce(function (map, item) {
            var differences = 0;
            for (var i = 0; i < input.length; i++) {
                if (item[i] !== input[i]) {
                    differences++;
                }
            }
            map[item] = differences;
            return map;
        }, {});
    
        let sortedItems = filteredItems.sort(function (a, b) {
            return Math.abs(a.length - input.length) - Math.abs(b.length - input.length);
        });
    
        let sortedMap = Object.entries(suggestionsMap).sort(function (a, b) {
            return a[1] - b[1];
        });
    
        let result = sortedItems.concat(sortedMap.map(item => item[0]));

        result = [...new Set(result)];
    
        return result;
    }
/*
    var xhr = new XMLHttpRequest();
    var url = "/search/suggestions?search=" + search;
    xhr.open("GET", url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            suggestions.innerHTML = "";
            response.forEach(function(item){
                var suggestion = document.createElement("div");
                suggestion.innerHTML = item;
                suggestion.onclick = function(){
                    document.getElementById('search').value = item;
                    suggestions.innerHTML = "";
                };
                suggestions.appendChild(suggestion);
            });
        }
    };
    xhr.send();
*/
}

document.addEventListener('DOMContentLoaded', function() {
    const inputBox = document.querySelector('.search_bar');
    const resultBox = document.querySelector('.result-box');
    const filterButtons = document.querySelectorAll('.filter_button');
    const searchButton = document.querySelector('.search_button'); 
    const marcaFilter = document.getElementById('marca_filter');
    const estadoFilter = document.getElementById('estado_filter');
    const sortFilter = document.getElementById('sort_filter');

    const tamanhoFilter = document.getElementById('Tamanhos');
    const subCateogriasFilter =  document.getElementById('subCategorias');  
    const categoriasFilter = document.getElementById('Categorias');

    const locationFilter = document.querySelector('.category_dropdown');

    let isImageFilterActive = false;
    let isDeliveryFilterActive = false;

    console.log("Loaded");
    console.log(inputBox);


    inputBox.addEventListener('keyup' , function() {
        console.log("inputBox.onkeyup");

        let input = inputBox.value; 
        
        console.log("input before sanitization" + input);

        input = sanitizeInput(input);

        console.log("input aftet sanitization" + input);

        let result_ = getSuggestions(input, JSON.stringify(itemNames)); 

        console.log("resultado" + result_);

        if(input.length == 0){
            result_ = [];
        }
        display_result(result_);
    });

    inputBox.addEventListener('click', function(event) {
        event.stopPropagation(); 
        resultBox.style.display = 'block'; 
    });

    locationFilter.addEventListener('change', function() {
        const selectedLocation = locationFilter.value;
        console.log('Selected Location:', selectedLocation);
        current_filters['location'] = selectedLocation;
    });

    document.addEventListener('click', function(event) {
        const clickedElement = event.target;
        
        if (!inputBox.contains(clickedElement)) {
            resultBox.style.display = 'none'; // Hide suggestion box
        }
    });

    filterButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            button.classList.toggle('active');
            if(button.id == 'image_filter'){
                isImageFilterActive = !isImageFilterActive;
                current_filters['onlyAdsWithImages'] = isImageFilterActive;
            }
            else if(button.id == 'delivery_filter'){
                isDeliveryFilterActive = !isDeliveryFilterActive;
                current_filters['delivery'] = isDeliveryFilterActive;
            }
        });
    });

    searchButton.addEventListener('click', async function() {
        try {
            const response = await fetch('js/get_all_items.php');
            if (!response.ok) {
                throw new Error('Failed to fetch data');
            }
            console.log('Data fetched successfully');
            
            const allItems = await response.json(); 
            console.log(allItems);

            items =  [...allItems];
            console.log(items);

            input = document.querySelector('.search_bar').value;

            input = sanitizeInput(input);

            console.log(input);
            
            const recommendad_items = calculateSuggestions(input, items);
            console.log("after suggestions");
            console.log(recommendad_items);
            search_algorithm(recommendad_items, isImageFilterActive , isDeliveryFilterActive);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    });

    document.querySelectorAll('.filter_section select, .filter_section input').forEach(input => {
        input.addEventListener('change', updateCurrentFilters);
    });

    marcaFilter.addEventListener('change', function() {
        const selectedMarca = marcaFilter.value;
        console.log('Selected Marca:', selectedMarca);
        updateCurrentFilters(selectedMarca , 'Marca' , true);
    });

    estadoFilter.addEventListener('change', function() {
        const selectedEstado = estadoFilter.value;
        console.log('Selected Estado:', selectedEstado);
        updateCurrentFilters(selectedEstado , 'State' , true);
        
    });

    sortFilter.addEventListener('change', function() {
        const selectedSort = sortFilter.value;
        console.log('Selected Sort:', selectedSort);
        updateCurrentFilters(selectedSort , 'Sort' , true);
        
    });

    tamanhoFilter.addEventListener('change', function() {
        const selectedTamanho = tamanhoFilter.value;
        console.log('Selected Tamanho:', selectedTamanho);
        updateCurrentFilters(selectedTamanho , 'Tamanho' , true);
    });

    subCateogriasFilter.addEventListener('change', function() {
        const selectedSubCategoria = subCateogriasFilter.value;
        console.log('Selected SubCategoria:', selectedSubCategoria);
        updateCurrentFilters(selectedSubCategoria , 'SubCategoria' , true);
    });

    categoriasFilter.addEventListener('change', function() {
        const selectedCategoria = categoriasFilter.value;
        console.log('Selected Categoria:', selectedCategoria);
        updateCurrentFilters(selectedCategoria , 'Categoria' , true);
    });

    function updateCurrentFilters(input , indicator , from) {

        switch(indicator){
            case 'Marca':
                if(input === 'Marca' || input === ''){
                    current_filters['brand'].clear();
                }else{
                    current_filters['brand'].add(input);
                }

                break;
            case 'State':
                if(input == 'Any'){
                    current_filters['state'].clear();
                }else{
                    current_filters['state'].add(input);
                }
                break;
            case 'Price':
                if(from){
                    if (input !== '' && input !== '0') { 
                        current_filters['state'].add('From' + input);
                    }
                } else {
                    if (input !== '' && input !== '10000') { 
                        current_filters['state'].add('To' + input);
                    }
                }
                break;
            case 'Sort':
                if (input !== '' && input !== 'Ordenar Por') { 
                    current_filters['sort'] = input;
                }
                break;
            case 'Tamanho':
                if(input !== '' && input !== 'Qualquer Uma' && input !== 'Tamanho'){
                    current_filters['tamanho'].add(input);
                }else if(input === 'Qualquer Um' || input === ''){
                    current_filters['tamanho'].clear();
                }
                break;
            case 'SubCategoria':
                if(input !== '' && input !== 'SubCategoria' && input !== 'Qualquer Uma'){
                    current_filters['subCategory'].add(input);
                }else if(input === 'Qualquer Uma' || input === ''){
                    current_filters['subCategory'].clear();
                }
                break;
            case 'Categoria':
                if(input !== '' && input !== 'Categoria' && input !== 'Qualquer Uma'){
                    current_filters['category'].add(input);
                }else if(input === 'Qualquer Uma' || input === ''){
                    console.log('clearing category');
                    current_filters['category'].clear();
                }
                break;
        }
        console.log(input);
        console.log(current_filters);
        display_current_filters();
    }
        

    function display_current_filters() {
        const currentFiltersDiv = document.querySelector('.current_filters');
        currentFiltersDiv.innerHTML = ''; 
    
        for (const key in current_filters) {
            console.log(typeof current_filters[key]);
            
            if(typeof current_filters[key] !== 'boolean' && current_filters[key] !== null){
                current_filters[key].forEach(value => {
                    console.log(key, value);
                    const filterEntry = document.createElement('div');
                    filterEntry.textContent = `${key}: ${value}`;
        
                    const removeButton = document.createElement('button');
                    removeButton.textContent = 'X';
                    removeButton.addEventListener('click', () => {
                        filterEntry.remove();
                        current_filters[key].delete(value);
                        console.log(current_filters);
                        display_current_filters();
                    });
        
                    filterEntry.appendChild(removeButton);
                    currentFiltersDiv.appendChild(filterEntry);
                });
            }
        }
    }
}); 


function display_result(result){

    const resultBox = document.querySelector('.result-box');

    const content = result.map((item) =>{
        return "<li onclick = selectInput(this) class = 'searched_item'>" + item + "</li>";
    });

    resultBox.innerHTML = "<ul>" + content.join('') + "</ul>";
}



function selectInput(element){
    document.querySelector('.search_bar').value = element.innerHTML;
}

function imageExistsAsync(url) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve(true);
        img.onerror = () => resolve(false);
        img.src = url;
    });
}

function getUserLoginStatus() {
    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    let response = xhr.responseText;
                    resolve(parseInt(response));
                } else {
                    reject(new Error("Request failed"));
                }
            }
        };
        xhr.open("GET", "../db_handler/action_is_user_logged_in.php", true);
        xhr.send();
    });
}

async function checkLoginStatus() {
    try {
        isLoggedIn = await getUserLoginStatus();// Assuming -1 denotes not logged in
        user_id_ = isLoggedIn;

 
    } catch (error) {
        console.error("Error:", error);
    }
}


async function search_algorithm(items , isImageFilterActive , isDeliveryFilterActive){
    
    console.log('search_algorithm');
    console.log(current_filters);

    const sortFilter = document.getElementById('sort_filter');
    const precoMin = document.querySelector('.from');
    const precoMax = document.querySelector('.to');
    
    const precoMinValue = precoMin.value;
    const precoMaxValue = precoMax.value;
    const sortValue = sortFilter.value;

    //allItems = [[Id, Name, Description, Brand, CategoryId, Size, Price, ConditionId, Available, isAvailableForDelivery, getSubCategory , Highlighted, location UserId ,  ] ,...]
    let size = items.length;
    let size2 = items.length;

    items = items.filter(item => {
        
        const precoMatch = (precoMinValue === '' || parseFloat(item[6]) >= parseFloat(precoMinValue)) &&
                        (precoMaxValue === '' || parseFloat(item[6]) <= parseFloat(precoMaxValue));

        const brandMatch = current_filters['brand'].size === 0 || current_filters['brand'].has(item[3]);
        const categoryMatch = current_filters['category'].size === 0 || current_filters['category'].has(item[4]);
        const stateMatch = current_filters['state'].size === 0 || current_filters['state'].has(item[7]);

        return  precoMatch && brandMatch && categoryMatch && stateMatch;
    });

    size2 = items.length;

    if(size > size2){
        console.log("marcou filter , estado filter , preço filter")
    }

    console.log("current filters " + current_filters['location']);
    
    items = items.filter(item => {
        const tamanhoMatch = current_filters['tamanho'].size === 0 || current_filters['tamanho'].has(item[5]);
        const subCategoryMatch = current_filters['subCategory'].size === 0 || current_filters['subCategory'].has(item[10]);

        const locationMatch = current_filters['location'] === null || item[13].includes(current_filters['location']);

        console.log("location match " + locationMatch);

        return tamanhoMatch && subCategoryMatch && item[8] && locationMatch;
    });

    size = size2;

    if (current_filters['onlyAdsWithImages']) {
        items = items.filter(item => item[11] != 0);
    }
    
    size2 = items.length;

    if(size > size2){
        console.log("price filter")
    }

    size = size2;

    if(current_filters['delivery']){
        items = items.filter(item => item[9] === 1);
    }

    size2 = items.length;

    if(size > size2){
        console.log("image filter")
    }

    size = size2;

    if (sortValue === 'price_asc') {
        items.sort(function(a, b) {
            return (parseFloat(a[6]) - parseFloat(b[6]));
        });
    } else if (sortValue === 'price_desc') {
        items.sort(function(a, b) {
            return (parseFloat(b[6]) - parseFloat(a[6]));
        });
    } else{
        items.sort(function(a, b) {
            if (a[11] && !b[11]) {
                return -1;
            } else if (!a[11] && b[11]) {
                return 1;
            } else {
                return 0;
            }
        });
    }

    await checkLoginStatus();

    console.log('user_id_ : ' + user_id_);

    if(user_id_ !== -1){
        items = items.filter(
            item => item[14] !== user_id_,
        );
    }

    user_id_ = -1;

    console.log(items);

    searched_items = items;

    render_items();
}   

function render_items() {
    const searchItemsDiv = document.querySelector('.search-items');
    searchItemsDiv.innerHTML = '';

    searched_items.forEach(item => {
        const itemContainer = document.createElement('div');
        itemContainer.classList.add('searched-item-container');
        
        itemContainer.addEventListener('click', function() {
            const itemId = item[0];
            
            window.location.href = `itempage.php?item=${itemId}`;
        });

        // Fetch the item photo
        let itemId = item[0]; 
        console.log(itemId);
        const itemPhotoUrl = `../assets/items/${itemId}-1.png`; 
        const itemPhoto = document.createElement('img');
        itemPhoto.src = itemPhotoUrl;
        itemPhoto.classList.add('item-photo');
        itemPhoto.addEventListener('click', function() {
            const itemId = item[0]; 
     
            window.location.href = `itempage.php?item=${itemId}`;
        });
        itemContainer.appendChild(itemPhoto);

        // Item title
        const titleElement = document.createElement('h3');
        
        titleElement.textContent = item[1];

        titleElement.classList.add('item-title');
        titleElement.addEventListener('click', function() {
            const itemId = item[0]; 
            
            window.location.href = `itempage.php?item=${itemId}`;
        });
        itemContainer.appendChild(titleElement);

        // Item description
        const descriptionElement = document.createElement('p');
        
        descriptionElement.textContent = item[2];
        descriptionElement.classList.add('item-description');
        descriptionElement.addEventListener('click', function() {
            const itemId = item[0]; 
            window.location.href = `itempage.php?item=${itemId}`;
        });
        itemContainer.appendChild(descriptionElement);

        // Item price
        const priceElement = document.createElement('p');
        item[6] = item[6];
        priceElement.textContent = `Price: ${item[6]}`; 
        priceElement.classList.add('item-price');
        priceElement.addEventListener('click', function() {
            const itemId = item[0]; 
            window.location.href = `itempage.php?item=${itemId}`;
        });
        itemContainer.appendChild(priceElement);

        

        // Text for wishlist
        const addToWishlistText = document.createElement('p');
        addToWishlistText.textContent = "Add to Wishlist?";
        addToWishlistText.classList.add('text-icon');
        itemContainer.appendChild(addToWishlistText);

        searchItemsDiv.appendChild(itemContainer);
    });
}




function display_current_filters() {
    const currentFiltersDiv = document.querySelector('.current_filters');
    currentFiltersDiv.innerHTML = ''; 

    for (const key in current_filters) {
        console.log(typeof current_filters[key]);
        
        if(typeof current_filters[key] !== 'boolean' && current_filters[key] !== null){
            current_filters[key].forEach(value => {
                console.log(key, value);
                const filterEntry = document.createElement('div');
                filterEntry.textContent = `${key}: ${value}`;
    
                const removeButton = document.createElement('button');
                removeButton.textContent = 'X';
                removeButton.addEventListener('click', () => {
                    filterEntry.remove();
                    current_filters[key].delete(value);
                    console.log(current_filters);
                    display_current_filters();
                });
    
                filterEntry.appendChild(removeButton);
                currentFiltersDiv.appendChild(filterEntry);
            });
        }
    }
}

async function initialSearch(searchInput , locationInput , brandInput , categoryInput){
    try {
        const response = await fetch('js/get_all_items.php');
        if (!response.ok) {
            throw new Error('Failed to fetch data');
        }
        console.log('Data fetched successfully');
        
        const allItems = await response.json(); 
        console.log(allItems);

        items =  [...allItems];
        console.log(items);

        if(locationInput !== null && locationInput !== ''){
            current_filters['location'] = locationInput;
        } 
        if(brandInput !== null && brandInput !== ''){
            current_filters['brand'].add(brandInput);
        }
        if(categoryInput !== null && categoryInput !== ''){
            current_filters['category'].add(categoryInput);
        }

        if(searchInput === null || searchInput === ''){
            display_current_filters();
            render_items();
        }

        display_current_filters();
        const recommendad_items = calculateSuggestions(searchInput, items);
        console.log("after suggestions");
        console.log(recommendad_items);

        search_algorithm(recommendad_items, false , false);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
} 

function checkLoggedInStatus() {

    console.log('checkLoggedInStatus');

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let isLoggedIn = xhr.responseText;
            console.log('isLoggedIn:', isLoggedIn);
            console.log('isLoggedIn:', typeof isLoggedIn);
            isLoggedIn = parseInt(isLoggedIn);
            if (isLoggedIn !== -1) {
                return isLoggedIn;
            } else {
                return -1;
            }
        }
    };
    xhr.open("GET", "../db_handler/action_is_user_logged_in.php", true);
    xhr.send();
}

document.addEventListener('DOMContentLoaded', function() {
    
    function getUrlParams() {
        var searchParams = new URLSearchParams(window.location.search);
        var searchValue = searchParams.has('search') ? searchParams.get('search') : null;
        var locationValue = searchParams.has('location') ? searchParams.get('location') : null;
        var brandValue = searchParams.has('brand') ? searchParams.get('brand') : null;
        var categoryValue = searchParams.has('category') ? searchParams.get('category') : null;
        return { search: searchValue, location: locationValue , brand: brandValue  , category: categoryValue};
    }

    function performInitialSearch() {
        var urlParams = getUrlParams();
        var searchInput = urlParams.search;
        var locationInput = urlParams.location;
        var brandInput = urlParams.brand;
        var categoryInput = urlParams.category;
        initialSearch(searchInput, locationInput , brandInput , categoryInput);
    }

    performInitialSearch();
});

