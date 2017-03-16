<?php
/**
 * 主题帖的显示和添加
 */
class forum_ctl_site_theme extends site_controller{
      function __construct(&$app){
        parent::__construct($app);
        $shopname = app::get('site')->getConf('site.name');
        if(isset($shopname)){
            $this->title = app::get('b2c')->_('论坛').'_'.$shopname;
            $this->keywords = app::get('b2c')->_('论坛_').'_'.$shopname;
            $this->description = app::get('b2c')->_('论坛_').'_'.$shopname;
        }
        $this->header .= '<meta name="robots" content="noindex,noarchive,nofollow" />';
        $this->_response->set_header('Cache-Control', 'no-store');
        $this->pagesize = 10;
        $this->action = $this->_request->get_act_name();
        if(!$this->action) $this->action = 'index';
        $this->action_view = $this->action.".html";
       // $this->member = $this->get_current_member();
        /** end **/
    }
     /*
     *论坛左侧菜单栏
     */
    private function get_cpmenu(){
        //获取所有类别信息
        $types = $this->app->model('themetype')->getList("*"); 
        foreach($types as $key=>$value)
        {
            $arr_bases[$key]["label"]=app::get('forum')->_($value["typename"]);
            $arr_bases[$key]["app"]='forum';
            $arr_bases[$key]["ctl"]='site_theme';
            $arr_bases[$key]["link"]="index";
            $arr_bases[$key]["args"]=array("type_id"=>$value["type_id"]);
        }
              $sql="select * FROM sdb_forum_item WHERE item_content='顶部图片'";  
             $picture1=kernel::database()->select($sql);
             $picture1[0]['item_imageid'] = base_storager::image_path($picture1[0]['item_imageid'],'b' );
             $this->pagedata['picture']=$picture1[0];
        return $arr_bases;
    }
    
    /*
     *论坛首页页面统一输出
     * */
    protected function output($app_id='forum'){
        $this->pagedata['cpmenu'] = $this->get_cpmenu();
        $this->pagedata['current'] = $this->action;
        if( $this->pagedata['_PAGE_'] ){
            $this->pagedata['_PAGE_'] = 'site/'.$this->pagedata['_PAGE_'];
        }else{
           $this->pagedata['_PAGE_'] = 'site/'.$this->action_view;
        }
        $this->pagedata['app_id'] = $app_id;
        $this->pagedata['_MAIN_'] = 'site/main.html';
        $this->page('site/main.html');
    }
     /*
     *本控制器公共分页函数
     * */
    function pagination($current,$totalPage,$act,$arg='',$app_id='forum',$ctl='site_theme'){
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

    /*
     *论坛主页首页
     * */
    function index($typeid=1,$nPage=1){
        $this->path[] = array('title'=>app::get('b2c')->_('论坛中心'),'link'=>$this->gen_url(array('app'=>'forum', 'ctl'=>'site_theme', 'act'=>'index','full'=>1)));
        $this->path[] = array('title'=>app::get('b2c')->_('所有帖子'),'link'=>'#');
        $GLOBALS['runtime']['path'] = $this->path;
        $model = app::get('forum')->model('theme');      
        $model2 = app::get('forum')->model('themetype');   
        $sctable=app::get(forum)->model('sctable');
        $replymodel= $this->app->model('reply');
        $aData=$model->fetchBytheme(null,$typeid,null,$nPage,null,11);
     
        
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

      	$hot=$model->getList('*',array('hot'=>1),0,10);
        //这里是屏蔽敏感词（替换星号显示）
        $aData['data']=$this->getMGword($aData['data']);  
        $this->pagedata['themes'] = $aData['data'];
        //提取右侧广告图数据
        $right=$this->right_menu();    
        $this->pagedata['themetype'] =$themetype[0];
        $this->pagedata['hots'] =$hot;
        $this->pagedata['right1'] = $right[0];
        $this->pagedata['right2'] = $right[1];  
        $this->pagination($nPage,$aData['pager']['total'],'index',array("type_id"=>$typeid,"type_id1"=>"i"));//当前页，总页数，方法名称，参数
        $this->pagedata['res_url'] = $this->app->res_url;
        $this->output();
    }
    
    /*
      *我的帖子
     * */
    function myPost($nPage=1){
        $this->path[] = array('title'=>app::get('b2c')->_('论坛中心'),'link'=>$this->gen_url(array('app'=>'forum', 'ctl'=>'site_theme', 'act'=>'index','full'=>1)));
        $this->path[] = array('title'=>app::get('b2c')->_('我的帖子'),'link'=>'#');
        $GLOBALS['runtime']['path'] = $this->path;
        $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());  
        if($members["member_id"]){ 
            $aData = app::get('forum')->model('theme')->fetchBytheme(null,null,$members,$nPage,null,9);
            $userobj=kernel::single('b2c_user_object');
             foreach ($aData["data"] as $key => $value) {
             	        $aData["data"][$key]["member_name"]=$userobj->get_member_name(null,$value["member_id"]);
             	}
             $sql="select * FROM sdb_forum_item WHERE item_content='顶部图片'";  
             $picture1=kernel::database()->select($sql);
             $picture1[0]['item_imageid'] = base_storager::image_path($picture1[0]['item_imageid'],'b' );   	
             	 $right=$this->right_menu(); //右侧热门贴数据(广告)
             	 $hot=$this->hot();          //右侧热门贴数据(贴)
             	 //屏蔽      	
            $aData['data']=$this->getMGword($aData['data']);
            $this->pagedata['themes'] = $aData['data'];
            $this->pagination($nPage,$aData['pager']['total'],'myPost');//当前页，总页数，方法名称，参数
            $this->pagedata['res_url'] = $this->app->res_url;
            $this->pagedata['picture']=$picture1[0];
            $this->pagedata['hots'] =$hot;
            $this->pagedata['right1'] = $right[0];
            $this->pagedata['right2'] = $right[1];  
            $this->page('site/myPost.html');
         }else{
               $this->splash('failed', null,"您还未登录，请先登录",false); exit;
         }
    }
    
