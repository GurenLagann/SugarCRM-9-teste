<?php

$manifest = array (
	'key' => 20190621121603,
	'name' => 'job_cancela_reuniao',
	'author' => 'wallace Lifetime TI',
	'version' => '4.0',
	'is_uninstallable' => true,
	'published_date' => '21/06/2019 121603',
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
	'id' => 'pck_20190621121603',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/job_cancela_reuniao.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/job_cancela_reuniao.php',
		),

		1 => array
		(
			'from' => '<basepath>/pt_BR.job_cancela_reuniao.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.job_cancela_reuniao.php',
		)
	),

	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);

