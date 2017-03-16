<?php


/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */
$db['mgword'] = array (
	'columns' => array (
		'mgword_id' => array (
			'type' => 'int(8)',
			'required' => true,
			'pkey' => true,
			'label' => '违规词汇id',
			'editable' => false,
			'extra' => 'auto_increment',
		),
		'mgword' => array (
			'type' => 'varchar(64)',
			'required' => true,
			'label' => app :: get('forum')->_('敏感词汇'),
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'normal',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
		),
	),
	'engine' => 'innodb',
	'version' => '$Rev:  $',
	'comment' => app :: get('forum')->_('违规词汇表'),
);