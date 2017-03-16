<?php
/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */
 
class forum_finder_xthemetype{
	
 public function __construct($app) {
 	
        $this->app = $app;
        
    }
    
    var $column_edit = '主题数量';
	    
	  function column_edit($row){
    	
       $main_id=$row['type_id'];
      
       
       $a=$this->gets('count(*)','forum','theme',array('type_id'=> $main_id));

//       echo '<pre>';

//       print_r($a);
        
       return $a['count(*)'];//返回字段
    	
    }
    
    
    
     
     var $column_edit2 = '查看';
     
      function column_edit2($row){
      	
//      	echo '<pre>';
//      	print_r($row['typename']);
      	
        return '<a href="index.php?app=forum&ctl=admin_theme&' .
        		'act=gettheme&typename=' . $row['typename'] 
        		. '&finder_id='.$_GET['_finder']['finder_id']
        		.'" >'.app::get('forum')->_('查看').'</a>';
        		
    }
    
    	/*
    	 * 查询本表的全部
    	 */
        function gets($col,$app,$mod,$filter){
      	
      	$model1 = app::get($app)->model($mod);
      	
      	$aa=$model1->getList($col,$filter);
      	
      	$data=$aa[0];
    	
    	return $data; 
    	
    }
    
   
}