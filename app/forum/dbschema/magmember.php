<?php


/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */

$db['magmember'] = array (
	'columns' => array (
		'magmember_id' => array (
			'type' => 'int(8)',
			'required' => true,
			'pkey' => true,
			'label' => 'id',
			'editable' => false,
			'extra' => 'auto_increment',
			'comment' => app :: get('forum')->_('绑定theme表'),
		),
		'greymember_id' => array (
			'type' => 'int(8)',
			'required' => true,
			'label' => app :: get('forum')->_('违规会员编号'),
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'normal',
			'filterdefault' => true,
			'in_list' => true,
			//'default_in_list' => true,
			
		),
		'greyreason' => array (
			'type' => 'varchar(255)',
			'required' => false,
			'label' => app :: get('forum')->_('违规原因'),
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
	'comment' => app :: get('forum')->_('违规会员表'),

	
);