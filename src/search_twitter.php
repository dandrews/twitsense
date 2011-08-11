<?php

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

  $twitter_search_url = "http://search.twitter.com/search.json?q=";

  $search_filter = "&result_type=popular&count=5&lang=en";
      
  // TODO take only the top search terms
  // build the seach url

  $search_terms_arr = explode( ":", $terms );
  
  $search_terms_arr = array_filter( array_unique( $search_terms_arr ) );
    
  if ( !empty( $search_terms_arr ) ) {
    $search_terms = implode(' OR ', $search_terms_arr );
  }

  $search_terms = rawurlencode( $search_terms );
    
  $search_json_url = $twitter_search_url . $search_terms . $search_filter;

  // echo "search url: " . $search_json_url . "\n";

  return $search_json_url;

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
    echo post_responder() . "\n";
    break;
  default:
    echo "What method is being used?\n";
    return false;
  }    

return true;

?>