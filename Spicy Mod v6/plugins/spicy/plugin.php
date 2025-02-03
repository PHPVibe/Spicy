<?php
/**
* Plugin Name: Spicy v5
* Plugin URI: http://get.phpvibe.com/
* Description: Adds several adult sources for web embeds plus the Redtube API based importer.
* Version: 5.5
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
$hosts = array_merge($adult,$hosts);
return $hosts;
}
function _adultA(){
return 	array('pornhub','redtube', 'extremetube', 'slutload', 'xhamster', 'tnaflix', 'pornrabbit', 'xvideos', 'tube8', 'mofosex','spankwire', 'youporn', 'fantasti', 'porntube' );
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
$content = file_get_contents('https://embed.redtube.com/?id=' . $videoId . '&bgcolor=000000');	
preg_match('/"videoUrl":"(.+)"}]/i', $content, $info);
$redmp4 = '';
if(isset($info[1])) {
$iurls= explode('"}]',$info[1]);
//var_dump($iurls[0]);
$redmp4 = urldecode(stripslashes($iurls[0]));
$redmp4 = str_replace(array('"videoUrl":"', '"}]'),'',$redmp4);
}elseif(isset($info[0])) {	
$iurls= explode('"}]',$info[0]);
$redmp4 = urldecode(stripslashes($iurls[0]));	
$redmp4 = str_replace(array('"videoUrl":"', '"}]'),'',$redmp4);
//	
} 
if(not_empty($redmp4)) {
$embedCode  = str_replace('type:','otype:',$vid->remotevideo($redmp4));	
$embedCode  = str_replace('image:','type: "mp4", image:',$embedCode);
$embedCode .= '<script>$(document).ready(function() {
              jwplayer().onError( function(){
				 toastr.warning("'._lang("if the video fails to play.").'"," '._lang("Please refresh the page").'");				  
				  });
		});	</script>';	
} else {
$embedCode  = '<iframe src="https://embed.redtube.com/?id=' . $videoId . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>';
}
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
$embedCode = '<iframe width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" src="https://xhamster.com/xembed.php?video=' . $videoId . '" frameborder="0" scrolling="no"></iframe>';
} //$videoId != ''
break;
case 'tnaflix':
$videoId = $vid->getVideoId("/video");
if ($videoId != '')
{
$embedCode = '<iframe width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" src="https://player.tnaflix.com/video/' . $videoId . '" frameborder="0" scrolling="no"></iframe>';
} //$videoId != ''
break;
case 'pornrabbit':
$videoslug = $vid->getVideoId(".com/video/");
if ($videoslug != '')
{
$embedCode = '
<iframe src="https://www.pornrabbit.com/embed/' . $videoslug . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>
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
$ids = explode("/",rtrim($link,'/'));
$id = end($ids);
if ($videoslug != '')
{
$embedCode = '
<iframe src="https://www.tube8.com/embed/' . $videoslug . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>
';
} //$videoslug != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'mofosex':
$videoId = $vid->getVideoId("videos/", "/");
if ($videoId != '')
{
$embedCode = '<iframe src="https://www.mofosex.com/embed?videoid=' . $videoId . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no" name="mofosex_embed_video"></iframe>';
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
$embedCode = '<iframe src="https://www.spankwire.com/EmbedPlayer.aspx?ArticleId=' . $videoId . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no" name="spankwire_embed_video"></iframe>';
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
$embedCode = '<iframe src="https://www.youporn.com/embed/' . $videoslug . '" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no" name=\'yp_embed_video\'></iframe>
';
} //$videoslug != ''
else
{
$embedCode = INVALID_URL;
}
break;
case 'fantasti':
$ids = explode("/",rtrim($link,'/'));
$videoId = end($ids);
if ($videoId != '')
{
$embedCode = '<iframe src="https://fantasti.cc/embed/' . $videoId . '/" frameborder="0" width="' . get_option('video-width') . '" height="' . get_option('video-height') . '" scrolling="no"></iframe>';

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

add_filter('EmbedModify', 'EmbedAdult');
add_filter('vibe-video-sources', '_AdultSources');
?>