     /*
      *我的评论
     * */
     public function myComment($nPage=1){
     	$this->path[] = array('title'=>app::get('b2c')->_('论坛中心'),'link'=>$this->gen_url(array('app'=>'forum', 'ctl'=>'site_theme', 'act'=>'index','full'=>1)));
        $this->path[] = array('title'=>app::get('b2c')->_('我的评论'),'link'=>'#');
         $GLOBALS["runtime"]['path'] = $this->path;
          $members=array("members_id"=>kernel::single('b2c_user_object')->get_member_session());  
            if($members["members_id"]){ 	
            	  $aData = app::get('forum')->model('reply')->fetchByreply($members,null,$nPage,null,9); 
            	  $userobj = kernel::single('b2c_user_object');
            	  $theme =  app::get('forum')->model('theme'); 
             foreach ($aData["data"] as $key => $value) {
             	         $aData["data"][$key]["member_name"]=$userobj->get_member_name(null,$value["member_id"]);            	        
             	        $title=$theme->getList("title",array('main_id'=>$value['theme_id'])); 
             	       $aData["data"][$key]['title']=$title[0]['title'];  
             	}
           	$sql="select * FROM sdb_forum_item WHERE item_content='顶部图片'";  
            $picture1=kernel::database()->select($sql);
            $picture1[0]['item_imageid'] = base_storager::image_path($picture1[0]['item_imageid'],'b' );
            $this->pagedata['picture']=$picture1[0];     	
            $right=$this->right_menu(); //右侧热门贴数据(广告)
            $hot=$this->hot();          //右侧热门贴数据(贴)
             	 //屏蔽
            $aData['data']=$this->getMGword($aData['data']);
            $this->pagedata['themes'] = $aData['data'];
            $this->pagination($nPage,$aData['pager']['total'],'myComment');//当前页，总页数，方法名称，参数
            $this->pagedata['res_url'] = $this->app->res_url;
            $this->pagedata['picture']=$picture1[0];
            $this->pagedata['hots'] =$hot;
            $this->pagedata['right1'] = $right[0];
            $this->pagedata['right2'] = $right[1];  
            $this->page('site/myComment.html');
             }else{
               $this->splash('failed', null,"您还未登录，请先登录",false); exit;
         }
     }
     
