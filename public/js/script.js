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


