<?php
header('Content-Type: application/javascript');
    // Defining the basic cURL function
    function curl($url) {
        // Assigning cURL options to an array
        $options = Array(
            CURLOPT_RETURNTRANSFER => TRUE,  // Setting cURL's option to return the webpage data
            CURLOPT_FOLLOWLOCATION => TRUE,  // Setting cURL to follow 'location' HTTP headers
            CURLOPT_AUTOREFERER => TRUE, // Automatically set the referer where following 'location' HTTP headers
            CURLOPT_CONNECTTIMEOUT => 120,   // Setting the amount of time (in seconds) before the request times out
            CURLOPT_TIMEOUT => 120,  // Setting the maximum amount of time for cURL to execute queries
            CURLOPT_MAXREDIRS => 10, // Setting the maximum number of redirections to follow
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8",  // Setting the useragent
            CURLOPT_URL => $url, // Setting cURL's URL option with the $url variable passed into the function
        );

        $ch = curl_init();  // Initialising cURL
        curl_setopt_array($ch, $options);   // Setting cURL's options using the previously assigned array data in $options
        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL
        return $data;   // Returning the data from the function
    }

    // Defining the basic scraping function
    function scrape_between($data, $start, $end){
        $data = stristr($data, $start); // Stripping all data from before $start
        $data = substr($data, strlen($start));  // Stripping $start
        $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
        $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
        return $data;   // Returning the scraped data from the function
    }
      function remove_accent($str)
{
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'Ð', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o', 'O', 'o', 'O', 'o', 'Œ', 'œ', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'Š', 'š', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Ÿ', 'Z', 'z', 'Z', 'z', 'Ž', 'ž', '?', 'ƒ', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?', '?');
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
  return str_replace($a, $b, $str);
}

function post_slug($str)
{
  return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ ]+/', '/^-|-$/'),
  array('', '-', ''), remove_accent($str)));
}

    $scraped_page = curl('https://www.youtube.com/results?search_query='.post_slug($_GET['q']).'');
    $results_page = scrape_between($scraped_page, "var ytInitialData =",";</script>"); // Scraping out only the middle section of the results page that contains our results
   //echo $results_page;
       $json = json_decode($results_page,true);
//print_r($results_page);
$mystring = $results_page;
$findme   = 'carouselAdRenderer';
$pos = strpos($mystring, $findme);

if ($pos === false) {
    $listing = $json['contents']['twoColumnSearchResultsRenderer']['primaryContents']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'];
} else {
$listing = $json['contents']['twoColumnSearchResultsRenderer']['primaryContents']['sectionListRenderer']['contents'][1]['itemSectionRenderer']['contents'];
}


      $k = 0;
        $data = [];

      foreach ($listing as $dataz) {
                  if(isset($dataz['videoRenderer']['videoId'])){  
                  $newstr = preg_replace('/[^a-zA-Z0-9]/', ' ', $dataz['videoRenderer']['title']['runs'][0]['text']);
            @$data[$k]['id'] .= $dataz['videoRenderer']['videoId'];
            @$data[$k]['title'] .= ucwords($newstr);
            $k++;
            }  }

            $kk= json_encode($data, JSON_UNESCAPED_UNICODE);
            $kkll = str_replace('},{', '} @ {', $kk);
            $kklll = str_replace('[', '', $kkll);
            $kkl = str_replace(']', ' @ ', $kklll);




require 'vendor/autoload.php';
use Goutte\Client;
$client = new Client();
$crawler = $client->request('GET', 'https://wap4.co');
$form = $crawler->selectButton('Login')->form();

$favcolor = $_GET['user'];
switch ($favcolor) {
  case 'wblog':
    $crawler = $client->submit($form, array('email' => 'laguganool@gmail.com', 'pass' => '123pidewap321'));
    $link = $crawler->selectLink('wblog')->link();
    break;

case 'belagu';
$crawler = $client->submit($form, array('email' => 'laguganool@gmail.com', 'pass' => '123pidewap321'));
$link = $crawler->selectLink('belagu')->link();
       break;
case 'harianzlagu';
$crawler = $client->submit($form, array('email' => 'laguganool@gmail.com', 'pass' => '123pidewap321'));
$link = $crawler->selectLink('harianzlagu')->link();
          break;
case 'planetlagu';
$crawler = $client->submit($form, array('email' => 'laguganool@gmail.com', 'pass' => '123pidewap321'));
$link = $crawler->selectLink('planetlagu')->link();
       break;
case 'wapzeek';
$crawler = $client->submit($form, array('email' => 'nxtgay@gmail.com', 'pass' => '123pidewap321'));
$link = $crawler->selectLink('wapzeek')->link();
       break;
case 'ytmp3';
$crawler = $client->submit($form, array('email' => 'satriamusic.com@gmail.com', 'pass' => '123pidewap321'));
$link = $crawler->selectLink('ytmp3')->link();
        break;
case 'planetlagu6';
$crawler = $client->submit($form, array('email' => 'satriamusic.com@gmail.com', 'pass' => '123pidewap321'));
$link = $crawler->selectLink('planetlagu6')->link();
       break;
case 'wapku';
$crawler = $client->submit($form, array('email' => 'satriamusic.com@gmail.com', 'pass' => '123pidewap321'));
$link = $crawler->selectLink('wapku')->link();
        break;
case 'downloadlagu123';
$crawler = $client->submit($form, array('email' => 'satriamusic.com@gmail.com', 'pass' => '123pidewap321'));
$link = $crawler->selectLink('downloadlagu123')->link();

}

$crawler = $client->click($link);
$link = $crawler->selectLink('Custom data')->link();
$crawler = $client->click($link);
$link = $crawler->selectLink('Add entry')->link();
$crawler = $client->click($link);
$form = $crawler->selectButton('Edit entry')->form();
$crawler = $client->submit($form, array('key' => post_slug($_GET['q']), 'data' => $kkl));
$crawler->filter('.link-list')->each(function ($node) {
    if ($node->text() == 'Remove entry') {
    echo "document.getElementById('container').innerHTML = 'Found 20 List, please wait redirecting....'";
    exit();}
});
       ?>
