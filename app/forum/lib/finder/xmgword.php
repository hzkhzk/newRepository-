<?php
/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */
 


class forum_finder_xmgword{
	
 public function __construct($app) {
 	
        $this->app = $app;
        
    }
    
      var $column_edit = '编辑';
	    
	  function column_edit($row){
	  	
	  	$return ='<a href="index.php?app=forum&ctl=admin_theme' .
        		'&act=edit_mgword_page'.'&mgword_id=' . $row['mgword_id'].'&_finder[finder_id]='.$_GET['_finder']['finder_id'].'" target="dialog::{title:\''.app::get('forum')->_('编辑敏感词').'\', ' .
        		'width:680, height:250}">'.app::get('forum')->_('编辑').'</a>';
//        return   $return;
 		return  '<a href="index.php?app=forum&ctl=admin_theme&' .
        		'act=edit_mgword_page&mgword_id=' . $row['mgword_id']. '&finder_id='
        		.$_GET['_finder']['finder_id']
        		.'" >'.app::get('forum')->_('编辑').'</a>';      	 
    }
        
}