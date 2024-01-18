<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    #formContainer {
      text-align: center;
    }

    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 300px;
    }

    input {
      width: calc(100% - 20px);
      padding: 10px;
      margin-bottom: 10px;
      box-sizing: border-box;
    }

    button {
      background-color: #4caf50;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-right: 5px;
    }

    button:hover {
      background-color: #45a049;
    }

    .error {
      color: red;
    }

    #actionButtons {
      display: flex;
      flex-direction: row;
    }

    #profileLogo {
      cursor: pointer;
      margin-left: 20px;
    }

    #profileContainer,
    #editProfileContainer {
      display: none;
    }
  </style>
  <script>
    function register() {
      var mobileNumber = document.getElementById("mobileNumber").value;
      var name = document.getElementById("name").value;
      var password = document.getElementById("password").value;
      var backupCode = document.getElementById("backupCode").value;
      var email = document.getElementById("email").value;

      // Validate input
      var mobileNumberPattern = /^\d{10}$/;
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!mobileNumberPattern.test(mobileNumber) || !name || !password || password.length !== 8 || !backupCode || backupCode.length !== 12 || !emailPattern.test(email)) {
        document.getElementById("error").innerText = "Please fill in all fields correctly. Mobile number should be 10 digits, password 8 digits, backup code 12 digits, and email should follow the standard email pattern.";
        return;
      }

      // Retrieve existing users or initialize an empty array
      var users = JSON.parse(localStorage.getItem("users")) || [];

      // Check if the mobile number is already registered
      if (users.some(user => user.mobileNumber === mobileNumber)) {
        document.getElementById("error").innerText = "Mobile number is already registered.";
        return;
      }

      // Generate a unique user ID
      var userId = generateUserId();

      // Add the new user to the array
      users.push({
        userId: userId,
        mobileNumber: mobileNumber,
        name: name,
        password: password,
        backupCode: backupCode,
        email: email
      });

      // Store the updated users array in localStorage
      localStorage.setItem("users", JSON.stringify(users));

      // Set expiration time (1 hour in milliseconds)
      var expirationTime = new Date().getTime() + 3600000;
      localStorage.setItem("expirationTime", expirationTime);

      // Reset error message
      document.getElementById("error").innerText = "";

      // Redirect to login form
      showLogin();
    }

    function login() {
      var loginMobileNumber = document.getElementById("loginMobileNumber").value;
      var loginPassword = document.getElementById("loginPassword").value;
      var loginBackupCode = document.getElementById("loginBackupCode").value;

      // Retrieve existing users
      var users = JSON.parse(localStorage.getItem("users")) || [];

      // Find the user with the provided mobile number
      var user = users.find(u => u.mobileNumber === loginMobileNumber);

      // Validate login credentials
      if (user && user.password === loginPassword && user.backupCode === loginBackupCode) {
        // Reset error message
        document.getElementById("loginError").innerText = "";

        // Redirect to profile page
        showProfile(user);

        // Show congratulations alert
        alert("Congratulations! Your login was successful. Your ID: " + user.userId);
      } else {
        document.getElementById("loginError").innerText = "Invalid mobile number, password, or backup code.";
      }
    }

    function checkExpiration() {
      var expirationTime = localStorage.getItem("expirationTime");
      if (expirationTime && new Date().getTime() > parseInt(expirationTime)) {
        // Clear stored data if it has expired
        localStorage.removeItem("users");
        localStorage.removeItem("expirationTime");
      }
    }

    function showLogin() {
      // Check for expiration before showing the login form
      checkExpiration();

      document.getElementById("registrationSection").style.display = "none";
      document.getElementById("loginSection").style.display = "block";
      document.getElementById("profileContainer").style.display = "none";
      document.getElementById("editProfileContainer").style.display = "none";
    }

    function showRegister() {
      document.getElementById("loginSection").style.display = "none";
      document.getElementById("registrationSection").style.display = "block";
      document.getElementById("profileContainer").style.display = "none";
      document.getElementById("editProfileContainer").style.display = "none";
    }

    function generateUserId() {
      return '_' + Math.random().toString(36).substr(2, 9);
    }

    function showProfile(user) {
      document.getElementById("registrationSection").style.display = "none";
      document.getElementById("loginSection").style.display = "none";
      document.getElementById("profileContainer").style.display = "block";
      document.getElementById("editProfileContainer").style.display = "none";

      // Display user information in the profile section
      document.getElementById("profileUserId").innerText = "User ID: " + user.userId;
      document.getElementById("profileMobileNumber").innerText = "Mobile Number: " + user.mobileNumber;
      document.getElementById("profileName").innerText = "Name: " + user.name;
      document.getElementById("profilePassword").innerText = "Password: " + user.password;
      document.getElementById("profileBackupCode").innerText = "Backup Code: " + user.backupCode;
      document.getElementById("profileEmail").innerText = "Email: " + user.email;

      // Show the "Edit" button
      document.getElementById("editButton").style.display = "block";
    }

    function editProfile() {
      // Hide the profile section and show the edit profile section
      document.getElementById("profileContainer").style.display = "none";
      document.getElementById("editProfileContainer").style.display = "block";

      // Populate the edit profile fields with current values
      var user = getCurrentUser();
      document.getElementById("editUserId").value = user.userId;
      document.getElementById("editMobileNumber").value = user.mobileNumber;
      document.getElementById("editName").value = user.name;
      document.getElementById("editPassword").value = user.password;
      document.getElementById("editBackupCode").value = user.backupCode;
      document.getElementById("editEmail").value = user.email;
    }

    function saveEditedProfile() {
      var editedUserId = document.getElementById("editUserId").value;
      var editedMobileNumber = document.getElementById("editMobileNumber").value;
      var editedName = document.getElementById("editName").value;
      var editedPassword = document.getElementById("editPassword").value;
      var editedBackupCode = document.getElementById("editBackupCode").value;
      var editedEmail = document.getElementById("editEmail").value;

      // Retrieve existing users
      var users = JSON.parse(localStorage.getItem("users")) || [];

      // Find the user with the provided user ID
      var userIndex = users.findIndex(u => u.userId === editedUserId);

      // Update the user's information
      if (userIndex !== -1) {
        users[userIndex].mobileNumber = editedMobileNumber;
        users[userIndex].name = editedName;
        users[userIndex].password = editedPassword;
        users[userIndex].backupCode = editedBackupCode;
        users[userIndex].email = editedEmail;

        // Store the updated users array in localStorage
        localStorage.setItem("users", JSON.stringify(users));

        // Show the profile section with the updated information
        showProfile(users[userIndex]);

        // Show a success message
        alert("Your profile has been updated successfully.");
      }
    }

    function getCurrentUser() {
      var userId = document.getElementById("profileUserId").innerText.split(":")[1].trim();
      var users = JSON.parse(localStorage.getItem("users")) || [];
      return users.find(u => u.userId === userId);
    }

    function logout() {
      // Clear stored data when the user logs out
      localStorage.removeItem("users");
      localStorage.removeItem("expirationTime");

      // Redirect to login form
      showLogin();
    }
    function showAdminPage() {
      window.location.href = "admin.html";
    }
  </script>
