<?php


/**
 * 论坛的controller
 * filtername: forum.php
 * author:hzk
 *
 */

class forum_ctl_admin_theme extends desktop_controller {



////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
	function advertisementlist(){
	        $this->finder('forum_mdl_item',
	              array('title'=>'广告列表',
	               /*  'actions' =>
	                array(
	                  array(
	                    'label' => app::get('forum')->_('添加广告'),
	                    'icon' => 'add.gif',
	                    'href' => 'index.php?app=forum&ctl=admin_theme&act=add',
	                    //        'target' => '_blank'
	                    ),
	                  ), */
	//                'use_buildin_set_tag'=>true,
//	                'use_buildin_filter'=>true,
//	                'use_buildin_tagedit'=>true,
//	                'use_buildin_export'=>true,
	//                'use_buildin_import'=>true,
	 				'use_buildin_recycle' => false,
	                'allow_detail_popup'=>true,
	                //'use_view_tab'=>true,
	                ));
	
	
	    }
     function add(){
        $this->page('admin/edit.html');
    }
	
	
	function edit(){
        header("cache-control:no-store,no-cache,must-revalidate");
        $id = $_GET["id"];
        $oItem = kernel::single('forum_mdl_item');
        $row = $oItem->getList('*',array('item_id'=>$id),0,1);
        $this->pagedata['item'] = $row[0];
        $this->page('admin/edit.html');
    }
	
    function toEdit(){
	    $oItem = kernel::single("forum_mdl_item");
	    $arr = $_POST['item'];
	    	  $arr['item_endtime']=strtotime($arr['item_endtime']);
	        $this->begin('index.php?app=forum&ctl=admin_theme&act=advertisementlist');
	    $oItem->save($arr);
	        $this->end(true, "广告添加成功！");

    }




////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

    /**
     * 构造方法
     * @params object app object
     * @return null
     */
    public function __construct($app)
    {
        parent::__construct($app);
        header("cache-control: no-store, no-cache, must-revalidate");
    }
    
     /*
	  * ////////////////////////////////////////////////////////////////////////////////////////////
	  * //////////////////////////////////////list////////////////////////////////////////////////
	  * ////////////////////////////////////////////////////////////////////////////////////////////
	  */
    
    /*
     * 主题列表
     */
	public function index() {
		$this->finder('forum_mdl_theme', array (
			'title' => app :: get('forum')->_('主题列表'),
			'actions' => array (
				array (
					'label' => app :: get('forum')->_('新建主题'),
					'href' => 'index.php?app=forum&ctl=admin_theme&act=add_theme_page',
					'target'=>'dialog::{title:\''.app::get('forum')->_('新建主题').'\',width:860,height:560}'
				),
			),
		 'use_buildin_filter' => true,
			'use_buildin_export' => true,
			'allow_detail_popup' => true,
 			'finder_aliasname' => 'xxxx',
		));
	}
	public function sctable() {
		$this->finder('forum_mdl_sctable', array (
			'title' => app :: get('forum')->_('收藏列表'),
		/*	'actions' => array (
				array (
					'label' => app :: get('forum')->_('新建主题'),
					'href' => 'index.php?app=forum&ctl=admin_theme&act=add_theme_page',
					'target'=>'dialog::{title:\''.app::get('forum')->_('新建主题').'\',width:460,height:460}'
				),
			),*/
		 	'use_buildin_filter' => true,
			'use_buildin_export' => true,
			'allow_detail_popup' => true,
 			'finder_aliasname' => 'xxxx',
		));
	}
	
	/*
	 * 类型列表
	 */
	public function typelist() {
		$this->finder('forum_mdl_themetype', array (
			'title' => app :: get('forum')->_('类型列表'),
			'actions' => array (
				array (
					'label' => app :: get('forum')->_('新建类型'),
					'href' => 'index.php?app=forum&ctl=admin_theme&act=add_themetype_page',
					'target'=>'dialog::{title:\''.app::get('forum')->_('新建类型').'\',width:460,height:460}'
				),
			),
			'use_buildin_filter' => true,
			'use_buildin_export' => true,
			'allow_detail_popup' => true,
     		'finder_aliasname' => 'xxxx',
		));
	}
	
