<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('partials/title-meta') ?>
    <?= $this->include('partials/head-css') ?>
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <?= $this->include('partials/menu') ?>
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content">

                <div class="row">
                    <div class="col-md-12">

                        <?= $this->include('partials/page-title') ?>

                        <div class="card main-card">
                            <div class="card-body">

                                <!-- Search -->
                                <h4>Generate KYC Link</h4><br><br>

                                <div class="search-section">

                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <h6 class="text-danger">Note : click generate link button to generate unique link for KYC, copy and send. Link is valid for 24 hrs only. </h6>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger w-100" onclick="$.getLink();">Generate Link</button>
                                        </div>

                                        <div class="col-md-10">
                                            <div class="input-group mb-3 w-100">
                                                <input type="text" class="form-control" id="myInput" placeholder="click generate button to generate new link" width="50%">
                                                <button class="btn btn-warning" onclick="myFunction()"><i class="fa fa-clone" aria-hidden="true"></i></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- /Page Wrapper -->


    </div>
    <!-- /Main Wrapper -->


    <?= $this->include('partials/vendor-scripts') ?>
    <script>
        $.getLink = function() {

            $('#myInput').val('');

            $.ajax({
                method: 'GET',
                url: 'getLink',
                data: {},
                success: function(response) {

                    console.log(response);

                    $('#myInput').val(response);

                }
            });
        }

        function myFunction() {
            // Get the text field
            var copyText = document.getElementById("myInput");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);

            // Alert the copied text
            alert("Link Copied : " + copyText.value);
        }
    </script>
</body>

</html>