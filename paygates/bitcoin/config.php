<?php
    // Blockonmics API stuff
    $apikey = "";
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
    $conn = mysqli_connect("mysql5040.site4now.net", "a7844b_marg03", "oujda2015", "test"); // enter your info
?>