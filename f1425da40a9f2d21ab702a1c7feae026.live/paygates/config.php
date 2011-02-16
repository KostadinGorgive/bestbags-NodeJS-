<?php
    // Blockonmics API stuff
    $apikey = "UaZoE0WyKDbodyEPnYTOV4L9mFp2153QElMDOapzleM";
    $url = "https://www.blockonomics.co/api/";
    
    $options = array( 
        'http' => array(
            'header'  => 'Authorization: Bearer '.$apikey,
            'method'  => 'POST',
            'content' => '',
            'ignore_errors' => true
        )   
    );

    // Connection info
    $conn = mysqli_connect("mysql5040.site4now.net", "a7844b_marg03", "oujda2015", "db_a7844b_marg03"); // enter your info
?>