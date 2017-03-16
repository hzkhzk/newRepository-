<?php

/**
 * 违规会员信息
 */



class forum_mdl_magmember extends dbeav_model {

	/* 构 造 方 法 * @ param object model 相 应 app 的 对 象 * @ return null * / 
	 * 
	 */
 	 public function __construct($app) {
		parent :: __construct($app);
		$this->use_meta();
	} 
        
        //获取所有违规会员id
        public function getListId() {
            $mags=$this->getList("greymember_id");
            var_dump($mags);
            exit;
            return;
        }
       

}