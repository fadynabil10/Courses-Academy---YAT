<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $email=$password = $confirm_password = "";
$username_err =$email_err= $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    print_r($_POST["password"]);
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email,$param_password);
            
            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Register</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Courses Academy"/>
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!--// Meta tag Keywords -->

    <!-- Custom-Files -->
    <!-- Bootstrap-Core-Css -->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <!-- Style-Css -->
    <link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
    <!-- Font-Awesome-Icons-Css -->
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <!-- //Custom-Files -->

    <!-- Web-Fonts -->
    <link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
          rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <!-- //Web-Fonts -->

</head>

<body>
<!-- header -->
<header>
    <!-- top header -->
    <div class="top-head-w3ls py-2 bg-dark">
        <div class="container">
            <div class="row">
                <h1 class="text-capitalize text-white col-7">
                    <i class="fas fa-book text-dark bg-white p-2 rounded-circle mr-3"></i>welcome to Courses Academy</h1>
                <!-- social icons -->
                <div class="social-icons text-right col-5">
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="fab fa-facebook-f icon-border facebook rounded-circle"> </a>
                        </li>
                        <li class="mx-2">
                            <a href="#" class="fab fa-twitter icon-border twitter rounded-circle"> </a>
                        </li>
                    </ul>
                </div>
                <!-- //social icons -->
            </div>
        </div>
    </div>
    <!-- //top header -->
    <!-- middle header -->
    <div class="middle-w3ls-nav py-2">
        <div class="container">
            <div class="row">
                <a class="logo font-italic font-weight-bold col-lg-4 text-lg-left text-center" href="index.html">Courses Academy</a>
                <div class="col-lg-8 right-info-agiles mt-lg-0 mt-sm-3 mt-1">
                    <div class="row">
                        <div class="col-sm-4 nav-middle">
                            <i class="far fa-envelope-open text-center mr-md-4 mr-sm-2 mr-4"></i>
                            <div class="agile-addresmk">
                                <p>
                                    <span class="font-weight-bold text-dark">Mail Us</span>
                                    <a href="mailto:mail@example.com">info@CoursesAcademy.com</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 nav-middle mt-sm-0 mt-2">
                            <i class="fas fa-phone-volume text-center mr-md-4 mr-sm-2 mr-4"></i>
                            <div class="agile-addresmk">
                                <p>
                                    <span class="font-weight-bold text-dark">Call Us</span>
                                    +1234-567-890
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 top-login-butt text-right mt-sm-2">
                            <a href="register.php" class="button-head-mow3 text-white">Register</a>

                            <a href="login.php" class="button-head-mow3 text-white">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //middle header -->
</header>
<!-- //header -->

<!-- banner -->
<div class="banner-agile-2">
    <!-- navigation -->
    <div class="navigation-w3ls">
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-nav">
            <button class="navbar-toggler mx-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                <ul class="navbar-nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.html">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="about.html">About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Courses
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="language.html">Language</a>
                            <a class="dropdown-item" href="communication.html">Communication</a>
                            <a class="dropdown-item" href="business.html">Business</a>
                            <a class="dropdown-item" href="software.html">Software</a>
                            <a class="dropdown-item" href="social_media.html">Social Media</a>
                            <a class="dropdown-item" href="photography.html">Photography</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="form.html">Apply Now</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="gallery.html">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="contact.html">Contact Us</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- //navigation -->
</div>
<!-- breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.html">Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Register Form</li>
    </ol>
</nav>
<!-- breadcrumb -->
<!-- //banner -->

<!-- register -->
<div class="login-w3ls py-5">
    <div class="container py-xl-5 py-lg-3">
        <h3 class="title text-capitalize font-weight-light text-dark text-center mb-5">register
            <span class="font-weight-bold">now</span>
        </h3>
        <!-- content -->
        <div class="sub-main-w3 pt-md-4">
            <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-style-agile form-group  <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>
                        Your Name
                        <i class="fas fa-user"></i>
                    </label>
                    <input placeholder="Your Name" class="form-control" name="username" type="text" required="" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-style-agile form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>
                        Email
                        <i class="fas fa-envelope"></i>
                    </label>
                    <input placeholder="Email" class="form-control" name="email" type="email" required="" value="<?php echo $email; ?>" >
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="form-style-agile form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>
                        Password
                        <i class="fas fa-unlock-alt"></i>
                    </label>
                    <input placeholder="Password" class="form-control" name="password" id="password1" type="password" required=""  value="<?php echo $password; ?>" >
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>

                <div class="form-group form-style-agile <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <!-- switch -->
                <ul class="list-unstyled list-login">
                    <li class="switch-agileits float-left">
                        <label class="switch  text-capitalize">
                            <input type="checkbox">
                            <span class="slider-switch slider-switch-2 round"></span>
                            I Accept to the Terms & Conditions
                        </label>
                    </li>
                </ul>
                <!-- //switch -->
                <input type="submit" value="Register">
            </form>
        </div>
        <!-- //content -->
    </div>
