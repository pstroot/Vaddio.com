<?php

//define("CURLOPT_TIMEOUT_MS",155);
//define("CURLOPT_CONNECTTIMEOUT_MS",156);

class curl
{
     
     // Response
     public $transfer;
     public $header;
     public $body;
     public $header_values;
     
     // cURL Resources
     public $handle;
     private $options;
     
     function __construct() {
     
          // Create new cURL resource
          $this->handle = curl_init();
          
          // Set default cURL options
          $this->options = array(
               CURLOPT_HEADER => 1,
               CURLOPT_HTTPHEADER => array("Expect:"),
               CURLOPT_RETURNTRANSFER => 1,
               CURLOPT_SSL_VERIFYPEER => 0,
               CURLOPT_FOLLOWLOCATION => 0,
               CURLOPT_AUTOREFERER => 0,
               CURLOPT_VERBOSE => 1,
               CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:16.0) Gecko/20100101 Firefox/16.0",
               CURLOPT_CONNECTTIMEOUT_MS => 3000,
               CURLOPT_TIMEOUT_MS => 5000
          );
          
          // Turn off transfer until populated
          $this->transfer = false;
     
     }
     
     function enableCookies() {
          $this->options[CURLOPT_COOKIEJAR] = "/tmp/cookies.txt";
          $this->options[CURLOPT_COOKIEFILE] = "/tmp/cookies.txt";
     }
     
     function disableLog() {
          $this->options[CURLOPT_VERBOSE] = 0;
     }
     
     function disableSpoofing() {
          unset($this->options[CURLOPT_USERAGENT]);
     }
     
     function setMode($mode) {
          if ($mode == "loose") {
               $this->options[CURLOPT_FOLLOWLOCATION] = 1;
               $this->options[CURLOPT_AUTOREFERER] = 1;
          } else {
               $this->options[CURLOPT_FOLLOWLOCATION] = 0;
               $this->options[CURLOPT_AUTOREFERER] = 0;
          }
     }
     
     function setImpatient() {
          $this->options[CURLOPT_CONNECTTIMEOUT_MS] = 750;
          $this->options[CURLOPT_TIMEOUT_MS] = 1500;
     }
     
     function setPatient() {
          $this->options[CURLOPT_CONNECTTIMEOUT_MS] = 3000;
          $this->options[CURLOPT_TIMEOUT_MS] = 180000; // 3 minutes
     }
     
     function setDefaults() {
          $this->options = array();
     }
     
     function setOption($key, $value) {
          $this->options[$key] = $value;
     }
     
     function setURL($url) {
          $this->options[CURLOPT_URL] = $url;
     }
     
     function clearCookies() {
          fopen("/tmp/cookies.txt", "w");
     }
     
     function post($fields) {
          $this->options[CURLOPT_POST] = 1;
          $this->options[CURLOPT_POSTFIELDS] = http_build_query($fields);
     }
     
     function execute() {
          
          // Set options
          curl_setopt_array($this->handle, $this->options);
          
          // Execute cURL request using options
          if ($this->options[CURLOPT_RETURNTRANSFER]) {
               $this->transfer = curl_exec($this->handle);
          } else {
               curl_exec($this->handle);
          }
          
          // Close cURL session to free up some resources
          curl_close($this->handle);
          
          // If we have data to manipulate, then manipulate it
          if ($this->transfer !== false) {
               $this->prepData();
          }
          
     }
     
     function reset() {
          
     }
     
     private function prepData() {
     
          // Iterate through response, line-by-line
          $header_count = 0;
          $body_count = 0;
          $header_line = false;
          $body_line = false;
          $header_content = array();
          $body_content = array();
          foreach (preg_split("/(\r?\n)/", $this->transfer) as $line) {
               if ($header_line && trim($line) == "") {
                    $header_line = false;
                    $body_line = true;
                    $body_count++;
               }
               if (substr($line,0,4) == "HTTP") {
                    $header_line = true;
                    $header_count++;
                    $body_line = false;
               }
               if ($header_line) {
                    @$header_content[$header_count-1] .= $line."\n";
               }
               if ($body_line) {
                    @$body_content[$header_count-1] .= $line."\n";
               }
          }
          
          // Store header and body from response
          $this->header = $header_content;
          $this->body = $body_content[count($body_content)-1];
          
          // Process header data into array
          foreach ($this->header as $header_number => $header) {
               foreach (preg_split("/(\r?\n)/", $header) as $line) {
                    if (substr($line,0,4) == "HTTP") {
                         $http_parts = explode("/",$line);
                         $http_parts2 = explode(" ",$http_parts[1]);
                         $this->header_values[$header_number]["http"]["protocol"] = $http_parts[0];
                         $this->header_values[$header_number]["http"]["version"] = $http_parts2[0];
                         $this->header_values[$header_number]["http"]["status"] = $http_parts2[1];
                    } else {
                         $header_parts = explode(": ",$line);
                         @$this->header_values[$header_number][$header_parts[0]] = $header_parts[1];
                    }
               }
               unset($this->header_values[$header_number][""]);
          }
     
     }

}

?>