<?php
class producerrequests{
    // accept a request in the form of a command and an array of params
    // then call the correspondent method
    public function process($command, $params){
        switch($command) {
            case "login":
                if (isset($params[0])) {$username = $params[0];}
                if (isset($params[1])) {$password = $params[1];}

                $result = $this->login($username, $password);

                break;
            case "forgot":
                if (isset($params[0])) {$username = $params[0];}
                
                $result = $this->forgot($username);
                
                break;
        }
        return $result;
    }
    // call the database API with a jSON string composed of a command and a list of params
    private function callAPI($arrayParams) {
        // create resource
        $ch = curl_init();

        // encode $arrayParams as a json string
        $jsonParams = json_encode($arrayParams);

        // set destination and params
        curl_setopt($ch, CURLOPT_URL, "consumer.local");    // set destination *** in real life, this should be https://consumer.local ***
        curl_setopt($ch, CURLOPT_POST, 1);                  // set POST (not GET)
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonParams);  // set params with json string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);     // don't output the result => set a var with it
    
        // run
        $result = curl_exec($ch);

        // close resource
        curl_close($ch);
        
        return $result;
    }
    private function login($username, $password){
        $arrayParams = [ 'login', $username, $password ];
        $jsonResult = $this->callAPI($arrayParams);
        $result = json_decode($jsonResult, true);

        // $result is an associative array with a variable structure, depending on the command that was issued
        return $result;
    }
    private function forgot($username){
        $arrayParams = [ 'forgot', $username ];
        $jsonResult = $this->callAPI($arrayParams);
        $result = json_decode($jsonResult, true);

        // $result is an associative array with a variable structure, depending on the command that was issued
        return $result;
    }
}
?>