	/*
	 * 回复列表
	 */
	public function reply() {
		$this->finder('forum_mdl_reply',array (
		'title' => app :: get('forum')->_('回复列表'),
		'use_buildin_filter' => true,
		'use_buildin_export' => true,
		'allow_detail_popup' => true,
		// 'base_filter'=>array('order_refer'=>'local','disabled'=>'false'), //对tab数据进行过滤筛选
     	'finder_aliasname' => 'xxxx',
		));
	}
	
	
	public function greylist() {
	     $this->finder('forum_mdl_magmember', array (
		'title' => app :: get('forum')->_('违规会员列表'),
		'actions' => array (
			array(
		        'label'=>app::get('forum')->_('添加违规人员'),
		        'icon'=>'add.gif',
		         //'disabled'=>'true',
		         'href'=>'index.php?app=forum&ctl=admin_theme&act=list_member',
		         // 'target'=>'dialog::{title:\''.app::get('forum')->_('添加违规会员').'\',width:460,height:460}'
	            ),
				),
			'use_buildin_filter' => true,
			'use_buildin_export' => true,
			'allow_detail_popup' => true,
     		'finder_aliasname' => 'xxxx',
		));
	}
	
	
	function mgwordlist(){
     	
		$this->finder('forum_mdl_mgword', array (
			'title' => app :: get('forum')->_('词汇列表'),
			'actions' => array (
				array (
					'label' => app :: get('forum')->_('新增词汇'),
					'href' => 'index.php?app=forum&ctl=admin_theme&act=add_mgword_page',
					'target'=>'dialog::{title:\''.app::get('forum')->_('添加词汇').'\',width:460,height:460}'
				),
			),
			'use_buildin_filter' => false,
			'use_buildin_export' => true,
			'allow_detail_popup' => true,
 			'finder_aliasname' => 'xxxx',
		));
		
	}
	
	
	
	
	
	/*
	 * 从主题中‘查看’对应主题的回复列表
	 */
	public function getreply() {
		$this->finder('forum_mdl_reply',
			 array (
				'title' => app :: get('forum')->_('回复列表'),
				'use_buildin_filter' => true,
				'use_buildin_export' => true,
				'allow_detail_popup' => true,
				'base_filter'=>array('theme_id'=>$_GET['theme_id'],'disabled'=>'false'), //对tab数据进行过滤筛选
		     	'finder_aliasname' => 'xxxx',
			));
	}


	       /*
        * 显示指定的theme（由xthemetype的‘查看’调用）
        */
    public function gettheme() {
			$model=app::get('forum')->model('themetype');
			$pam_id=$model->getList('type_id',array('typename'=>$_GET['typename']));
			$type_id=$type_id[0]; 
			
			$this->finder('forum_mdl_theme',
				array (
					'title' => app :: get('forum')->_('主题列表'),
					'use_buildin_filter' => true,
					'use_buildin_export' => true,
					'allow_detail_popup' => true,
					'base_filter'=>array('type_id'=>$type_id,'disabled'=>'false'), //对tab数据进行过滤筛选
		     		'finder_aliasname' => 'xxxx',
					  )
			);	 
	}
	
