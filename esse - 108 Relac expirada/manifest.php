<?php

$manifest = array
(
	'key' => '20180525153621',
	'name' => 'job_fase_relac_expirada',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array(
		'exact_matches' => array(),
		'regex_matches' => array('8\\..*$'),
	),
	'author' => 'Nectar Consulting',
	'description' => 'Altera fase de relacionamento para Expirada',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-05-25 15:36:21',
	'type' => 'module',
	'version' => '4.1',
);

$installdefs = array
(
	'id' => 'pck_20180525153621',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/job_fase_relac_expirada.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/job_fase_relac_expirada.php',
		),

		1 => array
		(
			'from' => '<basepath>/pt_BR.job_fase_relac_expirada.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.job_fase_relac_expirada.php',
		)
	),

	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);
