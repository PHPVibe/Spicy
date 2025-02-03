<?php function reds($txt) {
$txt .= '<a class="accordion-toggle" href="'.admin_url("redtube").'"><i class="icon-exclamation-sign"></i><span>Redtube Importer</span></a>';
return $txt;
}
function redc($txt) {
$txt .= '<a class="accordion-toggle" href="'.admin_url("redsetts").'"><i class="icon-exclamation-sign"></i><span>Redtube Settings</span></a>';
return $txt;
}
add_filter('importers_menu', 'reds');
add_filter('configuration_menu', 'redc');
?>