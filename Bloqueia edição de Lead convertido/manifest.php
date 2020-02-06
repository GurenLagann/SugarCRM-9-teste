<?php

$manifest = array(
	'key' => '20200205LFTM',
	'name' => 'Logic Hooks - Bloqueia Leads Convertidos',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array(
	'regex_matches' => array('9\\.[0-9]\\.[0-9]'),
	),
	'author' => 'Caio Fumiya',
	'description' => 'Bloqueia a edição de Leads convertidos',
	'icon' => '',
	'is_uninstallable' => true,
    'published_date' => '2020-02-05',
	'type' => 'module',
	'version' => '1.0',
);

$installdefs = array(
	'id' => 'LFTM-05022020',
	'hookdefs' => array(
		array(
			'from' => '<basepath>/hooklead.php',
			'to_module' => 'Leads',
		),
	),
	'copy' => array(
		0 => array(
			'from' => '<basepath>/hook_lead.php',
			'to' => 'custom/Extension/modules/Leads/Ext/hook_lead.php',
		),
	),

	
);


