<?php

$manifest = array
(
	'key' => '20190528175600',
	'name' => 'job_niver_conta',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array(
		'exact_matches' => array(),
		'regex_matches' => array('9\\..*$'),
	),
	'author' => 'TI Lifetime',
	'description' => 'Verifica se aniversario de Cliente',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-07-05 11:24:00',
	'type' => 'module',
	'version' => '4.0',
);

$installdefs = array
(
	'id' => 'pck_20190528175600',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/job_niver_conta.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/job_niver_conta.php',
		),

		1 => array
		(
			'from' => '<basepath>/pt_BR.job_niver_conta.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.job_niver_conta.php',
		)
	),

	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);
