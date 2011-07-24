function curl($url)
{
    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_USERAGENT,"www.YOURDOMAIN.com");
    curl_setopt($ch,CURLOPT_TIMEOUT,10);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
 
function GetTwitterFollowerCount($username)
{
    $twitter_followers = curl("http://twitter.com/statuses/user_timeline/".$username.".xml?count=1");
    $xml = new SimpleXmlElement($twitter_followers, LIBXML_NOCDATA);
    return = $xml->status->user->followers_count;
}
 
echo GetTwitterFollowerCount("YourTwitterName");
