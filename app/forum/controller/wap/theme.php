<?php
/**
 * 论坛页面
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */

class forum_ctl_wap_theme extends wap_frontpage
{
	
	public function __construct(&$app){

			parent::__construct($app);
			//这里设置本控制器不使用缓存no-store, no-cache********
            $this->_response->set_header('Cache-Control', 'no-store, no-cache');
      }
        /*
     *本控制器公共分页函数
     * */
     function pagination($current,$totalPage,$act,$arg='',$app_id='forum',$ctl='wap_theme'){
        if (!$arg)
            $this->pagedata['pager'] = array(
                'current'=>$current,
                'total'=>$totalPage,
                'link' =>$this->gen_url(array('app'=>$app_id, 'ctl'=>$ctl,'act'=>$act,'args'=>array(($tmp = time())))),
                'token'=>$tmp,
                );
        else
        {
            $arg = array_merge($arg, array(($tmp = time())));
            $this->pagedata['pager'] = array(
                'current'=>$current,
                'total'=>$totalPage,
                'link' =>$this->gen_url(array('app'=>$app_id, 'ctl'=>$ctl,'act'=>$act,'args'=>$arg)),
                'token'=>$tmp,
                );
        }
    }
    //所有帖子列表
    public function index($typeid,$nPage)
    {
        $model = app::get('forum')->model('theme'); 
        $aData=$model->fetchBytheme(null,$typeid,null,$nPage,null,10);
        $model2 = app::get('forum')->model('themetype');   
        $sctable=app::get(forum)->model('sctable');
        $replymodel= $this->app->model('reply');
         $userobj=kernel::single('b2c_user_object');
        foreach ($aData["data"] as $key => $value) {	
        $themetype=$model2->getList("typename",array('type_id'=>$value['type_id'])); 
        $themetype[$value['type_id']]['typename']=$themetype[0]['typename'];     	
        $aData["data"][$key]["member_name"]=$userobj->get_member_name(null,$value["member_id"]);
          //评论数
 		$reply_num=$replymodel->getList('count(*)',array("theme_id"=>$value["main_id"]));
    	$sc=$sctable->getList("count(*)",array("theme_id"=>$value["main_id"])); 
 		$aData["data"][$key]["sc_num"]=$sc[0]['count(*)'];
 		$aData["data"][$key]["reply_num"]=$reply_num[0]['count(*)'];
            } 
        $objType = app::get('forum')->model('themetype');
        $type_data = $objType->getList('type_id,typename');
        $this->pagedata['typeList'] = $type_data;
       
        $this->pagedata['themes'] = $aData['data'];
        $this->pagedata['themetype'] =$themetype[0];
        $this->pagination($nPage,$aData['pager']['total'],'index',array("type_id"=>$typeid,"type_id1"=>"i"));//当前页，总页数，方法名称，参数
//        echo '<pre>';
//        print_r($aData);
//        exit;
        $this->display("wap/list.html");
    }
    
//     //我的帖子
//    public function myPost($nPage)
//    {
//      $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());  
//        if($members["member_id"]){ 
//            $aData = app::get('forum')->model('theme')->fetchBytheme(null,null,$members,$nPage,null,9);
//            $userobj=kernel::single('b2c_user_object');
//             foreach ($aData["data"] as $key => $value) {
//             	        $aData["data"][$key]["member_name"]=$userobj->get_member_name(null,$value["member_id"]);
//             	}
//
//            $this->page("wap/myPost.html");
//         }else{
//               $this->splash('failed', null,"您还未登录，请先登录",true); exit;
//         }
//    }
   
