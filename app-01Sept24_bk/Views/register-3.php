<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->include('partials/title-meta') ?>
<?= $this->include('partials/head-css') ?>

</head>
<body class="account-page">
	
	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<div class="account-content">
			<div class="login-wrapper login-new">
                <div class="login-shapes">
                    <div class="login-right-shape">
                        <img src="<?php echo base_url(); ?>assets/img/authentication/shape-01.png" alt="Shape">
                    </div>
                    <div class="login-left-shape">
                        <img src="<?php echo base_url(); ?>assets/img/authentication/shape-02.png" alt="Shape"> 
                    </div> 
                </div>
                <div class="container">
                    <div class="login-content user-login">
                        <div class="login-logo">
                           <img src="<?php echo base_url(); ?>assets/img/logo.svg" class="img-fluid" alt="Logo">
                       </div>
                        <form action="login-3">
                            <div class="login-user-info">
                               <div class="login-heading">
                                   <h4>Register</h4>
                                   <p>Create new CRMS account</p>
                               </div>
                               <div class="form-wrap">
                                   <label class="col-form-label">Name</label>
                                   <div class="form-wrap-icon">
                                       <input type="text" class="form-control">
                                       <i class="ti ti-user"></i>
                                   </div>
                               </div>
                               <div class="form-wrap">
                                   <label class="col-form-label">Email Address</label>
                                   <div class="form-wrap-icon">
                                       <input type="text" class="form-control">
                                       <i class="ti ti-mail"></i>
                                   </div>
                               </div>
                               <div class="form-wrap">
                                   <label class="col-form-label">Password</label>
                                   <div class="pass-group">
                                       <input type="password" class="pass-input form-control">
                                       <span class="ti toggle-password ti-eye-off"></span>
                                   </div>
                               </div>
                               <div class="form-wrap">
                                   <label class="col-form-label">Confirm Password</label>
                                   <div class="pass-group">
                                       <input type="password" class="pass-inputs form-control">
                                       <span class="ti toggle-passwords ti-eye-off"></span>
                                   </div>
                               </div>
                               <div class="form-wrap form-wrap-checkbox">
                                   <div class="custom-control custom-checkbox">
                                        <label class="check">
                                            <input type="checkbox">
                                            <span class="box"></span>
                                            I agree to the <a href="javascript:void(0);" class="forgot-link ms-1">Terms & Privacy</a>
                                        </label>
                                   </div>
                               </div>
                               <div class="form-wrap">
                                   <button type="submit" class="btn btn-primary">Sign Up</button>
                               </div>
                               <div class="login-form">
                                   <h6>Already have an account?<a href="<?php echo base_url(); ?>login-3" class="hover-a"> Sign In Instead</a></h6>
                               </div>
                               <div class="form-set-login or-text">
                                   <h4>OR</h4>
                               </div>
                               <div class="login-social-link">
                                   <ul class="nav">
                                       <li>
                                           <a href="javascript:void(0);" class="facebook-logo">
                                               <img src="<?php echo base_url(); ?>assets/img/icons/facebook-logo.svg" alt="Facebook">
                                           </a>
                                       </li>
                                       <li>
                                           <a href="javascript:void(0);">
                                               <img src="<?php echo base_url(); ?>assets/img/icons/google-logo.svg" alt="Google">
                                           </a>
                                       </li>
                                       <li>
                                           <a href="javascript:void(0);" class="apple-logo">
                                               <img src="<?php echo base_url(); ?>assets/img/icons/apple-logo.svg" alt="Apple">
                                           </a>
                                       </li>
                                   </ul>
                               </div>
                           </div>
                        </form>
                    </div>
                    <div class="copyright-text">
                       <p>Copyright &copy;2024 - CRMS</p>
                   </div>
                </div>
            </div>
		</div>

	</div>
	<!-- /Main Wrapper -->
    <?= $this->include('partials/vendor-scripts') ?>
</body>
</html>