<?php
/**
* 商品に関するクラス
* 2024-01-22       【開1-23-0021】バルル委託販売機能作成
*/


require_once('/var/php_class/class_dbi.php');

class Mail {
	//グローバル変数
	protected $item_serial;
	protected $seller_id;
	protected $input_session_name = 'outlet_katte_item_reg';
	protected $input;
	protected $table_arr = [
		'valeur_seller_outlet' => 'mmart_uriba.valeur_seller_outlet'  // バルル出品社情報
		,'order_dat_m' => 'dami2.order_dat_m'//地方区分情報
		,'order_item_m' => 'dami2.order_item_m'//地方区分情報
		,'m_data_dat' => 'dami2.m_data_dat'//地方区分情報
		,'order_kakunin_mail'	=> 'dami2.order_dat_m_kakunin_mail'	//“確認メール、order_dat_m用”
		,'order_mail'	=> 'dami2.order_mail'	
	];
	protected $db_name = 'mmart_uriba';
	private $c_dbi;
	public function __construct(){
		$this->c_dbi = new G_class_dbi;
	}

	function get_mail_seller($S_id){
		$ret_arr=[];
		$this->c_dbi->DB_on("dami2");

		$sql=sprintf('SELECT t1.*, t_order.order_time as time, t_order.kaite_shamei as kaite_mei, t_item.ai_serial, t_manager.read_flg as read_flg, t_manager.del_flg as del_flg 
		FROM `dami2`.`order_mail` as t1
		inner join dami2.order_dat_m as t_order on t_order.order_serial = t1.order_serial
		left join dami2.order_item_m as t_item on t_order.order_serial = t_item.o_order_serial
		left join mmart_uriba.valeur_m_data_dat as t_vdata on t_item.ai_serial = t_vdata.m_data_dat_ai_serial
		left join mmart.order_mail_flg_manage as t_manager on t_manager.order_mail_serial = t1.order_mail_serial
		WHERE t_vdata.m_id=%1$s AND t_order.urite_shamei="バルル" AND t1.mail_to_type = "seller";'
		,$this->c_dbi->DB_qq($S_id)
		);
		// $sql=sprintf('SELECT t1.*, t_order.order_time as time, t_order.kaite_shamei as kaite_mei, t_item.ai_serial
		// FROM `mmart`.`mmart_kakuninmail_log` as t1
		// inner join dami2.order_dat_m as t_order on t_order.order_serial = t1.order_serial
		// left join dami2.order_item_m as t_item on t_order.order_serial = t_item.o_order_serial
		// left join mmart_uriba.valeur_m_data_dat as t_vdata on t_item.ai_serial = t_vdata.m_data_dat_ai_serial
		// WHERE t_vdata.m_id=%1$s AND t_order.urite_shamei="バルル" AND t1.mail_to_type = 2;'
		// ,$this->c_dbi->DB_qq($S_id)
		// );
		// test
		// $sql=sprintf('SELECT t1.*, t_order.order_time as time, t_order.kaite_shamei as kaite_mei, t_item.ai_serial
		// FROM `mmart`.`mmart_kakuninmail_log` as t1
		// left join dami2.order_dat_m as t_order on t_order.order_serial = t1.order_serial
		// left join dami2.order_item_m as t_item on t_order.order_serial = t_item.o_order_serial
		// left join mmart_uriba.valeur_m_data_dat as t_vdata on t_item.ai_serial = t_vdata.m_data_dat_ai_serial
		// WHERE t1.order_serial in (3270939,3270219,3269721) AND t1.mail_to_type = 2;'
		// ,$this->c_dbi->DB_qq($S_id)
		// );

        // dump($sql);exit;
		mysqli_set_charset($this->c_dbi->G_DB, "utf8");
		$res = $this->c_dbi->DB_exec($sql);

		!$res && die('取得エラー'. $this->c_dbi->err());
		$ret_arr['unread'] = [];
		$ret_arr['readed'] = [];
		$ret_arr['deleted'] = [];
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			if(empty($row["read_flg"]) || ($row["read_flg"] == 0)){
				$ret_arr['unread'][$row["order_mail_serial"]]=$row;
			}
			if(isset($row["read_flg"]) && $row["read_flg"] == 1 && $row["del_flg"] == 0){
				$ret_arr['readed'][]=$row;
			}
			if(isset($row["del_flg"]) && $row["del_flg"] == 1){
				$ret_arr['deleted'][]=$row;
			}
		}
		// dump($ret_arr);
		return $ret_arr;
	}
	// function seller_sendmail($data){
	// 	$ret_arr=[];
	// 	$this->c_dbi->DB_on("dami2");
  
	// 	$sql=sprintf('INSERT INTO `order_mail`(
	// 		`ichiba_name`,
	// 		`table_name`,
	// 		`order_serial`,
	// 		`order_serial_tmp`,
	// 		`mail_to_type`,
	// 		`frm_name`,
	// 		`frm_add`,
	// 		`to_add`,
	// 		`subject`,
	// 		`honbun`
	// 	)
	// 	VALUES(
	// 		"mmart"
	// 		, "order_dat_m"
	// 		, %1$d
	// 		, 0
	// 		, "buyer"
	// 		, %2$s
	// 		, %3$s
	// 		, %4$s
	// 		, %5$s
	// 		, %6$s
	// 	);'
	// 	,$this->c_dbi->DB_q($data["order_serial"])
	// 	,$this->c_dbi->DB_qq($data["frm_name"])
	// 	,$this->c_dbi->DB_qq($data["frm_add"])
	// 	,$this->c_dbi->DB_qq($data["to_add"])
	// 	,$this->c_dbi->DB_qq($data["subject"])
	// 	,$this->c_dbi->DB_qq($data["honbun"])
	// 	);
    //     // dump($sql);exit;
	// 	mysqli_set_charset($this->c_dbi->G_DB, "utf8");
	// 	$res = $this->c_dbi->DB_exec($sql);

	// 	!$res && die('エラー'. $this->c_dbi->err());
	// 	$cnt = 0;
	// 	// while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
	// 	// 	$cnt++;
	// 	// 	$row["cnt"]=$cnt;
	// 	// 	$ret_arr[]=$row;
	// 	// }
	// 	// dump($ret_arr);
	// 	return $res;
	// }
	function update_readed_mail($order_mail_serial){
		$ret_arr=[];
		$this->c_dbi->DB_on("mmart");
		$update = "";

		switch ($action) {
			case 'read_mail':
				$update = "read_flg = 1";
				break;
			case 'delete_mail':
				$update = "del_flg = 1";
				break;
			case 'save_mail':
				$update = "save_flg = 1";
				break;
			default:
				break;
		}

		$sql=sprintf('INSERT INTO `order_mail_flg_manage`(
			`order_mail_serial`,
			`read_flg`,
			`del_flg`,
			`save_flg`,
			`modified`,
			`created`)
		VALUES( %1$d, 1, 0, 0, NOW(), NOW()) ON DUPLICATE KEY UPDATE read_flg=1;'
		,$this->c_dbi->DB_q($order_mail_serial)
		);
        // dump($sql);exit;
		mysqli_set_charset($this->c_dbi->G_DB, "utf8");
		$res = $this->c_dbi->DB_exec($sql);

		!$res && die('エラー'. $this->c_dbi->err());

		return $res;
	}
	function update_delete_mail($order_mail_serial){
		$ret_arr=[];
		$this->c_dbi->DB_on("mmart");

		$sql=sprintf('INSERT INTO `order_mail_flg_manage`(
			`order_mail_serial`,
			`read_flg`,
			`del_flg`,
			`save_flg`,
			`modified`,
			`created`)
		VALUES( %1$d, 1, 1, 0, NOW(), NOW()) ON DUPLICATE KEY UPDATE read_flg=1, del_flg=1;'
		,$this->c_dbi->DB_q($order_mail_serial)
		);
        // dump($sql);exit;
		mysqli_set_charset($this->c_dbi->G_DB, "utf8");
		$res = $this->c_dbi->DB_exec($sql);

		!$res && die('エラー'. $this->c_dbi->err());

		return $res;
	}
}