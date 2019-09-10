<?php

$dt = new DateTime();
$manifest = array(
	'key' => 2019091074505,
	'name' => 'job_niver_conta',
	'acceptable_sugar_flavors' => array('PRO', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array('regex_matches' => array('9.*', '10.*')),
	'author' => 'Lifetime TI',
	'description' => 'Aniversario da Conta',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => $dt->format('Y-m-d H:i:s'),
	'type' => 'module',
	'version' => '5.1',
);

$installdefs = array(
	'id' => 'pck_2019091074505',
	'copy' => array(
		0 => 
			array(
				'from' => '<basepath>/job_niver_conta.php',
				'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/job_niver_conta.php',
			),

		1 => 
			array(
				'from' => '<basepath>/pt_BR.job_niver_conta.php',
				'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.job_niver_conta.php',
			)
	),
	'post_execute' => array(
		'<basepath>/post_install_actions.php'
	)
);



