<?php

$manifest = array
(
	'key' => '20180620100717',
	'name' => 'job_expira_agendado',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array(
		'exact_matches' => array(),
		'regex_matches' => array('8\\..*$'),
	),
	'author' => 'Nectar Consulting',
	'description' => 'Expira acompanhamentos que tem fase agendada mas passaram da data',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-06-20 10:07:17',
	'type' => 'module',
	'version' => '4.1',
);

$installdefs = array
(
	'id' => 'pck_20180620100717',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/job_expira_agendado.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/job_expira_agendado.php',
		),

		1 => array
		(
			'from' => '<basepath>/pt_BR.job_expira_agendado.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.job_expira_agendado.php',
		)
	),

	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);

