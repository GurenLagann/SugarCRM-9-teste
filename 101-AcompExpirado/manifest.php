<?php

$manifest = array
(
	'key' => '20180525153622',
	'name' => 'job_fase_acomp_expirado',
	'acceptable_sugar_flavors' => array('PRO', 'CORP', 'ENT', 'ULT'),
	'acceptable_sugar_versions' => array(
		'exact_matches' => array(),
		'regex_matches' => array('9*'),
	),
	'author' => 'Nectar Consulting',
	'description' => 'Altera fase de acompanhamento para Expirada',
	'icon' => '',
	'is_uninstallable' => true,
	'published_date' => '2018-05-25 15:36:22',
	'type' => 'module',
	'version' => '4.1',
);

$installdefs['copy'] = array
(
	'id' => 'pck_20180525153622',
	'beans' => array(),
	'layoutdefs' => array(),
	'relationships' => array(),
	'scheduledefs' => array
	(
		array
		(
			'from' => '<basepath>/job_fase_acomp_expirado.php',
		),

		'language' => array
		(
			'from' => '<basepath>/pt_BR.job_fase_acomp_expirado.php',
			'to_module' => 'Schedulers',
			'language' => 'pt_BR'
		)
	),

	'post_execute' => array
	(
		'<basepath>/post_install_actions.php'
	)
);