    //添加帖
    public function add(){
        $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());
        if($members["member_id"]){ 
            $mags=$this->app->model("magmember")->getList("greymember_id");
            foreach ($mags as $key => $value) {
                $mags[$key]=$value["greymember_id"];
            }
           if(in_array($members["member_id"],$mags))
           {
               $this->splash('failed', null,"您属于违规会员，不能发帖",true); exit;  
           }
               //获取类别id
            $objType = app::get('forum')->model('themetype');
            $type_data = $objType->getList('type_id,typename');
            $this->pagedata['typeList'] = $type_data;
            $this->display('wap/theme.html');
        }else{
            $this->splash('failed', null,"您还未登录，发帖前请先登录",true); exit;
        }   
    }
    
       /**
        * 添加收藏
        * */
          public function scAdd($theme_id){
    	  $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());
          $thememodel= $this->app->model('theme');
          $theme= $thememodel->getRow('main_id',array("main_id"=>$theme_id));  
    	  if($members["member_id"]){  	  	
    	  	$data=array(
    	  	         'member_id'=>$members["member_id"],
    	  	         'theme_id'=>$theme['main_id'],
    	  	);

    	  	  $result = $this->app->model('sctable')->save($data);
    	  	
    	  	  if($result){
            $url=$this->gen_url(array('app'=>"forum", 'ctl'=>"wap_theme",'act'=>"l",'args'=>array("theme_id"=>$theme_id)));//返回到帖子列表信息
            $this->splash('success', $url);   	  
    	  	  }else{
                $this->splash('failed', null,"收藏帖子失败"); 
              }
    }else{
           $this->splash('failed', null,"您还未登录，前请先登录",false); exit; 
        }
    	  }
    	  
    	/**
	     * 取消收藏
	     *参数：帖子id
	     */	  
	   public function scdelete($theme_id){
    	    $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());
         
          $thememodel= $this->app->model('theme');
          $theme= $thememodel->getRow('main_id',array("main_id"=>$theme_id));  
    	  if($members["member_id"]){  	  	
    	  	$result = $this->app->model('sctable')->delete(array('theme_id'=>$theme_id,'member_id'=>$members["member_id"]));
    	  	if($result){
	            $url=$this->gen_url(array('app'=>"forum", 'ctl'=>"wap_theme",'act'=>"l",'args'=>array("theme_id"=>$theme_id)));//返回到帖子列表信息
	            $this->splash('success', $url);   	  
    	 	}else{
           		$this->splash('failed', null,"收藏帖子失败"); 
    	 	 }
    	  	
    	  }else{
		        $this->splash('failed', null,"您还未登录，前请先登录",false); exit; 
		     }
		 }  	
    
    //保存
      public function save(){
      	$members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());
        if($members["member_id"]){ 
            $data = array(
                    "members"=>array("member_id"=>$members["member_id"]),
                    'title'=>$_POST['title'],
                    'content'=>$_POST['content'],
                    'type_id'=>$_POST['type_id'],
                    'time'=>time(),
                    
                );
               $res=$this->data_check($data);
        		if($res){
        			 $result = $this->app->model('theme')->save($data);
        		}else{
        			$this->splash('failed', null,"帖子标题或者内容不能为空，请重新输入",true); exit;
        		}
            if($result){
            $url=$this->gen_url(array('app'=>"forum", 'ctl'=>"wap_theme",'act'=>"index",'args'=>array("type_id"=>$_POST['type_id'])));//返回到帖子列表信息
            $this->splash('success', $url);
            }else{
               $this->splash('failed', null,"发帖失败"); 
            }
        }else{
            $this->splash('failed', null,"您还未登录，发帖前请先登录",true); exit;
        }     
    }
    
    
    /**
     * 功能：数据校验
     * 参数：需要校验的参数
     * 返回：true或者false
     */
       public function data_check($arr=array()){
       	$bool=true;
        if($arr){ 
        	foreach($arr as $key=>$value){
        		if(is_array($value)){
        			$bool=$this->data_check($value);
        		}else{
        			$value=trim($value);
        			if(!$value){
        				$bool=false;
//        				echo $key.'为空。。。';
        				return $bool;
        			} 
        		}
        	}	
        }		
       return $bool;
       } 		

    public function l($theme_id,$nPage=1) {
        $userobj=kernel::single('b2c_user_object');
		$thememodel= $this->app->model('theme');
        $theme= $thememodel->getRow('title,content,lnnum,member_id,type_id,time,main_id',array("main_id"=>$theme_id));
        if($theme["member_id"])
        {
        $theme["member_name"]=$userobj->get_member_name(null,$theme["member_id"]);
        }
       
        $theme=$this->getMGword(array($theme));
        $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());  
        $sctable = app::get('forum')->model('sctable');     	
        $sc=$sctable->getList("*",array('theme_id'=>$theme[0]["main_id"],'member_id'=>$members["member_id"])); 	
        $replymodel= $this->app->model('reply');
        $type = app::get('forum')->model('themetype'); 
        foreach ($theme as $key => $value) {	
        $themetype=$type->getList("typename",array('type_id'=>$value['type_id'])); 
        $themetype[$value['type_id']]['typename']=$themetype[0]['typename'];  
           }
        //评论数
 		$reply_num=$replymodel->getList('count(*)',array("theme_id"=>$value["main_id"]));	 
 		$theme[$key]["reply_num"]=$reply_num[1]['count(*)'];
        //浏览数      
        $lnnum= $theme[0]['lnnum']+1;//浏览数++++1111
        
        $thememodel->update(array('lnnum'=>$lnnum),array("main_id"=>$theme_id));//浏览数加一并更新数据到数据库
        $ln=$thememodel->getList('lnnum',array("main_id"=>$theme_id));
 		$theme[0]['lnnum']=$ln[0]['lnnum'];
		//显示回复
        $aData = app::get('forum')->model('reply')->fetchByreply(null,$theme_id,$nPage,null,10); 
        foreach($aData['data'] as $key=>$value){
          $aData['data'][$key]['floor']=$key+1;  
        }
        $aData['data']=$this->getMGword($aData['data']);     //屏蔽
        $this->pagedata['theme']=$theme[0]; //发送主题内容字段到页面 
        $this->pagedata['themetype'] =$themetype[0];
        $this->pagedata['sc'] =$sc[0];
        $this->pagedata['members'] =$members;
        $this->pagedata['replys'] = $aData['data'];
        $this->pagination($nPage,$aData['pager']['total'],'1',array("theme_id"=>$theme_id,"theme_id1"=>'i'));//当前页，总页数，方法名称，参数
        $this->pagedata['res_url'] = $this->app->res_url;
		$this->display('wap/theme_reply.html');
    }
    
    /**功能：帖子编辑页面
     * 参数：帖子id
     * 
     */   
    function mytheme_edit_page($id){
	 	
	 	//验证是否本人发的帖子
	 	$members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());
        if($members["member_id"]){
        	
	        $theme = app::get('forum')->model('theme');
		 	if($id){
	            $rows = $theme->getList('*',array('main_id'=>$id));
	            $row['main_id']=$rows[0]['main_id'];
	            $row['title']=$rows[0]['title'];
	            $row['content']=$rows[0]['content'];
	            $row['type_id']=$rows[0]['type_id'];
	            
	                //获取类别id
	            $objType = app::get('forum')->model('themetype');
	            $type_data = $objType->getList('type_id,typename');
	            
	            $this->pagedata['typeList'] = $type_data;
	            $this->pagedata['theme'] = $row;
	         }
	         if($members["member_id"]==$rows[0]['member_id']){
		 	$this->display('wap/edit_theme.html'); 
		 	 }else{
            $this->splash('failed', null,"非本人发的帖子，不能编辑",true); exit;
        }  
        
        }else{
            $this->splash('failed', null,"您还未登录，发帖前请先登录",true); exit;
        }     
	 	
	 }
	 
	  
	/**功能：帖子编辑后更新
     * 参数：帖子id及修改后数据
     * 
     */
	 function  update_theme(){
		
		$theme =app::get('forum')->model("theme");
		$check=array('title'=>$_POST['title'],'content'=>$_POST['content'],'type_id'=>$_POST['type_id']);
		$res=$this->data_check($check);
        if($res){
       		$result=$theme->update(array('title'=>$_POST['title'],'content'=>$_POST['content'],'type_id'=>$_POST['type_id']),array('main_id'=>$_POST['main_id']));
        }else{
        	$this->splash('failed', null,"回复内容不能为空，请重新输入",true); exit;
        }		
		if($result)
            {
                //添加成功刷新本页
                $url=$this->gen_url(array('app'=>"forum", 'ctl'=>"wap_theme",'act'=>"l",'args'=>array("theme_id"=>$_POST['main_id'])));//返回到帖子列表信息
                $this->splash('success', $url);
            }else{
                $this->splash('failed', null,"编辑失败",true); exit;
            }
       }
    
    /**功能：按删除跳转到删除的选择页面
     * 参数：帖子id   
     * 
     */
    public function delete_page($theme_id,$nPage=1) {
    	//验证是否本人的评论
    	
        $userobj=kernel::single('b2c_user_object');
		$thememodel= $this->app->model('theme');
        $theme= $thememodel->getRow('title,content,lnnum,member_id,type_id,time,main_id',array("main_id"=>$theme_id));
        if($theme["member_id"])
        {
        $theme["member_name"]=$userobj->get_member_name(null,$theme["member_id"]);
        }
       
        $theme=$this->getMGword(array($theme));
        $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());  
        $replymodel= $this->app->model('reply');
        $type = app::get('forum')->model('themetype'); 
        foreach ($theme as $key => $value) {	
        $themetype=$type->getList("typename",array('type_id'=>$value['type_id'])); 
        $themetype[$value['type_id']]['typename']=$themetype[0]['typename'];  
           }
               //评论数
 		$reply_num=$replymodel->getList('count(*)',array("theme_id"=>$value["main_id"]));	 
 		$theme[$key]["reply_num"]=$reply_num[0]['count(*)'];
        //浏览数      
        $lnnum= $theme[0]['lnnum']+1;//浏览数++++1111
        
        $thememodel->update(array('lnnum'=>$lnnum),array("main_id"=>$theme_id));//浏览数加一并更新数据到数据库
        $ln=$thememodel->getList('lnnum',array("main_id"=>$theme_id));
 		$theme[0]['lnnum']=$ln[0]['lnnum'];
		//显示回复
        $aData = app::get('forum')->model('reply')->fetchByreply(null,$theme_id,$nPage,null,10); 
        foreach($aData['data'] as $key=>$value){
          $aData['data'][$key]['floor']=$key+1;  
        }
        
        $aData['data']=$this->getMGword($aData['data']);     //屏蔽
        $this->pagedata['theme']=$theme[0]; //发送主题内容字段到页面 
        $this->pagedata['themetype'] =$themetype[0];
         $this->pagedata['members'] =$members;
        $this->pagedata['replys'] = $aData['data'];
        $this->pagination($nPage,$aData['pager']['total'],'1',array("theme_id"=>$theme_id,"theme_id1"=>'i'));//当前页，总页数，方法名称，参数
        $this->pagedata['res_url'] = $this->app->res_url;
        
         if($members["member_id"]==$theme[0]['member_id']){
         	
		 $this->display('wap/theme_reply_delete.html');
		 
		 	 }else{
            $this->splash('failed', null,"非本人发的帖子，不能编辑",true); exit;
        }  
		
    }
    
    /**功能：我的帖子中删除评论
     * 参数：评论id
     * 
     */
    public function delete_reply($reply_id){
    	  $res=$this->app->model('reply')->getList('*',array('reply_id'=>$reply_id));
	 	if($reply_id){
            $result=$this->app->model('reply')->delete(array('reply_id'=>$reply_id));
         }
         $theme_id=$res[0]['theme_id'];
        
          if($result)
            {
                //添加成功刷新本页
                $url=$this->gen_url(array('app'=>"forum", 'ctl'=>"wap_theme",'act'=>"delete_page",'args'=>array("theme_id"=>$theme_id)));//返回到帖子列表信息
                $this->splash('success', $url);
            }else{
                $this->splash('failed', null,"删除失败",true); exit;
            }
            
        } 
        
    /**功能：删除我的帖子
     * 参数：帖子id
     * 
     */
    public function delete_theme($theme_id){
	 	if($theme_id){
            $result=$this->app->model('theme')->delete(array('main_id'=>$theme_id));
         }
         $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());
          if($result)
            {
                //添加成功刷新本页
                $url=$this->gen_url(array('app'=>"forum", 'ctl'=>"wap_theme",'act'=>"myPost"));//返回到帖子列表信息
                $this->splash('success', $url);
            }else{
                $this->splash('failed', null,"删除失败",true); exit;
            }
        } 
        
        
        
      /*
      *我的帖子
     * */
    function myPost($nPage=1){
        $this->path[] = array('title'=>app::get('b2c')->_('论坛中心'),'link'=>$this->gen_url(array('app'=>'forum', 'ctl'=>'wap_theme', 'act'=>'index','full'=>1)));
        $this->path[] = array('title'=>app::get('b2c')->_('我的帖子'),'link'=>'#');
        $GLOBALS['runtime']['path'] = $this->path;
        $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());  
        if($members["member_id"]){ 
            $aData = app::get('forum')->model('theme')->fetchBytheme(null,null,$members,$nPage,null,9);
            $userobj=kernel::single('b2c_user_object');
            $themetype = app::get('forum')->model('themetype');
            $sctable=app::get('forum')->model('sctable');
        	$replymodel= $this->app->model('reply');
             foreach ($aData["data"] as $key => $value) {
             	        $aData["data"][$key]["member_name"]=$userobj->get_member_name(null,$value["member_id"]);
             	        $tyoename=$themetype->getList('typename',array('type_id'=>$value["type_id"]));
             	        $aData["data"][$key]["typename"]=$tyoename[0]['typename'];
			         	$reply_num=$replymodel->getList('count(*)',array("theme_id"=>$value["main_id"]));
			    		$sc=$sctable->getList("count(*)",array("theme_id"=>$value["main_id"])); 
			    		$aData["data"][$key]["sc_num"]=$sc[0]['count(*)'];
			 			$aData["data"][$key]["reply_num"]=$reply_num[0]['count(*)'];
             	}
             	 //屏蔽      	
            $aData['data']=$this->getMGword($aData['data']);
           		 
            $this->pagedata['themes'] = $aData['data'];
            $this->pagination($nPage,$aData['pager']['total'],'myPost');//当前页，总页数，方法名称，参数

            $this->display('wap/myPost.html');
         }else{
               $this->splash('failed', null,"您还未登录，请先登录",false); exit;
         }
    }
    
     /*
      *我的评论
     * */
     public function myComment($nPage=1){
     	$this->path[] = array('title'=>app::get('b2c')->_('论坛中心'),'link'=>$this->gen_url(array('app'=>'forum', 'ctl'=>'wap_theme', 'act'=>'index','full'=>1)));
        $this->path[] = array('title'=>app::get('b2c')->_('我的评论'),'link'=>'#');
         $GLOBALS["runtime"]['path'] = $this->path;
          $members=array("members_id"=>kernel::single('b2c_user_object')->get_member_session());  
            if($members["members_id"]){ 	
            	  $aData = app::get('forum')->model('reply')->fetchByreply($members,null,$nPage,null,9); 
            	  $userobj = kernel::single('b2c_user_object');
            	  $theme =  app::get('forum')->model('theme'); 
            	  $themetype = app::get('forum')->model('themetype');
            	  $sctable=app::get('forum')->model('sctable');
			      $replymodel= $this->app->model('reply');
			        	
             foreach ($aData["data"] as $key => $value) {
             	        $aData["data"][$key]["member_name"]=$userobj->get_member_name(null,$value["member_id"]);            	        
             	        $title=$theme->getList("title,type_id,lnnum",array('main_id'=>$value['theme_id'])); 
             	        $aData["data"][$key]['title']=$title[0]['title'];  
             	        $aData["data"][$key]["lnnum"]=$title[0]['lnnum'];
             	        $tyoename=$themetype->getList('typename',array('type_id'=>$title[0]['type_id']));
             	        $aData["data"][$key]["typename"]=$tyoename[0]['typename'];
             	        $aData["data"][$key]["main_id"]=$value['theme_id'];
             	        
             	        $reply_num=$replymodel->getList('count(*)',array("theme_id"=>$value["main_id"]));
			    		$sc=$sctable->getList("count(*)",array("theme_id"=>$value["main_id"])); 
			    		$aData["data"][$key]["sc_num"]=$sc[0]['count(*)'];
			 			$aData["data"][$key]["reply_num"]=$reply_num[0]['count(*)'];
			
             	}

             	 //屏蔽
            $aData['data']=$this->getMGword($aData['data']);
            $this->pagedata['themes'] = $aData['data'];
            $this->pagination($nPage,$aData['pager']['total'],'myComment');//当前页，总页数，方法名称，参数
//			echo '<pre>';
//			print_r($aData['data']);
//			exit;
			
            $this->display('wap/myComment.html');
             }else{
               $this->splash('failed', null,"您还未登录，请先登录",false); exit;
         }
     }
	    				
     /*
      * 我的收藏
      * */
      public function myCollection($nPage=1){
        $this->path[] = array('title'=>app::get('b2c')->_('论坛中心'),'link'=>$this->gen_url(array('app'=>'forum', 'ctl'=>'wap_theme', 'act'=>'index','full'=>1)));
        $this->path[] = array('title'=>app::get('b2c')->_('我的收藏'),'link'=>'#');
        $GLOBALS['runtime']['path'] = $this->path;
        $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());  
        if($members["member_id"]){ 
        	$sctable = app::get('forum')->model('sctable');     	
        	$sc=$sctable->getList("*",array('member_id'=>$members["member_id"])); 	
        	if($sc!=null){
            $aData = app::get('forum')->model('theme')->fetchBytheme($sc,null,null,$nPage,null,9);
        	}
            $userobj=kernel::single('b2c_user_object');
            $themetype = app::get('forum')->model('themetype');
            
            $sctable=app::get('forum')->model('sctable');
			$replymodel= $this->app->model('reply');
			
   						
			    		
					
            foreach ($aData["data"] as $key => $value) {
             	        $aData["data"][$key]["member_name"]=$userobj->get_member_name(null,$value["member_id"]);
             	         $tyename=$themetype->getList('typename',array('type_id'=>$value["type_id"]));
             	        $aData["data"][$key]["typename"]=$tyename[0]['typename'];
             	        
             	        $reply_num=$replymodel->getList('count(*)',array("theme_id"=>$value["main_id"]));
			    		$sc=$sctable->getList("count(*)",array("theme_id"=>$value["main_id"])); 
			    		$aData["data"][$key]["sc_num"]=$sc[0]['count(*)'];
			 			$aData["data"][$key]["reply_num"]=$reply_num[0]['count(*)'];
             	}
             	 //屏蔽     	
            $aData['data']=$this->getMGword($aData['data']);
            $this->pagedata['themes'] = $aData['data'];
            $this->pagination($nPage,$aData['pager']['total'],'myCollection');//当前页，总页数，方法名称，参数
//            	echo '<pre>';
//						print_r($aData);
//						exit;
            $this->display('wap/myCollection.html');
         }else{
               $this->splash('failed', null,"您还未登录，请先登录",false); exit;
         }
      }
      
      ////////////////////////////////////////////////////////////////////////////////////  
         
    
           //添加回复信息
    public function reply_save(){
        $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());
        if($members["member_id"]){ 
            $mags=$this->app->model("magmember")->getList("greymember_id");
            foreach ($mags as $key => $value) {
                $mags[$key]=$value["greymember_id"];
            }
           if(in_array($members["member_id"],$mags))
           {
               $this->splash('failed', null,"您属于违规会员，不能回复",true); exit;  
           }
            $data = array(
                "members_id"=>$members['member_id'],
                'content'=>$_POST['content'],
                'theme_id'=>$_POST['main_id'],
                'time'=>time(),
                );
                 $res=$this->data_check($data);
        		if($res){
        			 $result=$this->app->model('reply')->save($data);
        		}else{
        			$this->splash('failed', null,"回复内容不能为空，请重新输入",true); exit;
        		}
           
            
            if($result)
            {
                //添加成功刷新本页
                $url=$this->gen_url(array('app'=>"forum", 'ctl'=>"wap_theme",'act'=>"l",'args'=>array("theme_id"=>$_POST['main_id'])));//返回到帖子列表信息
                $this->splash('success', $url);
            }else{
                $this->splash('failed', null,"回复失败",true); exit;
            }
        }else{
            $this->splash('failed', null,"您还未登录，发帖前请先登录",true); exit;
        }  
    }
    
  
   /*
     * params:参数是$data[1=>结果1，2=>结果2， 。。。。。]
     * 方法中替换了敏感词成为星号，返回数据的结构不变
     * return:返回值是$data[1=>结果1，2=>结果2， 。。。。。]
     */
    //直接保存，星号显示
    function getMGword($data){
    	$mgword=$this->app->model("mgword")->getList("mgword");
        foreach($data as $key=> $value1){
    	  	if($mgword){
	    	  	foreach($mgword as $key2=> $value){
	    	  		$badword[$key2]=$value['mgword'];
		    	  	$length[$key2] = mb_strlen($badword[$key2],"utf-8");
					$star[$key2]=str_repeat('*',ceil($length[$key2]));
	    	  	}
	    	  	$badword1 = array_combine($badword,$star);
	    	  	$title= $value1['title'];
	    	  	$content=$value1['content'];
				$data[$key]['title'] = strtr($title, $badword1);
				$data[$key]['content'] = strtr($content, $badword1);
	    	 }
	      }
			return $data;
		}	
    
} 
