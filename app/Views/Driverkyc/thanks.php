<!DOCTYPE html>
<html lang="hi">

<head>
    <?= $this->include('partials/title-meta') ?>
    <?= $this->include('partials/head-css') ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body>

    <div class="container text-center">
        <h1 class="no-print">
            <?php
            $session = \Config\Services::session();
            if ($session->getFlashdata('error')) {
                echo '<div class="alert alert-success">' . $session->getFlashdata("error") . '</div>';
            }
            ?>
        </h1>
    </div>

    <div class="m-2">

        <h2 style="text-align: center; text-decoration: underline;">GAE CARGO MOVERS PVT. LTD.</h2>
        <h6 style="text-align: center;"><strong>A/131/2 2nd FLOOR, WAZIRPUR GROUP IND. AREA, WAZIRPUR</strong></h6>
        <h6 style="text-align: center;"><strong>DELHI-110052. PHONE NO. 7669027900</strong></h6><br><br>
        <h4 style="text-align: center;"><span style="text-decoration: underline;"><strong>DRIVER REGISTERATION FORM</strong></span></h4><br><br>
        <p style="text-align: justify;">
            मैं <?= isset($details) ? $details['party_name'] : '...............................' ?> , <br><br>
            मेरा लाइसेंस नंबर <?= isset($details) ? $details['dl_no'] : '...........................................................' ?> वैधता <?= isset($details) ? date('d-m-Y', strtotime($details['dl_expiry']))  : '.................' ?> ,<br>
            मेरा आधार कार्ड नंबर ................................................................ <br>
            मेरे फॉरमेन का नाम <?= isset($details) ? $details['foreman_name'] : '...................................................................' ?> एवं मोबाइल नंबर <?= isset($details) ? $details['foreman_mobile'] : '............................. ' ?><br>
            <?= isset($vehicle_type) ? $vehicle_type['name'] : '' ?> गाड़ी नंबर .................................. ₹<?= isset($scheme) ? $scheme['rate'] : '.......' ?> प्रति किलोमीटर ( जीपीएस के
            अनुसार ) जिसके अंतर्गत डीजल / यूरिया / रास्ते के सभी खर्च एवं प्रत्येक पॉइंट ( लोडिंग / अनलोडिंग )
            ₹500 तक इसमें शामिल होंगे इसके अलावा लोडिंग अनलोडिंग डाला जो भी ₹500 से ऊपर लगेगा तो
            कंपनी में बात करके पास कर सकते हैं परंतु बात करना अनिवार्य है अन्यथा पास नहीं किया जाएगा |
        </p>
        <p style="text-align: justify;">
            मैं ................................... , पुत्र ....................................... , उपरोक्त सभी नियमों को ध्यान पूर्वक अपने पूरे होशो
            हवास में मानता हूं और अपनी ड्यूटी दिनांक ............................. को
            चालू करता हूं एवं गाड़ी पकड़ते टाइम मुझे गाड़ी की टंकी में .......... लीटर डीजल मिला |
        </p>
        <p style="text-align: left;"><strong>NOTED:- FASTAG और दिल्ली पर्ची (DELHI M.C.D.TEG) कंपनी की होगी</strong></p>
        <p style="text-align: left;">&nbsp;</p>
        <p style="text-align: left;"><strong>ड्राइवर का मोबाइल नंबर ............................... </strong></p>
        <p style="text-align: left;"><strong>गाड़ी पकड़ने का स्थान ................................</strong></p>
        <p style="text-align: right;"><strong>हस्ताक्षर</strong></p>


        <button class="btn btn-danger no-print" onclick="window.print()">Print this page</button>
    </div>

    <?php
    // echo '<pre>';
    // print_r($details);
    // print_r($vehicle_type);
    // print_r($scheme);
    // echo '</pre>';
    ?>

    <?= $this->include('partials/vendor-scripts') ?>

</body>

</html>