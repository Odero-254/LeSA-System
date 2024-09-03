<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="dist/css/style2.css" rel="stylesheet" type="text/css">
    <title>User Profile</title>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h2>Basic Information</h2>
        </div>
        <div class="profile-content">
            <div class="profile-picture">
                <img src="path_to_user_image" alt="User Image">
                <button class="upload-button">Upload Profile Picture</button>
            </div>
            <div class="profile-info">
                <div class="info-item">
                    <label>Name:</label>
                    <span>John Doe</span>
                </div>
                <div class="info-item">
                    <label>Email:</label>
                    <span>john.doe@example.com</span>
                </div>
                <div class="info-item">
                    <label>Phone Number:</label>
                    <span>+1234567890</span>
                </div>
                <div class="info-item">
                    <label>Date Registered:</label>
                    <span>01/01/2023</span>
                </div>
                <div class="info-item">
                    <label>Last Updated:</label>
                    <span>07/15/2024</span>
                </div>
                <div class="info-item">
                    <label>Department:</label>
                    <span>IT Department</span>
                </div>
            </div>
        </div>
        <button class="open-form-button" onclick="openForm()">Edit Information</button>
    </div>

    <div class="form-popup" id="editForm">
        <form action="/submit_info" class="form-container">
            <h2>Edit Information</h2>

            <label for="name"><b>Name</b></label>
            <input type="text" placeholder="Enter Name" name="name" required>

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>

            <label for="phone"><b>Phone Number</b></label>
            <input type="text" placeholder="Enter Phone Number" name="phone" required>

            <label for="department"><b>Department</b></label>
            <input type="text" placeholder="Enter Department" name="department" required>

            <button type="submit" class="btn">Save</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>

    <script>
        function openForm() {
            document.getElementById("editForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("editForm").style.display = "none";
        }
    </script>
</body>
</html>
