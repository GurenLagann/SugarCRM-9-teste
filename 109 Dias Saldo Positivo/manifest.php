<?php

$manifest = array
(
	'key' => '20180803101917',
	'name' => 'dias_saldo_positivo',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array
	(
		'exact_matches' => array(),
		'regex_matches' => array('8\\..*$'),
	),
	'author' => 'Marcel',
	'description' => 'Contador de dias com saldo positivo',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-08-03 10:19:17',
	'type' => 'module',
	'version' => '1.5',
);

$installdefs = array
(
	'id' => 'pck_20180803101917',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/dias_saldo_positivo.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/dias_saldo_positivo.php',
		),

		1 => array
		(
			'from' => '<basepath>/pt_BR.dias_saldo_positivo.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.dias_saldo_positivo.php',
		)
	),

	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);
