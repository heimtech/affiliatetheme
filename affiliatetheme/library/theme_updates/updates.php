<?php
//Initialize the update checker.
$example_update_checker = new ThemeUpdateChecker(
	'affiliatetheme',                                            //Theme folder name, AKA "slug". 
	'http://affiliseo.de/theme-updates/info.json' //URL of the metadata file.
);

