<?php

$manifest = array(
	'key' => 20190708130240,
	'name' => 'dias_saldo_positivo',
	'author' => 'wallace',
	'version' => '4.0',
	'is_uninstallable' => true,
	'published_date' => '08/07/2019 13:02:40',
	'type' => 'module',
	'acceptable_sugar_versions' => array(
		'exact_matches' => array(
			'9.0.0'
		),
		//or
		'regex_matches' => array(
			'9.*' //any 9.0 release
		),
	),
	'acceptable_sugar_flavors' => array(
		'PRO',
		'ENT',
		'ULT'
	),
	'readme' => '',
	'icon' => '',
	'remove_tables' => '',
	'uninstall_before_upgrade' => false,
);

$installdefs = array
(
	'id' => 'pck_20190708130240',
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
