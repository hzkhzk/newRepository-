<?php


/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */

$db['themetype'] = array (
	'columns' => array (
		'type_id' => array (
			'type' => 'int(8)',
			'required' => true,
			'pkey' => true,
			'label' => 'id',
			'editable' => false,
			'extra' => 'auto_increment',
			'comment' => app :: get('forum')->_('绑定theme表'),
		),
		'typename' => array (
			'type' => 'varchar(255)',
			'required' => true,
			'label' => app :: get('forum')->_('主题类型'),
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'normal',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
			'is_title' => true,

			
		),
		


	/*
		 'test103_id' => array (
			'required' => true,
			'type' => 'int(8)',
			'label' => app :: get('forum')->_('test103id'),
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'normal',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
			'is_title' => true,
			'comment' => app :: get('forum')->_('test03id'),

			
		),
		*/
	),
	'engine' => 'innodb',
	'version' => '$Rev:  $',
	'comment' => app :: get('forum')->_('主题类型表'),

	
);