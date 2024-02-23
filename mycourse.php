<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/fav.png" />
  <!-- Author Meta -->
  <meta name="author" content="colorlib" />
  <!-- Meta Description -->
  <meta name="description" content="" />
  <!-- Meta Keyword -->
  <meta name="keywords" content="" />
  <!-- meta character set -->
  <meta charset="UTF-8" />
  <!-- Site Title -->
  <title>Courses</title>

  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:900|Roboto:400,400i,500,700" rel="stylesheet" />
  <!--
      CSS
      =============================================
    -->
  <link rel="stylesheet" href="css/linearicons.css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="css/magnific-popup.css" />
  <link rel="stylesheet" href="css/owl.carousel.css" />
  <link rel="stylesheet" href="css/nice-select.css">
  <link rel="stylesheet" href="css/hexagons.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" />
  <link rel="stylesheet" href="css/main.css" />
  <style>
    span {
            font-family: 'Pacifico', cursive;
            color:white;
        }
  </style>
</head>

<body>
  <!-- ================ Start Header Area ================= -->
  <header class="default-header">
    <nav class="navbar navbar-expand-lg  navbar-light">
      <div class="container">
        <a class="navbar-brand" href="index.html">
          <span>
            Tune Tutor 
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="lnr lnr-menu"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
          <ul class="navbar-nav">
            
          <?php
            session_start();

            // Check if the user is logged in
            if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
                // User is logged in
                echo '<li><a href="home.php">Home</a></li>';
                echo '<li><a href="mycourse.php">My Course</a></li>';
                echo '<li><a href="courses.php">Courses</a></li>';
                echo '<li><a href="blog-home.html">Blog</a></li>';
                echo '<li><a href="logout.php">Logout</a></li>';
                echo '<li>
                <button class="search">
                  <span class="lnr lnr-magnifier" id="search"></span>
                </button>
              </li>';
            } else {
                echo'
                <li><a href="index.html">Home</a></li>
                <li><a href="courses.php">Courses</a></li>            
                <li><a href="contacts.html">Contacts</a></li>
                <li class="dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                    Join Now
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="login.php">Login</a>
                    <a class="dropdown-item" href="signup.php">Signup</a>
                </div>
                </li>';
            }
            ?>


          </ul>
        </div>
      </div>
    </nav>
    <div class="search-input" id="search-input-box">
      <div class="container">
        <form class="d-flex justify-content-between">
          <input type="text" class="form-control" id="search-input" placeholder="Search Here" />
          <button type="submit" class="btn"></button>
          <span class="lnr lnr-cross" id="close-search" title="Close Search"></span>
        </form>
      </div>
    </div>
  </header>
  <!-- ================ End Header Area ================= -->

  <!-- ================ start banner Area ================= -->
  <section class="banner-area">
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-12 banner-right">
            <h1 class="text-white">
              Courses
            </h1>
            
            <div class="link-nav">
              <span class="box">
                <a href="index.html">Home </a>
                <i class="lnr lnr-arrow-right"></i>
                <a href="courses.html">Courses</a>
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- ================ End banner Area ================= -->


  <!-- ================ Start Popular Course Area ================= -->
  <section class="popular-course-area section-gap">
    <div class="container-fluid">
      <div class="row justify-content-center section-title">
        <div class="col-lg-12">
          <h2>
            Enrolled Courses <br />
         
          </h2>
         
        </div>
      </div>
      <div class="owl-carousel popuar-course-carusel">


      <?php
include 'vendor/autoload.php';

// MongoDB connection
$mongoClient = new MongoDB\Client('mongodb+srv://praveen:Byf0rEebirBOILam@cluster0.9mzctp3.mongodb.net/');
$enrollmentCollection = $mongoClient->tunetutor->course_enrollment;
$coursedetailsCollection = $mongoClient->tunetutor->coursedetails;

