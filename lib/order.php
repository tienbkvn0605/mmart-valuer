<?php
/**
* 受注情報に関するクラス
* 2024-01-22       【開1-23-0021】バルル委託販売機能作成
*/

require_once('/var/php_class/class_dbi.php');

class Order {
	//グローバル変数
	protected $item_serial;
	protected $seller_id;
	protected $input_session_name = 'outlet_katte_item_reg';
	protected $input;
	protected $table_arr = [
		// 'm_cate1' => 'dami2.m_cate1'
		// ,'m_cate2' => 'dami2.m_cate2'
		// ,'m_cate3' => 'dami2.m_cate3'
		// ,'m_cate4' => 'dami2.m_cate4'
		// ,'m_data_dat' => 'dami2.m_data_dat'                            // Mマート商品情報
		// ,'valeur_m_data_dat' => 'mmart_uriba.valeur_m_data_dat'
		// ,'valeur_m_item_hanyou' => 'mmart_uriba.valeur_m_item_hanyou'  //
		// ,'valeur_item_holiday' => 'mmart_uriba.valeur_item_holiday'    // 商品ごとに休業日設定情報
		// ,'valeur_holiday_table' => 'mmart_uriba.valeur_holiday_table'  // 休業日設定表情報
		// ,'valeur_item_soryo' => 'mmart_uriba.valeur_item_soryo'       // 商品ごとに送料設定情報
		// ,'m_item_hanyou' => 'tools_db.m_item_hanyou'                  // Mマート商品ごとに送料設定情報
		// ,'valeur_soryo_table' => 'mmart_uriba.valeur_soryo_table'     // 送料設定表情報
		'valeur_seller_outlet' => 'mmart_uriba.valeur_seller_outlet'  // バルル出品社情報
		,'order_dat_m' => 'dami2.order_dat_m'//地方区分情報
		,'order_item_m' => 'dami2.order_item_m'//地方区分情報
		,'m_data_dat' => 'dami2.m_data_dat'//地方区分情報
		,'order_kakunin_mail'	=> 'dami2.order_dat_m_kakunin_mail'	//“確認メール、order_dat_m用”
	];
	protected $db_name = 'mmart_uriba';
	protected $valeur_id = 'valeur';
	private $c_dbi;
	public function __construct(){
		$this->c_dbi = new G_class_dbi;
	}

