<?php
$db['theme'] = array (
	'columns' => array (
	'main_id' => array (
			'type' => 'number',
			'required' => true,
			'extra' => 'auto_increment',
			'pkey' => true,
//			'searchtype' => 'has',
			'label' => app :: get('forum')->_('主题帖编号'),
		),
       'member_id' => array (
			'type' => 'number',
            'required' => true,
            'sdfpath' => 'members/member_id',
			'label' => app :: get('forum')->_('发帖人id'),
			'editable' => false,
//			'searchtype' => 'has',
			'comment' => app :: get('forum')->_('发帖人的id关联members表'),
			
		),
		
		//这里是标题
		'title' => array (
			'type' => 'varchar(1000)',
			'editable' => true,
			'label' => app :: get('forum')->_('主题帖标题'),
			'searchtype' => 'has',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
			 
		),
		'content' => array (
			'type' => 'html',
			'searchtype' => 'has',
			'editable' => false,
			'label' => app :: get('forum')->_('主题帖内容'),
			'filterdefault' => true,
			/*'in_list' => true,*/
			/*'default_in_list' => true,*/
			
		),
		'time' => array (
			'label' => app :: get('forum')->_('创建时间'),
			'width' => 75,
			'type' => 'time',
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'time',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
			'comment' => app :: get('forum')->_('创建时间'),
			
		),
			'type_id' => array (
			//'required' => true,
			'type' => 'int(8)',
			'label' => app :: get('forum')->_('类型'),
			'editable' => false,
			'filtertype' => 'normal',
			'comment' => app :: get('forum')->_('类型'),
		),
		 	'state' => array (
			'type' => 'int(1)',
            'required' => true,
            'default' => 0,
			'label' => app :: get('forum')->_('是否禁用'),
			'editable' => false,
//			'searchtype' => 'has',
			'filterdefault' => true,
			/*'in_list' => true,
			'default_in_list' => true,*/
		),
			'lnnum' => array (
			'type' => 'number',
            'required' => true,
            'default' => 0,
			'label' => app :: get('forum')->_('帖子浏览量'),
			'editable' => false, 
			'in_list' => true,
			'default_in_list' => true,
		),
		 /*	'scnum' => array (
			'type' => 'number',
            'required' => true,
			'label' => app :: get('forum')->_('帖子浏览量'),
			'editable' => false,
			'in_list' => true,
			'default_in_list' => true,
		),
		
			'plnum' => array (
			'type' => 'number',
            'required' => true,
			'label' => app :: get('forum')->_('评论数'),
			'editable' => false,
			'in_list' => true,
			'default_in_list' => true,
		), */
			'hot' => array (
			'type' => 'number',
            'required' => true,
            'default' => 0,
			'label' => app :: get('forum')->_('热帖'),
			'editable' => false,
//			'searchtype' => 'has',
			'filtertype' => 'time',
			'filterdefault' => true,
			/*'in_list' => true,
			'default_in_list' => true,*/
		),
		
	),
	'comment' => app :: get('forum')->_('论坛主题表'),
	'engine' => 'innodb',
	'version' => '$Rev:  $',

	
);