<?php

$str = 'happy beautiful happy lines pear gin happy lines rock happy lines pear ';

$words = array_count_values(str_word_count($str, 1));

print_r($words);

arsort($words);

print_r($words);

?>