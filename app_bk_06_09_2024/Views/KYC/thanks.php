<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('partials/title-meta') ?>
    <?= $this->include('partials/head-css') ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body>

    <div class="container text-center">
        <h1>
            <?php
            $session = \Config\Services::session();
            if ($session->getFlashdata('error')) {
                echo '
                      <div class="alert alert-success">' . $session->getFlashdata("error") . '</div>
                      ';
            }
            ?>
        </h1>
    </div>

    <?= $this->include('partials/vendor-scripts') ?>

</body>

</html>