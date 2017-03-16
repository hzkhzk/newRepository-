<?php
/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */
 
class forum_finder_xsctable{
	
	  var $column_edit2 = '会员';
	    
	  function column_edit2($row){
	  	
		 $a=$this->gets('*','forum','sctable',array('sctable_id'=>$row['sctable_id']));
		   
	     $member_id=$a['member_id'];
	       
	     $data=$this->gets('*','pam','members',array('member_id'=> $member_id));
	        
	     return $data["login_account"];//返回字段
    	
    }
    
    
      var $column_edit4 = '收藏帖子';
	    
	  function column_edit4($row){
	  	
		 $a=$this->gets('*','forum','sctable',array('sctable_id'=>$row['sctable_id']));
		  	
		 $main_id=$a['theme_id'];
		 
		 $data=$this->gets('*','forum','theme',array('main_id'=> $main_id));
	 
      	 return   $data['title'];
    	
    }
    
       	//查询全部
        function getcreaters($a){
        
     	$member_id=$a['member_id'];
      	
      	$filter = array('member_id'=> $member_id); 
      	
      	$model =  app::get('pam')->model('members');
    	
    	$aaa=$model->getRow('*',$filter);
    	
    	return $aaa;
    } 
    	/*
    	 * 查询本表的全部
    	 */
        function gets($col,$app,$mod,$filter=array()){
      	
      	$model1 = app::get($app)->model($mod);
      	
      	$aa=$model1->getList($col,$filter);
      	
      	$data=$aa[0];
    	
    	return $data; 
    	
    }
    
}
