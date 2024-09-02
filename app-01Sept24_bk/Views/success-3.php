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
                            <div class="login-user-info login-user-inner">
                               <div class="login-heading text-center">
                                    <i class="ti ti-circle-check-filled"></i>
                                    <h4>Success</h4>
                                    <p class="verfy-mail-content mb-0">Your Passwrod Reset Successfully!</p>
                               </div>
                               <div class="form-wrap mb-0">
                                   <button type="submit" class="btn btn-primary">Back to Log In</button>
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