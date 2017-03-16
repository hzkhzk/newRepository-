<?php
/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */
 
class forum_finder_xtheme{
	
 public function __construct($app) {
 	
        $this->app = $app;
        
    }
    //////////////////////////////////////////////////////////
    
    var $detail_edit = '详细列表';
    function detail_edit($id){
    		
        $render = app::get('forum')->render();
        $oItem = kernel::single("forum_mdl_theme");
        $items = $oItem->getList('title,content',
                     array('main_id' => $id), 0, 1);
        $render->pagedata['item'] = $items[0];
        $render->display('admin/themedetail.html');
    }
    
    
    ///////////////////////////////////////////////
    
    var $column_edit = '主题类型';
    
     function column_edit($row){
     	
     	$main_id=$row['main_id'];
     	
    	$a=$this->gets('type_id','forum','theme',array('main_id'=> $main_id));
    	
        $data =$this->gettypes($a);
        
        return $data["typename"];
        
    }
      var $column_edit2 = '创建人';
	    
	  function column_edit2($row){
    	
       $main_id=$row['main_id'];
       
       $a=$this->gets('member_id','forum','theme',array('main_id'=> $main_id));
      	
       $data =$this->getcreaters($a);
        
//       echo '<pre>';
//    	 print_r($a);  
        
       return $data["login_account"];//返回字段
    	
    }
    var $column_edit3 = '回复数量';
	    
	  function column_edit3($row){
    	
       $main_id=$row['main_id'];
      
       
       $a=$this->gets('count(*)','forum','reply',array('theme_id'=> $main_id));

//       echo '<pre>';
//
//       print_r($row);
        
       return $a['count(*)'];//返回字段
    	
    }
    
    
    
        var $column_edit4 = '是否禁用';
	    
	  function column_edit4($row){
	  	
	 $main_id=$row['main_id'];
	 
	 $a=$this->gets('*','forum','theme',array('main_id'=> $main_id));
	 
       return   (($a['state']==0)?'否':'是') ;
    	
    }
    
           var $column_edit5 = '是否热帖';
	    
	  function column_edit5($row){
	  	
	 $main_id=$row['main_id'];
	 
	 $a=$this->gets('*','forum','theme',array('main_id'=> $main_id));
	 
       return   (($a['hot']==0)?'否':'是') ;
    	
    }
    
     var $column_edit6 = '查看具体回复';
     
      function column_edit6($row){
       
        return '<a href="index.php?app=forum&ctl=admin_theme&' .
        		'act=getreply&theme_id=' . $row['main_id'] 
        		. '&finder_id='.$_GET['_finder']['finder_id']
        		.'" >'.app::get('forum')->_('查看').'</a>';
    }
    
      var $column_edit7 = '编辑';
	    
	  function column_edit7($row){
        		
        
        //下面的语句，会有   （正在提交表单的提示一直存在）的问题
        return  '<a href="index.php?app=forum&ctl=admin_theme&' .
        		'act=edit_theme_page&main_id=' . $row['main_id']. '&finder_id='
        		.$_GET['_finder']['finder_id']
        		.'" >'.app::get('forum')->_('编辑').'</a>';  
    	 
    }
      /*  return  '<a href="index.php?app=forum&ctl=admin_theme' .

        		'&act=edit_theme_page&_finder[finder_id]='.$_GET['_finder']['finder_id'].'' .
        		'&main_id=' . $row['main_id'].'" target="dialog::{title:\''.app::get('forum')->_('编辑主题贴').'\', ' .
        		'width:680, height:400}">'.app::get('forum')->_('编辑').'</a>'; */
    
      /*
       * 通过关联字段查询所需要的第二表的全部字段
       * //类型表查询全部
       */
    function gettypes($row){
      
      	$type_id=$row['type_id'];//$row['type_id']是表1的关联字段
      
      	$filter = array('type_id'=> $type_id);//'type_id'=>是表2的关联字段
      	
      	$model = $this->app->model('themetype');
    	
    	$aa=$model->getRow('*',$filter);
    	
    	return $aa;
    	
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
        function gets($col,$app,$mod,$filter){
      	
      	$model1 = app::get($app)->model($mod);
      	
      	$aa=$model1->getList($col,$filter);
      	
      	$data=$aa[0];
    	
    	return $data; 
    	
    }
    
   
    	 /*function gets($col1,$col2,$app1,$app2,$mod1,$mod2,$f1t1col,$f1t2col,$f2t1col,$f2t2col){
      	
      	$model1 = app::get($app1)->model($mod1);
      	
      	$aa=$model1->getList($col1,$filter1);
      	
      	$data=$aa[0];
      	
      	$filter = array($f1t2col=> $data[$f1t1col]); 
      	
		$model =  app::get($app2)->model($mod2);
    	
    	$aaa=$model->getRow($col2,$filter2);
    	
    	return $aaa;    	
    }*/
    	
}
