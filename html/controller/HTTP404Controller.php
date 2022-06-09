<?php 

class HTTP404Controller
{
    private $uri;
    private $method;

    public function __construct($uri, $method)
    {
        $this->uri = $uri;
        $this->method = $method;
    }

    public function response()
    {
        header("HTTP/1.1 404 Not Found", true, 404);
        $aResponse = ["message" => sprintf("URI: %s METHOD: %s Not found", $this->uri, $this->method) ];
        print( json_encode($aResponse, JSON_PRETTY_PRINT) );
    }
}