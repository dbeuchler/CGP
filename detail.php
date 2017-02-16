<?php

require_once 'conf/common.inc.php';
require_once 'inc/functions.inc.php';
require_once 'inc/html.inc.php';
require_once 'inc/collectd.inc.php';

header("Content-Type: text/html");

# use width/height from config if nothing is given
if (empty($_GET['x']))
	$_GET['x'] = $CONFIG['detail-width'];
if (empty($_GET['y']))
	$_GET['y'] = $CONFIG['detail-height'];

# set graph_type to canvas if hybrid
if ($CONFIG['graph_type'] == 'hybrid')
	$CONFIG['graph_type'] = 'canvas';

$host = GET('h');
$plugin = GET('p');
$pinstance = GET('pi');
$category = GET('c');
$type = GET('t');
$tinstance = GET('ti');
$seconds = GET('s');

$selected_plugins = !$plugin ? $CONFIG['overview'] : array($plugin);

html_start($host, $selected_plugins);


		echo <<<EOT
<input type="checkbox" id="navicon" class="navicon" />
<label for="navicon"></label>

EOT;

if (!$plugins = collectd_plugins($host)) {
	echo "Unknown host\n";
	return false;
}


echo '<div class="graphs">';
plugin_header($host, $plugin);

$args = GET();
print '<div class="time-range btn-group" role="group">' . "\n";
foreach($CONFIG['term'] as $key => $s) {
	$args['s'] = $s;
	if ($seconds == $s) {
		$selected = 'active';
	}
	else {
		$selected = '';
	}

	printf('<a class="btn btn-default %s" href="%s%s">%s</a>'."\n",
		$selected,
		htmlentities($CONFIG['weburl']),
		htmlentities(build_url('detail.php', $args)),
		htmlentities($key));
}
print "<br /><br />\n";

if ($CONFIG['graph_type'] == 'canvas') {
	chdir($CONFIG['webdir']);
	include $CONFIG['webdir'].'/graph.php';
} else {
	printf("<img src=\"%s%s\">\n",
		htmlentities($CONFIG['weburl']),
		htmlentities(build_url('graph.php', GET()))
	);
}
echo '</div>';
echo "</fieldset>\n";

html_end();