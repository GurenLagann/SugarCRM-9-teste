<?php

$manifest = array (
	'key' => 201900619180255,
	'name' => 'job_niver_conta',
	'author' => 'wallace',
	'version' => '4.0',
	'is_uninstallable' => true,
	'published_date' => '19/06/2019 18:02:55',
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
	'id' => 'pck_201900619180255',
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
