<?php

$tweets = array(
                array( "Good times with the twitter API", "the_dan_bot" ),
                array("College ghost-writer uses online channels to help students cheat (and get away with it). http://t.co/fobRoBA", "manifestphil"),
                array("Montana ranked 2nd on 'most fit' list, right behind Alaska. http://bit.ly/raiiLz (via @krtv)","manifestphil"),
                array("It kills me that people host with GoDaddy. Are they that great or do they just not know better?","manifestphil"),
                array("What No One Seems to Mention About Google+ http://bit.ly/jxUorL", "manifestphil"),
                array("Wow! Here's a great way to run Internet Explorer on your Mac without a virtual machine. http://t.co/sJiDsEK","manifestphil"),
                array("Cool! A vending machine that sells bike parts/tubes/food + free public workstation. http://dld.bz/agnB6", "manifestphil"),
                array("Announcing GitHub for Mac http://t.co/XNux4NY", "manifestphil"),
                array("Can anyone recommend any light/healthy cooking blogs and recipe sites? Need some inspiration on a daily basis...", "manifestphil"),
                array("Testing out Google's Music beta service. In the cloud baby, in the cloud!", "manifestphil"),
                array("I really hope that Microsoft doesn't bunk up Skype. :-( It was just getting really good on Mac.", "manifestphil")
                );

$pair = $tweets[ rand( 0, count($tweets)-1 ) ];

$tweet = $pair[0];
$user = $pair[1];

$html = "<div><a target='_parent' href='https://twitter.com/#!/{$user}'>{$tweet}</a> @{$user}</div>";

echo $html;

// return $html;

?>