	function list_member(){
		
		$mod1=app::get('b2c')->model('members');
		$mod2=app::get('b2c')->model('member_lv');
		$mod3=app::get('pam')->model('members');
		
		$res1=$mod1->getList('*');
		$res2=$mod2->getList('*');
//		$res3=$mod3->getList('*');
		
		$searchvalue=array('用户名','EMAIL');
		$searchcol=array('login_account','email');
		
		foreach($searchvalue  as $key1=> $value){
			$selt['searchlist'][$key1]=$value;
		} 
		
		$content=$_POST['searchcontent'];
		if($content){
			$filter=array($searchcol[$_POST['getselt']]=>$searchvalue[$_POST['getselt']]);
		}
		
		if($_POST['searchcontent']){
			if($_POST['getselt']==0){
				$sql = "select * from sdb_pam_members a LEFT JOIN sdb_b2c_members b ON a.member_id=b.member_id WHERE a.login_account like '%$content%'";
			}else{
				$sql = "select * from sdb_b2c_members where email like '%$content%'";
			}
			$res = kernel::database()->select($sql);
		}else{
			$res=$res1;
		}
		

		foreach($res  as $key =>$value){
//			$row[$key]["member_name"]=kernel::single('b2c_user_object')->get_member_name(null,$value["member_id"]);
			$name=$mod3->getList('login_account',array('member_id'=>$value["member_id"]));
			$row[$key]["member_name"]=$name[0]['login_account'];
			$row[$key]["member_id"]= $value["member_id"];
			$memberlv=$mod2->getList('name', array('member_lv_id'=>$value["member_lv_id"]));
			$row[$key]["member_lv"]=  $memberlv[0]['name'];
			
		} 
//	    echo '<pre>';
//		print_r($row);
//		print_r($selt);
		
		
		$this->pagedata['mem'] =$row;
		$this->pagedata['selt'] =$selt;
			
//		$this->display('admin/listtmemeber.html');	
		$this->page('admin/listtmemeber.html');
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////
	/*	function list_member(){
		
		$mod1=app::get('b2c')->model('members');
		$mod2=app::get('b2c')->model('member_lv');
		
		$res1=$mod1->getList('*');
		$res2=$mod2->getList('*');
		
		$searchvalue=array('用户名','EMAIL');
		$searchcol=array('login_account','email');
		
		foreach($searchvalue  as $key1=> $value){
			$selt['searchlist'][$key1]=$value;
		} 
		
		$content=$_POST['searchcontent'];
		if($content){
			
			$filter=array($searchcol[$_POST['getselt']]=>$searchvalue[$_POST['getselt']]);
		}
		
		if($_POST['searchcontent']){
			if($_POST['getselt']==0){
				$sql = "select * from sdb_pam_members a LEFT JOIN sdb_b2c_members b ON a.member_id=b.member_id WHERE a.login_account like '%$content%'";
			}else{
				$sql = "select * from sdb_b2c_members where email like '%$content%'";
			}
			$res = kernel::database()->select($sql);
		}else{
			$res=$res1;
		}
		
		foreach($res  as $key =>$value){
			$row[$key]["member_name"]=kernel::single('b2c_user_object')->get_member_name(null,$value["member_id"]);
			
			$row[$key]["member_id"]= $value["member_id"];
			$memberlv=$mod2->getList('name', array('member_lv_id'=>$value["member_lv_id"]));
			$row[$key]["member_lv"]=  $memberlv[0]['name'];
		} 
		
//	    echo '<pre>';
//
//		print_r($res);
//		print_r($selt);
		
		
		$this->pagedata['mem'] =$row;
		$this->pagedata['selt'] =$selt;
			
//		$this->display('admin/listtmemeber.html');	
		$this->page('admin/listtmemeber.html');
	}*/
	
	
	 /*
	  * ////////////////////////////////////////////////////////////////////////////////////////////
	  * ///////////////////////////add_page 和 edit_page/////////////////////////////////////////////
	  * ////////////////////////////////////////////////////////////////////////////////////////////
	  */
	
	
	
	
	function add_mgword_page(){
		$this->display('admin/newmgword.html');
	}
	
	
     /*
     * 跳转theme新增页面
     */
	 function add_theme_page(){
	 	
	 	$themetype=$this->app->model("themetype");
	  	foreach($themetype->getList() as $row){
	   	 	$options[$row['type_id']] = $row['typename'];
	    }
	 	$a_type['lv']['options'] = is_array($options) ? $options : array(app::get('forum')->_('请添主题类型')) ;
	 	
  		$this->pagedata['mem'] = $a_type;
	  	$this->display('admin/newtheme.html');
	    
	    }
	    
     function add_themetype_page(){
	    $this->display('admin/newthemetype.html');
	 }
	    /////////////////////////////////////////////////////////////////////////////
     function edit_theme_page(){
		$theme =app::get('forum')->model("theme");
		$members =  app::get('pam')->model('members');
		$themetype = app::get('forum')->model('themetype');
	    
	    if($_GET['main_id']){
            $row = $theme->getList('*',array('main_id'=>$_GET['main_id']));
            $creater=$members->getRow('login_account',array('member_id'=>$row[0]['member_id']));
            $type=$themetype->getRow('typename',array('type_id'=>$row[0]['type_id']));
            $row[0]['typename']=$type['typename'];
            $row[0]['creater']=$creater['login_account'];
            $row[0]['options']=array('否','是');
            $this->pagedata['theme'] = $row;
         }
        
 		$this->display('admin/edittheme.html');
	 }
	 
	 
	 function edit_mgword_page(){
	 	
	 	$mod = app::get('forum')->model('mgword');
//		echo '<pre>';
//	  	print_r($_GET);
	 	if($_GET['mgword_id']){
            $rows = $mod->getList('*',array('mgword_id'=>$_GET['mgword_id']));
            $row[0]['mgword']=$rows[0]['mgword'];
            $row[0]['mgword_id']=$_GET['mgword_id'];
            
            $this->pagedata['mgwords'] = $row;
         }
//         	print_r($rows);
	 	$this->display('admin/editmgword.html');
	 	
	 }
	    
	  
       

    
 
	  
	
	 /*
	  * ////////////////////////////////////////////////////////////////////////////////////////////
	  * //////////////////////////////////////update////////////////////////////////////////////////
	  * ////////////////////////////////////////////////////////////////////////////////////////////
	  */
	  
	  /*
	   * 这里是theme的更新，只有是否禁用state的状态可以更改
	   */
      function  updatetheme(){
		
		$this->begin();
		
		$theme =app::get('forum')->model("theme");
		
		$state=$_POST['state'];
		
		$res=$theme->update(array('state'=>$state,'hot'=>$_POST['hot']),array('main_id'=>$_POST['main_id']));

	    if($res){
	   		 $msg = app::get('forum')->_('修改成功');
	    }else{
	   		 $msg = app::get('forum')->_('修改失败');
	   }
	    $this->end(true, $msg, "index.php?app=forum&ctl=admin_theme&act=index");
		
		
       }
	
	 function  updatemgword(){
	 	
//	    $this->begin("index.php?app=b2c&ctl=admin_order&act=addnew");
		$this->begin();
		$theme =app::get('forum')->model("mgword");
		$res=$theme->update(array('mgword'=>$_POST['mgword']),array('mgword_id'=>$_POST['mgword_id']));
		if($res){
	   		 $msg = app::get('forum')->_('修改成功');
	    }else{
	   		 $msg = app::get('forum')->_('修改失败');
	    }
		$res=(($res)?true:false);
	    	 
		$this->end(true, $msg, "index.php?app=forum&ctl=admin_theme&act=mgwordlist");
	    	 
	    	 
     }
	
	/*
	 * ////////////////////////////////////////////////////////////////////////////////////////////////
	 * ////////////////////////save////////////////////////////////////////////////////////////////////
	 * ////////////////////////////////////////////////////////////////////////////////////////////////
	 */
	  public function savemgword(){
	     $this->begin();
         $data = array(
              'mgword'=>$_POST['mgword'],
            ); 
	     $result = $this->app->model('mgword')->save($data);
	     $this->end(true, app::get('forum')->_('新建成功！'));
    }
	 
       
	 /*
	  * 保存新增的theme
	  */
	 public function savetheme(){
	 	
     	 $this->begin();
     	 $id=$this->app->member_id;
         $data = array(
		 	'members'=>array(
				"member_id"=>kernel::single('b2c_user_object')->get_member_session()),
 		 		//这一行是取得前台的登录用户
				//'member_id'=>$id,
              	'title'=>$_POST['title'],
	            'content'=>$_POST['content'],
	            'time'=>time(),
	            'type_id'=>$_POST['themetype'],
	            /*'lnnum'=>$_POST['lnnum'],
	            'hot'=>$_POST['hot'],
	            'state'=>$_POST['state'],*/
	            
            ); 
	      $result = $this->app->model('theme')->save($data);
	      $this->end(true, app::get('forum')->_('新建成功！'));
    }
    
    
    
    
	 public function savethemetype(){
	     $this->begin();
         $data = array(
		//  'members'=>array("member_id"=>kernel::single('b2c_user_object')->get_member_session()),
              'typename'=>$_POST['typename'],
              'time'=>time(),
            ); 
	     $result = $this->app->model('themetype')->save($data);
	     $this->end(true, app::get('forum')->_('新建成功！'));
    }
	
	
	
	/*
	 * 保存违规人员magmember 
	 */
	function save_grey_member() {
		
		foreach($_POST['getid'] as $key=> $value){
		$check=$this->app->model('magmember')->getList('greymember_id',array('greymember_id'=>$value));
		$name=app::get('pam')->model('members');
		if(!$check){
			$data[$key]  = array(
              'greyreason'=>$_POST['greyreason'][$value],
              'greymember_id'=>$value,
            );
		 $result = $this->app->model('magmember')->save($data[$key]);
		}else{
			$getname=$name->getList('login_account',array('member_id'=>$value));
//			echo '<center><pre>';
//			print_r($getname);
			echo '<center><pre>';
			print_r('<br>' .
					'xxxxxxxxxxxxxxxxxxxxxx输入的会员: 编号为: '.$value.'会员名为 :'.$getname[0]['login_account'].'  已存在xxxxxxxxxxxxxxxxxxx');
			echo '</center>';
//				exit;
		
		} 	
        
		}
		
		 $this->greylist();
	}
}