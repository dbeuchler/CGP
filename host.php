<?php

require_once 'conf/common.inc.php';
require_once 'inc/html.inc.php';
require_once 'inc/collectd.inc.php';

header("Content-Type: text/html");

$host = GET('h');
$plugin = GET('p');

$selected_plugins = !$plugin ? $CONFIG['overview'] : array($plugin);

html_start($host, $selected_plugins);

if (!strlen($host) || !$plugins = collectd_plugins($host)) {
	echo "Unknown host\n";
	return false;
}

foreach ($selected_plugins as $selected_plugin) {
	if (in_array($selected_plugin, $plugins)) {
		plugin_header($host, $selected_plugin);
		graphs_from_plugin($host, $selected_plugin, empty($plugin));
	}
}

html_end();
