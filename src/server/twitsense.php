<?php

  // $search_url = "http://search.twitter.com/search.json?q=%23friendship";

  // rice or beans and cheese: http://twitter.com/#!/search/rice%20or%20beans%20and%20cheese
  // fake latin fun: http://twitter.com/#!/search/fake%20latin%20and%20fun
  // ignore me please #friend: http://twitter.com/#!/search/ignore%20me%20please%20%23friend
  // $public_tweets = 'https://api.twitter.com/1/statuses/public_timeline.json';

  // $cached_tweets = 'http://atlatler.com/twitsense/tweets.json';
  // love%20OR%20hate

function make_url( $terms )
{

  $twitter_search_url = "http://search.twitter.com/search.json?q=";

  $search_filter = "&result_type=popular&count=5&lang=en";
      
  $search_terms = rawurlencode( str_replace( ':', ' OR ', $terms ) );
  
  $search_url = $twitter_search_url . $search_terms . $search_filter;

  echo "search url: " . $search_url . "\n";

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
  
function exec_request( $url )
{

  $curl = curl_init();
 
  // Set the url path we want to call
  curl_setopt($curl, CURLOPT_URL, $url);
  // Make it so the data coming back is put into a string
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  curl_setopt($curl, CURLOPT_TIMEOUT, '3');  
  
  $result = trim( curl_exec( $curl ) );

  curl_close($curl);

  $response_code = curl_getinfo($result, CURLINFO_HTTP_CODE);
  
  if ( 200 != $response_code )
    {
      $response = get_cached_tweets();
    }

  return $response;

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

  $response = exec_request( $search_url );

  echo $response;
  
  return $response;
  
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

switch ($method)
  {
  case 'POST':
    $content = post_responder() ;
    return $content;
    break;
  default:
    echo "What method is being used?\n";
    return false;
  }    

?>