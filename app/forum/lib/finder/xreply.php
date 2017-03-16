<?php
/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */
 
class forum_finder_xreply{

/*    var $column_edit = '编辑';

    function column_edit($row){
    	//var_dump($row);
    	$data =$this->gets();
        return '<a href="index.php?app=b2c&ctl=admin_brand' .
        		'&act=edit&_finder[finder_id]='
        .$_GET['_finder']['finder_id'].'&p[0]='
        .$row['brand_id'].'" target="_blank">'
        .app::get('b2c')->_('编辑').'</a>';
    }
    function gets(){
    	
    }*/
    
    
    var $detail_edit = '详细列表';
    function detail_edit($id){
    		
        $render = app::get('forum')->render();
        
        $oItem1 = kernel::single("forum_mdl_reply");
        $oItem2 = kernel::single("forum_mdl_theme");
        $oItem3 = kernel::single("pam_mdl_members");
        
        $items1 = $oItem1->getList('*',array('reply_id' => $id), 0, 1);
        $items2 = $oItem2->getList('title',array('main_id' => $items1[0]["theme_id"]), 0, 1);
        $items3 = $oItem3->getList('login_account',array('member_id' =>  $items1[0]["members_id"]), 0, 1);
      	
      	$items[0]["content"]=$items1[0]["content"];
      	$items[0]["title"]=$items2[0]["title"];
      	$items[0]["login_account"]=$items3[0]["login_account"];
                     
        $render->pagedata['item'] = $items[0];
        $render->display('admin/replydetail.html');
    }
    
    
    	
	 var $column_edit = '回复人名称';
    
     function column_edit($row){
     	
     	 $main_id=$row['reply_id'];
     	  
     	 $a=$this->gets('members_id','forum','reply',array('reply_id'=>$main_id));
     	 
     	  $main_id=$a['members_id'];
     	
    	 $aa=$this->gets('login_account','pam','members',array('member_id'=>$main_id));
    	
    /*     echo '<pre>';


    	 print_r($main_id);  */
        
       return $aa["login_account"];
        
    }
     var $column_edit2 = '主题标题';
    
     function column_edit2($row){
     	
     	 $a=$this->gets('*','forum','reply',array('reply_id'=>$row['reply_id']));
     	 
     	 $main_id=$a['theme_id'];
     	
    	 $aa=$this->gets('*','forum','theme',array('main_id'=>$main_id));
    	 
    	  // echo '<pre>';

    	// print_r($aa);
    	 
       return $aa["title"];
        
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
