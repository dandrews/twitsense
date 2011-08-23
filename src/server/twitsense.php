<?php

function curl_get($url, array $get = NULL, array $options = array()) 
{    
  $defaults = array( 
                    CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get), 
                    CURLOPT_HEADER => 0, 
                    CURLOPT_RETURNTRANSFER => TRUE, 
                    CURLOPT_TIMEOUT => 4 
                     ); 
    
  $ch = curl_init(); 
  curl_setopt_array($ch, ($options + $defaults)); 
  if( ! $result = curl_exec($ch)) 
    {
      $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ( 200 != $response_code )
        {
          $result = get_cached_tweets();
        }
      else
        {
          trigger_error(curl_error($ch));
        }
    } 
  curl_close($ch); 
  return $result; 
} 

function make_url( $terms )
{
  $twitter_search_url = "http://search.twitter.com/search.json?q=";
  $search_filter = "&result_type=popular&count=5&lang=en";
  $search_terms = rawurlencode( str_replace( ':', ' OR ', $terms ) );
  $search_url = $twitter_search_url . $search_terms . $search_filter;
  return $search_url;
}

function get_cached_tweets()
{
  $filename = "tweets.json";
  $handle = fopen( $filename, "rb" );
  $cached_tweets = fread( $handle, filesize( $filename ) );
  fclose( $handle );
  return $cached_tweets;
}
  
function post_responder()
{
  if (isset($_POST))
    {
      if (!isset($_POST['terms']))
        {
          return "POST: terms not set\n";
        }
      else 
        {
          $terms = $_POST['terms'];
        }
      if (!isset($_POST['user']))
        {
          return "POST: user not set\n";
        }
      else
        {
          $user = $_POST['user'];
        }
    }
  else
    {
      echo "POST NOT SET:\n";
      var_dump($_POST);
      return false;
    }

  $search_url = make_url( $terms );

  // $search_url = "http://search.twitter.com/search.json?q=dude%20OR%20mom%20OR%20chill&result_type=popular&count=5&lang=en";

  $tweets = curl_get( $search_url );

  return $tweets;
  
}

if (isset($_SERVER['REQUEST_METHOD']))
  {
    $method = $_SERVER['REQUEST_METHOD'];
  }
else
  {
    echo "The SERVER variable is not set: ";
    var_dump($_SERVER);
    return false;
  }

$content = post_responder();

echo $content;

return true;

?>