</head>
<body onload="showLogin()">
  <div id="formContainer">
    <form>
      <div id="actionButtons">
        <button type="button" onclick="showRegister()">Register</button>
        <button type="button" onclick="showLogin()">Login</button>
        <div id="profileLogo" data-toggle="modal" data-target="#profileModal">&#128100;</div>
      </div>

      <div id="registrationSection">
        <h2>Register</h2>
        <input type="text" id="mobileNumber" placeholder="Mobile Number (10 digits)">
        <input type="text" id="name" placeholder="Name">
        <input type="password" id="password" placeholder="Password (8 digits)">
        <input type="text" id="backupCode" placeholder="Backup Code (12 digits)">
        <input type="text" id="email" placeholder="Email">
        <button type="button" onclick="register()">Submit</button>
        <p class="error" id="error"></p>
      </div>

      <div id="loginSection" style="display: none;">
        <h2>Login</h2>
        <input type="text" id="loginMobileNumber" placeholder="Mobile Number">
        <input type="password" id="loginPassword" placeholder="Password">
        <input type="text" id="loginBackupCode" placeholder="Backup Code">
        <button type="button" onclick="login()">Login</button>
        <p class="error" id="loginError"></p>
      </div>

      <div id="profileContainer">
        <h2>Profile</h2>
        <p id="profileUserId"></p>
        <p id="profileMobileNumber"></p>
        <p id="profileName"></p>
        <p id="profilePassword"></p>
        <p id="profileBackupCode"></p>
        <p id="profileEmail"></p>
        <button type="button" id="editButton" onclick="editProfile()">Edit</button>
        <button type="button" onclick="logout()">Logout</button>
      </div>

      <div id="editProfileContainer">
        <h2>Edit Profile</h2>
        <input type="text" id="editUserId" disabled>
        <input type="text" id="editMobileNumber" placeholder="Mobile Number">
        <input type="text" id="editName" placeholder="Name">
        <input type="password" id="editPassword" placeholder="Password (8 digits)">
        <input type="text" id="editBackupCode" placeholder="Backup Code (12 digits)">
        <button type="button" onclick="saveEditedProfile()">Save</button>
      </div>
    </form>
  </div>
</body>
</html>
