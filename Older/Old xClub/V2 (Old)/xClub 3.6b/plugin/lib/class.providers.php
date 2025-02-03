<?php
  //constants
  define('UNKNOWN_PROVIDER', _lang('Unknown provider or incorrect URL. Please try again.'));
  define('INVALID_URL', _lang('This URL is invalid or the video is removed by the provider.'));
  
 
 
  class Vibe_Providers
  {
      protected $height = 300;
      protected $width = 600;
      protected $link = "";
      function __construct($width = null, $height = null)
      {
          $this->setDimensions($width, $height);
      }
      //check if video link is valid
      public function isValid($videoLink)
      {
          $this->link    = $videoLink;
          $videoProvider = $this->decideVideoProvider();
          if (!empty($videoProvider) && $videoProvider != "") {
              return true;
          } else {
              return false;
          }
      }
      // getEmbedCode
      public function getEmbedCode($videoLink, $width = null, $height = null)
      {
          $this->setDimensions($width, $height);
          if ($videoLink != "") {
              if (!is_numeric(strpos($videoLink, "http://")) && !is_numeric(strpos($videoLink, "https://")) ) {
                  $videoLink = "http://" . $videoLink;
              }
              $this->link    = $videoLink;
              $embedCode     = "";
              $videoProvider = $this->decideVideoProvider();
              if ($videoProvider == "") {
                  $embedCode = UNKNOWN_PROVIDER;
              } else {
                  $embedCode = $this->generateEmbedCode($videoProvider);
              }
          } else {
              $embedCode = INVALID_URL;
          }
          return $embedCode;
      }
      // decide video provider
      private function decideVideoProvider()
      {
          $videoProvider = "";
          //providers list
          $hostings      = array(
              'youtube',
              'vimeo',
              'metacafe',
              'dailymotion',
              'hell',
              'trilulilu',
              'viddler',
              'blip',
              'myspace',
              'twitcam',
              'ustream',
              'liveleak',
              'livestream',
              'vplay',
              'facebook',
              'localfile',
              'localimage',
              'peteava',
              'vk',
			  'vine',
              'telly',
              'putlocker',
              'gametrailers',
			  'docs.google.com',
			   'pornhub',
												'redtube',
												'extremetube',
												'slutload',
												'youku',
												'xhamster',
												'tnaflix',
												'pornrabbit',
												'keezmovies',
												'xvideos',
												'tube8',
												'vidxnet',
												'mofosex',
												'drtuber',
												'spankwire',
												'youporn',
												'alotporn',
												'bigtits',
												'porntube'
          );
          //hook for more sources
          $hostings      = apply_filter('vibe-video-sources', $hostings);
          //check	provider	
          for ($i = 0; $i < count($hostings); $i++) {
              if (is_numeric(strpos($this->link, $hostings[$i]))) {
                  $videoProvider = $hostings[$i];
              }
          }
          return $videoProvider;
      }
      // generate video ıd from link
      public function VideoProvider($link = null)
      {
          if (is_null($link)) {
              $thisProvider = $this->decideVideoProvider();
          } else {
              $this->link   = $link;
              $thisProvider = $this->decideVideoProvider();
          }
          return $thisProvider;
      }
       public function getVideoId($operand, $optionaOperand = null)
      {
          $videoId      = null;
          $startPosCode = strpos($this->link, $operand);
          if ($startPosCode != null) {
              $videoId = substr($this->link, $startPosCode + strlen($operand), strlen($this->link) - 1);
              if (!is_null($optionaOperand)) {
                  $startPosCode = strpos($videoId, $optionaOperand);
                  if ($startPosCode > 0) {
                      $videoId = substr($videoId, 0, $startPosCode);
                  }
              }
          }
          return $videoId;
      }
	 public function evplayer ($file,$thumb, $logo = null, $type=null) {
	if(!nullval(Fb_Key)) {$fbb = "yes";} else {$fbb = "no";}
$embed = ' <script>	  var thelogo = "'.$logo.'"; var thelink = "'.site_url().'";</script>
<script type="text/javascript" src="'.site_url().'lib/players/easyvideoplayer/java/FWDEVPlayer.js"></script>

<script type="text/javascript">
			FWDEVPUtils.onReady(function(){

				FWDEVPlayer.useYoutube = "yes";
				FWDEVPlayer.videoStartBehaviour = "pause";
				
				new FWDEVPlayer({		
					//main settings
					instanceName:"player1",
					parentId:"evplayer",
					mainFolderPath:"'.site_url().'lib/players/easyvideoplayer/content",
					skinPath:"minimal_skin_dark",
					displayType:"responsive",
					facebookAppId:"'.Fb_Key.'",
					videoSourcePath:"'.$file.'",
					logoSourcePath:"'.$logo.'",
					posterPath:"'.$thumb.'",
					showContextMenu:"no",
					addKeyboardSupport:"yes",
					autoPlay:"yes",
					loop:"yes",
					maxWidth:900,
					maxHeight:510,
					volume:.6,
					backgroundColor:"#000000",
					posterBackgroundColor:"#0099FF",
					//logo settings
					showLogo:"yes",
					hideLogoWithController:"yes",
					logoPosition:"topRight",
					logoMargins:5,
					//controller settings
					showControllerWhenVideoIsStopped:"yes",
					showVolumeScrubber:"yes",
					showVolumeButton:"yes",
					showTime:"yes",
					showYoutubeQualityButton:"yes",
					showFacebookButton:"'.$fbb.'",
					showEmbedButton:"no",
					showFullScreenButton:"yes",
					repeatBackground:"yes",
					controllerHeight:41,
					controllerHideDelay:3,
					startSpaceBetweenButtons:7,
					spaceBetweenButtons:9,
					scrubbersOffsetWidth:4,
					timeOffsetLeftWidth:5,
					timeOffsetRightWidth:3,
					volumeScrubberWidth:80,
					volumeScrubberOffsetRightWidth:0,
					timeColor:"#888888",
					youtubeQualityButtonNormalColor:"#888888",
					youtubeQualityButtonSelectedColor:"#FFFFFF",
					//embed window
					embedWindowCloseButtonMargins:0,
					borderColor:"#333333",
					mainLabelsColor:"#FFFFFF",
					secondaryLabelsColor:"#a1a1a1",
					shareAndEmbedTextColor:"#5a5a5a",
					inputBackgroundColor:"#000000",
					inputColor:"#FFFFFF"
				});				
			});
		</script>
<div id="evplayer"></div>

		 ';
return  $embed._ad('1');	
	  }   
	  
	 public function cjplayer ($file,$thumb, $logo = null, $type=null) {
	
$embed = '<iframe style="visibility: hidden; height:100%important;" onload="this.style.visibility=\'visible\';"                 
                data-width="'.$this->width.'" 
                data-height="'.$this->height.'"                 
                data-auto-play="false" 
                data-video="'.$file.'" 
                data-poster="'.$thumb.'"                 
                data-skin="dark" 
                data-firefox-uses-flash="false"                 
                data-use-share-buttons="true" 
                data-share-text="'._lang("Watch this video").'"         
                data-fallback-dark="'.site_url().'lib/players/cjplayer/swf/video_fallback_dark.swf" 
                data-fallback-light="'.site_url().'lib/players/cjplayer/swf/video_fallback_light.swf"                 
                width="100%" height="'.$this->height.'" scrolling="no" frameborder="0" type="text/html" 
                mozallowfullscreen="mozallowfullscreen" webkitallowfullscreen="webkitallowfullscreen"  allowfullscreen="allowfullscreen" 
                src="'.site_url().'lib/players/cjplayer/cj-video.html">
                
          </iframe>
		 ';
return  $embed._ad('1');	
	  } 
	   public function _jpcustom ($file,$thumb) {
	  global $video;	  
	  $ads = _jads();
 
	  $embed = "<script type=\"text/javascript\">
	  $(document).ready(function() {	 

				$('.mediaPlayer').mediaPlayer({
					media: {
						m4v: '" . $file . "',
						poster: '" . $thumb . "'
					},
                    playerlogo : '".thumb_fix(get_option('player-logo'))."',
					playerlink : '".canonical()."',
					playerlogopos : '".get_option('jp-logo','bright')."',
					size: {
						width: '100%',
						height: '".$this->height."'
					},
					autoplay:true,
					nativeVideoControls: {  ipad: /ipad/,   iphone: /iphone/,   android: /android/,   blackberry: /blackberry/,   iemobile: /iemobile/ },
                    playing: function() { $('div.screenAd').addClass('hide');  }
				});
			
			var cpJP  = \"#\" + $(this).find('.Player').attr('id');
".$ads['js']."			
				</script>
				<div id=\"uniquePlayer-1\" class=\"mediaPlayer darkskin\">
				<div id=\"uniqueContainer-1\" class=\"Player\">				
				</div>
				".$ads['html']."
			    </div>
				";		  
		  
			  return $embed;
	  }
	  public function _jwplayer6 ($file,$thumb, $logo = null, $type=null) {
	  global $video;
	 
	  $embed = '<div id="video-setup" class="full">' . _lang("Loading the player...") . '</div>';
              $embed .= ' <script type="text/javascript">
			
		jwplayer("video-setup").setup({ primary : "html5",  file: "' . $file . '",  image: "' . $thumb . '", modes: [
        { type: "html5" },
        { type: "flash", src: "' . site_url() . 'lib/players/jwplayer/player.swf" }
    ], stretching: "uniform",  height: ' . $this->height . ',   repeat: "always",	  width: "100%"';
if($type) {   $embed .= ', type: "' . strtolower($type) . '" '; }
if($logo && !nullval($logo)) {	  $embed .= ',	logo: {         file: "'.$logo.'",  position: "bottom-left",  link: "'.site_url().'"    }'; }
              $embed .= '  }); </script>';		  
		  
			  return $embed._ad('1');
	  }
	   public function _jwplayer5 ($file,$thumb, $logo = null, $type=null) {
	  	$embed = '<script type="text/javascript" src="'.site_url().'lib/players/jwplayer5/swfobject.js"></script>';
		$embed .= '<div id="mediaspace">You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and a browser with JavaScript support.</div>';
		$embed .= "	<script type='text/javascript'>
  var so = new SWFObject('".site_url()."lib/players/jwplayer5/player.swf','mpl','".$this->width."','".$this->height."','9');
  so.addParam('allowfullscreen','true');
  so.addParam('allowscriptaccess','always');
  so.addParam('wmode','opaque');
  so.addVariable('file','".$file."');";
  if($type == 'mp3') {
   $embed .= " so.addVariable('provider','sound');";
  } elseif($type) {
  $embed .= " so.addVariable('provider','video');";
   }
  $embed .= " so.addVariable('image','".$thumb."');
  so.addVariable('skin','".site_url()."lib/players/jwplayer5/newtube.zip');
  so.addVariable('controlbar','over');
  so.addVariable('logo.file','".$logo."');
  so.addVariable('logo.link','".site_url()."');
  so.addVariable('autostart','true');
  so.addVariable('logo.hide','false');
  so.addVariable('logo.position','bottom-left');    
  so.addVariable('repeat','always');
  //so.addVariable('stretching','fill');
  so.addVariable('plugins', 'fbit-1,tweetit-1');
  so.write('mediaspace');
</script>";
return  $embed._ad('1');	
	  }
	  public function _jwplayer($file,$thumb, $logo = null, $type=null) {
	  /** Switch jwplayer versions **/
	  if(get_option('jwp_version') == 5 ) {
	  return $this->_jwplayer5($file,$thumb, $logo, $type);
	  } else {
	  return $this->_jwplayer6($file,$thumb, $logo, $type);
	  }	  
	  }
	   public function flowplayer($file,$thumb, $logo = null, $type=null) {
	  $embed = ' <link rel="stylesheet" type="text/css"href="' . site_url() . 'lib/players/fplayer/skin/functional.css">';
      $embed .= ' 
	  <script>	  var thelogo = "'.$logo.'"; var thelink = "'.site_url().'";</script>
	  <script src="' . site_url() . 'lib/players/fplayer/flowplayer.min.js"></script>';
      $embed .= '<div data-swf="' . site_url() . 'lib/players/fplayer/flowplayer.swf"  class="flowplayer color-alt no-background aside-time" data-flashfit="true"  data-scaling="scale" data-embed="false" data-analytics="' . get_option("googletracking") . '">
       <video poster="' . $thumb . '" loop="loop">
       <source type="video/' . str_replace("ogv", "ogg", $type) . '" src="' . $file . '"/>';
      $embed .= '</video>   </div>';
	  
	return  $embed;					  
	  }
public function remotevideo($url)
      {
          global $video;
          $embedCode = '';
          if ($url) {
		  $pieces_array     = explode('.', $url);
                  $ext              = end($pieces_array);
                  $choice           = get_option('remote-player',1);
                  $mobile_supported = array("mp4","mp3", "webm","ogv","m3u8","ts","tif");
                  if (!in_array($ext, $mobile_supported)) {
                      /*force jwplayer always on non-mobi formats, as others are just html5 */
                      $choice = 1;
                  }
				   /* Redtube remote support */
				  if($this->VideoProvider($video->source) == "redtube") {
		          $url .='?'.$this->red_key();
		          $type= "mp4";
		            }
                  if ($choice == 1) {
				   
				  $embedCode = $this->_jwplayer($url,thumb_fix($video->thumb),thumb_fix(get_option('player-logo')),$ext);
                    } elseif ($choice == 2) {
                  $embedCode = $this->flowplayer($url,thumb_fix($video->thumb),thumb_fix(get_option('player-logo')),$ext);
                  }	elseif ($choice == 4) {
				  $embedCode = $this->cjplayer($url,thumb_fix($video->thumb),thumb_fix(get_option('player-logo')),$ext);
                  }	 
				  elseif ($choice == 5) {
				  $embedCode = $this->evplayer($url,thumb_fix($video->thumb),thumb_fix(get_option('player-logo')),$ext);
                  }	 
				  else {
                  $embedCode = $this->_jpcustom($url,thumb_fix($video->thumb));
				 }
           }
          return $embedCode;
      }
      // generate video embed code via using standart templates
      private function generateEmbedCode($videoProvider)
      {
          global $video;
          $embedCode = "";
          switch ($videoProvider) {
              case 'localimage':
                  $path = $this->getVideoId("localimage/").'@@'.get_option('mediafolder');
				  $real_link        = site_url() . 'stream.php?type=1&file=' . base64_encode(base64_encode($path));
                  $embedCode .= '<a rel="lightbox" class="media-href" title="' . stripslashes($video->title) . '" href="' . $real_link . '"><img class="media-img" src="' . $real_link . '" /></a>';
                  break;
              case 'localfile':
                  $path             = $this->getVideoId("localfile/").'@@'.get_option('mediafolder');
				  
                  if(!isIOS() && (get_option('hide-mp4',0) > 0)) {
				  $real_link        = site_url() . 'stream.php?file=' . base64_encode(base64_encode($path));
				  } else {
				  $real_link        = thumb_fix(get_option('mediafolder').'/'.$this->getVideoId("localfile/"));
				  }
                  //$ext = explode(".", $this->link);
                  //$ext = $ext[1];
                  $pieces_array     = explode('.', $this->link);
                  $ext              = end($pieces_array);
                  $choice           = get_option('choosen-player',1);
                   $mobile_supported = array("mp4","mp3", "webm","ogv","m3u8","ts","tif");
                  if (!in_array($ext, $mobile_supported)) {
                      /*force jwplayer always on non-mobi formats, as other players are just html5 */
                      $choice = 1;
                  }
				  
                  if ($choice == 1) {
				  $embedCode = $this->_jwplayer($real_link,thumb_fix($video->thumb),thumb_fix(get_option('player-logo')),$ext);
                    } elseif ($choice == 2) {
                  $embedCode = $this->flowplayer($real_link,thumb_fix($video->thumb),thumb_fix(get_option('player-logo')),$ext);
                  }	elseif ($choice == 4) {
				  $embedCode = $this->cjplayer($real_link,thumb_fix($video->thumb),thumb_fix(get_option('player-logo')),$ext);

                  }	elseif ($choice == 5) {
				  $embedCode = $this->evplayer($real_link,thumb_fix($video->thumb),thumb_fix(get_option('player-logo')),$ext);
                  }	
				  else {
                  $embedCode = $this->_jpcustom($real_link,thumb_fix($video->thumb));
				 }
                  break;
			case 'vine':
			$videoId = $this->getVideoId("/v/");
			if ($videoId != null) {
			 $embedCode .= '<iframe class="vine-embed" src="https://vine.co/v/'.$videoId.'/embed/simple?audio=1" width="' . $this->width . '" height="' . $this->height . '" frameborder="0"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>';
             $embedCode .= _ad('1');
			 } else {
                      $embedCode = INVALID_URL;
                  }
            break;			
              case 'facebook':
                  $videoId = $this->getVideoId("v=", "&");
                  if (empty($videoId)) {
                      $videoId = $this->getVideoId("v/");
                  }
                  if ($videoId != null) {
                      $embedCode .= '<iframe src="https://www.facebook.com/video/embed?video_id=' . $videoId . '" type="application/x-shockwave-flash" allowfullscreen="true" width="' . $this->width . '" height="' . $this->height . '"  frameborder="0"></iframe>';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
				  case 'docs.google.com':
                  $videoId = str_replace('/edit','/preview',$this->link);
                  if ($videoId != null) {
                      $embedCode .= '<iframe src="' . $videoId . '" width="' . $this->width . '" height="' . $this->height . '"  frameborder="0"></iframe>';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;  
				  
              case 'youtube':
                  $videoId = $this->getVideoId("v=", "&");
                  if ($videoId != null) {
                      $choice = get_option('youtube-player');
                      if ($choice < 2) {
                          $embedCode .= "<iframe width=\"" . $this->width . "\" height=\"" . $this->height . "\" src=\"http://www.youtube.com/embed/" . $videoId . "?&amp;title=&amp;html5=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;nologo=1&amp;vq=large&amp;autoplay=1&amp;ps=docs\" frameborder=\"0\" allowfullscreen=\"true\"></iframe>";
                      $embedCode .= _ad('1');
					  } elseif ($choice == 3) {
				  $embedCode = $this->evplayer($videoId,thumb_fix($video->thumb),thumb_fix(get_option('player-logo')));
                  }	
					  
					  else {
					  $real_link = 'http://www.youtube.com/watch?v=' . $videoId;
					  $img = 'http://i2.ytimg.com/vi/' . $videoId . '/mqdefault.jpg';
					  $embedCode = $this->_jwplayer ($real_link,$img, thumb_fix(get_option('player-logo')));
                             }
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'vimeo':
                  $videoIdForChannel = $this->getVideoId('#');
                  if (strlen($videoIdForChannel) > 0) {
                      $videoId = $videoIdForChannel;
                  } else {
                      $videoId = $this->getVideoId(".com/");
                  }
                  //$videoId = $videoForChannel;
                  if ($videoId != null) {
                      $embedCode .= '<iframe src="http://player.vimeo.com/video/' . $videoId . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;autoplay=1" width="' . $this->width . '" height="' . $this->height . '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'peteava':
                  $videoId = $this->getVideoId("/id-", "/");
                  $pieces  = explode("-", $videoId);
                  $videoId = $pieces[0];
                  //$videoId = $this->getLastNr($this->link);
                  if ($videoId != null) {
                      $embedCode .= '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://www.peteava.ro/static/swf/player.swf?http://content.peteava.ro/stream.php&file=' . $videoId . '_standard.mp4&image=http://storage2.peteava.ro/serve/thumbnail/' . $videoId . '/playerstandard&hd_file=' . $videoId . '_high.mp4&hd_image=http://storage2.peteava.ro/serve/thumbnail/' . $videoId . '/playerhigh&autostart=true" frameborder="0" scrolling="no" allowfullscreen></iframe>';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'putlocker':
                  $videoId = $this->getVideoId("file/");
                  if ($videoId != null) {
                      $embedCode .= '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://www.putlocker.com/embed/' . $videoId . '" frameborder="0" scrolling="no" allowfullscreen></iframe>';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'hell':
                  $videoId = $this->getVideoId("videos/");
                  //$videoId = $this->getLastNr($this->link);
                  if ($videoId != null) {
                      $embedCode .= '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://www.hell.tv/embed/video/' . $videoId . '" frameborder="0" scrolling="no" allowfullscreen></iframe>';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'dailymotion':
                  $videoId = $this->getVideoId("video/");
                  if ($videoId != null) {
                      $embedCode .= '<iframe frameborder="0" width="' . $this->width . '" height="' . $this->height . '" src="http://www.dailymotion.com/embed/video/' . $videoId . '"></iframe>';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'trilulilu':
                  $videoId = $this->getVideoId(".ro/");
                  if ($videoId != null) {
                      $embedCode .= '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://embed.trilulilu.ro/' . $videoId . '" frameborder="0" allowfullscreen></iframe> ';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'liveleak':
                  $videoId = $this->getVideoId("i=");
                  if ($videoId != null) {
                      $embedCode .= '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://www.liveleak.com/e/' . $videoId . '" frameborder="0" allowfullscreen></iframe> ';
                 $embedCode .= _ad('1');
				 } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'metacafe':
                  $videoId = $this->getVideoId("watch/", "/");
                  if ($videoId != null) {
                      $embedCode .= '<iframe src="http://www.metacafe.com/embed/' . $videoId . '/" width="' . $this->width . '" height="' . $this->height . '" allowFullScreen frameborder=0></iframe>';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'viddler':
                  $videoId = $this->getVideoId("v/");
                  if ($videoId != null) {
                      $embedCode .= "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"" . $this->width . "\" height=\"" . $this->height . "\" ";
                      $embedCode .= "id=\"viddler_1f72e4ee\">";
                      $embedCode .= "<param name=\"movie\" value=\"http://www.viddler.com/player/" . $videoId . "\" />";
                      $embedCode .= "<param name=\"allowScriptAccess\" value=\"always\" />";
                      $embedCode .= "<param name=\"allowFullScreen\" value=\"true\" />";
                      $embedCode .= "<embed src=\"http://www.viddler.com/player/" . $videoId . "\"";
                      $embedCode .= " width=\"" . $this->width . "\" height=\"" . $this->height . "\" type=\"application/x-shockwave-flash\" ";
                      $embedCode .= "allowScriptAccess=\"always\"";
                      $embedCode .= "allowFullScreen=\"true\" name=\"viddler_" . $videoId . "\"\"></embed></object>";
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'blip':
                  $videoId = $this->getLastNr($this->link);
                  if ($videoId != null) {
                      $embedCode .= "<embed src=\"http://blip.tv/file/" . $videoId . "\" ";
                      $embedCode .= "type=\"application/x-shockwave-flash\" width=\"" . $this->width . "\" height=\"" . $this->height . "\"";
                      $embedCode .= " allowscriptaccess=\"always\" allowfullscreen=\"true\"></embed>";
                 $embedCode .= _ad('1');
				 } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'myspace':
                  $this->link = strtolower($this->link);
                  $videoId    = $this->getVideoId("vid/", "&");
                  if ($videoId != null) {
                      $embedCode .= "<object width=\"" . $this->width . "\" height=\"" . $this->height . "\" ><param name=\"allowFullScreen\" ";
                      $embedCode .= "value=\"true\"/><param name=\"wmode\" value=\"transparent\"/><param name=\"movie\" ";
                      $embedCode .= "value=\"http://mediaservices.myspace.com/services/media/embed.aspx/m=" . $videoId . ",t=1,mt=video\"/>";
                      $embedCode .= "<embed src=\"http://mediaservices.myspace.com/services/media/embed.aspx/m=" . $videoId . ",t=1,mt=video\" ";
                      $embedCode .= "width=\"" . $this->width . "\" height=\"" . $this->height . "\" allowFullScreen=\"true\" type=\"application/x-shockwave-flash\" ";
                      $embedCode .= "wmode=\"transparent\"></embed></object>";
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'vplay':
                  $videoId = $this->getVideoId("watch/");
                  $videoId = str_replace("/", "", $videoId);
                  if ($videoId != null) {
                      $embedCode .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="' . $this->width . '" height="' . $this->height . '"><param name="movie" value="http://i.vplay.ro/f/embed.swf?key=' . $videoId . '"><param name="allowfullscreen" value="true"><param name="wmode" value="opaque"><param name="quality" value="high"><embed src="http://i.vplay.ro/f/embed.swf?key=' . $videoId . '" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="' . $this->width . '" height="' . $this->height . '" allowfullscreen="true" wmode="opaque" ></embed></object>';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'ustream':
                  $videoId = $this->getVideoId("recorded/", '/');
                  if ($videoId != null) {
                      $embedCode .= "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" ";
                      $embedCode .= "width=\"" . $this->width . "\" height=\"" . $this->height . "\" ";
                      $embedCode .= "id=\"utv867721\" name=\"utv_n_859419\"><param name=\"flashvars\" ";
                      $embedCode .= "value\"beginPercent=0.0236&amp;endPercent=0.2333&amp;autoplay=false&locale=en_US\" />";
                      $embedCode .= "<param name=\"allowfullscreen\" value=\"true\" /><param name=\"allowscriptaccess\" ";
                      $embedCode .= "value=\"always\" />";
                      $embedCode .= "<param name=\"src\" value=\"http://www.ustream.tv/flash/video/" . $videoId . "\" />";
                      $embedCode .= "<embed flashvars=\"beginPercent=0.0236&amp;endPercent=0.2333&amp;autoplay=false&locale=en_US\" ";
                      $embedCode .= "width=\"" . $this->width . "\" height=\"" . $this->height . "\" ";
                      $embedCode .= "allowfullscreen=\"true\" allowscriptaccess=\"always\" id=\"utv867721\" ";
                      $embedCode .= "name=\"utv_n_859419\" src=\"http://www.ustream.tv/flash/video/" . $videoId . "\" ";
                      $embedCode .= "type=\"application/x-shockwave-flash\" /></object>";
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'livestream':
                  $firstID  = $this->getVideoId("com/", '/');
                  $secondID = $this->getVideoId("?clipId=", '&');
                  if ($firstID != null && $secondID != null) {
                      $embedCode .= "<object width=\"" . $this->width . "\" height=\"" . $this->height . "\" id=\"lsplayer\" ";
                      $embedCode .= "classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\">";
                      $embedCode .= "<param name=\"movie\" ";
                      $embedCode .= "value=\"http://cdn.livestream.com/grid/LSPlayer.swf?channel=" . $firstID . "&amp;";
                      $embedCode .= "clip=" . $secondID . "&amp;autoPlay=false\"></param>";
                      $embedCode .= "<param name=\"allowScriptAccess\" value=\"always\"></param><param name=\"allowFullScreen\" ";
                      $embedCode .= "value=\"true\"></param><embed name=\"lsplayer\" wmode=\"transparent\" ";
                      $embedCode .= "src=\"http://cdn.livestream.com/grid/LSPlayer.swf?channel=" . $firstID . "&amp;";
                      $embedCode .= "clip=" . $secondID . "&amp;autoPlay=false\" ";
                      $embedCode .= "width=\"" . $this->width . "\" height=\"" . $this->height . "\" allowScriptAccess=\"always\" allowFullScreen=\"true\" ";
                      $embedCode .= "type=\"application/x-shockwave-flash\"></embed></object>	";
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'gametrailers':
                  $videoFullID = $this->getVideoId("video/");
                  $videoId     = strpos($videoFullID, "/");
                  $videoId     = substr($videoFullID, $videoId + 1, strlen($videoFullID));
                  if ($videoId != null) {
                      $embedCode .= '<embed src="http://media.mtvnservices.com/mgid:moses:video:gametrailers.com:' . $videoId . '" width="' . $this->width . '" height="' . $this->height . '" type="application/x-shockwave-flash" allowFullScreen="true" allowScriptAccess="always" base="." flashVars=""></embed>';
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'vk':
                  $firstIDs  = $this->getVideoId("video", '_');
                  $secondIDs = $this->getVideoId("_", '?');
                  $thirdIDs  = $this->getVideoId("hash=");
                  if ($firstIDs != null && $secondIDs != null && $thirdIDs != null) {
                      $embedCode .= "<iframe src=\"http://vk.com/video_ext.php?oid=" . $firstIDs . "&id=" . $secondIDs . "&hash=" . $thirdIDs . "&sd\" width=\"" . $this->width . "\" height=\"" . $this->height . "\" frameborder=\"0\"></iframe>";
                  $embedCode .= _ad('1');
				  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
              case 'telly':
                  $videoIdForChannel = $this->getVideoId('guid=');
                  if (strlen($videoIdForChannel) > 0) {
                      $videoId = $videoIdForChannel;
                  } else {
                      $videoId = $this->getVideoId(".com/", '?');
                  }
                  if ($videoId != null) {
                      $embedCode .= "<iframe src=\"http://telly.com/embed.php?guid=" . $videoId . "&#038;autoplay=0\" title=\"Telly video player \" class=\"twitvid-player\" type=\"text/html\" width=\"" . $this->width . "\" height=\"" . $this->height . "\" frameborder=\"0\"></iframe>";
                  } else {
                      $embedCode = INVALID_URL;
                  }
                  break;
				  /* Start adult providers */
			
			 case 'pornhub':
																$videoId = $this->getVideoId("viewkey=");
																if ($videoId != '')
																				{
																				$embedCode = '<iframe src="http://www.pornhub.com/embed/' . $videoId . '" frameborder=0 width=' . $this->width . ' height=' . $this->height . ' scrolling=no name="ph_embed_video"></iframe>';
																				} //$videoId != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'redtube':
																$videoId = $this->getVideoId(".com/");																
																if ($videoId != '')
																				{
																				
																				$embedCode  = '<object height="' . $this->height . '" width="' . $this->width . '"><param name="allowfullscreen" value="true"><param name="AllowScriptAccess" value="always"><param name="movie" value="http://embed.redtube.com/player/?id=' . $videoId . '&style=redtube"><param name="FlashVars" value="id=' . $videoId . '&style=redtube&autostart=false"><embed src="http://embed.redtube.com/player/?id=' . $videoId . '&style=redtube" allowfullscreen="true" AllowScriptAccess="always" flashvars="autostart=false" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" height="' . $this->height . '" width="' . $this->width . '" /></object>';
																				} //$videoId != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																			
																break;
												case 'extremetube':
																$videoslug = $this->getVideoId(".com/video/");
																if ($videoslug != '')
																				{
																				$embedCode = '
				<iframe src="http://www.extremetube.com/embed/' . $videoslug . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no" name="extremetube_embed_video"></iframe>
				';
																				} //$videoslug != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'slutload':
																$videoId = $this->getVideoId(".com/watch/", "/");
																if ($videoId != '')
																				{
																				$player_swf = 'http://emb.slutload.com/' . $videoId;
																				$flash_var  = '';
																				$embedCode  = '' . '<object type="application/x-shockwave-flash" data="' . $player_swf . '" width="' . $this->width . '" height="' . $this->height . '">' . '<param name="AllowScriptAccess" value="always">' . '<param name="movie" value="' . $player_swf . '"></param>' . '<param name="allowfullscreen" value="true"></param>' . '<embed src="' . $player_swf . '" AllowScriptAccess="always" allowfullscreen="true" width="' . $this->width . '" height="' . $this->height . '"></embed>' . '</object>' . '';
																				} //$videoId != ''
																break;
												case 'youku':
																$videoId = $this->getVideoId("v_show/id_", ".html");
																if ($videoId != '')
																				{
																				$player_swf = 'http://player.youku.com/player.php/sid/' . $videoId . '/v.swf';
																				$flash_var  = '';
																				$embedCode  = '' . '<embed src="' . $player_swf . '" ' . ' quality="high" width="' . $this->width . '" height="' . $this->height . '" ' . ' align="middle" allowScriptAccess="always" ' . ' type="application/x-shockwave-flash">' . '</embed>' . '';
																				} //$videoId != ''
																break;
												case 'xhamster':
																$videoId = $this->getVideoId(".com/movies/", "/");
																if ($videoId != '')
																				{
																				$embedCode = '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://xhamster.com/xembed.php?video=' . $videoId . '" frameborder="0" scrolling="no"></iframe>';
																				} //$videoId != ''
																break;
												case 'tnaflix':
																$videoId = $this->getVideoId("/video");
																if ($videoId != '')
																				{
																				$embedCode = '<iframe width="' . $this->width . '" height="' . $this->height . '" src="http://player.tnaflix.com/video/' . $videoId . '" frameborder="0" scrolling="no"></iframe>';
																				} //$videoId != ''
																break;
												case 'pornrabbit':
																$videoslug = $this->getVideoId(".com/video/");
																if ($videoslug != '')
																				{
																				$embedCode = '
				<iframe src="http://www.pornrabbit.com/embed/' . $videoslug . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no"></iframe>
				';
																				} //$videoslug != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'keezmovies':
																$videoslug = $this->getVideoId(".com/video/");
																if ($videoslug != '')
																				{
																				$embedCode = '
				<iframe src="http://www.keezmovies.com/embed/' . $videoslug . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no"></iframe>
				';
																				} //$videoslug != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'xvideos':
																$videoslug = $this->getVideoId(".com/video", "/");
																if ($videoslug != '')
																				{
																				$embedCode = '
				<iframe src="http://flashservice.xvideos.com/embedframe/' . $videoslug . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no"></iframe>
				';
																				} //$videoslug != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'tube8':
																$videoslug = $this->getVideoId(".com/");
																if ($videoslug != '')
																				{
																				$embedCode = '
				<iframe src="http://www.tube8.com/embed/' . $videoslug . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no"></iframe>
				';
																				} //$videoslug != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'vidxnet':
																$videoId = $this->getVideoId("movies/", "/");
																if ($videoId != '')
																				{
																				$embedCode = '<script type="text/javascript">
                                                                                              var vidxnet_embed_movieid=' . $videoId . ';
																							  var vidxnet_embed_width=' . $this->width . ';
                                                                                              var vidxnet_embed_height=' . $this->height . ';
                                                                                              </script>
                                                                                              <script type="text/javascript" src="http://www.vidxnet.com/javascript/embed.js"></script>​';
																				} //$videoId != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'mofosex':
																$videoId = $this->getVideoId("videos/", "/");
																if ($videoId != '')
																				{
																				$embedCode = '<iframe src="http://www.mofosex.com/embed?videoid=' . $videoId . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no" name="mofosex_embed_video"></iframe>';
																				} //$videoId != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'drtuber':
																$videoId = $this->getVideoId("video/", "/");
																if ($videoId != '')
																				{
																				$embedCode = '<iframe src="http://www.drtuber.com/embed/' . $videoId . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no"></iframe>';
																				} //$videoId != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'spankwire':
																$videoId = $this->getVideoId("/video", "/");
																if ($videoId != '')
																				{
																				$embedCode = '<iframe src="http://www.spankwire.com/EmbedPlayer.aspx?ArticleId=' . $videoId . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no" name="spankwire_embed_video"></iframe>';
																				} //$videoId != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'youporn':
																$videoslug = $this->getVideoId(".com/watch/");
																if ($videoslug != '')
																				{
																				$embedCode = '<iframe src="http://www.youporn.com/embed/' . $videoslug . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no" name=\'yp_embed_video\'></iframe>
				';
																				} //$videoslug != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'alotporn':
																$videoslug = $this->getVideoId(".com/", "/");
																if ($videoslug != '')
																				{
																				$embedCode = '<iframe src="http://alotporn.com/embed.php?id=' . $videoslug . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no"></iframe>
				';
																				} //$videoslug != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'bigtits':
																$videoId = $this->getLastNr($this->link);
																if ($videoId != '')
																				{
																				$embedCode = '<object id="BigTitsPlayer" width="' . $this->width . '" height="' . $this->height . '" type="application/x-shockwave-flash" data="http://www.bigtits.com/js/flowplayer/flowplayer.embed-3.2.6-dev.swf"><param value="true" name="allowfullscreen"/><param value="always" name="allowscriptaccess"/><param value="high" name="quality"/><param value="#000000" name="bgcolor"/><param name="movie" value="http://www.bigtits.com/js/flowplayer/flowplayer.embed-3.2.6-dev.swf" /><param value=\'config=http%3A%2F%2Fwww.bigtits.com%2Fvideos%2Fembed_config%3Fid%3D' . $videoId . '\' name="flashvars"/></object>​';
																				} //$videoId != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
												case 'porntube':
																$videoId = $this->getVideoId("_");
																if ($videoId != '')
																				{
																				$embedCode = '<iframe src="http://embed.porntube.com/' . $videoId . '" frameborder="0" width="' . $this->width . '" height="' . $this->height . '" scrolling="no" class="porntube-player"></iframe>';
																				} //$videoId != ''
																else
																				{
																				$embedCode = INVALID_URL;
																				}
																break;
																//finished, let's return the embed code
          }
          return $embedCode;
      }
      // get id from weird rewrites
      public function getLastNr($url)
      {
          $pieces_array = explode('/', $url);
          $end_piece    = end($pieces_array);
          $id_pieces    = explode('-', $end_piece);
          $last_piece   = end($id_pieces);
          $videoId      = preg_replace("/[^0-9]/", "", $last_piece);
          return $videoId;
      }
      private function setDimensions($width = null, $height = null)
      {
          if ((!is_null($width)) && ($width != "")) {
              $this->width = $width;
          }
          if ((!is_null($height)) && ($height != "")) {
              $this->height = $height;
          }
      }
      private function match($regex, $str, $i = 0)
      {
          if (preg_match($regex, $str, $match) == 1) {
              return $match[$i];
          } else {
              return null;
          }
      }
      function get_data()
      {
          $provider = $this->decideVideoProvider();
		  $video = array();
				  $video['description'] ='';
				   $video['title'] ='';
				   $video['thumbnail'] ='';
				   $video['duration'] ='';
				   $video['description'] ='';
          switch ($provider) {
		    case 'vine':
                 $videoId = $this->getVideoId("/v/");
				  $video = array();
				  $video['description'] ='';
				   $video['title'] ='';
				   $video['thumbnail'] ='';
    $url = "https://vine.co/v/". $videoId;
    $data = file_get_contents($url);
    preg_match('~<\s*meta\s+property="(twitter:description)"\s+content="([^"]*)~i', $data, $matches);
    if ( isset($matches[2]) ) {
       $video['description'] = $matches[2];
    }
	unset($matches);
	 preg_match('/property="twitter:title" content="(.*?)"/', $data, $matches);
 if ( isset($matches[1]) ) {
       $video['title'] = $matches[1];
    }
unset($matches);
	 preg_match('/property="twitter:image" content="(.*?)"/', $data, $matches);
 if ( isset($matches[1]) ) {
      $video['thumb'] = explode('?versionId',$matches[1]);
	  $video['thumbnail'] = $video['thumb']['0'];
    }
	  $video['duration']    = 6;
unset($matches);
unset($data);
return $video;
                  break;
              case 'vimeo':
                  $json_url              = "http://vimeo.com/api/v2/video/" . $this->getLastNr($this->link) . ".json";
                  $content               = $this->getDataFromUrl($json_url);
                  $video                 = json_decode($content, true);
                  $video[0]['thumbnail'] = $video[0]['thumbnail_medium'];
                  return $video[0];
                  break;
              case 'youtube':
                  $vid                        = preg_replace('/^.*(\?|\&)v\=/', '', $this->link);
                  $vid                        = preg_replace('/[^\w\-\_].*$/', '', $vid);
                  $json_url                   = 'http://gdata.youtube.com/feeds/api/videos/' . $vid . '?v=2&alt=jsonc';
                  $content                    = $this->getDataFromUrl($json_url);
                  $video                      = json_decode($content, true);
                  $video['data']['thumbnail'] = "http://i4.ytimg.com/vi/" . $video['data']['id'] . "/0.jpg";
                  if (isset($video['data']['tags'])) {
                      $taglist               = $video['data']['tags'];
                      $video['data']['tags'] = null;
                      $count                 = count($taglist);
                      for ($i = 0; $i < $count; $i++) {
                          $video['data']['tags'] .= $taglist[$i] . ', ';
                      }
                  } else {
                      $video['data']['tags'] = '';
                  }
                  return $video['data'];
                  break;
              case 'metacafe':                  
                   $idvid = $this->getVideoId("watch/","/");
                  
                  $file_data            = "http://www.metacafe.com/api/item/" . $idvid;
                  $video                = array();
                  $xml                  = new SimpleXMLElement(file_get_contents($file_data));
                  $title_query          = $xml->xpath('/rss/channel/item/title');
                  $video['title']       = $title_query ? strval($title_query[0]) : '';
                  $description_query    = $xml->xpath('/rss/channel/item/media:description');
                  $video['description'] = $description_query ? strval($description_query[0]) : '';
                  $tags_query           = $xml->xpath('/rss/channel/item/media:keywords');
                  $video['tags']        = $tags_query ? explode(',', strval(trim($tags_query[0]))) : null;
                  if (isset($video['tags']) && !empty($video['tags'])) {
                      $video['tags'] = implode(', ', $video['tags']);
                  } else{
				  $video['tags'] = '';
				  }
				 
                  $date_published_query = $xml->xpath('/rss/channel/item/pubDate');
                  $video['uploaded']    = $date_published_query ? ($date_published_query[0]) : null;
                  $thumbnails_query     = $xml->xpath('/rss/channel/item/media:thumbnail/@url');
				  if(isset($thumbnails_query[0])) {
                  $video['thumbnail']   = strval($thumbnails_query[0]);
				  } else {
				  $video['thumbnail']   = '';
				  }
                  $video['duration']    = null;
				  
                  return $video;
                  break;
              case 'dailymotion':
                  if (preg_match('#http://www.dailymotion.com/video/([A-Za-z0-9]+)#s', $this->link, $match)) {
                      $idvid = $match[1];
                  }
                  $file_data            = "http://www.dailymotion.com/rss/video/" . $idvid;
                  $video                = array();
                  $xml                  = new SimpleXMLElement(file_get_contents($file_data));
                  $title_query          = $xml->xpath('/rss/channel/item/title');
                  $video['title']       = $title_query ? strval($title_query[0]) : '';
                  $description_query    = $xml->xpath('/rss/channel/item/itunes:summary');
                  $video['description'] = $description_query ? strval($description_query[0]) : '';
                  $tags_query           = $xml->xpath('/rss/channel/item/itunes:keywords');
				  if(!empty($tags_query) && $tags_query) {
                  $video['tags']        = $tags_query ? explode(',', strval(trim($tags_query[0]))) : null;
                  $video['tags']        = implode(', ', $video['tags']);
				  } else {
				  $video['tags'] = '';
				  }
                  $date_published_query = $xml->xpath('/rss/channel/item/pubDate');
                  $video['uploaded']    = $date_published_query ? ($date_published_query[0]) : null;
                  $thumbnails_query     = $xml->xpath('/rss/channel/item/media:thumbnail/@url');
                  $video['thumbnail']   = strval($thumbnails_query[0]);
                  $duration_query       = $xml->xpath('/rss/channel/item/media:group/media:content/@duration');
                  $video['duration']    = $duration_query ? intval($duration_query[0]) : null;
                  return $video;
              case 'myspace':
                  # Get XML data URL
                  $file_data            = "http://mediaservices.myspace.com/services/rss.ashx?type=video&videoID=" . $this->getLastNr($this->link);
                  # XML
                  $xml                  = new SimpleXMLElement(file_get_contents($file_data));
                  $video                = array();
                  # Get video title
                  $title_query          = $xml->xpath('/rss/channel/item/title');
                  $video['title']       = $title_query ? strval($title_query[0]) : '';
                  # Get video description
                  $description_query    = $xml->xpath('/rss/channel/item/media:content/media:description');
                  $video['description'] = $description_query ? strval($description_query[0]) : '';
                  # Get video tags
                  $tags_query           = $xml->xpath('/rss/channel/item/media:keywords');
                  $video['tags']        = $tags_query ? explode(',', strval(trim($tags_query[0]))) : null;
                  $video['tags']        = implode(', ', $video['tags']);
                  # Fet video duration
                  $duration_query       = $xml->xpath('/rss/channel/item/media:content/@duration');
                  $video['duration']    = $duration_query ? intval($duration_query[0]) : null;
                  # Get video publication date
                  $date_published_query = $xml->xpath('/rss/channel/item/pubDate');
                  $video['uploaded']    = $date_published_query ? ($date_published_query[0]) : null;
                  # Get video thumbnails
                  $thumbnails_query     = $xml->xpath('/rss/channel/item/media:thumbnail/@url');
                  $video['thumbnail']   = strval($thumbnails_query[0]);
                  return $video;
                  break;
              case 'vplay':
                  $video              = array();
                  $videoId            = $this->getVideoId("watch/");
                  $videoId            = str_replace("/", "", $videoId);
                  $pre                = substr($videoId, 0, 2);
                  $video['thumbnail'] = "http://i.vplay.ro/th/" . $pre . "/" . $videoId . "/0.jpg";
                  return $video;
                  break;
			
				   case 'redtube':
																$videoId            = $this->getVideoId(".com/");
																$json_url           = 'http://api.redtube.com/?data=redtube.Videos.getVideoById&video_id=' . $videoId . '&output=json&thumbsize=big';
																$content            = $this->getDataFromUrl($json_url);
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
																return $video;
																break;
												case 'pornhub':
																$html = $this->getDataFromUrl($this->link);
																preg_match('%<h1 class="section_title">(.+?)</h1>%i', $html, $tmatches);
																$video['title'] = $tmatches[1];
																preg_match('/<var class="duration">(.*)<\/var>/U', $html, $dmatches);
																$di                = $dmatches[1];
																$duration_arr      = explode(":", $di);
																$mincon            = preg_replace("/\D/", "", $duration_arr[0]);
																$seccon            = preg_replace("/\D/", "", $duration_arr[1]);
																$video['duration'] = $mincon * 60 + $seccon;
																$reg               = "/phncdn.com(.+).flv/";
																preg_match($reg, $html, $thumbmatches);
																$t = str_replace("%2F","/",$thumbmatches[0]);
																$t = str_replace("/videos/","",$t);
																$t = str_replace("phncdn.com","",$t);
																$t = str_replace(".flv","",$t);
																$x = explode("/",$t);
																$t='';
																$t = "/thumbs/".$x[0]."/".$x[1]."/".$x[2];
																$video['thumbnail'] = "http://cdn2.image.pornhub.phncdn.com" . $t."/small4.jpg";
																return $video;
																break;
												case 'extremetube':
																$html   = $this->getDataFromUrl($this->link);
																$dom    = new domDocument('1.0', 'utf-8');
																$finder = new DomXPath($dom);
																// load the html into the object ***/ 
																@$dom->loadHTML($html);
																//discard white space 
																$dom->preserveWhiteSpace = false;
																$hTwo                    = $dom->getElementsByTagName('h1'); // here u use your desired tag
																$video['title']          = $hTwo->item(1)->nodeValue;
																return $video;
																break;
												case 'slutload':
																$html = $this->getDataFromUrl($this->link);
																$dom  = new domDocument('1.0', 'utf-8');
																// load the html into the object ***/ 
																@$dom->loadHTML($html);
																//discard white space 
																$dom->preserveWhiteSpace = false;
																$hTwo                    = $dom->getElementsByTagName('h1');
																$video['title']          = $hTwo->item(1)->nodeValue;
																$pattern                 = '%<h2>(.+?)</h2>%i';
																preg_match($pattern, $html, $matches);
																$video['description'] = $matches[1];
																return $video;
																break;
												case 'xhamster':
																$videoId            = $this->getVideoId(".com/movies/", "/");
																//$html = $this->getDataFromUrl($this->link);
																$video['thumbnail'] = 'http://et0.xhamster.com/t/' . substr($videoId, -3) . '/5_b_' . $videoId . '.jpg';
																return $video;
																break;
												case 'tnaflix':
																$html = $this->getDataFromUrl($this->link);
																preg_match('/<meta property="og:image" content="(.*?)" \/>/', $html, $matches);
																$video['thumbnail'] = $matches[1];
																preg_match('/<meta property="og:title" content="(.*?)" \/>/', $html, $tmatches);
																$video['title'] = $tmatches[1];
																preg_match('/<meta property="og:description" content="(.*?)" \/>/', $html, $dmatches);
																$video['description'] = $dmatches[1];
																preg_match('/<meta name="keywords" content="(.*?)" \/>/', $html, $kmatches);
																$video['tags'] = $kmatches[1];
																return $video;
																break;
												case 'pornrabbit':
																$html = $this->getDataFromUrl($this->link);
																//$videoslug = $this->getVideoId(".com/video/");
																preg_match('/<meta name="description" content="(.*?)" \/>/', $html, $dmatches);
																$video['description'] = $dmatches[1];
																preg_match('/<meta name="keywords" content="(.*?)" \/>/', $html, $kmatches);
																$video['tags'] = $kmatches[1];
																preg_match('%<h1>(.+?)</h1>%i', $html, $tmatches);
																$video['title'] = $tmatches[1];
																return $video;
																break;
												case 'keezmovies':
																$html = $this->getDataFromUrl($this->link);
																preg_match('/<meta name="description" content="(.*?)" \/>/', $html, $dmatches);
																$video['description'] = str_replace("on Keezmovies.com. Enjoy free porn videos on this porno tube updated daily!", "", $dmatches[1]);
																preg_match('/<meta name="keywords" content="(.*?)" \/>/', $html, $kmatches);
																$video['tags'] = $kmatches[1];
																preg_match('%<h1 class="title-video-page" style="font-size: 11pt; text-align: center; font-family: arial, helvetica, sans-serif; color: #222;">(.+?)</h1>%i', $html, $tmatches);
																$video['title'] = $tmatches[1];
																return $video;
																break;
												case 'tube8':
																//$videoslug = $this->getVideoId(".com/");
																$html = $this->getDataFromUrl($this->link);
																preg_match("/<title>(.*)<\/title>/siU", $html, $tmatches);
																$tmp_title      = explode("-", $tmatches[1]);
																$video['title'] = $tmp_title[0];
																preg_match("/categories = (.*)searchq /siU", $html, $tagmatches);
																$vtags         = str_replace("categories = [", "", $tagmatches[0]);
																$vtags         = str_replace("searchq", "", $vtags);
																$vtags         = str_replace("]", "", $vtags);
																$vtags         = str_replace(";", "", $vtags);
																$vtags         = str_replace("\"", "", $vtags);
																$vtags         = strip_tags($vtags);
																$video['tags'] = trim($vtags);
																preg_match("/Duration:\s+(.+?)\s?$/m", $html, $dmatches);
																$di                = trim($dmatches[1]);
																$duration_arr      = explode(":", $di);
																$mincon            = preg_replace("/\D/", "", $duration_arr[0]);
																$seccon            = preg_replace("/\D/", "", $duration_arr[1]);
																$video['duration'] = $mincon * 60 + $seccon;
																return $video;
																break;
												case 'mofosex':
																$videoId = $this->getVideoId("videos/", "/");
																break;
												case 'drtuber':
																$videoId            = $this->getVideoId("video/", "/");
																$video['thumbnail'] = 'http://pics.drtuber.com/media/videos/tmb/' . $videoId . '/240_180/1.jpg';
																$html               = $this->getDataFromUrl($this->link);
																preg_match('%<h1 class="name">(.+?)</h1>%i', $html, $tmatches);
																$video['title'] = $tmatches[1];
																preg_match('%<p>Duration: <strong>(.+?)</strong></p>%i', $html, $dmatches);
																$di                = $dmatches[1];
																$duration_arr      = explode(":", $di);
																$mincon            = preg_replace("/\D/", "", $duration_arr[0]);
																$seccon            = preg_replace("/\D/", "", $duration_arr[1]);
																$video['duration'] = $mincon * 60 + $seccon;
																return $video;
																break;
												case 'spankwire':
																$html = $this->getDataFromUrl($this->link);
																preg_match('%<h1>(.+?)</h1>%i', $html, $tmatches);
																$video['title'] = $tmatches[1];
																preg_match('/<var class="duration">(.*)<\/var>/U', $html, $dmatches);
																$di                = $dmatches[1];
																$duration_arr      = explode(":", $di);
																$mincon            = preg_replace("/\D/", "", $duration_arr[0]);
																$seccon            = preg_replace("/\D/", "", $duration_arr[1]);
																$video['duration'] = $mincon * 60 + $seccon;
																$reg               = "/phncdn.com(.+).mp4/";
																preg_match($reg, $html, $thumbmatches);
																//var_dump($thumbmatches);
																$t = str_replace("%2F","/",$thumbmatches[0]);
																$t = str_replace("/videos/","",$t);
																$t = str_replace("phncdn.com","",$t);
																$t = str_replace(".flv","",$t);
																$x = explode("/",$t);
																//var_dump($x);
																$t='';
																$t = $x[1]."/".$x[2]."/".$x[3];
																$video['thumbnail'] = "http://cdn1.image.spankwire.phncdn.com/" . $t."/177X129/1.jpg";
																return $video;
																break;
												case 'youporn':
																$videoslug = $this->getVideoId(".com/watch/");
																$html      = $this->getDataFromUrl($this->link);
																preg_match('/<title>(.*) - Free/U', $html, $tmatches);
																$video['title'] = $tmatches[1];
																preg_match('/<div class="duration fontSize2">(.*)<\/div>/U', $html, $dmatches);
																$di                = $dmatches[1];
																$duration_arr      = explode(":", $di);
																$mincon            = preg_replace("/\D/", "", $duration_arr[0]);
																$seccon            = preg_replace("/\D/", "", $duration_arr[1]);
																$video['duration'] = $mincon * 60 + $seccon;
																$reg               = "/phncdn.com(.+)1.jpg/";
																preg_match($reg, $html, $thumbmatches);
																$video['thumbnail'] = "http://cdn1b.image.youporn." . $thumbmatches[0];
																return $video;
																break;
												case 'alotporn':
																$html = $this->getDataFromUrl($this->link);
																preg_match('/<meta property="og:image" content="(.*?)" \/>/', $html, $matches);
																$video['thumbnail'] = $matches[1];
																preg_match('/<meta property="og:title" content="(.*?)" \/>/', $html, $tmatches);
																$video['title'] = $tmatches[1];
																preg_match('/<meta property="og:description" content="(.*?)" \/>/', $html, $dmatches);
																$video['description'] = $dmatches[1];
																preg_match('/<meta name="keywords" content="(.*?)" \/>/', $html, $kmatches);
																$video['tags'] = $kmatches[1];
																preg_match('/<span class="duration">(.*)<\/span>/U', $html, $dmatches);
																$di                = $dmatches[1];
																$duration_arr      = explode(":", $di);
																$mincon            = preg_replace("/\D/", "", $duration_arr[0]);
																$seccon            = preg_replace("/\D/", "", $duration_arr[1]);
																$video['duration'] = $mincon * 60 + $seccon;
																return $video;
																break;
												case 'bigtits':
																$html = $this->getDataFromUrl($this->link);
																preg_match('/<meta property="og:image" content="(.*?)" \/>/', $html, $matches);
																$video['thumbnail'] = $matches[1];
																preg_match('/<meta property="og:title" content="(.*?)" \/>/', $html, $tmatches);
																$video['title'] = str_replace("- ( . Y . ) Big Tits&trade;", "", $tmatches[1]);
																return $video;
																break;
												case 'porntube':
																$html = $this->getDataFromUrl($this->link);
																if (preg_match("#'(/xml/index\?id=\d+\S+)'#", $html, $prelink))
																				$xlink = 'http://www.porntube.com' . $prelink[1];
																$data = $this->getDataFromUrl($xlink);
																preg_match_all("(\<image\>(.+)\<\/image\>)U", $data, $matches);
																$garbage            = array(
																				'<image>',
																				'</image>'
																);
																$video['thumbnail'] = str_replace($garbage, "", $matches[0][0]);
																preg_match_all("(\<duration\>(.+)\<\/duration\>)U", $data, $dmatches);
																$garbage           = array(
																				'<duration>',
																				'</duration>'
																);
																$video['duration'] = str_replace($garbage, "", $dmatches[0][0]);
																$data              = '';
																return $video;
																break;
																//	unset $html
																$html = '';	  
																
		  }
      }
	   // Get redtube token 
      private function red_key() {
	  return $this->get_new_key();	 
	  }
	
	  private function get_new_key() {
	  global $video;
	  $bypass = $this->red_fetch("http://www.redtube.com/contact");
	   preg_match('#<source src="(.*)" type=\\"video/mp4\\">#',$this->red_fetch($video->source), $key_search);
	  $bypass = '';
	  if(isset($key_search[1]) && !empty($key_search[1])) {
	   $pieces = explode("mp4?", $key_search[1]);
       return $pieces[1];
  }
	  }
	  public static function get_mp4($url) {
	  global $video;
	  $bypass = Vibe_Providers::red_fetch("http://www.redtube.com/contact");
	   preg_match('#<source src="(.*)" type=\\"video/mp4\\">#',Vibe_Providers::red_fetch($url), $key_search);
	  $bypass = '';
	  if(isset($key_search[1]) && !empty($key_search[1])) {
	   $pieces = explode("mp4?", $key_search[1]);
       return $pieces[0];
  }
	  }
	  
	   public static function red_fetch($url = null, $stream = false) {
        $handle = fopen($url, 'r');
        $buffer = null;
        if ($handle) {
            if ($stream) {
                while (!feof($handle)) {
                    echo fgets($handle, 4096);
                }
            } else {
                while (!feof($handle)) {
                    $buffer .= fgets($handle, 4096);
                }
            }
            fclose($handle);
        }
        return $buffer;
    
	  }
      function getDataFromUrl($url)
      {
          $ch      = curl_init();
          $timeout = 15;
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
          $data = curl_exec($ch);
          curl_close($ch);
          return $data;
      }
  }
?>