<?php

$manifest = array(
	'key' => '20200130LFTM',
	'name' => 'Logic Hooks - Opportunities',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array(
	'regex_matches' => array('9\\.[0-9]\\.[0-9]'),
	),
	'author' => 'Caio Fumiya',
	'description' => 'Calcula os campos da aba Câmbio',
	'icon' => '',
	'is_uninstallable' => true,
    'published_date' => '2020-01-30',
	'type' => 'module',
	'version' => '2.0',
);

$installdefs = array(
	'id' => 'LFTM-30012020',
	'hookdefs' => array(
		array(
			'from' => '<basepath>/hookopp.php',
			'to_module' => 'Opportunities',
		),
	),
	'copy' => array(
		0 => array(
			'from' => '<basepath>/hook_camb_opp.php',
			'to' => 'custom/Extension/modules/Opportunities/Ext/hook_camb_opp.php',
		),
	),

	
);


