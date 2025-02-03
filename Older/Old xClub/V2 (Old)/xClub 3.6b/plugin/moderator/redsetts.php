<?php $key_check = get_option('redtube_key');
if(false === $key_check ) {
add_option('redtube_key', '');
add_option('redkey_lastrun', '0');
add_option('redkey_checkperiod', '3600');
}

if(isset($_POST['update_options_now'])){
foreach($_POST as $key=>$value)
{
if($key !== "site-logo") {
  update_option($key, toDb($value));
}
}
  echo '<div class="msg-info">Configuration options have been updated.</div>';
  $db->clean_cache();
}

$all_options = get_all_options();
?>

<div class="row-fluid">
<h3>Redtube Configuration</h3>
<form id="validate" class="form-horizontal styled" action="<?php echo admin_url('redsetts');?>" enctype="multipart/form-data" method="post">
<fieldset>
<input type="hidden" name="update_options_now" class="hide" value="1" /> 
<div class="control-group">
<label class="control-label"><i class="icon-pencil"></i>Hash grab interval</label>
<div class="controls">
<input type="text" name="redkey_checkperiod" class="span12" value="<?php echo get_option('redkey_checkperiod'); ?>" /> 						
<span class="help-block" id="limit-text">Interval in seconds to scrape Redtube for a new access hash!</span>
</div>	
</div>	
<div class="control-group">
<label class="control-label"><i class="icon-pencil"></i>Hash grab lastrun</label>
<div class="controls">
<input type="text" name="redkey_lastrun" class="span12" value="<?php echo get_option('redkey_lastrun'); ?>" /> 						
<span class="help-block" id="limit-text"> That's <?php echo strtotime(get_option('redkey_lastrun'))?> | Last run (as php time) for the hash grabber! </span>
</div>	
</div>
<div class="control-group">
<label class="control-label"><i class="icon-pencil"></i>Current Hash</label>
<div class="controls">
<input type="text" name="redtube_key" class="span12" value="<?php echo get_option('redtube_key'); ?>" /> 						
<span class="help-block" id="limit-text">Pulled automatically from redtube in order to bypass their security. Do not edit if not necesary!</span>
</div>	
</div>
<div class="control-group">
<button class="btn btn-large btn-primary pull-right" type="submit"><?php echo _lang("Update settings"); ?></button>	
</div>	
</fieldset>						
</form>
</div>