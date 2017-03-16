<?php
/**
 * 主题帖的显示和添加
 */
class forum_ctl_wap_themes extends wap_frontpage{
		public function __construct(&$app){

			parent::__construct($app);
			//这里设置本控制器不使用缓存no-store, no-cache********
            $this->_response->set_header('Cache-Control', 'no-store, no-cache');
      }
        
        function pagination($current,$totalPage,$act,$arg='',$app_id='forum',$ctl='wap_themes'){
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
        
        public function index($data=0){
            $themetype = app::get('forum')->model('themetype')->getList('*');
            var_dump('22222222222222222');
			exit;
            $this->page('wap/activity/index.html');
        }

}
