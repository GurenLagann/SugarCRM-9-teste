<?php

$manifest = array
(
	'key' => '20180824092217',
	'name' => 'lftm_it_atualiza_net',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array(
		'exact_matches' => array(),
		'regex_matches' => array('8\\..*$'),
	),
	'author' => 'Lifetime TI',
	'description' => 'Atualiza o NET e o perfil',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-08-24 09:22:17',
	'type' => 'module',
	'version' => '5.0',
);

$installdefs = array
(
	'id' => 'pck_20180824092217',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'copy' => array
	(
		0 => array
		(
			'from' => '<basepath>/lftm_it_atualiza_net.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/lftm_it_atualiza_net.php',
		),

		1 => array
		(
			'from' => '<basepath>/pt_BR.lftm_it_atualiza_net.php',
			'to' => 'custom/Extension/modules/Schedulers/Ext/Language/pt_BR.lftm_it_atualiza_net.php',
		)
	),

	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);
?>