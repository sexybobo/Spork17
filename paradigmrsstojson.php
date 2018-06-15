<?php
$url = "http://abundantlifels.com/feed/podcast/paradigm";
$xml = simplexml_load_file ($url);
$items = $xml->channel->item;
$providername = $xml->channel->title;
$lastupdated2 = $xml->channel->lastBuildDate;
$lastupdated1 = new DateTime($lastupdated2);
$lastupdated = $lastupdated1->format(DateTime::ISO8601);
$feed = [
                'providerName'       => (string) $providername,
                'lastUpdated'        => (string) $lastupdated,
                'language'                      => 'en-US',
                'tvSpecials'         => [],
        ];
foreach($items as $item)
{
$mp3url = (string) $item->enclosure->attributes()->url;
$mp3file = basename ($mp3url, ".mp3");
$videofile = $mp3file . ".mp4";
$videourl = "https://abls.boboland.info/paradigm/temp/" . $videofile;
$title = $item->title;
$strtime = $item->children('http://www.itunes.com/dtds/podcast-1.0.dtd')->duration;
$parsed = date_parse($strtime);
$time_seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
$pubdate1 = $item->pubDate;
$pubdate2 = new DateTime($pubdate1);
$pubdate = $pubdate2->format(DateTime::ISO8601);
$feed['tvSpecials'][] = [
        'id' => (string) $mp3file . "hello",
        'title' => (string) $title,
        'shortDescription' => (string) $title,
        'thumbnail' => "https://i.imgur.com/gfH2o8J.jpg",
        'genres' => ["educational"],
        'tags' => ["faith"],
        'releaseDate' => $pubdate,
        'content' => [
        'dateAdded' => $pubdate,
        'duration' => $time_seconds,
        'videos' => [[
        'url' => "http://abls.boboland.info/paradigm/temp/fountains-from-drought-to-deluge.mp4",
        'quality' => "HD",
        'videoType' => 'MP4',
        ]],
                ]];
}

header('Content-Type: application/json');
echo json_encode($feed);
?>
