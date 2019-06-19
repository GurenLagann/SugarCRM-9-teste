<?php

$manifest = array
(
	'key' => '20180706093522',
	'name' => 'opp_aderida',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array
	(
		'exact_matches' => array(),
		'regex_matches' => array('8\\..*$'),
	),
	'author' => 'Marcel',
	'description' => 'Atualiza Oportunidade Aderida em Clientes',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-07-06 09:35:22',
	'type' => 'module',
	'version' => 'vFINAL',
);

$installdefs = array
(
	'id' => 'pck_20180706093522',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'logic_hooks' => array
	(
		array
		(
			'module' => 'Opportunities',
			'hook' => 'before_save',
			'order' => 97,
			'description' => 'Atualiza Oportunidade Aderida em Clientes',
			'file' => 'custom/modules/Opportunities/opp_aderida.php',
			'class' => 'before_save_class',
			'function' => 'before_save'
		),
	),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/opp_aderida.php',
			'to' => 'custom/modules/Opportunities/opp_aderida.php'
		),
	),
	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);


