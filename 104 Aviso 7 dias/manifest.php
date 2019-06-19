<?php

$manifest = array
(
	'key' => '20180525153623',
	'name' => 'job_aviso_semana',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array(
		'exact_matches' => array(),
		'regex_matches' => array('8\\..*$'),
	),
	'author' => 'Nectar Consulting',
	'description' => 'Seta envio de alerta de uma semana',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-05-25 15:36:23',
	'type' => 'module',
	'version' => '4.1',
);

$installdefs = array
(
	'id' => 'pck_20180525153623',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/job_aviso_semana.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/job_aviso_semana.php',
		),

		1 => array
		(
			'from' => '<basepath>/pt_BR.job_aviso_semana.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.job_aviso_semana.php',
		)
	),

	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);