     /*
      * 我的收藏
      * */
      public function myCollection($nPage=1){
        $this->path[] = array('title'=>app::get('b2c')->_('论坛中心'),'link'=>$this->gen_url(array('app'=>'forum', 'ctl'=>'site_theme', 'act'=>'index','full'=>1)));
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
             foreach ($aData["data"] as $key => $value) {
             	        $aData["data"][$key]["member_name"]=$userobj->get_member_name(null,$value["member_id"]);
             	}
             $sql="select * FROM sdb_forum_item WHERE item_content='顶部图片'";  
             $picture1=kernel::database()->select($sql);
             $picture1[0]['item_imageid'] = base_storager::image_path($picture1[0]['item_imageid'],'b' );
             $right=$this->right_menu(); //右侧热门贴数据(广告)
             $hot=$this->hot();          //右侧热门贴数据(贴)
             	 //屏蔽     	
            $aData['data']=$this->getMGword($aData['data']);
            $this->pagedata['themes'] = $aData['data'];
            $this->pagination($nPage,$aData['pager']['total'],'myCollection');//当前页，总页数，方法名称，参数
            $this->pagedata['res_url'] = $this->app->res_url;
            $this->pagedata['picture']=$picture1[0];
            $this->pagedata['hots'] =$hot;
            $this->pagedata['right1'] = $right[0];
            $this->pagedata['right2'] = $right[1];  
            $this->page('site/myCollection.html');
         }else{
               $this->splash('failed', null,"您还未登录，请先登录",false); exit;
         }
      }

     //主题表页面
     public function l($theme_id,$nPage=1) { 
        $this->path[] = array('title'=>app::get('b2c')->_('论坛中心'),'link'=>$this->gen_url(array('app'=>'forum', 'ctl'=>'site_theme', 'act'=>'index','full'=>1)));
        $this->path[] = array('title'=>app::get('b2c')->_('帖子详情'),'link'=>'#'); 
        $GLOBALS['runtime']['path'] = $this->path;
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

      
        //提取热门贴数据
        $hot=$this->hot();
        //提取右侧广告图
         $right=$this->right_menu();  
         //屏蔽
         
        $aData['data']=$this->getMGword($aData['data']); 
        $this->pagedata['theme']=$theme[0]; //发送主题内容字段到页面 
        $this->pagedata['themetype'] =$themetype[0];  
        $this->pagedata['hots'] =$hot;
        $this->pagedata['sc'] =$sc[0];
        $this->pagedata['right1'] = $right[0];
        $this->pagedata['right2'] = $right[1];  
        $this->pagedata['replys'] = $aData['data'];
        $this->pagination($nPage,$aData['pager']['total'],'1',array("theme_id"=>$theme_id,"theme_id1"=>'i'));//当前页，总页数，方法名称，参数
        $this->pagedata['res_url'] = $this->app->res_url;
       
		$this->page('site/theme_reply.html');
}
	
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
                     'members_id'=>$members['member_id'],
                      'content'=>$_POST['content'],
                      'theme_id'=>$_POST['main_id'],
                      'time'=>time(),
                      'floor'=>$reply[0]['floor']+1,
                  );
               $res=$this->data_check($data);
        		if($res){
        			$result = $this->app->model('reply')->save($data);
         		}else{
        			$this->splash('failed', null,"回复内容不能为空，请重新输入",true); exit;
        		}    
              
              if($result)
              {
              //添加成功刷新本页
                  $url=$this->gen_url(array('app'=>"forum", 'ctl'=>"site_theme",'act'=>"l",'args'=>array("theme_id"=>$_POST['main_id'])));//返回到帖子列表信息
                  $this->splash('success', $url);; 
              }else{
                $this->splash('failed', null,"回复帖子失败"); 
              }
        }else{
            $this->splash('failed', null,"您还未登录，发帖前请先登录",true); exit;
        }   
    }
    
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
            $url=$this->gen_url(array('app'=>"forum", 'ctl'=>"site_theme",'act'=>"l",'args'=>array("theme_id"=>$theme_id)));//返回到帖子列表信息
            $this->splash('success', $url);   	  
    	  	  }else{
                $this->splash('failed', null,"回复帖子失败"); 
              }
    }else{
           $this->splash('failed', null,"您还未登录，前请先登录",false); exit; 
        }
    	  }
    
    //添加帖
    public function add(){

        $members=array("member_id"=>kernel::single('b2c_user_object')->get_member_session());
        if($members["member_id"]){ 
            //查询所有违规会员id，如果属于违规会员id就过来
             $mags=$this->app->model("magmember")->getList("greymember_id");
             foreach ($mags as $key => $value) {
                 $mags[$key]=$value["greymember_id"];
             }
            if(in_array($members["member_id"],$mags))
            {
                $this->splash('failed', null,"您属于违规会员，不能发帖",false); exit;  
            }
            $this->path[] = array('title'=>app::get('b2c')->_('论坛中心'),'link'=>$this->gen_url(array('app'=>'forum', 'ctl'=>'site_theme', 'act'=>'index','full'=>1)));
            $this->path[] = array('title'=>app::get('b2c')->_('发表帖子'),'link'=>'#');    
            $GLOBALS['runtime']['path'] = $this->path;
            //获取类别id
            $objType = app::get('forum')->model('themetype');
            $type_data = $objType->getList('type_id,typename');
            $this->pagedata['typeList'] = $type_data;
            $this->page('site/theme.html');
        }else{
           $this->splash('failed', null,"您还未登录，发帖前请先登录",false); exit; 
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
            $url=$this->gen_url(array('app'=>"forum", 'ctl'=>"site_theme",'act'=>"index",'args'=>array("type_id"=>$_POST['type_id'])));//返回到帖子列表信息
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
  
    
     public function right_menu(){
     	 $sql="select * FROM sdb_forum_item WHERE item_content='右部图片上' or item_content='右部图片下'";
         $picture=kernel::database()->select($sql);
         $picture[0]['item_imageid'] = base_storager::image_path($picture[0]['item_imageid'],'b' );
          $picture[1]['item_imageid'] = base_storager::image_path($picture[1]['item_imageid'],'b' );
           return $picture;
    }
     public function hot(){
     	 $model = app::get('forum')->model('theme');   
     	$hot=$model->getList('*',array('hot'=>1),0,10);
        return $hot;
     }

    
    /**
     * 帖列表浏览数据
     * */
    public function quantity(){ 
    	 $collect = app::get('forum')->model('sctable');   
    	 $Collection=$collect->getList('*',array('hot'=>1)); 
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
?>
