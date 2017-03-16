<?php
class forum_mdl_mgword extends dbeav_model {

	/* 构 造 方 法 * @ param object model 相 应 app 的 对 象 * @ return null * / 
	 * 
	 */
 	 public function __construct($app) {
		parent :: __construct($app);
		$this->use_meta();
	
		
	} 
/*
 * （b3c_members）编号，会员等级，(pam_members)名字，()主题，主题类型，
 */
	/*public function count($filter=null){
	    //自己写sql，返回满足条件的条数
	    $sql = 'SELECT count(*) as _count FROM (SELECT I.goods_id FROM '.
	        kernel::database()->prefix.'orders as O LEFT JOIN '.
	        kernel::database()->prefix.'order_items as I ON O.order_id=I.order_id LEFT JOIN '.
	        kernel::database()->prefix.'goods as G ON G.goods_id=I.goods_id WHERE '.
	        'O.disabled=\'false\' and O.pay_status!=\'0\' and '.$this->_filter($filter).' Group By I.goods_id) as tb';
	    $row = $this->db->select($sql);
	    return intval($row[0]['_count']);
	}
	      public function getlist($cols='*', $filter=array(), $offset=0, $limit=-1, $orderType=null){
	    $sql = 'SELECT I.goods_id as rownum,G.name as pname,G.bn as bn,sum(I.nums) as saleTimes,sum(I.amount) as salePrice,I.goods_id FROM '.
	        kernel::database()->prefix.'orders as O LEFT JOIN '.
	        kernel::database()->prefix.'order_items as I ON O.order_id=I.order_id LEFT JOIN '.
	        kernel::database()->prefix.'goods as G ON G.goods_id=I.goods_id WHERE '.
	        'O.disabled=\'false\' and O.pay_status!=\'0\' and G.goods_id!=\'0\' and '.$this->_filter($filter).' Group By I.goods_id';
	
	    if($orderType)$sql.=' ORDER BY '.(is_array($orderType)?implode($orderType,' '):$orderType);
	
	    $rows = $this->db->selectLimit($sql,$limit,$offset);
	    return $rows;
	} 
	    public function _filter($filter,$tableAlias=null,$baseWhere=null){
        $where = array(1);
        if(isset($filter['time_from']) && $filter['time_from']){
            $where[] = ' O.createtime >='.strtotime($filter['time_from']);
        }
        if(isset($filter['time_to']) && $filter['time_to']){
            $where[] = ' O.createtime <'.(strtotime($filter['time_to'])+86400);
        }
        if(isset($filter['pname']) && $filter['pname']){
            $where[] = ' G.name LIKE \'%'.$filter['pname'].'%\'';
        }
        if(isset($filter['bn']) && $filter['bn']){
            $where[] = ' G.bn LIKE \''.$filter['bn'].'%\'';
        }
        return implode($where,' AND ');
    } 
	
      
      
      public function get_schema(){
   		 $schema = array (
        'columns' => array (
        
        
        
        
        
        
        
        
            //写法属性和dbschema差不多，对应的字段名是和上面的getlist中获取的字段一致的
            'rownum' => array (
                'type' => 'number',
                'default' => 0,
                'label' => app::get('forum')->_('排名'),
                'width' => 110,
                'orderby' => false,
                'editable' => false,
                'hidden' => true,
                'in_list' => true,
                'default_in_list' => true,
                'realtype' => 'mediumint(8) unsigned',
            ),
            'pname' => array (
                'type' => 'varchar(200)',
                'pkey' => true,
                'sdfpath' => 'pam_account/account_id',
                'label' => app::get('forum')->_('商品名称'),
                'width' => 210,
                'searchtype' => 'has',
                'editable' => false,
                'in_list' => true,
                'default_in_list' => true,
                'realtype' => 'mediumint(8) unsigned',
            ),
              'member_id' => array (
            	    'pkey' => true,
                    'type' => 'number',
                    'default' => 0,
                    'label' => app::get('forum')->_('会员编号'),
                    'width' => 110,
                    'orderby' => false,
                    'editable' => false,
                    'hidden' => true,
                    'in_list' => true,
                    'default_in_list' => true,
                    'realtype' => 'mediumint(8) unsigned',
                ),
                'pname' => array (
                    'type' => 'varchar(200)',
                    'pkey' => true,
                   //'sdfpath' => 'pam_account/account_id',
                    'label' => app::get('forum')->_('商品名称'),
                    'width' => 210,
                    'searchtype' => 'has',
                    'editable' => false,
                    'in_list' => true,
                    'default_in_list' => true,
                    'realtype' => 'mediumint(8) unsigned',
                ),
                'bn' => array (
                    'required' => true,
                    'default' => 0,
                    'label' => app::get('forum')->_('商品编号'),
                    //'sdfpath' => 'member_lv/member_group_id',
                    'width' => 120,
                    'searchtype' => 'has',
                    'type' => 'varchar(200)',
                    'editable' => true,
                    'filtertype' => 'bool',
                    'filterdefault' => 'true',
                    'in_list' => true,
                    'default_in_list' => true,
                    'realtype' => 'mediumint(8) unsigned',
                ),
                'saleTimes' => array (
                    'type' => 'number',
                    'label' => app::get('forum')->_('销售量'),
                    'width' => 75,
                    'sdfpath' => 'contact/name',
                    'editable' => true,
                    'filtertype' => 'normal',
                    'filterdefault' => 'true',
                    'in_list' => true,
                    'is_title' => true,
                    'default_in_list' => true,
                    'realtype' => 'varchar(50)',
                ),
                'salePrice' => array (
                    'type' => 'money',
                    'default' => 0,
                    'required' => true,
                    'sdfpath' => 'score/total',
                    'label' => app::get('forum')->_('销售额'),
                    'width' => 110,
                    'editable' => false,
                    'filtertype' => 'number',
                    'in_list' => true,
                    'default_in_list' => true,
                    'realtype' => 'mediumint(8) unsigned',
                ),
                'refund_num' => array (
                    'type' => 'varchar(200)',
                    'sdfpath' => 'profile/gender',
                    'default' => 1,
                    'required' => true,
                    'label' => app::get('forum')->_('退换货量'),
                    'orderby' => false,
                    'width' => 110,
                    'editable' => true,
                    'filtertype' => 'yes',
                    'in_list' => true,
                    'default_in_list' => true,
                    'realtype' => 'enum(\'0\',\'1\')',
                ),
                'refund_ratio' => array (
                    'label' => app::get('forum')->_('退换货率'),
                    'width' => 110,
                    'type' => 'varchar(200)',
                    'orderby' => false,
                    'editable' => false,
                    'filtertype' => 'time',
                    'filterdefault' => true,
                    'in_list' => true,
                    'default_in_list' => true,
                    'realtype' => 'int(10) unsigned',
                ),
        ), 
			'idColumn' => 'pname',
            'in_list' => array (
                0 => 'rownum',
                1 => 'pname',
                2 => 'bn',
                3 => 'saleTimes',
                4 => 'salePrice',
                5 => 'refund_num',
                6 => 'refund_ratio',
            ),
            'default_in_list' => array (
                0 => 'rownum',
                1 => 'pname',
                2 => 'bn',
                3 => 'saleTimes',
                4 => 'salePrice',
                5 => 'refund_num',
                6 => 'refund_ratio',
            ),
    ); 
    return $schema;
      } 
      */
      
/*      
   public function getlist($cols='*', $filter=array(), $offset=0, $limit=-1, $orderType=null){
     
      $rows=parent::getList('*');
     
//	  echo '<pre>';
//	    
//	  print_r($rows); 
    
   //  $this->get_schema();
    
      return $rows;
       
   }
       
       
        public function get_schema(){
   		 $schema = array (
        'columns' => array (
            //写法属性和dbschema差不多，对应的字段名是和上面的getlist中获取的字段一致的
            'magmember_id' => array (
			'type' => 'int(8)',
			'required' => true,
			'pkey' => true,
			'label' => '违规会员编号',
			'editable' => false,
			'extra' => 'auto_increment',
			'comment' => app :: get('forum')->_('绑定theme表'),
		),
			'greymember_name' => array (
			'type' => 'varchar(255)',
			'required' => true,
			'label' => app :: get('forum')->_('违规会员名称'),
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'normal',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
			
		),
            'greyreason' => array (
			'type' => 'varchar(255)',
			'required' => true,
			'label' => app :: get('forum')->_('违规原因'),
			'editable' => false,
			'searchtype' => 'has',
			'filtertype' => 'normal',
			'filterdefault' => true,
			'in_list' => true,
			'default_in_list' => true,
			
		),
	
        ), 
			'idColumn' => 'magmember_id',
            'in_list' => array (
                0 => 'magmember_id',
                1 => 'greyreason',
                2 => 'greymember_name',
            ),
            'default_in_list' => array (
                0 => 'magmember_id',
                1 => 'greyreason',
                2 => 'greymember_name',
            ),
    ); 
    return $schema;
      } 
       
       
       
    */   
       

}