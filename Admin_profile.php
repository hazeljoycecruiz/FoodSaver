<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile </title>
    <link href="img/favicon.ico" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Heebo:wght@400;600;700&display=swap" rel="stylesheet">


    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    
</head>
<body>
    <div class="container py-4">
        <!-- Back Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="back-btn" onclick="window.location.href='Admin_index.php'">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
        </div>
        <div style="border: 2px solid #E95F5D; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <input class="form-control" type="text" value="       My Profile" 
            aria-label="Disabled input example" disabled readonly 
            style="background-color: white; color: black;">
        </div>
        <!-- Profile Content -->
        <div class="row g-3 mt-1 ">
            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="sidebar pt-5" style="border: 2px solid #E95F5D; border-radius: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Profile Icon -->

                <!-- Display the Profile Picture -->
                <div class="profile-picture-container">
                    <img src="img/admin.png" alt="Profile Picture" id="profile-pic" onclick="document.getElementById('file-input').click();" style="cursor: pointer;">
                    <input type="file" id="file-input" accept="image/*" style="display: none;" onchange="previewImage(event)">
                </div>

                    <a href="#" class="pb-4 name" style="text-decoration: none;"><h5>Admin</h5></a>
                    <!-- Favorites Menu Item -->
                    
                    
                  
                    <div class="nav flex-column">
                        
                    </div>
                    <div class="pt-5 pb-5">
                    </div>
                    <div class="pt-5 pb-5">
                    </div>
                    <div class="pt-5 pb-5">
                    </div>

                    <div class="pt-2 pb-5">
                    </div>
                 
                </div>
            </div>

            <!-- Favorites -->
            <div class="col-md-8">

                <div class="favorites-container" style="border: 2px solid #E95F5D; border-radius: 12px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                   
                        <div class="profiles-picture-container">
                            <img src="img/photo_edit.png" alt="Profile Picture" id="profile-pic" onclick="document.getElementById('file-input').click();" style="cursor: pointer;">
                            <input type="file" id="file-input" accept="image/*" style="display: none;" onchange="previewImage(event)">
                        </div>

                        <div class="row">
                            <div class="col mb-4">
                                <input type="first_name" class="form-control-lg w-100 transparent-border" id="first_name" placeholder="First Name">
                            </div>
                            <div class="col mb-4">
                                <input type="last_name" class="form-control-lg w-100 transparent-border" id="last_name" placeholder="Last Name">
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col mb-4">
                                <input type="email" class="form-control-lg w-100 transparent-border" id="age" placeholder="Age">
                            </div>
                            <div class="col mb-4">
                                <input type="email" class="form-control-lg w-100 transparent-border" id="birthdate" placeholder="Birthdate       Ex.  March 21, 1977">
                            </div>
                        </div>
                    
                        <div class="mb-4 w-100">
                            <input type="email" class="form-control-lg w-100 transparent-border" id="address" placeholder="Address">
                        </div>
                    
                        <div class="mb-4 w-100">
                            <input type="email" class="form-control-lg w-100 transparent-border" id="email" placeholder="Email">
                        </div>
                    
                        <div class="mb-3 ">
                            <input type="email" class="form-control-lg w-100 transparent-border" id="contact_number" placeholder="Contact Number">
                        </div>
                    
                        <div class="d-flex justify-content-end pt-1">
                            <button type="button" class="btn btn-primary  w-25 rounded-pill" onclick="window.location.href='Admin_index.php'">Save</button>
                        </div>
    
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
