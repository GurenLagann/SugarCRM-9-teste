<?php

$dt = new DateTime();

$manifest = array(
	'key' => 20190508130121,
	'name' => 'Mesa_Ops_rel_Tier',
	'author' => 'Giovanni',
	'version' => '1.0',
	'is_uninstallable' => true,
	'published_date' => $dt->format('Y-m-d H:i:s'),
	'type' => 'module',
	'acceptable_sugar_versions' => array(
	  'regex_matches' => array(
			'9.*', //any 9.0 release
			'10.*' //any 10.0 release
	  ),
	),
	'acceptable_sugar_flavors' => array('PRO','ENT','ULT'),
	'icon' => '',
	'remove_tables' => '',
	'uninstall_before_upgrade' => false,
	'readme' => 'Expira relacionamentos fora do prazo'
);

$installdefs = array(
	'id' => 'pck_20190508130121',
	'copy' => array(
		0 => array(
			'from' => '<basepath>/job_relacionamento_tier.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/job_relacionamento_tier.php',
		),
		1 => array(
			'from' => '<basepath>/pt_BR.job_relacionamento_tier.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.job_relacionamento_tier.php',
		)
	),
	'post_execute' => array(
		'<basepath>/post_install_actions.php'
	)
);
