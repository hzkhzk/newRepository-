<?php
/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */
 
class forum_finder_xmagmember{
	
	/*
	 * 现已弃用

	 
	 var $column_edit = '违规等级';
    
     function column_edit($row){
     	
     	 $main_id=$row['member_id'];
     	
    	 $a=$this->gets('greylv','forum','forum_magmember',array('greymember_id'=>$main_id));
    	
    	 
    	 echo '<pre>';
    	
    	print_r($a); 
        
        
       return $a["greylv"]?$a["greylv"]:'0';
        
    }
	
	
	
		//条件查询
       function gets($col,$app,$mod,$filter){



      	
      	$model1 = app::get($app)->model($mod);
      	
      	$aa=$model1->getList($col,$filter);
      	
      	$data=$aa[0];
    	
    	return $data;
    	//return $aa;
    } */
     var $column_edit = '会员名称';
    
     function column_edit($row){

     	 $a=$this->gets('*','forum','magmember',array('magmember_id'=>$row['magmember_id']));

     	 $main_id=$a['greymember_id'];
     	
    	 $aa=$this->gets('login_account','pam','members',array('member_id'=>$main_id));
    	
      /*   echo '<pre>';
    	
    	 print_r($aa); */
        
       return $aa["login_account"];
        
    }
/*	 var $column_edit1 = '参与主题列表';
    
     function column_edit1($row){

     	 $a=$this->gets('*','forum','magmember',array('magmember_id'=>$row['magmember_id']));

     	 $main_id=$a['greymember_id'];
     	
    	 $aa=$this->gets('login_account','pam','members',array('member_id'=>$main_id));
    	
         echo '<pre>';
    	
    	 print_r($aa); 
        
       return $aa["login_account"];
       
       return '<a>查看</a>';
        return '<a href="index.php?app=forum&ctl=admin_theme&' .
        		'act=getmembers&member_id=' . $row['greymember_id'] 
        		. '&finder_id='.$_GET['_finder']['finder_id']
        		.'" >'.app::get('forum')->_('查看').'</a>';
        
    }
	*/
		//条件查询
       function gets($col,$app,$mod,$filter){

      	$model1 = app::get($app)->model($mod);
      	
      	$aa=$model1->getList($col,$filter);
      	
      	$data=$aa[0];
    	
    	return $data;
    	
    	
    	
    	
    	
}}