	/**
	 * 受注情報取得
	 *
	 * @param [type] $S_id	出品社ID 
	 * @return void
	 */
	function get_all_order($S_id){
		$ret_arr=[];
		$this->c_dbi->DB_on($this->db_name);
  
		$sql=sprintf('SELECT
			t1.order_serial, juchubi, kaite_shamei, shouhin,
			CASE WHEN t2.change_before_kingaku IS NOT NULL THEN
				t2.change_before_kingaku
			ELSE
				kingaku
			END AS kingaku,
			urite_shamei, ken, t1.gyoushu, SUBSTRING_INDEX(chumon,"/",1) AS chumon,
			kaiin, t1.mail, category, kaite_name, tanka, suryou,
			ifnull(t2.kakunin_mail_send_time, mail_kakunin) AS mail_kakunin,
			mail_pre_kakunin,
			ifnull(t2.hassou_mail_send_time, mail_hassou) AS mail_hassou,
			order_time, zip, address, t1.tel, comment,
			order_point_use, order_point_get, order_payment_type, card_kakunin_flg,
			CASE WHEN t2.change_before_kingaku IS NOT NULL THEN
				kingaku
			ELSE
				\'\'
			END AS futei_kingaku,
			t2.cancel_shinsei_datetime AS cancel_shinsei_datetime
			,t2.paid_date AS paid_date,\'m\' AS o_site
			,tb4.m_tel AS urite_tel,CONCAT(tb3.zip1,tb3.zip2) AS urite_zip,tb4.m_add AS urite_add
			FROM `dami2`.`order_data_m` AS t1
			LEFT JOIN dami2.order_dat_m_hanyou AS t2 ON t1.order_serial = t2.order_serial
			LEFT JOIN dami2.seller_master AS tb3 ON t1.m_seller_id = tb3.id AND tb3.site=\'m\' AND tb3.id = %1$s
			LEFT JOIN %8$s AS tb4 ON t1.m_seller_id = tb4.m_id
			WHERE m_seller_id=%2$s 
			AND CASE WHEN t2.drop_list_time IS NOT NULL THEN
				CASE WHEN t2.drop_list_time >= NOW() THEN 1
				ELSE 0
				END
			ELSE 1 END 
			AND
			/*メール確認ステータスカラムが、キャンセルでないデータ。2017/02/15以前 */
			CASE WHEN t1.mail_kakunin IS NOT NULL THEN
				CASE WHEN t1.mail_kakunin = \'キャンセル\' THEN 0 
				ELSE 1
				END
			ELSE 1 END'
		,$this->c_dbi->DB_qq($this->valeur_id)
		,$this->c_dbi->DB_qq($S_id)
		);
		// dump($sql);exit;
		$sql=sprintf('SELECT * FROM `dami2`.`order_dat_m` as t_order
		LEFT JOIN `dami2`.`order_item_m` as t_item ON t_order.order_serial = t_item.o_order_serial
		WHERE `m_seller_id` = "shokun" limit 100;'
		);
		mysqli_set_charset($this->c_dbi->G_DB, "utf8");
		$res = $this->c_dbi->DB_exec($sql);

		!$res && die('第四カテゴリ取得エラー'. $this->c_dbi->err());
		$cnt = 0;
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$cnt++;
			$row["cnt"]=$cnt;
			$ret_arr[]=$row;
		}
		// dump($ret_arr);
		return $ret_arr;
	}
	/**
	 * 受注情報取得
	 *
	 * @param array $post
	 * @return array
	 */
	function get_one_order($post){
		$ret_arr=[];
		$this->c_dbi->DB_on("dami2");
  
		$sql=sprintf('SELECT t1.*, t2.*, t3.*, t4.*, t4.valeur_tantou FROM `order_dat_m` as t1
		left join dami2.order_item_m as t2 on t1.order_serial = t2.o_order_serial
		left join mmart_uriba.valeur_m_data_dat as t3 on t2.ai_serial = t3.m_data_dat_ai_serial
		left join mmart_uriba.valeur_seller_outlet as t4 on t3.m_id = t4.valeur_id
		WHERE `order_serial` = %1$d;'
		,$this->c_dbi->DB_q($post["order_serial"])
		);
		// $sql=sprintf('SELECT t1.*, t2.* FROM `order_dat_m` as t1
		// left join dami2.order_item_m as t2 on t1.order_serial = t2.o_order_serial
		// WHERE `order_serial` = %1$d;'
		// ,$this->c_dbi->DB_q($post["order_serial"])
		// );
		// dump($sql);exit;
		mysqli_set_charset($this->c_dbi->G_DB, 'utf8');
		$res = $this->c_dbi->DB_exec($sql);

		!$res && die('エラー'. $this->c_dbi->err());
		$cnt = 0;
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$ret_arr[]=$row;
		}
		$ret_arr = $ret_arr[0];
		// dump($ret_arr);
		return $ret_arr;
	}

	function F_setmail_info($post){
		$ret_arr=[];
		$this->c_dbi->DB_on("dami2");
  
		$sql=sprintf('INSERT INTO `dami2`.`order_dat_m_kakunin_mail`(
			`from_who`,
			`order_serial`,
			`syohin`,
			`kingaku_edited`,
			`soryo`,
			`total_kingaku`,
			`hasso_date`,
			`totyaku_date`,
			`takuhai_gyosya_name`,
			`denpyo_number`,
			`bin_type`,
			`takuhai_url`,
			`comment_mail`,
			`mail_kakunin_datetime`,
			`created_datetime`
		)
		VALUES(
			"s", %1$d, %2$s, %3$d, %4$s, %5$d, %6$s, %7$s, %8$s, %9$s, %10$s, %11$s, %12$s, NOW(), NOW()

		);'
		,$this->c_dbi->DB_q($post["order_serial"])
		,$this->c_dbi->DB_qq($post["syohin"])
		,$this->c_dbi->DB_q($post["kingaku_edited"])
		,$this->c_dbi->DB_q($post["soryo"])
		,$this->c_dbi->DB_q($post["kingaku_edited"] + $post["soryo"])
		,$this->c_dbi->DB_qq($post["hasso_date"])
		,$this->c_dbi->DB_qq($post["totyaku_date"])
		,$this->c_dbi->DB_qq($post["takuhai_gyosya_name"])
		,$this->c_dbi->DB_qq($post["denpyo_number"])
		,$this->c_dbi->DB_qq($post["bin_type"]) //10
		,$this->c_dbi->DB_qq($post["takuhai_url"])
		,$this->c_dbi->DB_qq($post["comment_mail"])
		);
		// dump($sql);exit;
		// mysqli_set_charset($this->c_dbi->G_DB, "utf8");
		$res = $this->c_dbi->DB_exec($sql);

		!$res && die('第四カテゴリ取得エラー'. $this->c_dbi->err());
		$cnt = 0;
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$cnt++;
			$row["cnt"]=$cnt;
			$ret_arr[]=$row;
		}
		// dump($ret_arr);
		return $ret_arr;
	}
	/**
	 * 売手の銀行情報取得
	 *
	 * @param array $post
	 * @return array
	 */
	function get_seller_bank($S_id){
		$ret_arr=NULL;
		$this->c_dbi->DB_on("mmart_uriba");
  
		$sql=sprintf('SELECT * FROM `valeur_seller_bank`
		WHERE `valeur_id` = %1$s;'
		,$this->c_dbi->DB_qq($S_id)
		);
		// dump($sql);exit;
		mysqli_set_charset($this->c_dbi->G_DB, 'utf8');
		$res = $this->c_dbi->DB_exec($sql);

		!$res && die('エラー'. $this->c_dbi->err());
		$cnt = 0;
		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
			$ret_arr=$row["bank_info"];
		}
		return $ret_arr;
	}
}