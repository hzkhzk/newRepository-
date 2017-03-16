<?php

/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */

class forum_mdl_reply extends dbeav_model {
	
     /**
     * 分页回复数据
     * @params string type_id
     * @params string page number
     */
    public function fetchByreply($members_id,$theme_id, $nPage=1, $filter_pre=array(),$limit=10)
    {
        if (!$limit)
          $limit = 10;
          $limitStart = ($nPage-1) * $limit;
          $filter["state"] =0;
          if($theme_id&&$theme_id>0)
          {
            $filter["theme_id"] =$theme_id;
          }
           if($members_id!=null){
              $filter["members_id"] =$members_id['members_id'];
          }
           
           $userobj=kernel::single('b2c_user_object');
           $replys =$this->getList('*',$filter, $limitStart, $limit, 'time ASC');
            if($replys)
            {
               foreach ($replys as $key => $value) {
                $replys[$key]["member_name"]=$userobj->get_member_name(null,$value["members_id"]);
                $replys[$key]["content"]=$value["content"];
                $replys[$key]["time"]=$value["time"];
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
        $arrdata['data'] = $replys;
        $arrdata['pager'] = $arrPager;
        return $arrdata;
    }	
}