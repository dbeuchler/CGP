<?php

require_once 'conf/common.inc.php';
require_once 'inc/functions.inc.php';
require_once 'inc/html.inc.php';
require_once 'inc/collectd.inc.php';

# use width/height from config if nothing is given
if (empty($_GET['x']))
	$_GET['x'] = $CONFIG['detail-width'];
if (empty($_GET['y']))
	$_GET['y'] = $CONFIG['detail-height'];

# set graph_type to canvas if hybrid
if ($CONFIG['graph_type'] == 'hybrid')
	$CONFIG['graph_type'] = 'canvas';

$host = validate_get(GET('h'), 'host');
$plugin = validate_get(GET('p'), 'plugin');
$pinstance = validate_get(GET('pi'), 'pinstance');
$category = validate_get(GET('c'), 'category');
$type = validate_get(GET('t'), 'type');
$tinstance = validate_get(GET('ti'), 'tinstance');
$seconds = GET('s');

$selected_plugins = !$plugin ? $CONFIG['overview'] : array($plugin);

$plugins = collectd_plugins($host);

html_start($host, $selected_plugins);

if(!$plugins) {
	echo "Unknown host\n";
	return false;
}


plugin_header($host, $plugin);

$args = $_GET;
print '<ul class="time-range btn-group">' . "\n";
foreach($CONFIG['term'] as $key => $s) {
	$args['s'] = $s;
	$selected = selected_timerange($seconds, $s);
	printf('<li class="btn btn-default"><a %s href="%s%s">%s</a></li>'."\n",
		$selected, $CONFIG['weburl'], build_url('detail.php', $args), $key);
}
print "</ul><br />\n";

if ($CONFIG['graph_type'] == 'canvas') {
	chdir($CONFIG['webdir']);
	include $CONFIG['webdir'].'/plugin/'.$plugin.'.php';
} else {
	printf('<img src="%s%s">'."\n", $CONFIG['weburl'], build_url('graph.php', $_GET));
}
echo '</div>';

html_end();

?>
