<?php

$str = "";

// read from a source of words
$file_handle = fopen("sample_blog_post.txt", "r");

while (!feof($file_handle)) {
  $str .=  strtolower(fgets($file_handle));
}

fclose($file_handle);


// now do the counting
$words = array_count_values(str_word_count($str, 1));

arsort($words);

$top_words = array();

$stopwords_arr = array("to", "in", "each", "and", "a", "s", "t", "is", "if", "you", "your", "the", "this", "they", "that");


// filter out infrequently use and unimportant words
foreach ($words as $key => $val )
{
  if (($val >= 5) && (!in_array($key, $stopwords_arr)))
  {
    array_push( $top_words, $key );
  }
}

// only take the top 5 words
$top_words = array_slice($top_words, 0, 5);

// at this point, the first word is the most common, the second is ...
print_r($top_words);

?>