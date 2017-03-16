<?php
$db['reply'] = array (
	'columns' => array (

		'reply_id' => array (
			'type' => 'int(8)',
			'required' => true,
			'pkey' => true,
			'label' => app :: get('forum')->_('回复编号'),
			'editable' => false,
			'extra' => 'auto_increment',
			
		),

		'content' => array (
			'type' => 'html',
			'required' => true,
			'label' => app :: get('forum')->_('回复内容'),
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'normal',
			'filterdefault' => true,
//			'in_list' => true,
//			'default_in_list' => true,
			
		),

		'time' => array (
			'label' => app :: get('forum')->_('回帖时间'),
			'width' => 75,
			'type' => 'time',
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'time',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
			'comment' => app :: get('forum')->_('回帖时间'),
			
		),
		'theme_id' => array (
			'type' => 'int(8)',
			'required' => true,
			'label' => app :: get('forum')->_('主题编号'),
			'editable' => false,
//			'searchtype' => 'has',
			'filtertype' => 'normal',
			
		),
		'members_id' => array (
			'type' => 'int(8)',
			'required' => true,
			'label' => app :: get('forum')->_('回复人编号'),
			'editable' => false,
			'filtertype' => 'normal',
 	 		'in_list' => true,
		),
/*		'title' => array (
			'type' => 'varchar(1000)',
			'editable' => true,
			'label' => app :: get('forum')->_('主题帖标题'),
			'searchtype' => 'has',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
			
		),*/
		
	),
	'comment' => app :: get('forum')->_('论坛回复表'),
	'engine' => 'innodb',
	'version' => '$Rev:  $',

	
);