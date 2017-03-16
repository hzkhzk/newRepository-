<?php
$db['item']=
    array (
       'columns' =>
       array (
          'item_id' =>
          array (
             'type' => 'number',
             'required' => true,
             'extra' => 'auto_increment',
             'pkey' => true,
             ),
          'item_subject' =>
          array (
             'type' => 'varchar(100)',
             'in_list'=>true,
             'is_title'=>true,
             'default_in_list'=>true,
             'label'=>'广告标题',
             'filtertype'=>true,
             'searchtype'=>true,
             'searchtype' => 'has',
             ),
          'item_content' =>
          array (
             'label'=>'广告位置',
             'type' => 'html',
             'in_list'=>true,
             'default_in_list'=>true,
             'filtertype'=>true,
             'searchtype'=>true,
             'searchtype' => 'has',
             ),
          'item_imagesize' =>
          array (
             'label'=>'图片推荐大小',
             'type' => 'varchar(200)',
             'in_list'=>true,
             'default_in_list'=>true,
             'filtertype'=>true,
             ),
             
   /*       'item_begintime' =>
          array (
			'label' => app :: get('forum')->_('开启时间'),
			'width' => 75,
			'type' => 'time',
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'time',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
		),
             
             
          'item_endtime' => 
          array (
			'label' => app :: get('forum')->_('结束时间'),
			'width' => 75,
			'type' => 'time',
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'time',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
		),*/
//          'item_email' =>
//          array (
//             'in_list'=>true,
//             'default_in_list' => true,
//             'label' => 'email',
//             'type' => 'email',
//             ),
		  'item_url'=>array(
		      'label'=>app::get('forum')->_('网址'),
		      'type'=>'varchar(200)',
		      'required' => true,
		      'width'=>300,
		      'in_list'=>false,
		     ),
          'item_imageid' =>
		       array (
			  'type' => 'varchar(32)',
			  'label' =>'广告图片',
			  'width' => 75,
			  'hidden' => true,
			  'editable' => false,
			  'in_list' => false,
		    ),
          ),
       );