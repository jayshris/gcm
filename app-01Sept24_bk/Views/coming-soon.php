<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->include('partials/title-meta') ?>
<?= $this->include('partials/head-css') ?>
</head>
<body>

<body class="error-page">

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="comming-soon">
            <div class="comming-shapes">
                <div class="comming-right-shape">
                    <img src="<?php echo base_url();?>assets/img/authentication/shape-03.png" alt="Shape">
                </div>
                <div class="comming-left-shape">
                    <img src="<?php echo base_url();?>assets/img/authentication/shape-04.png" alt="Shape"> 
                </div> 
            </div>
            <div class="coming-soon-box">
                <div class="crms-logo">
                    <img src="<?php echo base_url();?>assets/img/icons/coming-icon.svg" alt="Coming Icon">
                </div>
                <span>Our Website is</span>
                <h1><span> COMING </span> SOON </h1>
                <p>Please check back later, We are working hard  to get everything  just  right.</p>
                <ul class="coming-soon-timer">
                    <li><span class="days">54</span>days</li>
                    <li class="seperate-dot">:</li>
                    <li><span class="hours">10</span>Hrs</li>
                    <li class="seperate-dot">:</li>
                    <li><span class="minutes">47</span>Min</li>
                    <li class="seperate-dot">:</li>
                    <li><span class="seconds">00</span>Sec</li>
                </ul>
                <div class="subscribe-form">
                    <div class="form-wrap">
                        <label class="col-form-label">Subscribe to get notified!</label>
                        <input type="email" class="form-control" placeholder="Enter Your Email">
                        <a href="" class="btn btn-primary subscribe-btn">Subscribe</a>
                    </div>
                </div>
                <ul class="social-media-icons">
                    <li><a href="javascript:void(0);"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="javascript:void(0);"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="javascript:void(0);"><i class="fab fa-pinterest-p"></i></a></li>
                    <li><a href="javascript:void(0);"><i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->


<?= $this->include('partials/vendor-scripts') ?>

</body>
</html>