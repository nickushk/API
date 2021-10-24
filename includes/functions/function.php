<?php

    /*
    * test the function and get response
    * @param function which return bool
    * @return array
    */
    function addDataResponse(bool $function):array {
        if ($function) {
            $response = array("message" => "Created");
            http_response_code(201); //Created
        } else {
            $response = array("message" => "Somthing went werong!");
            http_response_code(500); //server error
        }
        return $response;
    }
?>