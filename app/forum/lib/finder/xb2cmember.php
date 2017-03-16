<?php
/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */
 
class forum_finder_xb2cmember{
	
     var $column_edit = '加入论坛违规名单';
    
     function column_edit($row){

//         echo '<pre>';
//    	
//    	 print_r($row);  
    	 
        return '<a href="index.php?app=forum&ctl=admin_theme&' .
        		'act=add_grey_page&member_id=' . $row['member_id'] 
        		. '&finder_id='.$_GET['_finder']['finder_id']
        		.'" >'.app::get('forum')->_('添加').'</a>';
        		
        
    }
		//条件查询
       function gets($col,$app,$mod,$filter){

      	$model1 = app::get($app)->model($mod);
      	
      	$aa=$model1->getList($col,$filter);
      	
      	$data=$aa[0];
    	
    	return $data;
    	
    	
    	
    	
    	
}}
