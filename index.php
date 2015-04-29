<?php

ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

chdir('..');

session_start();

header('Content-Type: text/plain');

include_once('clarus/_loader.php');

try {
	$app = clarus\Application::i();
	$app->addRouote(new \claruscms\BackendRouter());

	include_once('claruscms/_loader.php');

	$app->run();
	$app->display();
} catch (\Exception $e) {
	echo $e->getMessage()."\n\n";
	echo $e->getTraceAsString();
}