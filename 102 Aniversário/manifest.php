<?php

$manifest = array
(
	'key' => '20180614161437',
	'name' => 'job_aniversario',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array(
		'exact_matches' => array(),
		'regex_matches' => array('8\\..*$'),
	),
	'author' => 'Nectar Consulting',
	'description' => 'Verifica se aniversario de Cliente',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-06-14 16:14:37',
	'type' => 'module',
	'version' => '4.0',
);

$installdefs = array
(
	'id' => 'pck_20180614161437',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/job_aniversario.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/job_aniversario.php',
		),

		1 => array
		(
			'from' => '<basepath>/pt_BR.job_aniversario.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.job_aniversario.php',
		)
	),

	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);
