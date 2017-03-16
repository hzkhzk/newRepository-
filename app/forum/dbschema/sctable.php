<?php


/**
 * 用户_帖子收藏表
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */
$db['sctable'] = array (
	'columns' => array (
		'sctable_id' => array (
			'type' => 'int(8)',
			'required' => true,
			'pkey' => true,
			'label' => '会员收藏主题表id',
			'editable' => false,
			'extra' => 'auto_increment',
		),
		'member_id' => array (
			'type' => 'number',
			'required' => true,
			'label' => app :: get('forum')->_('会员id'),
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'normal',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
		),
		'theme_id' => array (
			'type' => 'number',
			'required' => true,
			'label' => app :: get('forum')->_('主题id'),
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
	'comment' => app :: get('forum')->_('会员收藏主题表'),
);