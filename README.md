<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Protected App</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #000305;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        color: white;
    }
    .container {
        display: none;
    }
    .active {
        display: block;
    }
    .keyboard {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 10px;
    }
    .keyboard button {
        font-size: 1.5em;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #e9ecef;
        cursor: pointer;
    }
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    .popup-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        max-width: 80%;
        text-align: center;
        color: black;
    }
    img{
        height: 100px;
        width: 100px;
    }
    h1{
        display: none;
    }
</style>
</head>
<body>


<div class="container text-center password-input">
    <h2>Create Password</h2>
    <input type="password" id="password" maxlength="8" class="form-control mb-3" placeholder="Enter your password">
    <input type="password" id="confirmPassword" maxlength="8" class="form-control mb-3" placeholder="Confirm your password" style="display: none;">
    <div class="keyboard">
        <button class="btn btn-secondary">1</button>
        <button class="btn btn-secondary">2</button>
        <button class="btn btn-secondary">3</button>
        <button class="btn btn-secondary">4</button>
        <button class="btn btn-secondary">5</button>
        <button class="btn btn-secondary">6</button>
        <button class="btn btn-secondary">7</button>
        <button class="btn btn-secondary">8</button>
        <button class="btn btn-secondary">9</button>
        <button class="btn btn-secondary">0</button>
        <button id="clear" class="btn btn-light">Clear</button>
        <button id="next" class="btn btn-success" style="display:none;">Next</button>
    </div>
</div>

<div class="container text-center enter-password">
    <h2>Enter your App Lock Password</h2>
    <input type="password" id="enteredPassword" maxlength="8" class="form-control mb-3" placeholder="Enter your password">
    <div class="keyboard">
        <button class="btn btn-secondary">1</button>
        <button class="btn btn-secondary">2</button>
        <button class="btn btn-secondary">3</button>
        <button class="btn btn-secondary">4</button>
        <button class="btn btn-secondary">5</button>
        <button class="btn btn-secondary">6</button>
        <button class="btn btn-secondary">7</button>
        <button class="btn btn-secondary">8</button>
        <button class="btn btn-secondary">9</button>
        <button class="btn btn-secondary">0</button>
        <button id="clearEntered" class="btn btn-light">Clear</button>
        <button id="submit" class="btn btn-primary">Submit</button>
    </div>
</div>

<div class="popup" id="successPopup">
    <div class="popup-content">
        <h2>Login Successful!</h2>
        <p>You may now proceed to the next page.</p>
    </div>
</div>

<div class="popup" id="errorPopup">
    <div class="popup-content">
        <h2>Incorrect Password!</h2>
        <p>Please try again.</p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const splashScreen = document.querySelector('.splash-screen');
    const passwordInputSection = document.querySelector('.password-input');
    const enterPasswordSection = document.querySelector('.enter-password');
    const successPopup = document.getElementById('successPopup');
    const errorPopup = document.getElementById('errorPopup');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const enteredPasswordInput = document.getElementById('enteredPassword');
    const nextButton = document.getElementById('next');
    const submitButton = document.getElementById('submit');
    const clearButton = document.getElementById('clear');
    const clearEnteredButton = document.getElementById('clearEntered');

    function showSection(section) {
        document.querySelectorAll('.container').forEach(function(el) {
            el.classList.remove('active');
        });
        section.classList.add('active');
    }

    function showPopup(popup) {
        popup.style.display = 'flex';
        setTimeout(() => {
            popup.style.display = 'none';
            if (popup === successPopup) {
                window.location.href = "secondpage.html"; // Replace with your second page URL
            }
        }, 5000);
    }

    setTimeout(() => {
        const storedPassword = localStorage.getItem('password');
        if (storedPassword) {
            showSection(enterPasswordSection);
        } else {
            showSection(passwordInputSection);
        }
    function clearPasswordInputs() {
        passwordInput.value = "";
        confirmPasswordInput.value = "";
        enteredPasswordInput.value = "";
        nextButton.style.display = 'none';
        nextButton.textContent = "Next";
    }

    document.querySelectorAll('.keyboard').forEach(kb => kb.addEventListener('click', function(event) {
        if (event.target.tagName === "BUTTON") {
            let buttonValue = event.target.textContent.trim();
            if (buttonValue === "Clear") {
                clearPasswordInputs();
            } else if (buttonValue === "Next") {
                confirmPasswordInput.style.display = 'block';
                nextButton.textContent = "Submit";
            } else if (buttonValue === "Submit") {
                if (passwordInputSection.classList.contains('active')) {
                    if (passwordInput.value === confirmPasswordInput.value) {
                        localStorage.setItem('password', passwordInput.value);
                        showPopup(successPopup);
                    } else {
                        alert("Passwords do not match. Please try again.");
                        clearPasswordInputs();
                    }
                }
            } else {
                if (passwordInputSection.classList.contains('active')) {
                    if (passwordInput.value.length < 8) {
                        passwordInput.value += buttonValue;
                        if (passwordInput.value.length === 8) {
                            nextButton.style.display = 'block';
                        }
                    } else if (confirmPasswordInput.style.display === 'block' && confirmPasswordInput.value.length < 8) {
                        confirmPasswordInput.value += buttonValue;
                        if (confirmPasswordInput.value.length === 8) {
                            nextButton.style.display = 'block';
                        }
                    }
                } else if (enterPasswordSection.classList.contains('active')) {
                    if (enteredPasswordInput.value.length < 8) {
                        enteredPasswordInput.value += buttonValue;
                    }
                }
            }
        }
    }));

    clearButton.addEventListener('click', () => {
        clearPasswordInputs();
    });

    clearEnteredButton.addEventListener('click', () => {
        enteredPasswordInput.value = "";
    });

    submitButton.addEventListener('click', () => {
        const storedPassword = localStorage.getItem('password');
        if (enteredPasswordInput.value === storedPassword) {
            showPopup(successPopup);
        } else {
            showPopup(errorPopup);
            enteredPasswordInput.value = "";
        }
    });
});
</script>

</body>
