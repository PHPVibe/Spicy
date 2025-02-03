<?php $importer = array_merge($_GET, $_POST);
require_once( ADM.'/redtube.class.php' );
$Vibe = new RedVibe();
$users = $db->get_results("SELECT id, name FROM  ".DB_PREFIX."users where id <> '".user_id()."' order by id asc limit 0,200");

?>

<h2 class=""> Redtube Stars importer</h2>

<ul class="nav nav-tabs" id="myTab">
    <li><a href="#user active">Pornstar Import</a></li>
</ul>

<div class="tab-content" style="min-height:900px">

 	  <div class="tab-pane active" id="user">
  <div class="row-fluid">
<form class="form-horizontal styled" action="<?php echo admin_url('redtube');?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="action" class="hide" value="pornstar"> 
<div class="control-group">
<label class="control-label"><i class="icon-user"></i>Pornstar</label>
<div class="controls">
<div class="control-group">
	<label class="control-label">Choose a pornstar</label>
	<div class="controls">
	<select id="Pstar" data-placeholder="Choose" name="pornstar" id="clear-results" class="select" tabindex="2">
	
<?php
/* $stars = $Vibe->getAllStars(); 
if(isset($stars['stars']) && !nullval($stars)) {
foreach ($stars['stars'] as $starlet) {
echo '<option class="styled" value="'.$starlet['star']['star_name'].'">'._html($starlet['star']['star_name']).'</label>';		
		}
		
		unset($stars);
		unset($starlet);
}
*/
	
?>	
</select>
	  </div>             
	  </div>					
</div>	
</div>
<script>
var sxurl = '<?php echo site_url().ADMINCP;?>/cache/stars.json';
$.getJSON(sxurl, function (data) {
	var result = data['stars'];
	
	//console.log(JSON.stringify(result));
$.each(result, function(key, value) {
    //display the key and value pair
   //console.log(value['star']['star_name']);
   $('#Pstar').append($('<option>', {
    value: value['star']['star_name'],
    text: value['star']['star_name']
}));
});
    });
</script>
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
		<input class="span12" name="endpage" type="text" value="25"><span class="help-block k align-right">Which page to end push </span>
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
