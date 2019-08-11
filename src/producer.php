<?php
    require_once('./autoloader.php'); // include autoloader function
    autoload();

    // separate command from params
    $input = json_decode(file_get_contents('php://input'),true);
    $command = $input[0];
    $params = array_slice($input, 1);
    
    $requests = new producerrequests(); // this is the class that processes the requests
    
    $result = $requests->process($command, $params);

    header('Content-type: application/json');
    print json_encode($result);
?>