const userSelectionList = document.querySelector(".user-selection-list");
const additionalFields = document.querySelectorAll(".additional-fields");
const userTypeInput = document.getElementById('user_type'); // Hidden input field

userSelectionList.addEventListener("click", function (e) {
    if (e.target.tagName === "LI") {
        const selectedUserType = e.target.getAttribute("data-user-type");

        // Remove the "selected" class from all list items
        userSelectionList.querySelectorAll("li").forEach(item => {
            item.classList.remove("selected");
        });

        // Add the "selected" class to the clicked list item
        e.target.classList.add("selected");

        // Set the selected user type in the hidden input field
        userTypeInput.value = selectedUserType;

        // Hide all additional field divs
        additionalFields.forEach(field => {
            field.style.display = "none";
        });

        // Show the additional fields based on the selected user type
        const selectedField = document.getElementById(`${selectedUserType}Fields`);
        if (selectedField) {
            selectedField.style.display = "block";
        }
    }
});


// ------------------------------- Password Check -------------------------------

const passwordInput = document.getElementById('password');
const strengthText = document.getElementById('strength-text');

passwordInput.addEventListener('input', function () {
    const password = passwordInput.value;
    const strength = getPasswordStrength(password);

    updateStrengthText(strength);
});

function getPasswordStrength(password) {
    if (password.length < 6) {
        return 0; // Weak
    } else if (password.length < 10) {
        return 30; // Medium
    } else {
        return 100; // Strong
    }
}

function updateStrengthText(strength) {
    let text = '';
    if (strength === 0) {
        text = 'Weak';
        strengthText.style.color = 'red';
    } else if (strength <= 30) {
        text = 'Medium';
        strengthText.style.color = 'orange';
    } else {
        text = 'Strong';
        strengthText.style.color = 'green';
    }
    strengthText.textContent = text;
}



// ------------------------------- Navbar Toggle -------------------------------
function navToggle() {
    var element1 = document.querySelector('.sidenav');
    element1.classList.toggle("sidenav-toggled");

    var element2 = document.querySelector('.overlay-container');
    element2.classList.toggle("overlay-container-active");

    if (window.innerWidth <= 1160) {
        setTimeout(function() {
            document.body.addEventListener('click', handleOutsideClick);
        }, 100);
    }
}

// Close the navbar when clicking outside of it
function handleOutsideClick(event) {
    var sidebar = document.querySelector('.sidenav');
    var toggleButton = document.querySelector('.sidenav-close-btn');
    var overlayContainer = document.querySelector('.overlay-container');

    if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
        sidebar.classList.remove("sidenav-toggled");
        overlayContainer.classList.remove("overlay-container-active");
        document.body.removeEventListener('click', handleOutsideClick);
    }
}

// ------------------------------- Side Card Toggle -------------------------------
// Side card close button
function closeRightCard(){
    var screenWidth = window.innerWidth;
    var element1, element2, element3, element4;

    if (screenWidth <= 720){
        element1 = document.querySelector('.side-cards');
        element1.classList.toggle("side-cards-active");

        element2 = document.querySelector('.open-side-cards-btn');
        element2.classList.toggle("open-side-cards-btn-hide");
    }
    else {
        element1 = document.querySelector('.side-cards');
        element1.classList.toggle("side-cards-hide");

        element2 = document.querySelector('.cards');
        element2.classList.toggle("cards-active");

        element3 = document.querySelector('.charts');
        element3.classList.toggle("charts-active");

        element4 = document.querySelector('.open-side-cards-btn');
        element4.classList.toggle("open-side-cards-btn-active");
    }
}
