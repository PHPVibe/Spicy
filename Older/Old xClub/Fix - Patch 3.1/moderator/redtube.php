<?php $importer = array_merge($_GET, $_POST);
require_once( ADM.'/redtube.class.php' );
$Vibe = new RedVibe();
function ToSec($time) {
        $t = explode(':', $time);
		if ( count($t) > 2) { 
		return $t[0] * 3600 + $t[1] * 60 + $t[2];
		}else {		
        return $t[0] * 60 + $t[1];
		}
}

//var_dump($importer);
$nb_display = 24;
$startIndex = $nb_display * this_page() - $nb_display + 1;
if (isset($importer['action'])) {
if (isset($importer['owner'])) { $own = $importer['owner']; } else { $own = user_id();}
if (isset($importer['nsfw'])) { $nsfw = $importer['nsfw']; } else { $nsfw = 1;}	
if(!isset($importer['mp4']) || empty($importer['mp4'])) { $importer['mp4'] = '0' ; }
if($importer['action'] == "search") {
//Import by search
if(!isset($importer['key']) || empty($importer['key'])) { $importer['key'] = '' ; }
$videos = $Vibe->RedSearch($importer['key'],this_page()); 
$pagi_url = admin_url("redtube").'&action=search&key='.$importer['key'].'&categ='.$importer['categ'];
$pagi_url .= '&owner='.$own.'&mp4='.$importer['mp4'].'&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';


} elseif($importer['action'] == "tags") {
// import by tag
if(!isset($importer['tags']) || empty($importer['tags'])) { $importer['tags'] = '' ; }
$videos = $Vibe->RedTags($importer['tags'],this_page()); 
$pagi_url = admin_url("redtube").'&action=tags&tags='.$importer['tags'].'&categ='.$importer['categ'];
$pagi_url .= '&mp4='.$importer['mp4'].'&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';

}elseif($importer['action'] == "pornstar") {
//import by pornstar
if(!isset($importer['pornstar']) || empty($importer['pornstar'])) { $importer['pornstar'] = '' ; }
$videos = $Vibe->RedStar($importer['pornstar'],this_page()); 
$pagi_url = admin_url("redtube").'&action=pornstar&pornstar='.$importer['pornstar'].'&categ='.$importer['categ'];
$pagi_url .= '&mp4='.$importer['mp4'].'&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';

}elseif($importer['action'] == "category") {
//import by category
if(!isset($importer['redchannel']) || empty($importer['redchannel'])) { $importer['redchannel'] = '' ; }
$videos = $Vibe->RedCategory($importer['redchannel'],this_page()); 
$pagi_url = admin_url("redtube").'&action=category&redchannel='.$importer['redchannel'].'&categ='.$importer['categ'];
$pagi_url .= '&mp4='.$importer['mp4'].'&auto='.$importer['auto'].'&allowduplicates='.$importer['allowduplicates'].'&sleeppush='.$importer['sleeppush'].'&sleepvideos='.$importer['sleepvideos'].'&endpage='.$importer['endpage'].'&p=';

} else {
echo 'Missing action/section. Click back and try again.';
}

// Do the import
if(isset($videos) && (count($videos > 0))) {
$a = new pagination;	
$a->set_current(this_page());
$a->set_first_page(true);
$a->set_pages_items(12);
$a->set_per_page($nb_display);
$a->set_values($importer['endpage'] * $nb_display);
$a->show_pages($pagi_url);
?>

<div class="table-overflow top10">
                        <table class="table table-bordered table-checks">
                          <thead>
                                <tr>                                 
                                  <th width="130px"><?php echo _lang("Thumb"); ?></th>								 
                                  <th><?php echo _lang("Video"); ?></th>
								  <th>Duration</th>
                                  <th>Tags</th>									   
							      <th>Status</th>							  
                                 
								</tr>
                          </thead>
                          <tbody>
						  <?php 
						  $nbTotal = count($videos);
						  if(isset($videos['videos']) && !nullval($videos['videos'])) {
						  foreach ($videos['videos'] as $video) {
		                     if(!is_null($video)){ 
/* thumb swipe if not available */							 
 if(!empty($video['video']['thumbs']['6']['src'])) {
$thumb = $video['video']['thumbs']['6']['src'];
} elseif(!empty($video['video']['thumbs']['1']['src'])) {
$video['video']['thumbs']['1']['src'];
}else {
$thumb = $video['video']['default_thumb'];
}
$thumb = 'http:'.$thumb;
/* duration to sec converting */
$duration = ToSec($video['video']['duration']);
/* format tags */
$xtags = '';
if(isset($video['video']['tags']) && !is_null($video['video']['tags'])){
		foreach ($video['video']['tags'] as $tag) {
	    $xtags .= toDb($tag['tag_name']).", ";
		}
}	

/*Redtube has no description but edit below*/
$description = ucfirst($video['video']['title']). '  '.	$xtags. ' '.$video['video']['title'];
/* Get remote */
$remote = '';
			 
							 ?>
                              <tr>
                                 
                                  <td><img src="<?php echo $thumb; ?>" style="width:130px; height:90px;"></td>
                                  <td><?php echo _html(ucfirst($video['video']['title'])); ?></td>
								   <td><?php echo $video['video']['duration']; ?></td>
                                  <td>
								    <?php echo $xtags; ?>
								  </td>
								  <td>
								<?php 
								$remote = '';
								if($importer['allowduplicates'] > 0) {
								
 echo '<span class="greenText">Imported</span>';
								  //Insert it
$db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` , `liked` , `category`, `description`, `nsfw`, `remote`, `views`) VALUES ('".intval(get_option('videos-initial'))."','".$video['video']['url']."', '".$own."', now() , '".$thumb."', '".toDb($video['video']['title']) ."', '".intval($duration)."', '".$xtags."', '0','".intval($importer['categ'])."','".toDb($description)."','".$nsfw."','".toDb($remote)."','1')");	
								} else {
								$check = $db->get_row("SELECT count(*) as dup from ".DB_PREFIX."videos where source ='".toDb($video['video']['url'])."'");
								
                                   if($check->dup > 0) {
								    echo '<span class="redText">Skipped as duplicate</span>';
								   } else {							   
 echo '<span class="greenText">Imported</span>';									
									//Insert it 
 $db->query("INSERT INTO ".DB_PREFIX."videos (`pub`,`source`, `user_id`, `date`, `thumb`, `title`, `duration`, `tags` ,  `liked` , `category`, `description`, `nsfw`, `remote`, `views`) VALUES  ('".intval(get_option('videos-initial'))."','".$video['video']['url']."', '".$own."', now() , '".$thumb."', '".toDb($video['video']['title']) ."', '".intval($duration)."', '".$xtags."', '0','".intval($importer['categ'])."','".toDb($description)."','".$nsfw."','".toDb($remote)."','1')");  }

                                  } ?>
								  </td>
								  
                              </tr>
							  <?php 
							if($importer['sleepvideos'] > 0) {   sleep($importer['sleepvideos']); }
							  } 
}
} else {
echo '<div class="msg-warning">Redtube returned no video for this.</div>';	
}
							  //end loop 
							  ?>
						</tbody>  
</table>
</div>						
<?php
$next = this_page() + 1;
if(($importer['auto'] > 0) && ($nbTotal > 0) && ($next < $importer['endpage'])) {
echo 'Redirecting to '.$next;
echo '
<script type="text/javascript">
setTimeout(function() {
  window.location.href = "'.$pagi_url.$next.'";
}, '.$importer['sleeppush'].');

</script>
';
}

$a->show_pages($pagi_url);
} else { echo '<div class="msg-info">No (more) videos found</div>'; }

 //end if data
//end actions
//render forms
} else {
$users = $db->get_results("SELECT id, name FROM  ".DB_PREFIX."users where id <> '".user_id()."' order by id asc limit 0,200");

$cats = cats_select("categ","select","");
?>

<h2 class=""> Redtube importer</h2>

<ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#search">Search</a></li>
  <li><a href="#tags">Tag Import</a></li>
  <li><a href="#category">Category Import</a></li>
</ul>

<div class="tab-content" style="min-height:900px">
  <div class="tab-pane active" id="search">
  <div class="row-fluid">
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('redtube');?>" enctype="multipart/form-data" method="post">
<i>Used for importing video by keyword search. </i>
<input type="hidden" name="action" class="hide" value="search"> 
<div class="control-group">
<label class="control-label"><i class="icon-search"></i>Keyword</label>
<div class="controls">
<input type="text" name="key" class=" span8" value=""> 						
</div>	
</div>
<?php
echo '<div class="control-group">
	<label class="control-label">'._lang("Category:").'</label>
	<div class="controls">
	<select data-placeholder="'._lang("Choose a category:").'" name="categ" id="clear-results" class="select validate[required]" tabindex="2">
	';
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	
echo'<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option>';
	}
}	else {
echo'<option value="">'._lang("No categories").'</option>';
}
echo '</select>
	  </div>             
	  </div>';
?>	 
 
	<div class="control-group">
	<label class="control-label">Add to owner</label>
	<div class="controls">
	<?php
	echo '<select data-placeholder="'._lang("Choose owner:").'" name="owner" id="clear-results" class="select validate[required]" tabindex="2"> 	';
    echo'<option value="'.user_id().'" selected>'.user_name().'</option>';
    if($users) {
    foreach ($users as $cat) {	echo'<option value="'.intval($cat->id).'">'._html($cat->name).'</option>'; 	}
    }
    echo '</select>'; 	
	?>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">NSFW?</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="nsfw" class="styled" value="1" checked> YES </label>
	<label class="radio inline"><input type="radio" name="nsfw" class="styled" value="0">NO</label>
	</div>
	</div>	
	<div class="control-group">
	<label class="control-label">Autopush</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
	</div>
	</div>	
	<div class="control-group">
	<label class="control-label">Allow duplicates</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
	<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>				
		
	</div>
	</div>	
<div class="control-group">
	<label class="control-label">Advanced settings</label>
	<div class="controls">
<div class="row-fluid">
	<div class="span4">
		<input class="span12" name="sleeppush" type="text" value="2"><span class="help-block">Seconds to sleep before push </span>
	</div>
	<div class="span4">
		<input class="span12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
	</div>
	<div class="span4">
		<input class="span12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push (Youtube returns </span>
	</div>
</div>
	</div>
	</div>		
<div class="control-group">
<button type="submit" class="pull-right btn btn-success">Start import</button> 						

</div>	  
	</form>    
    </div>
   </div> 
<div class="tab-pane" id="tags">
  <div class="row-fluid">
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('redtube');?>" enctype="multipart/form-data" method="post">
<i>Used for importing video by Redtube tag. </i>
<input type="hidden" name="action" class="hide" value="tags"> 
<div class="control-group">
<label class="control-label"><i class="icon-tag"></i>Tags</label>

<div class="controls">
<?php
echo '<select data-placeholder="Redtube tags" name="tags" id="clear-results" class="select" tabindex="2">';
$tags = $Vibe->getAlltags(); 
if(isset($tags['tags']) && !nullval($tags)) {
foreach ($tags['tags'] as $tag) {
echo '<option value="'.$tag['tag']['tag_name'].'" />'.ucfirst($tag['tag']['tag_name']).' </option>';
		}
}	
?>
</select>						
</div>						
</div>	
<div class="control-group">
	<label class="control-label">Add to owner</label>
	<div class="controls">
	<?php
	echo '<select data-placeholder="'._lang("Choose owner:").'" name="owner" id="clear-results" class="select validate[required]" tabindex="2"> 	';
    echo'<option value="'.user_id().'" selected>'.user_name().'</option>';
    if($users) {
    foreach ($users as $cat) {	echo'<option value="'.intval($cat->id).'">'._html($cat->name).'</option>'; 	}
    }
    echo '</select>'; 	
	?>
	</div>
	</div>

<?php
echo '<div class="control-group">
	<label class="control-label">Store videos in:</label> 	<div class="controls"> 	'.$cats.'  </div> 
	<span class="help-block">Pick your category for this import. </span></div>';
?>	  
	<div class="control-group">
	<label class="control-label">NSFW?</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="nsfw" class="styled" value="1" checked> YES </label>
	<label class="radio inline"><input type="radio" name="nsfw" class="styled" value="0">NO</label>
	</div>
	</div>	
	<div class="control-group">
	<label class="control-label">Autopush</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
	</div>
	</div>	
	<div class="control-group">
	<label class="control-label">Allow duplicates</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
	<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>				
		
	</div>
	</div>	
<div class="control-group">
	<label class="control-label">Advanced settings</label>
	<div class="controls">
<div class="row-fluid">
	<div class="span4">
		<input class="span12" name="sleeppush" type="text" value="2"><span class="help-block">Seconds to sleep before push </span>
	</div>
	<div class="span4">
		<input class="span12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
	</div>
	<div class="span4">
		<input class="span12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push</span>
	</div>
</div>
	</div>
	</div>		
<div class="control-group">
<button type="submit" class="pull-right btn btn-success">Start import</button> 						

</div>	  
	</form>    
    </div>
   </div> 
 <div class="tab-pane" id="category">
  <div class="row-fluid">
<form class="form-horizontal styled" action="<?php echo admin_url('redtube');?>" enctype="multipart/form-data" method="post">
<i>Import videos from a specific Redtube category </i>
<input type="hidden" name="action" class="hide" value="category"> 
<div class="control-group">
<label class="control-label"><i class="icon-list"></i>Redtube category</label>
<div class="controls">
<?php
echo '<select data-placeholder="'._lang("Redtube category:").'" name="redchannel" id="clear-results" class="select validate[required]" tabindex="2">';
$redcats = $Vibe->getAllCats(); 
if(isset($redcats['categories']) && !nullval($redcats)) {
foreach ($redcats['categories'] as $redcat) {
echo '<option value="'.$redcat['category'].'" />'.ucfirst($redcat['category']).' </option>';
		}
}
?>
</select>						
</div>	
</div>
<?php
echo '<div class="control-group">
	<label class="control-label">'._lang("Category:").'</label>
	<div class="controls">
	<select data-placeholder="'._lang("Choose a category:").'" name="categ" id="clear-results" class="select validate[required]" tabindex="2">
	';
$categories = $db->get_results("SELECT cat_id as id, cat_name as name FROM  ".DB_PREFIX."channels order by cat_name asc limit 0,10000");
if($categories) {
foreach ($categories as $cat) {	
echo'<option value="'.intval($cat->id).'">'.stripslashes($cat->name).'</option>';
	}
}	else {
echo'<option value="">'._lang("No categories").'</option>';
}
echo '</select>
	  </div>             
	  </div>';
?>	 
<div class="control-group">
	<label class="control-label">Add to owner</label>
	<div class="controls">
	<?php
	echo '<select data-placeholder="'._lang("Choose owner:").'" name="owner" id="clear-results" class="select validate[required]" tabindex="2"> 	';
    echo'<option value="'.user_id().'" selected>'.user_name().'</option>';
    if($users) {
    foreach ($users as $cat) {	echo'<option value="'.intval($cat->id).'">'._html($cat->name).'</option>'; 	}
    }
    echo '</select>'; 	
	?>
	</div>
	</div>
	<div class="control-group">
	<label class="control-label">NSFW?</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="nsfw" class="styled" value="1" checked> YES </label>
	<label class="radio inline"><input type="radio" name="nsfw" class="styled" value="0">NO</label>
	</div>
	</div>	
	<div class="control-group">
	<label class="control-label">Autopush</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="auto" class="styled" value="0" checked>NO</label>
	</div>
	</div>	
		<div class="control-group">
	<label class="control-label">Allow duplicates</label>
	<div class="controls">
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="1"> YES </label>
	<label class="radio inline"><input type="radio" name="allowduplicates" class="styled" value="0" checked>NO</label>
	<span class="help-block">If set to NO it will search if video is already in the dabase and skip it. </span>				
		
	</div>
	</div>	
<div class="control-group">
	<label class="control-label">Advanced settings</label>
	<div class="controls">
<div class="row-fluid">
	<div class="span4">
		<input class="span12" name="sleeppush" type="text" value="3"><span class="help-block">Seconds to sleep before push </span>
	</div>
	<div class="span4">
		<input class="span12" name="sleepvideos" type="text" value="0"><span class="help-block k align-center">Seconds to sleep between videos import</span>
	</div>
	<div class="span4">
		<input class="span12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push  </span>
	</div>
</div>
	</div>
	</div>	
<div class="control-group">
<button type="submit" class="pull-right btn btn-success">Start import</button> 						

</div>	 
</form>
</div>
  </div>
</div>

<?php } ?>