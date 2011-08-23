<?php

function curl_post($url, array $post = NULL, array $options = array()) 
{ 
  $defaults = array( 
                    CURLOPT_POST => 1, 
                    CURLOPT_HEADER => 0, 
                    CURLOPT_URL => $url, 
                    CURLOPT_FRESH_CONNECT => 1, 
                    CURLOPT_RETURNTRANSFER => 1, 
                    CURLOPT_FORBID_REUSE => 1, 
                    CURLOPT_TIMEOUT => 4, 
                    CURLOPT_POSTFIELDS => http_build_query($post) 
                     ); 

  $ch = curl_init(); 
  curl_setopt_array($ch, ($options + $defaults)); 
  if( ! $result = curl_exec($ch)) 
    { 
      trigger_error(curl_error($ch)); 
    } 
  curl_close($ch); 
  return $result; 
}

$url = 'http://atlatler.com/twitsense/twitsense.php';

// Here is the data we will be sending to the service
$some_data = array(
                   'terms' => 'zebra:stripes',
                   'user' => 'Chadly'
                   );  

// Send the request
$result = curl_post($url, $some_data );

echo $result;

// $tweets = json_decode( $result, true );

//print_r($tweets);

return true;

?>