</div>
<!-- //register -->


<!-- brands -->
<div class="brands-w3ls py-md-5 py-4">
    <div class="container py-xl-3">
        <ul class="list-unstyled">
            <li>

            </li>
        </ul>
    </div>
</div>
<!-- //brands -->

<!-- footer -->
<footer>
    <div class="container py-4">
        <div class="row py-xl-5 py-sm-3">
            <div class="col-lg-6 map">
                <h2 class="contact-title text-capitalize text-white font-weight-light mb-sm-4 mb-3">our
                    <span class="font-weight-bold">directions</span>
                </h2>
                <iframe src="https://www.google.com/maps/embed?pb=!1m21!1m12!1m3!1d110497.66821097069!2d31.29865423027965!3d30.064040138956354!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m6!3e6!4m0!4m3!3m2!1d30.064339999999998!2d31.228638!5e0!3m2!1sar!2seg!4v1606434195262!5m2!1sar!2seg"></iframe>
                <div class="conta-posi-w3ls p-4 rounded">
                    <h5 class="text-white font-weight-bold mb-3">Address</h5>
                    <p>25095 Rd,
                        <span>13 street,</span> Cairo, Egypt</p>
                </div>
            </div>
            <div class="col-lg-6 contact-agileits-w3layouts mt-lg-0 mt-4">
                <h4 class="contact-title text-capitalize text-white font-weight-light mb-sm-4 mb-3">get in
                    <span class="font-weight-bold">touch</span>
                </h4>
                <p class="conta-para-style border-left pl-4">If you have any questions about the services we provide simply use the form below. We try and respond to all queries
                    and comments within 24 hours.</p>
                <div class="subscribe-w3ls my-xl-5 my-4">
                    <h6 class="text-white text-capitalize mb-4">subscribe our newsletter</h6>
                    <form action="#" method="post" class="subscribe_form">
                        <input class="form-control" type="email" name="email" placeholder="Enter your email..." required="">
                        <button type="submit" class="btn btn-primary submit">Submit</button>
                    </form>
                </div>
                <p class="para-agileits-w3layouts text-white">
                    <i class="fas fa-map-marker pr-3"></i>25095 Blue Ravine Rd,USA</p>
                <p class="para-agileits-w3layouts text-white my-sm-3 my-2">
                    <i class="fas fa-phone pr-3"></i>000 000 0000</p>
                <p class="para-agileits-w3layouts">
                    <i class="far fa-envelope-open pr-2"></i>
                    <a href="mailto:mail@example.com" class=" text-white">info@CoursesAcademy.com</a>
                </p>
            </div>
        </div>
    </div>

</footer>
<!-- //footer -->



<!-- Js files -->
<!-- JavaScript -->
<script src="../js/jquery-2.2.3.min.js"></script>
<!-- Default-JavaScript-File -->
<script src="../js/bootstrap.js"></script>
<!-- Necessary-JavaScript-File-For-Bootstrap -->

<!-- password-script -->
<script>
    window.onload = function () {
        document.getElementById("password1").onchange = validatePassword;
        document.getElementById("password2").onchange = validatePassword;
    }

    function validatePassword() {
        var pass2 = document.getElementById("password2").value;
        var pass1 = document.getElementById("password1").value;
        if (pass1 != pass2)
            document.getElementById("password2").setCustomValidity("Passwords Don't Match");
        else
            document.getElementById("password2").setCustomValidity('');
        //empty string means no validation error
    }
</script>
<!-- //password-script -->

<!-- smooth scrolling -->
<script src="../js/SmoothScroll.min.js"></script>
<!-- //smooth scrolling -->

<!-- move-top -->
<script src="../js/move-top.js"></script>
<!-- easing -->
<script src="../js/easing.js"></script>
<!--  necessary snippets for few javascript files -->
<script src="../js/edulearn.js"></script>

<!-- //Js files -->


</body>

</html>