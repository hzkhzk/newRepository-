<?php
class forum_mdl_themetype extends dbeav_model {
		
    public $recycle_msg;
	##进回收站前操作
    function pre_recycle($data)
    {
    	
        $falg = true;
        $obj_hastheme = app::get('forum')->model('theme');
        $arr_theme = array();
        foreach($data as $val){
            $arr_theme[] = $val['type_id'];
        }
        $row = $obj_hastheme->getList('type_id',array('type_id' => $arr_theme));
        if($row){
            $this->recycle_msg = app::get('forum')->_('主题不为空的类型,不能删除');
            $falg = false;
        }
        return $falg;
    }

}