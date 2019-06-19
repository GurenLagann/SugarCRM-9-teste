<?php

$manifest = array
(
	'key' => '20180712180517',
	'name' => 'job_cancela_chamada',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array(
		'exact_matches' => array(),
		'regex_matches' => array('8\\..*$'),
	),
	'author' => 'Nectar Consulting',
	'description' => 'Expira chamadas que tem fase agendada mas passaram de um mes',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-07-12 18:05:17',
	'type' => 'module',
	'version' => '4.2',
);

$installdefs = array
(
	'id' => 'pck_20180712180517',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/job_cancela_chamada.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/job_cancela_chamada.php',
		),

		1 => array
		(
			'from' => '<basepath>/pt_BR.job_cancela_chamada.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.job_cancela_chamada.php',
		)
	),

	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);

