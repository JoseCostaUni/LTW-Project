
let inputedImages = [];


document.addEventListener("DOMContentLoaded", function() {
  var searchInput = document.querySelector(".search_category");
  var suggestions = document.querySelector(".suggestions");

  searchInput.addEventListener("click", function() {
    suggestions.style.display = suggestions.style.display === "block" ? "none" : "block";
  });

  var suggestionOptions = document.querySelectorAll(".suggestions div");
  suggestionOptions.forEach(function(option) {
    option.addEventListener("click", function() {
      searchInput.value = option.value;
      suggestions.style.display = "none";
    });
  });

  var subSearchInput = document.querySelector(".sub_search_category");
  var subSuggestions = document.querySelector(".sub_suggestions");

  subSearchInput.addEventListener("click", function() {
    subSuggestions.style.display = subSuggestions.style.display === "block" ? "none" : "block";
  });

  var subSuggestionOptions = document.querySelectorAll(".sub_suggestions div");
  subSuggestionOptions.forEach(function(option) {
    option.addEventListener("click", function() {
      subSearchInput.value = option.value;
      subSuggestions.style.display = "none";
    });
  });

  const inputElements = document.querySelectorAll('.image_inputer');

  inputElements.forEach(inputElement => {
    inputElement.addEventListener('change', (event) => {
        console.log("image input changed");

        const file = event.target.files[0];
        inputedImages.push(file);

        const reader = new FileReader();
        let originalHolder = event.target.id;

        for (let i = 1; i <= 15; i++) {
            const imageHolder = document.getElementById('selected_image' + i);
            const src = imageHolder.src;
            const fileName = src.substring(src.lastIndexOf('/') + 1);
            console.log("Image " + i + ":", fileName);

            if (fileName === 'camera.png') {
                imageHolder.src = URL.createObjectURL(file);
                const frame = document.getElementById('image_icon' + i);
                frame.classList.remove('image_icon');
                frame.classList.add('new_image');

                console.log('Frame:', frame);
                console.log("Image " + i + ":", file.name);

                frame.addEventListener('mouseenter', () => {
                  let closeIcon = frame.querySelector('.close_icon');
                  console.log('Close Icon:', closeIcon);

                  if (!closeIcon && file.name !== 'camera.png') {
                      closeIcon = document.createElement('span');
                      closeIcon.innerHTML = 'Remove Image';
                      closeIcon.classList.add('close_icon');
                      frame.appendChild(closeIcon);
                  }
              
                  closeIcon.addEventListener('click', () => {

                      console.log('Close icon clicked');
                      console.log('inputedImages before:', inputedImages);
                      inputedImages = inputedImages.filter(image => image !== file);
                      console.log('inputedImages after:', inputedImages);
                      imageHolder.src = '../assets/camera.png';
                      frame.classList.remove('new_image');
                      frame.classList.add('image_icon');
                      frame.removeChild(closeIcon);
                      
                  });
              });
              
              frame.addEventListener('mouseleave', () => {
                  const closeIcon = frame.querySelector('.close_icon');
                  if (closeIcon) {
                      frame.removeChild(closeIcon);
                  }
              });

                break;
            }

            if (i === 15) {
                let originalHolderNumber = originalHolder.replace(/\D/g, '');
                let newHolder = document.getElementById('selected_image' + originalHolderNumber);
                newHolder.src = URL.createObjectURL(file);
                newHolder.style.width = '100%';
                newHolder.style.height = '100%';
                newHolder.style.objectFit = 'cover';
                break;
            }
        }
    });
});



});



document.addEventListener("DOMContentLoaded", function() {
  var searchInput = document.querySelector(".search_category");
  var suggestions = document.querySelector(".suggestions");
  var suggestionOptions = suggestions.querySelectorAll(".category-option");

  searchInput.addEventListener("input", function() {
      var searchText = searchInput.value.toLowerCase();
      suggestionOptions.forEach(function(option) {
          var optionText = option.textContent.toLowerCase();
          if (optionText.includes(searchText)) {
              option.style.display = "block";
          } else {
              option.style.display = "none";
          }
      });
  });

  suggestionOptions.forEach(function(option) {
      option.addEventListener("click", function() {
          searchInput.value = option.textContent;
          suggestions.style.display = "none";
      });
  });
});


document.addEventListener("DOMContentLoaded", function() {
  var subSearchInput = document.querySelector(".sub_search_category");
  var subSuggestions = document.querySelector(".sub_suggestions");
  var subSuggestionOptions = subSuggestions.querySelectorAll(".subcategory-option");

  subSearchInput.addEventListener("input", function() {
      var searchText = subSearchInput.value.toLowerCase();
      subSuggestionOptions.forEach(function(option) {
          var optionText = option.textContent.toLowerCase();
          if (optionText.includes(searchText)) {
              option.style.display = "block";
          } else {
              option.style.display = "none";
          }
      });
  });

  subSuggestionOptions.forEach(function(option) {
      option.addEventListener("click", function() {
          subSearchInput.value = option.textContent;
          subSuggestions.style.display = "none";
      });
  });
});

