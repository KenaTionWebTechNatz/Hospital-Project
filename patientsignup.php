<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$fullname = $email = $password = $confirm_password = "";
$fullname_err = $email_err = $password_err  = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate fullname
    if(empty(trim($_POST["fullname"]))){
        $username_err = "Please enter your fullname.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM patient WHERE fullname = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_fullname);
            
            // Set parameters
            $param_fullname = trim($_POST["fullname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $fullname_err = "This fullname is already taken.";
                } else{
                    $fullname= trim($_POST["fullname"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    
    
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $username_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM patient WHERE email = ?";
        
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
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
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
    if(empty($fullname_err) && empty($email_err)  && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO patient ( fullname,email, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss",$param_fullname,$param_email,$param_password);
            
            // Set parameters
            $param_fullname = $fullname;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: patientlogin.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

    <!DOCTYPE html>
    <html lang="zxx" class="no-js">
    <head>
        <!-- Mobile Specific Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Favicon-->
        <link rel="shortcut icon" href="img/fav.png">
        <!-- Author Meta -->
        <meta name="author" content="colorlib">
        <!-- Meta Description -->
        <meta name="description" content="">
        <!-- Meta Keyword -->
        <meta name="keywords" content="">
        <!-- meta character set -->
        <meta charset="UTF-8">
        <!-- Site Title -->
        <title>Patient Sign Up</title>

        <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
            <!--
            CSS
            ============================================= -->
            <link rel="stylesheet" href="css/linearicons.css">
            <link rel="stylesheet" href="css/font-awesome.min.css">
            <link rel="stylesheet" href="css/bootstrap.css">
            <link rel="stylesheet" href="css/magnific-popup.css">
            <link rel="stylesheet" href="css/jquery-ui.css">                
            <link rel="stylesheet" href="css/nice-select.css">                          
            <link rel="stylesheet" href="css/animate.min.css">
            <link rel="stylesheet" href="css/owl.carousel.css">         
            <link rel="stylesheet" href="css/jquery-ui.css">            
            <link rel="stylesheet" href="css/main.css">
        </head>
        <body>  
          <header id="header">
           
            <div class="container main-menu">
                <div class="row align-items-center justify-content-between d-flex">
                  <div id="logo">
                    <a href="index.html"><img src="img/logo.png" alt="" title="" /></a>
                  </div>
                  <nav id="nav-menu-container">
                    <ul class="nav-menu">
                      <li><a href="index.html">Home</a></li>
                      <li><a href="patientsignup.php">Sign Up</a></li>
                      <li><a href="patientlogin.php">Log in</a></li>
                      <li><a href="about.html">About</a></li>
                      <li><a href="features.html">Features</a></li>
                      <li><a href="doctors.html">Doctors</a></li>
                      <li><a href="departments.html">Departments</a></li>
                      <li class="menu-has-children"><a href="">Blog</a>
                        <ul>
                          <li><a href="blog-home.html">Blog Home</a></li>
                          <li><a href="blog-single.html">Blog Single</a></li>
                        </ul>
                      </li> 
                      <li class="menu-has-children"><a href="">Pages</a>
                        <ul>
                              <li><a href="elements.html">Elements</a></li>
                              <li><a href="#">Item One</a></li>
                              <li><a href="#">Item Two</a></li>
                              <li class="menu-has-children"><a href="">Level 2 </a>
                                <ul>
                                  <li><a href="#">Item One</a></li>
                                  <li><a href="#">Item Two</a></li>
                                </ul>
                              </li>                                         
                        </ul>
                      </li>                                                                       
                      <li><a href="contact.html">Contact</a></li>
                    </ul>
                  </nav><!-- #nav-menu-container -->                    
                </div>
            </div>
          </header><!-- #header -->

            <!-- start banner Area -->
            <section class="banner-area relative" id="home">
                <div class="overlay overlay-bg"></div>  
                <div class="container">
                    <div class="row fullscreen d-flex align-items-center justify-content-center">
                        <div class="banner-content col-lg-8 col-md-12">
                            <h1>
                                Patient Sign Up     
                            </h1>
                            <p class="pt-10 pb-10 text-white">
                                Welcome to Hospital where you get to sign up to enter your credentials to the systems
                            </p>
                            <a href="#" class="primary-btn text-uppercase">Get Started</a>
                        </div>                                      
                    </div>
                </div>                  
            </section>
            <!-- End banner Area -->

            <!-- Start appointment Area -->
            <section class="appointment-area">          
                <div class="container">
                    <div class="row justify-content-between align-items-center pb-120 appointment-wrap">
                        <div class="col-lg-5 col-md-6 appointment-left">
                            <h1>
                                Patient Sign Up
                            </h1>
                            <p>
                            Sign Up to Hospital Today 
                            </p>
                            
                        </div>
                        <div class="col-lg-6 col-md-6 appointment-right pt-60 pb-60">
                          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <h3 class="pb-20 text-center mb-30">Sign Up</h3>

                            <div class="form-group <?php echo (!empty($fullname_err)) ? 'has-error' : ''; ?>">
                                   <label>Fullname</label>
                                  <input type="text" name="fullname" class="form-control" value="<?php echo $fullname; ?>">
                                  <span class="help-block"><?php echo $fullname_err; ?></span>
                            </div> 
                            
                            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                   <label>Email</label>
                                   <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                                  <span class="help-block"><?php echo $email_err; ?></span>
                            </div>  

                                 
                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                   <label>Password</label>
                                   <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                                  <span class="help-block"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                  <label>Confirm Password</label>
                                 <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                                <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                  </div>

                                <button class="primary-btn text-uppercase">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>  
            </section>
            <!-- End appointment Area -->

            <!-- Start facilities Area -->
            <section class="facilities-area section-gap">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="menu-content pb-70 col-lg-7">
                            <div class="title text-center">
                                <h1 class="mb-10">Our Latest Facilities</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua. </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="single-facilities">
                                <span class="lnr lnr-rocket"></span>
                                <a href="#"><h4>24/7 Emergency</h4></a>
                                <p>
                                    inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct women face higher conduct.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="single-facilities">
                                <span class="lnr lnr-heart"></span>
                                <a href="#"><h4>24/7 Emergency</h4></a>
                                <p>
                                    inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct women face higher conduct.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="single-facilities">
                                <span class="lnr lnr-bug"></span>
                                <a href="#"><h4>Intensive Care</h4></a>
                                <p>
                                    inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct women face higher conduct.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="single-facilities">
                                <span class="lnr lnr-users"></span>
                                <a href="#"><h4>Family Planning</h4></a>
                                <p>
                                    inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct women face higher conduct.
                                </p>
                            </div>
                        </div>                                                                      
                    </div>
                </div>  
            </section>
            <!-- End facilities Area -->
            

            <!-- Start offered-service Area -->
            <section class="offered-service-area section-gap">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 offered-left">
                            <h1 class="text-white">Our Offered Services</h1>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua.
                            </p>
                            <div class="service-wrap row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="single-service">
                                        <div class="thumb">
                                            <img class="img-fluid" src="img/s1.jpg" alt="">     
                                        </div>
                                        <a href="#">
                                            <h4 class="text-white">Cardiac Treatment</h4>
                                        </a>    
                                        <p>
                                            inappropriate behavior Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="single-service">
                                        <div class="thumb">
                                            <img class="img-fluid" src="img/s2.jpg" alt="">     
                                        </div>
                                        <a href="#">
                                            <h4 class="text-white">Routine Checkup</h4>
                                        </a>    
                                        <p>
                                            inappropriate behavior Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        </p>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="offered-right relative">
                                <div class="overlay overlay-bg"></div>
                                <h3 class="relative text-white">Departments</h3>
                                <ul class="relative dep-list">
                                    <li><a href="#">Pediatric Diagnosis</a></li>
                                    <li><a href="#">Outpatient Rehabilitation</a></li>
                                    <li><a href="#">Laryngological Functions</a></li>
                                    <li><a href="#">Ophthalmology Unit</a></li>
                                    <li><a href="#">Cardiac Unit</a></li>
                                    <li><a href="#">Outpatient Surgery</a></li>
                                    <li><a href="#">Gynaecological Wings</a></li>
                                </ul>
                                <a class="viewall-btn" href="#">View all Department</a>         
                            </div>  
                        </div>
                    </div>
                </div>  
            </section>
            <!-- End offered-service Area -->
        
            <!-- Start team Area -->
            <section class="team-area section-gap">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="menu-content pb-70 col-lg-7">
                            <div class="title text-center">
                                <h1 class="mb-10">Our Consultants</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center d-flex align-items-center">
                        <div class="col-lg-3 col-md-6 single-team">
                            <div class="thumb">
                                <img class="img-fluid" src="img/t1.jpg" alt="">
                                <div class="align-items-end justify-content-center d-flex">
                                    <div class="social-links">
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-dribbble"></i></a>
                                        <a href="#"><i class="fa fa-behance"></i></a>
                                    </div>                                      
                                    <p>
                                        inappropriate behavior
                                    </p>
                                    <h4>Andy Florence</h4>                                  
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 single-team">
                            <div class="thumb">
                                <img class="img-fluid" src="img/t2.jpg" alt="">
                                <div class="align-items-end justify-content-center d-flex">
                                    <div class="social-links">
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-dribbble"></i></a>
                                        <a href="#"><i class="fa fa-behance"></i></a>
                                    </div>                                      
                                    <p>
                                        inappropriate behavior
                                    </p>
                                    <h4>Andy Florence</h4>                                  
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 single-team">
                            <div class="thumb">
                                <img class="img-fluid" src="img/t3.jpg" alt="">
                                <div class="align-items-end justify-content-center d-flex">
                                    <div class="social-links">
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-dribbble"></i></a>
                                        <a href="#"><i class="fa fa-behance"></i></a>
                                    </div>                                      
                                    <p>
                                        inappropriate behavior
                                    </p>
                                    <h4>Andy Florence</h4>                                  
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 single-team">
                            <div class="thumb">
                                <img class="img-fluid" src="img/t4.jpg" alt="">
                                <div class="align-items-end justify-content-center d-flex">
                                    <div class="social-links">
                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                        <a href="#"><i class="fa fa-dribbble"></i></a>
                                        <a href="#"><i class="fa fa-behance"></i></a>
                                    </div>                                      
                                    <p>
                                        inappropriate behavior
                                    </p>
                                    <h4>Andy Florence</h4>                                  
                                </div>
                            </div>
                        </div>                                                                      
                    </div>
                </div>
            </section>
            <!-- End team Area -->              
                        
            <!-- Start feedback Area -->
            <section class="feedback-area section-gap relative">
                <div class="overlay overlay-bg"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12 pb-60 header-text text-center">
                            <h1 class="mb-10 text-white">Enjoy our Client’s Feedback</h1>
                            <p class="text-white">
                                Who are in extremely love with eco friendly system..
                            </p>
                        </div>
                    </div>          
                    <div class="row feedback-contents justify-content-center align-items-center">
                        <div class="col-lg-6 feedback-left relative d-flex justify-content-center align-items-center">
                            <div class="overlay overlay-bg"></div>
                            <a class="play-btn" href="https://www.youtube.com/watch?v=ARA0AxrnHdM"><img class="img-fluid" src="img/play-btn.png" alt=""></a>
                        </div>
                        <div class="col-lg-6 feedback-right">
                            <div class="active-review-carusel">
                                <div class="single-feedback-carusel">
                                    <img src="img/r1.png" alt="">
                                    <div class="title d-flex flex-row">
                                        <h4 class="text-white pb-10">Fannie Rowe</h4>
                                        <div class="star">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>                                
                                        </div>                                      
                                    </div>
                                    <p class="text-white">
                                        Accessories Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker. Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker.
                                    </p>
                                </div>
                                <div class="single-feedback-carusel">
                                    <img src="img/r1.png" alt="">
                                    <div class="title d-flex flex-row">
                                        <h4 class="text-white pb-10">Fannie Rowe</h4>
                                        <div class="star">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>                                
                                        </div>                                      
                                    </div>
                                    <p class="text-white">
                                        Accessories Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker. Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker.
                                    </p>
                                </div>
                                <div class="single-feedback-carusel">
                                    <img src="img/r1.png" alt="">
                                    <div class="title d-flex flex-row">
                                        <h4 class="text-white pb-10">Fannie Rowe</h4>
                                        <div class="star">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked "></span>                               
                                        </div>                                      
                                    </div>
                                    <p class="text-white">
                                        Accessories Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker. Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker.
                                    </p>
                                </div>                                                              
                            </div>
                        </div>
                    </div>
                </div>  
            </section>
            <!-- End feedback Area -->  

            <!-- Start brands Area -->
            <section class="brands-area">
                <div class="container">
                    <div class="brand-wrap section-gap">
                        <div class="row align-items-center active-brand-carusel justify-content-start no-gutters">
                            <div class="col single-brand">
                                <a href="#"><img class="mx-auto" src="img/l1.png" alt=""></a>
                            </div>
                            <div class="col single-brand">
                                <a href="#"><img class="mx-auto" src="img/l2.png" alt=""></a>
                            </div>
                            <div class="col single-brand">
                                <a href="#"><img class="mx-auto" src="img/l3.png" alt=""></a>
                            </div>
                            <div class="col single-brand">
                                <a href="#"><img class="mx-auto" src="img/l4.png" alt=""></a>
                            </div>
                            <div class="col single-brand">
                                <a href="#"><img class="mx-auto" src="img/l5.png" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End brands Area -->
    
            <!-- Start recent-blog Area -->
            <section class="recent-blog-area section-gap">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-7 pb-60 header-text">
                            <h1>Our Recent Blogs</h1>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua.
                            </p>
                        </div>
                    </div>
                    <div class="row">   
                        <div class="single-recent-blog col-lg-4 col-md-4">
                            <div class="thumb">
                                <img class="f-img img-fluid mx-auto" src="img/b1.jpg" alt="">   
                            </div>                      
                            <a href="#">
                                <h4>Portable Fashion for women</h4>
                            </a>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exea.
                            </p>
                            <div class="bottom d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <img class="img-fluid" src="img/user.png" alt="">
                                    <a href="#"><span>Mark Wiens</span></a>
                                </div>
                                <div class="meta">
                                    13th Dec
                                    <span class="lnr lnr-heart"></span> 15
                                    <span class="lnr lnr-bubble"></span> 04
                                </div>
                            </div>                              
                        </div>
                        <div class="single-recent-blog col-lg-4 col-md-4">
                            <div class="thumb">
                                <img class="f-img img-fluid mx-auto" src="img/b2.jpg" alt="">   
                            </div>                      
                            <a href="#">
                                <h4>Summer ware are coming</h4>
                            </a>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exea.
                            </p>
                            <div class="bottom d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <img class="img-fluid" src="img/user.png" alt="">
                                    <a href="#"><span>Mark Wiens</span></a>
                                </div>
                                <div class="meta">
                                    13th Dec
                                    <span class="lnr lnr-heart"></span> 15
                                    <span class="lnr lnr-bubble"></span> 04
                                </div>
                            </div>                              
                        </div>
                        <div class="single-recent-blog col-lg-4 col-md-4">
                            <div class="thumb">
                                <img class="f-img img-fluid mx-auto" src="img/b3.jpg" alt="">   
                            </div>                      
                            <a href="#">
                                <h4>Summer ware are coming</h4>
                            </a>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exea.
                            </p>
                            <div class="bottom d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <img class="img-fluid" src="img/user.png" alt="">
                                    <a href="#"><span>Mark Wiens</span></a>
                                </div>
                                <div class="meta">
                                    13th Dec
                                    <span class="lnr lnr-heart"></span> 15
                                    <span class="lnr lnr-bubble"></span> 04
                                </div>
                            </div>                              
                        </div>                                                              
                    </div>
                </div>  
            </section>
            <!-- end recent-blog Area -->   

            <!-- start footer Area -->      
            <footer class="footer-area section-gap">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2  col-md-6">
                            <div class="single-footer-widget">
                                <h6>Top Products</h6>
                                <ul class="footer-nav">
                                    <li><a href="#">Managed Website</a></li>
                                    <li><a href="#">Manage Reputation</a></li>
                                    <li><a href="#">Power Tools</a></li>
                                    <li><a href="#">Marketing Service</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4  col-md-6">
                            <div class="single-footer-widget mail-chimp">
                                <h6 class="mb-20">Contact Us</h6>
                                <p>
                                    56/8, Santa bullevard, Rocky beach, San fransisco, Los angeles, USA
                                </p>
                                <h3>012-6532-568-9746</h3>
                                <h3>012-6532-568-97468</h3>
                            </div>
                        </div>                          
                        <div class="col-lg-6  col-md-12">
                            <div class="single-footer-widget newsletter">
                                <h6>Newsletter</h6>
                                <p>You can trust us. we only send promo offers, not a single spam.</p>
                                <div id="mc_embed_signup">
                                    <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="form-inline">

                                        <div class="form-group row" style="width: 100%">
                                            <div class="col-lg-8 col-md-12">
                                                <input name="EMAIL" placeholder="Your Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address '" required="" type="email">
                                            </div> 
                                        
                                            <div class="col-lg-4 col-md-12">
                                                <button class="nw-btn primary-btn circle">Subscribe<span class="lnr lnr-arrow-right"></span></button>
                                            </div> 
                                        </div>      
                                        <div class="info"></div>
                                    </form>
                                </div>      
                            </div>
                        </div>                  
                    </div>

                    <div class="row footer-bottom d-flex justify-content-between">
                        <p class="col-lg-8 col-sm-12 footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                        <div class="col-lg-4 col-sm-12 footer-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-dribbble"></i></a>
                            <a href="#"><i class="fa fa-behance"></i></a>
                        </div>                  
                    </div>
                </div>
            </footer>
            <!-- End footer Area -->


            <script src="js/vendor/jquery-2.2.4.min.js"></script>
            <script src="js/popper.min.js"></script>
            <script src="js/vendor/bootstrap.min.js"></script>          
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
            <script src="js/jquery-ui.js"></script>                 
            <script src="js/easing.min.js"></script>            
            <script src="js/hoverIntent.js"></script>
            <script src="js/superfish.min.js"></script> 
            <script src="js/jquery.ajaxchimp.min.js"></script>
            <script src="js/jquery.magnific-popup.min.js"></script> 
            <script src="js/jquery.tabs.min.js"></script>                       
            <script src="js/jquery.nice-select.min.js"></script>    
            <script src="js/owl.carousel.min.js"></script>                                  
            <script src="js/mail-script.js"></script>   
            <script src="js/main.js"></script>  
        </body>
    </html>