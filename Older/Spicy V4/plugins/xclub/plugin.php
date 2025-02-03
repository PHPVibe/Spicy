<?php
/**
* Plugin Name: Spicy (xClub v4)
* Plugin URI: http://get.phpvibe.com/
* Description: Adds several adult sources for web embeds plus the Redtube API based importer.
* Version: 4
* Author: PHPVibe Crew
* Author URI: http://www.phpvibe.com
* License: Commercial
*/

function reds($txt) {
$txt .= '<li><a href="'.admin_url("redtube").'"><i class="icon-heart"></i>Redtube Importer</a></li>';
$txt .= '<li><a href="'.admin_url("redstar").'"><i class="icon-female"></i>Redtube Pornstars</a></li>';
$txt .= '<li><a href="'.admin_url("reddown").'"><i class="icon-download"></i>Redtube Download</a></li>';

return $txt;
}

add_filter('importers_menu', 'reds');
function _AdultSources($hosts = array()){
$adult = _adultA();
$hosts = array_merge ($adult,$hosts);
return $hosts;
}
function _adultA(){
return 	array('pornhub','redtube', 'extremetube', 'slutload', 'xhamster', 'tnaflix', 'pornrabbit', 'keezmovies', 'xvideos', 'tube8', 'vidxnet', 'mofosex', 'drtuber', 'spankwire', 'youporn', 'alotporn', 'bigtits', 'porntube' );
}
function AdultDetails($txt = ''){
global $vid,$websLink;
if(!isset($vid) && isset($websLink)) {
$vid = new Vibe_Providers($websLink);	
}
if(isset($vid)) {
$link = $vid->theLink();
if(!nullval($link)) {
$ss = _adultA();
$provider = $vid->VideoProvider($link);	
if(in_array($provider, $ss)) {
switch($provider){
case 'redtube':
$videoId            = $vid->getVideoId(".com/");
$json_url           = 'https://api.redtube.com/?data=redtube.Videos.getVideoById&video_id=' . $videoId . '&output=json&thumbsize=big';
$content            = $vid->getDataFromUrl($json_url);
$data               = json_decode($content, true);
$video              = $data["video"];
$duration_arr       = explode(":", $video['duration']);
$video['duration']  = $duration_arr[0] * 60 + $duration_arr[1];
$video['thumbnail'] = str_replace("m.jpg", "b.jpg", $video['default_thumb']);
if (!empty($video['tags'])):
$video['tags'] = implode(', ', $video['tags']);
endif;
if (!empty($video['stars'])):
$video['stars'] = implode(', ', $video['stars']);
endif;
if (!empty($video['tags']) && !empty($video['stars'])):
$video['tags'] = $video['stars'] . "," . $video['tags'];
endif;
$video['video']['url'] =  str_replace('http:','https:',$video['video']['url']);
return $video;
break;
case 'pornhub':
$html = $vid->getDataFromUrl($link);
preg_match('%<h1 class="title">(.+?)</h1>%i', $html, $tmatches);
$video['title'] = @$tmatches[1];
preg_match('/<var class="duration">(.*)<\/var>/U', $html, $dmatches);
$di                = @$dmatches[1];
$duration_arr      = explode(":", $di);
$mincon            = preg_replace("/\D/", "", $duration_arr[0]);
$seccon            = preg_replace("/\D/", "", $duration_arr[1]);
$video['duration'] = $mincon * 60 + $seccon;
preg_match('/<meta property="og:image" content="(.*?)" \/>/', $html, $matches);
if(isset($matches[1])) {$video['thumbnail'] = $matches[1]; }
unset($matches);
return $video;
break;
case 'xhamster':
$videoId            = $vid->getVideoId(".com/movies/", "/");
//$html = $vid->getDataFromUrl($link);
$video['thumbnail'] = 'http://et0.xhamster.com/t/' . substr($videoId, -3) . '/5_b_' . $videoId . '.jpg';
return $video;
break;
case 'tnaflix':
$html = $vid->getDataFromUrl($link);
preg_match('/<meta property="og:image" content="(.*?)" \/>/', $html, $matches);
$video['thumbnail'] = @$matches[1];
preg_match('/<meta property="og:title" content="(.*?)" \/>/', $html, $tmatches);
$video['title'] = @$tmatches[1];
preg_match('/<meta property="og:description" content="(.*?)" \/>/', $html, $dmatches);
$video['description'] = @$dmatches[1];
preg_match('/<meta name="keywords" content="(.*?)" \/>/', $html, $kmatches);
$video['tags'] = @$kmatches[1];
return $video;
break;
case 'pornrabbit':
$html = $vid->getDataFromUrl($link);
//$videoslug = $vid->getVideoId(".com/video/");
preg_match('/<meta name="description" content="(.*?)" \/>/', $html, $dmatches);
$video['description'] = $dmatches[1];
preg_match('/<meta name="keywords" content="(.*?)" \/>/', $html, $kmatches);
$video['tags'] = $kmatches[1];
preg_match('%<h1>(.+?)</h1>%i', $html, $tmatches);
$video['title'] = $tmatches[1];
return $video;
break;
case 'keezmovies':
$html = $vid->getDataFromUrl($link);
preg_match('/<meta name="description" content="(.*?)" \/>/', $html, $dmatches);
$video['description'] = str_replace("on Keezmovies.com. Enjoy free porn videos on this porno tube updated daily!", "", $dmatches[1]);
preg_match('/<meta name="keywords" content="(.*?)" \/>/', $html, $kmatches);
$video['tags'] = $kmatches[1];
preg_match('%<h1 class="title-video-page" style="font-size: 11pt; text-align: center; font-family: arial, helvetica, sans-serif; color: #222;">(.+?)</h1>%i', $html, $tmatches);
$video['title'] = $tmatches[1];
return $video;
break;
case 'tube8':
//$videoslug = $vid->getVideoId(".com/");
$html = $vid->getDataFromUrl($link);
preg_match("/<title>(.*)<\/title>/siU", $html, $tmatches);
$tmp_title      = explode("-", $tmatches[1]);
$video['title'] = @$tmp_title[0];
return $video;
break;
case 'spankwire':
$html = $vid->getDataFromUrl($link);
preg_match('%<h1>(.+?)</h1>%i', $html, $tmatches);
$video['title'] = @$tmatches[1];
return $video;
break;
case 'youporn':
$videoslug = $vid->getVideoId(".com/watch/");
$html      = $vid->getDataFromUrl($link);
preg_match('/<title>(.*) - Free/U', $html, $tmatches);
$video['title'] = $tmatches[1];
$reg               = "/phncdn.com(.+)1.jpg/";
$html='';
return $video;
break;
case 'bigtits':
$html = $vid->getDataFromUrl($link);
preg_match('/<meta property="og:image" content="(.*?)" \/>/', $html, $matches);
$video['thumbnail'] = $matches[1];
preg_match('/<meta property="og:title" content="(.*?)" \/>/', $html, $tmatches);
$video['title'] = str_replace("- ( . Y . ) Big Tits&trade;", "", $tmatches[1]);
return $video;
break;
}															

/* End link check */
}
/* End provider check */
}
/* End isset(vid) */
}
/* End function */
return $txt;
}
function EmbedAdult($txt = ''){
global $vid,$websLink;
if(!isset($vid) && isset($websLink)) {
$vid = new Vibe_Providers($websLink);	
}
if(isset($vid)) {
$link = $vid->theLink();
if(!nullval($link)) {
$ss = _adultA();
$provider = $vid->VideoProvider($link);	
if(in_array($provider, $ss)) {
switch($provider) {
/* Start adult providers */

case 'pornhub':
$videoId = $vid->getVideoId("viewkey=");
if ($videoId != '')
{
$embedCode = '<iframe src="https://www.pornhub.com/embed/' . $videoId . '" frameborder=0 width=' . get_option('video-width') . ' height=' . get_option('video-height') . ' scrolling=no name="ph_embed_video"></iframe>';
} //$videoId != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'redtube':
$videoId = $vid->getVideoId(".com/");																
if ($videoId != '')
{
$embedCode  = '<iframe src="https://embed.redtube.com/?id=' . $videoId . '&bgcolor=000000" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>';
} //$videoId != ''
else
{
$embedCode = INVALID_URL;
}

break;
case 'extremetube':
$videoslug = $vid->getVideoId(".com/video/");
if ($videoslug != '')
{
$embedCode = '
<iframe src="https://www.extremetube.com/embed/' . $videoslug . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no" name="extremetube_embed_video"></iframe>
';
} //$videoslug != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'slutload':
$videoIdx = explode("/",$vid->getVideoId(".com/video/"));
$videoId = @$videoIdx["1"];
if ($videoId != '')
{
$embedCode = '<iframe src="http://www.slutload.com/embed_player/' . $videoId.'" style="overflow: hidden;" width="640" height="360" frameborder="0" scrolling="no" allowfullscreen></iframe>';
} //$videoId != ''
break;
case 'xhamster':
$videoId = $vid->getVideoId(".com/movies/", "/");
if ($videoId != '')
{
$embedCode = '<iframe width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" src="http://xhamster.com/xembed.php?video=' . $videoId . '" frameborder="0" scrolling="no"></iframe>';
} //$videoId != ''
break;
case 'tnaflix':
$videoId = $vid->getVideoId("/video");
if ($videoId != '')
{
$embedCode = '<iframe width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" src="http://player.tnaflix.com/video/' . $videoId . '" frameborder="0" scrolling="no"></iframe>';
} //$videoId != ''
break;
case 'pornrabbit':
$videoslug = $vid->getVideoId(".com/video/");
if ($videoslug != '')
{
$embedCode = '
<iframe src="http://www.pornrabbit.com/embed/' . $videoslug . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>
';
} //$videoslug != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'keezmovies':
$videoslug = $vid->getVideoId(".com/video/");
if ($videoslug != '')
{
$embedCode = '
<iframe src="http://www.keezmovies.com/embed/' . $videoslug . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>
';
} //$videoslug != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'xvideos':
$videoslug = $vid->getVideoId(".com/video", "/");
if ($videoslug != '')
{
$embedCode = '
<iframe src="http://flashservice.xvideos.com/embedframe/' . $videoslug . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>
';
} //$videoslug != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'tube8':
$videoslug = $vid->getVideoId(".com/");
if ($videoslug != '')
{
$embedCode = '
<iframe src="http://www.tube8.com/embed/' . $videoslug . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>
';
} //$videoslug != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'vidxnet':
$videoId = $vid->getVideoId("movies/", "/");
if ($videoId != '')
{
$embedCode = '<script type="text/javascript">
var vidxnet_embed_movieid=' . $videoId . ';
var vidxnet_embed_width=' . get_option('video-width') . ';
var vidxnet_embed_height=' . get_option('video-height') . ';
</script>
<script type="text/javascript" src="http://www.vidxnet.com/javascript/embed.js"></script>​';
} //$videoId != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'mofosex':
$videoId = $vid->getVideoId("videos/", "/");
if ($videoId != '')
{
$embedCode = '<iframe src="http://www.mofosex.com/embed?videoid=' . $videoId . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no" name="mofosex_embed_video"></iframe>';
} //$videoId != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'drtuber':
$videoId = $vid->getVideoId("video/", "/");
if ($videoId != '')
{
$embedCode = '<iframe src="http://www.drtuber.com/embed/' . $videoId . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>';
} //$videoId != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'spankwire':
$videoId = $vid->getVideoId("/video", "/");
if ($videoId != '')
{
$embedCode = '<iframe src="http://www.spankwire.com/EmbedPlayer.aspx?ArticleId=' . $videoId . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no" name="spankwire_embed_video"></iframe>';
} //$videoId != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'youporn':
$videoslug = $vid->getVideoId(".com/watch/");
if ($videoslug != '')
{
$embedCode = '<iframe src="http://www.youporn.com/embed/' . $videoslug . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no" name=\'yp_embed_video\'></iframe>
';
} //$videoslug != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'alotporn':
$videoslug = $vid->getVideoId(".com/", "/");
if ($videoslug != '')
{
$embedCode = '<iframe src="http://alotporn.com/embed.php?id=' . $videoslug . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>
';
} //$videoslug != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'bigtits':
$videoId = $vid->getLastNr($link);
if ($videoId != '')
{
$embedCode = '<object id="BigTitsPlayer" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" type="application/x-shockwave-flash" data="http://www.bigtits.com/js/flowplayer/flowplayer.embed-3.2.6-dev.swf"><param value="true" name="allowfullscreen"/><param value="always" name="allowscriptaccess"/><param value="high" name="quality"/><param value="#000000" name="bgcolor"/><param name="movie" value="http://www.bigtits.com/js/flowplayer/flowplayer.embed-3.2.6-dev.swf" /><param value=\'config=http%3A%2F%2Fwww.bigtits.com%2Fvideos%2Fembed_config%3Fid%3D' . $videoId . '\' name="flashvars"/></object>​';
} //$videoId != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'porntube':
$videoId = $vid->getVideoId("_");
if ($videoId != '')
{
$embedCode = '<iframe src="http://embed.porntube.com/' . $videoId . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no" class="porntube-player"></iframe>';
} //$videoId != ''
else
{
$embedCode = INVALID_URL;
}
break;
//finished, let's return the embed code
}
/* End link check */
}
/* End provider check */
}
/* End isset(vid) */
}
/* End function */
return $embedCode;
}

add_filter('EmbedDetails', 'AdultDetails');
add_filter('EmbedModify', 'EmbedAdult');
add_filter('vibe-video-sources', '_AdultSources');
?>