// Fetch courses enrolled by the user
$enrolledCourses = [];
try {
    $cursor = $enrollmentCollection->find(['user_id' => $_SESSION["uid"]]);
    foreach ($cursor as $document) {
        // Get the course details based on product_id from coursedetails collection
        $courseId = $document['product_id'];
        $course = $coursedetailsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($courseId)]);
        if ($course) {
            // Calculate the review count for the course
            $reviewCount = isset($course['review']) ? count($course['review']) : 0;
            $course['review_count'] = $reviewCount;
            $enrolledCourses[] = $course;
        }
    }
} catch (Exception $e) {
    // Handle any exceptions
    echo "Error: " . $e->getMessage();
}

// Check if enrolled courses are available
if (!empty($enrolledCourses)) {
    // Loop through the enrolled courses and generate HTML
    foreach ($enrolledCourses as $course) {
        ?>
        <div class="single-popular-course">
            <div class="thumb">
            <?php
                // Concatenate the base path with the stored image path
                $basePath = "admin/template/courseimage/"; // Change this to your actual base URL
                $imagePath = $basePath . $course['c_img_filename'];            
                ?>

                <img class="f-img img-fluid mx-auto" style="height:200px;" src="<?= $imagePath ?>" alt="Image" />
            </div>
            <div class="details">
                <div class="d-flex justify-content-between mb-20">
                    <p class="name"><?= $course['instrument'] ?></p>
                    <p class="value">₹<?= $course['c_fee'] ?></p>
                </div>
                <a href="course-details.php?id=<?= $course['_id'] ?>">
                    <h4><?= $course['c_title'] ?></h4>
                </a>
                <div class="bottom d-flex mt-15">
                  <ul class="list">
                    <li>
                      <a href=""><i class="fa fa-star"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-star"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-star"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-star"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-star"></i></a>
                    </li>
                  </ul>
                  <p class="ml-20"><?= $course['review_count'] ?> Reviews</p>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    // If no enrolled courses found, display a message
    echo "No courses available. Nice try!";
}
?>




        
      </div>
    </div>
  </section>
  <!-- ================ End Popular Course Area ================= -->

 <footer class="footer-area section-gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>Top Products</h4>
					<ul>
						<li><a href="#">Managed Website</a></li>
						<li><a href="#">Manage Reputation</a></li>
						<li><a href="#">Power Tools</a></li>
						<li><a href="#">Marketing Service</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>Quick Links</h4>
					<ul>
						<li><a href="#">Jobs</a></li>
						<li><a href="#">Brand Assets</a></li>
						<li><a href="#">Investor Relations</a></li>
						<li><a href="#">Terms of Service</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>Features</h4>
					<ul>
						<li><a href="#">Jobs</a></li>
						<li><a href="#">Brand Assets</a></li>
						<li><a href="#">Investor Relations</a></li>
						<li><a href="#">Terms of Service</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>Resources</h4>
					<ul>
						<li><a href="#">Guides</a></li>
						<li><a href="#">Research</a></li>
						<li><a href="#">Experts</a></li>
						<li><a href="#">Agencies</a></li>
					</ul>
				</div>
				<div class="col-lg-4 col-md-6 single-footer-widget">
					<h4>Newsletter</h4>
					<p>You can trust us. we only send promo offers,</p>
					<div class="form-wrap" id="mc_embed_signup">
						<form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
						 method="get" class="form-inline">
							<input class="form-control" name="EMAIL" placeholder="Your Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address '"
							 required="" type="email">
							<button class="click-btn btn btn-default text-uppercase">subscribe</button>
							<div style="position: absolute; left: -5000px;">
								<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
							</div>

							<div class="info"></div>
						</form>
					</div>
				</div>
			</div>
			<div class="footer-bottom row align-items-center">
				<p class="footer-text m-0 col-lg-8 col-md-12">
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="#" target="_blank">Aakash Ranga</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
				<div class="col-lg-4 col-md-12 footer-social">
					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-twitter"></i></a>
					<a href="#"><i class="fa fa-dribbble"></i></a>
					<a href="#"><i class="fa fa-behance"></i></a>
				</div>
			</div>
		</div>
	</footer>
  <!-- ================ End footer Area ================= -->

  <script src="js/vendor/jquery-2.2.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
    crossorigin="anonymous"></script>
  <script src="js/vendor/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/parallax.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/hexagons.min.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>     