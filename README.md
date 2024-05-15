
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cool App Showcase</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <style>
    /* Custom styles */
    #welcomePopup, #downloadPopup, #loader, #generatingPopup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
    }
    .popup-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
    }
    .bold {
      font-weight: bold;
    }
    .italic {
      font-style: italic;
    }

    /* Additional styles for layout */
    .content-container {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .important-note-container {
      border: 2px solid #f00;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(255, 0, 0, 0.2);
      animation: blinker 3s linear infinite;
    }
    .blinking-text {
      color: #f00;
    }
    @keyframes blinker {
      50% {
        opacity: 0;
      }
    }
    /* CSS */
    .blinking-text.bold {
      color: #f00;
      font-weight: bold;
    }
    /* Loader animation */
    .loader {
      border: 8px solid #f3f3f3;
      border-top: 8px solid #3498db;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 2s linear infinite;
      margin: 20px auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">VB APP</span>
  </nav>

  <!-- Main Content -->
  <div class="container mt-4">
    <div class="row">
      <!-- Left Side - Logo -->
      <div class="col-md-3">
        <div class="content-container">
          <img src="https://i.fbcd.co/products/resized/resized-750-500/vb-bv-creative-logo-designs-2-489105599fadb3aa48601129288df31e69b3b5f268a001439557f15c60e8b103.jpg" alt="Logo" class="img-fluid">
        </div>
      </div>
      <!-- Right Side - App Details -->
      <div class="col-md-9">
        <div class="content-container">
          <h2>App Name: <span class="bold">VB APP</span></h2>
          <p>APK Size: <span class="bold">3 MB ONLY</span></p>
          <p>Developer: <span class="bold">VED BHOGAYTA</span></p>
          <h3>App Features:</h3>
          <ul>
            <li>
              <span class="bold">REGISTER & LOGIN:</span>
              <p>User register and login is compulsory to secure your data.</p>
            </li>
            <li>
              <span class="bold">HELPER AI:</span>
              <p>This AI helps with all your problems. If you face any issues with registration and login, click "Need Help," and my AI employee will provide a solution.</p>
            </li>
            <li>
              <span class="bold">PROFILE:</span>
              <p>Profile contains your registered data.</p>
            </li>
            <li>
              <span class="bold">EDIT DATA:</span>
              <p>When you don't remember your registered data, you can use the "Edit Data" feature to edit your registered data such as mobile number, username, password, email address, and backup code.</p>
            </li>
            <li>
              <span class="bold">SHARE & INVITE:</span>
              <p>Use the "Share & Invite" feature to invite your friends using a referral code.</p>
            </li>
            <li>
              <span class="bold">LOGOUT:</span>
              <p>Use this feature to remove your data from the app. Click "Logout" to delete your data.</p>
            </li>
          </ul>
        </div>
        <!-- HTML -->
        <div class="content-container">
          <b>IMPORTANT NOTE:</b>
          <p class="blinking-text bold">WHEN YOU DOWNLOAD THIS APP, MOST DEVICES WILL SHOW A SECURITY SCAN WARNING. WHEN YOU SEE IT, DON'T WORRY. CLICK "SCAN AND INSTALL." THIS APP WON'T HARM YOUR DEVICE.</p>
        </div>
       <center><button id="downloadButton" class="btn btn-primary">Download</button></center><br>
               <div class="content-container">
          <b>IMPORTANT NOTE 2:</b>
          <p class="blinking-text bold">This APK admin does not have any database to store your data, so don't worry, your data will be secured.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3 mt-4">
    <p>&copy; 2024 VB APP. All rights reserved.</p>
  </footer>

  <!-- Welcome Popup -->
  <div id="welcomePopup">
    <div class="popup-content">
      <h2>Welcome, friends!</h2>
      <button id="closePopupBtn" class="btn btn-primary">Close</button>
    </div>
  </div>

  <!-- Download Popup -->
  <div id="downloadPopup">
    <div class="popup-content">
      <h2>Thanks for downloading!</h2>
      <div id="loader" class="loader"></div>
      <p>Your download will start shortly.</p>
    </div>
  </div>

  <!-- Generating Popup -->
  <div id="generatingPopup">
    <div class="popup-content">
      <h2>Generating...</h2>
      <div id="loader" class="loader"></div>
      <p>Please wait while we generate the content.</p>
    </div>
  </div>

  <!-- Bootstrap JS and jQuery (optional for Bootstrap) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Custom JavaScript -->
  <script>
    // Function to show welcome popup on first visit
    $(document).ready(function(){
      if(localStorage.getItem("visited") === null) {
        $("#welcomePopup").show();
        localStorage.setItem("visited", "true");
      }
    });

    // Function to close welcome popup
    $("#closePopupBtn").click(function(){
      $("#welcomePopup").hide();
    });

    // Function to handle download button click
    $("#downloadButton").click(function(){
      $("#downloadPopup").show();
      setTimeout(function(){
        $("#downloadPopup").hide();
        $("#generatingPopup").show();
        setTimeout(function(){
          $("#generatingPopup").hide();
          // Redirect to the second page
          window.location.href = "https://www.mediafire.com/file/fnuuw7rd6hvo7qm/VB+APP.apk/file";
        }, 5000); // 5 seconds for generating content
      }, 5000); // 5 seconds for showing download popup
    });
  </script>
