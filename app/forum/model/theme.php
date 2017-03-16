<?php
class forum_mdl_theme extends dbeav_model {
	
	public $recycle_msg;
	##进回收站前操作
    function pre_recycle($data)
    {
    	
        $falg = true;
        $obj_hasreply = app::get('forum')->model('reply');
        $arr_reply = array();
        foreach($data as $val){
            $arr_reply[] = $val['main_id'];
        }
        $row = $obj_hasreply->getList('reply_id',array('theme_id' => $arr_reply));
        if($row){
            $this->recycle_msg = app::get('forum')->_('回复不为空的主题,不能删除');
            $falg = false;
        }
        return $falg;
    }

    
         /**
     * 分享帖子数据
     * @params string type_id
     * @params string page number
     */
    public function fetchBytheme($main_id,$type_id, $member_id,$nPage=1, $filter_pre=array(),$limit=10)
    {
        if (!$limit)
          $limit = 10;
          $limitStart = ($nPage-1) * $limit;
          $filter["state"] =0;
           if($main_id)
          {
          	foreach($main_id as $key=>$value){
          		$filter["main_id"][$key]=$value['theme_id'];
          	}
          	
          }
          if($type_id&&$type_id>0)
          {
              $filter["type_id"] =$type_id;
          }
          if($member_id!=null){
              $filter["member_id"] =$member_id['member_id'];
          }
               
   
           $res =$this->getList('*',$filter, $limitStart, $limit, 'time DESC');
            if($res)
            {
              foreach ($res as $k => $v) {
                 //$res[$k]['product_id'] = $v['product_id'];
             }
            }
            
        // 生成分页组建
        $countRd = $this->count($filter);
        $total = ceil($countRd/$limit);
        $current = $nPage;
        $token = '';
        $arrPager = array(
            'current' => $current,
            'total' => $total,
            'token' => $token,
        );
        
        $arrdata['data'] = $res;
        $arrdata['pager'] = $arrPager;
        return $arrdata;
    }
}