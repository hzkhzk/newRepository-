<?php
/**
 * ShopEx licence
 *
 * @copyright  Copyright (c) 2005-2010 ShopEx Technologies Inc. (http://www.shopex.cn)
 * @license  http://ecos.shopex.cn/ ShopEx License
 */
 
class forum_finder_xitem{

    var $column_edit = '编辑';
    
    function column_edit($row){
//    echo '<pre>';
//    	print_r($row);
    	return '<a href="index.php?app=forum&ctl=admin_theme&act=edit&id='.$row['item_id'].'">' .
    			'编辑</a>';
    
    }

    var $detail_edit = '详细列表';
    function detail_edit($id){
    		
        $render = app::get('forum')->render();
        $oItem = kernel::single("forum_mdl_item");
        $items = $oItem->getList('item_imageid,item_subject,item_url, item_content,item_imagesize',
                     array('item_id' => $id), 0, 1);
        $items[0]['item_imageid']=$this->getimage($items[0]['item_imageid']);   
                                       echo '<pre>';
        $render->pagedata['item'] = $items[0];
        $render->display('admin/itemdetail.html');
        //return 'detail';
    }
    
    var $column_edit2 = '广告缩略图';
    
    function column_edit2($row){
    	
        $o =  app::get('forum')->model('item');
		$g =$o->db_dump(array('item_id'=>$row['item_id']),'item_imageid');
		$img_src=$this->getimage($g['item_imageid']);
		return $img_src;
		
	}
	

    function getimage($item_imageid){

		$img_src = base_storager::image_path($item_imageid,'s' );
		if(!$img_src)return '';
		return "<a href='$img_src' class='img-tip pointer' target='_blank'
		        onmouseover='bindFinderColTip(event);'>
		<span>&nbsp;pic</span></a>";
		
	}


}