document.addEventListener("DOMContentLoaded", function() {
  var titleInput = document.querySelector(".Item-Title");
  var wordCount = document.querySelector(".word-count");

  titleInput.addEventListener("input", function(event) {
      var inputLength = titleInput.value.length;

      wordCount.textContent = inputLength + "/50 letters";

      if (inputLength >= 50) {
          event.preventDefault();
          titleInput.value = titleInput.value.substring(0, 50);
      }
  });
});


document.addEventListener("DOMContentLoaded", function() {
  var descriptionInput = document.querySelector(".description-text");
  var wordCount = document.querySelector(".word-counter");


  descriptionInput.addEventListener("input", function() {
      var words = descriptionInput.value.trim().split(/\s+/).filter(Boolean); 
      var wordLength = words.length;

      wordCount.textContent = wordLength + "/200 words";

      if (wordLength > 200) {
          event.preventDefault();
          descriptionInput.value = words.slice(0, 200).join(" ");
          
      }
  });
});



document.addEventListener("DOMContentLoaded", function() {
  var tamanhoInput = document.querySelector(".Tamanho");
  var tamanhoDropdown = document.querySelector(".sizes");
  var estadoInput = document.querySelector(".Estado");
  var conditionsDropdown = document.querySelector(".conditions");

  
  tamanhoInput.addEventListener("click", function() {
      tamanhoDropdown.style.display = tamanhoDropdown.style.display === "block" ? "none" : "block";
  });


  estadoInput.addEventListener("click", function() {
      conditionsDropdown.style.display = conditionsDropdown.style.display === "block" ? "none" : "block";
  });

  tamanhoInput.addEventListener("keydown", function(event) {
      event.preventDefault();
  });

  estadoInput.addEventListener("keydown", function(event) {
      event.preventDefault();
  });

  tamanhoDropdown.addEventListener("click", function(event) {
    var clickedElement = event.target.closest("li.size_list");
    if (clickedElement) {
        tamanhoInput.value = clickedElement.textContent;
        tamanhoDropdown.style.display = "none";
    }
});

conditionsDropdown.addEventListener("click", function(event) {
    var clickedElement = event.target.closest("li.condition_list");
    if (clickedElement) {
        estadoInput.value = clickedElement.textContent;
        conditionsDropdown.style.display = "none";
    }
});

});


function sanitizeInput(input) {
  input.trim().replace(/</g, "&lt;").replace(/>/g, "&gt;");
  return DOMPurify.sanitize(input);
}


document.addEventListener("DOMContentLoaded", function() {
  var publicarBtn = document.querySelector(".Publicar");

  publicarBtn.addEventListener("click", function() {
      
      console.log('Publish button clicked');

      let title = sanitizeInput(document.querySelector(".Item-Title").value);
      let category = sanitizeInput(document.querySelector(".search_category").value);
      let subCategory = sanitizeInput(document.querySelector(".sub_search_category").value);
      let description = sanitizeInput(document.querySelector(".description-text").value);
      let price = sanitizeInput(document.querySelector(".Preço_").value);
      let tamanho = sanitizeInput(document.querySelector(".Tamanho").value);
      let marca = sanitizeInput(document.querySelector(".Marca").value);
      let estado = sanitizeInput(document.querySelector(".Estado").value);
      let numberOfImages = inputedImages.length;
      let csrf_token = document.getElementById("csrf_token");

      console.log('Title:', title);
      console.log('Category:', category);
      console.log('Subcategory:', subCategory);
      console.log('Description:', description);
      console.log('Price:', price);
      console.log('Tamanho:', tamanho);
      console.log('Marca:', marca);
      console.log('Estado:', estado);
      console.log('Number of images:', numberOfImages);

      if (title.trim() === "" || category.trim() === "" || description.trim() === "" || price.trim() === "" || marca.trim() === "" || estado.trim() === "") {
          alert("Please fill in all required fields.");
          return;
      }

      const formElements = document.querySelectorAll('.form');

      formElements.forEach(formElement => {
          formElement.submit();
      });

      console.log('Form submitted');

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "add_item.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
              console.log(xhr.responseText);
          } 
      };
      
      xhr.send("title=" + encodeURIComponent(title) + "&category=" + encodeURIComponent(category) + "&subCategory=" + encodeURIComponent(subCategory) + "&description=" + encodeURIComponent(description) + "&price=" + encodeURIComponent(price) + "&tamanho=" + encodeURIComponent(tamanho) + "&marca=" + encodeURIComponent(marca) + "&estado=" + encodeURIComponent(estado)
        + "&imagesSizes=" + numberOfImages + '&csrf_token=' + encodeURIComponent(csrf_token.value));
      

      inputedImages.forEach((image, index) => {
        const formData = new FormData();
        formData.append('item_image', image);
        formData.append('index', index); 
        formData.append('csrf_token', csrf_token.value);
    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../db_handler/uploadItemImage.php');
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                document.getElementById('profile-image').src = xhr.responseText;
            } else {
                console.error(xhr.responseText);
            }
        };
        xhr.send(formData);
    });
      

    
  });
});

