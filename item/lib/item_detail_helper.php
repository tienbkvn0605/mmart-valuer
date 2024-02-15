<?php
/**
 * バルルの詳細画面対応
 * 
 * 2024-02-09   新規作成    ダット
 */

require_once('/var/php_class/class_dbi.php');


class ItemDetailHelper
{
    private $c_dbi;
    public function __construct()
    {
        $this->c_dbi = new G_class_dbi;
    }

    /**
     * DBの設定を実行する
     *
     * @param string $db_name
     * @param string $charset
     * @return void
     */
    protected function set_db_config($db_name = 'dami2', $charset = 'utf8'){
        $this->c_dbi->DB_on($db_name);
        mysqli_set_charset($this->c_dbi->G_DB, $utf8);
    }

    /**
     * 商品詳細情報を取得する
     *
     * @param string $id
     * @param int $num
     * @return array
     */
    function get_item_card_type($id, $num)
    {
        $this->c_dbi->DB_on("dami2");
        mysqli_set_charset($this->c_dbi->G_DB, "utf8mb4");
        $sql = sprintf('SELECT T_i.*
                        , CASE WHEN TB_card.card_type = \'3\' THEN \'VM_JCB\'
                            WHEN TB_card.card_type = \'2\' THEN \'JCB\'
                            WHEN TB_card.TenantId != \'\' AND TB_card.credit_stop_flg = 0 AND TB_card.credit_date <= CURDATE() THEN \'VM\'
                            ELSE \'\'
                        END AS card_type
                        , t4.contents
                        FROM dami2.m_data_dat as T_i
                        LEFT JOIN dami2.seller_master AS t3 ON t3.id=T_i.m_id AND t3.site=\'m\'
                        LEFT JOIN dami2.seller_mmart AS T_s ON T_i.m_id=T_s.m_id
                        LEFT JOIN dami2.card_seller AS TB_card ON T_i.m_id = TB_card.id 
                            AND TB_card.card_type > 0
                            AND TB_card.credit_flg = 1
                            AND TB_card.moto_flg = \'m\'
                        INNER JOIN mmart_uriba.valeur_m_data_dat AS item_valeur ON item_valeur.m_data_dat_ai_serial = T_i.ai_serial AND item_valeur.del_flg = 0
                        LEFT JOIN dami2.item_wysiwyg as t4 ON t4.item_serial = item_valeur.ai_serial AND t4.site_id = 1 AND t4.del_flg = 0
                        WHERE 
                        T_i.m_id = %1$s AND
                        T_i.m_serial = %2$s AND
                        ((T_i.m_disp_limit is null) OR (T_i.m_disp_limit > now()));'
                        ,$this->c_dbi->DB_qq($id)
                        ,$this->c_dbi->DB_qq($num)
        );
        $res = $this->c_dbi->DB_exec($sql);

        $this->c_dbi->DB_off();

        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        if(empty($row)){
            return null;
        }

        $row['order_point'] = 0;


        // 商品画像の配列を作成する
        $row['imgs'] = [];

        for($i = 1; $i <= 6; $i++){
            if($row['m_pic'.$i]){
                $row["imgs"][] = DF_valeur_img_path . $row['m_pic'.$i];
            }
        }
        if($row['m_pic_eiyo']){
            $row["imgs"][] = DF_valeur_img_path . $row['m_pic_eiyo'];
        }

        // 産地・加工地	
        list($row['m_sanchi'],  $row['m_kakouchi']) = explode('-', $row['m_sanchi']);

        if($row['m_size']){
            $lot_weight = '約'.$row['m_lot_weight'].'kg';	
	
            if($row['m_lot_weight'] != 0 && !empty($row['m_lot_weight'])){	
                $row['disp_size_weight'] = $lot_weight.'<br>'.$row['m_size'];				
            }else{
                $row['disp_size_weight'] = $row['m_size'];
            }
        }
        return $row;
    }


    /**
     * バルルのIDを取得する
     *
     * @param string $id
     * @param int $num
     * @return array
     */
    function get_id_valeur($id, $num)
    {
        $this->c_dbi->DB_on("dami2");
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");

        $sql=sprintf('SELECT
                t_data.m_id as valuer_id,
                t_soryo.soryo_master_serial as soryo_master_serial
            FROM
                dami2.m_data_dat AS t_mdata
            INNER JOIN mmart_uriba.valeur_m_data_dat AS t_data ON t_mdata.ai_serial = t_data.m_data_dat_ai_serial
            LEFT JOIN mmart_uriba.valeur_item_soryo AS t_soryo
            ON
                t_data.ai_serial = t_soryo.ai_serial
            WHERe
                t_mdata.m_id = %1$s AND t_mdata.m_serial = %2$d', 
            $this->c_dbi->DB_qq($id), 
            $this->c_dbi->DB_q($num)
        );

        $res=$this->c_dbi->DB_exec($sql);
        
        $this->c_dbi->DB_off();

        if(!$res){
            return null;
        }

        return mysqli_fetch_array($res,MYSQLI_ASSOC);
    }

    /**
     * SNS共有ボタンを取得する
     *
     * @param string $m_id
     * @return array
     */
    function get_sns_button_info($item)
    {
        require_once('/var/php_class/class_db.php');
        $c_db = new G_class_db;

        require_once("/var/php_class/class_social_button.php");
        $sns = new social_button();

        $sns->charge_opt = true; // 有料枠
        $sns->encoding = 'Shift_JIS';
        $sns->text = $item['m_id']."\n" ; // twitter
        $sns->hashtag = 'Mマート';
        $sns->site_name = '業務用食材卸売市場 Mマート';
        //SNS共有ボタン申込確認
        require_once("/var/php_class/class_option_sns.php");
        $c_sns_apply = new G_class_option_sns_apply($c_db);
        $sns->validity_period = $c_sns_apply->is_showable('m', $item['m_id']); // seller_id
        //SNS共有ボタン用HTML
        $img_sns_url = 'https://'.$_SERVER['HTTP_HOST'].'/' . $item['m_id'] . '/ireg/tmp/' . $item['m_pic1'];
        $H_sns_header   = $sns->make_ogp_header($item['m_item'], $item['m_setsumei'], $img_sns_url);    // facebook
        $H_sns_bodyhead = $sns->make_fb_header();
        $H_sns_button   = $sns->make_tags();
        if($H_sns_button!=''){
            $H_sns_button = '<div>'.$H_sns_button.'</div>';
        }

        return [
            "body_head"     => $H_sns_bodyhead,
            "header"        => $H_sns_header,
            "sns_button"    => $H_sns_button
        ];
    }

    /**
     * バルルの送料データを取得する
     *
     * @param string    $valeur_id
     * @param int       $soryo_master_serial
     * @return array
     */
    public function get_valeur_soryo_info($valeur_id, $soryo_master_serial)
    {
        $this->c_dbi->DB_on("dami2");
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res_arr = [];
       
        $sql = sprintf('SELECT t1.*
                FROM mmart_uriba.valeur_soryo_table AS t1
                WHERE t1.valeur_id = %1$s AND t1.soryo_master_serial = %2$s AND t1.del_flg = 0;'
                , $this->c_dbi->DB_qq($valeur_id)
                , $this->c_dbi->DB_qq($soryo_master_serial)
            );
        $res = $this->c_dbi->DB_exec($sql);
        
        !$res && die('配送料表情報取得エラー:');
        while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
            $res_arr["valeur_coname"] = $row['valeur_coname'];
            $res_arr["valeur_item"] = $row['m_item'];
            $res_arr[$row['soryo_master_serial']]['soryo_name'] = $row['soryo_name'];
            $res_arr[$row['soryo_master_serial']]['valeur_id'] = $row['valeur_id'];
            $res_arr[$row['soryo_master_serial']]['soryo_table'][] = [
                'region_label' => $row['region_label'],
                'pref' => $row['pref'],
                'size' => $row['size'],
                'weight' => $row['weight'],
                'fee' => $row['fee'],
                'region_serial' => $row['region_serial'],
            ];

        }
        
        return $res_arr;
    }

    /**
     * 地方区分情報取得
     *
     * @return void
     */
    public function get_region_master()
    {        
        $rtn_arr=array();
        
        $this->c_dbi->DB_on('mmart_tools');
        $sql = 'SELECT serial, region, pref
                FROM mmart_tools.seller_delivery_region_master
                WHERE del_flg = 0;';
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        
        !$res && die('地方区分情報取得エラー:');
        while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
            $rtn_arr[$row['serial']]['region']=$row['region'];
            $rtn_arr[$row['serial']]['pref']=explode(',',$row['pref']);
        }
        
        return $rtn_arr;
    }

    /**
     * 商品カテゴリーを取得する
     *
     * @param string $m_id
     * @param int    $m_serial
     * @return array
     */
    public function get_item_categories($m_id, $m_serial)
    {
        $this->c_dbi->DB_on("dami2");
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $ret_arr=array('id'=>array(), 'name'=>array());

        $this->c_dbi->DB_on("dami2");
        $sql = sprintf('SELECT CONCAT(c3.c_serial1, \'<>\', c1.c_cate1)
                            , CONCAT(c3.c_serial2, \'<>\', c2.c_cate2)
                            , CONCAT(c3.c_serial3, \'<>\', c3.c_cate3)
                            , CONCAT(c4.c_serial4, \'<>\', c4.c_cate4)
                        FROM dami2.m_data_dat AS d
                        LEFT JOIN m_cate3 AS c3 ON c3.c_search3 = d.m_cate_m
                        LEFT JOIN m_cate2 AS c2 ON c2.c_serial1 = c3.c_serial1 AND c2.c_serial2 = c3.c_serial2
                        LEFT JOIN m_cate1 AS c1 ON c1.c_serial1 = c3.c_serial1
                        LEFT JOIN m_cate4 AS c4 ON c4.c_search4 = d.m_cate_m2 AND c3.c_serial1 = c4.c_serial1 AND c3.c_serial2 = c4.c_serial2 AND c3.c_serial3 = c4.c_serial3
                        WHERE m_id = %s AND m_serial = %d
                        LIMIT 1'
                        , $this->c_dbi->DB_qq($m_id),$this->c_dbi->DB_q($m_serial));
        $res = $this->c_dbi->DB_exec($sql);
        $this->c_dbi->DB_off();
        !$res && die('カテゴリ情報取得エラー:');	//セレクト失敗
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        if (is_array($row)) {
            foreach ($row as $key => $value) {
                if ($value == NULL) break; // シリアルもしくはカテゴリ名がNULLだと$valueはNULLになる
                list($ret_arr['id'][$key], $ret_arr['name'][$key]) = explode('<>', $value);
            }
        }

        return $ret_arr;
    }

    /**
     * カロリー成分表取得
     * 
     * @param int   $num 
     * @param string $id 
     * @return array 
     */
    public function get_kcal($num, $id)
    {
        // Initialize the return array
        $ret_arr = array();

        // Connect to the database
        $this->c_dbi->DB_on('dami2');
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");

        // Construct the SQL query
        $sql = sprintf('select TB_kcal.c_energy,TB_kcal.c_suibun,TB_kcal.c_tanpaku,TB_kcal.c_shishitsu
                        ,TB_kcal.c_tansui,TB_kcal.c_kaibun,TB_kcal.c_na,TB_kcal.c_k,TB_kcal.c_ca,TB_kcal.c_mg
                        ,TB_kcal.c_p,TB_kcal.c_fe,TB_kcal.c_zn,TB_kcal.c_lechi,TB_kcal.c_kalo,TB_kcal.c_b1,TB_kcal.c_b2
                        ,TB_kcal.c_c,TB_kcal.c_seni,TB_kcal.c_shokuen
                        from dami2.m_data_dat as TB_items
                        inner join dami2.m_cate3 as TB_cate3 on TB_items.m_cate_m = TB_cate3.c_search3
                        inner join tools_db.m_item_hanyou as TB_kcal on TB_items.ai_serial = TB_kcal.ai_serial
                        where TB_items.m_id like %s && TB_items.m_serial = %s && TB_cate3.c_serial1 = 9;'
                        ,$this->c_dbi->DB_qq($id)
                        ,$this->c_dbi->DB_qq($num));

        // Execute the SQL query
        $res = $this->c_dbi->DB_exec($sql);

        // Disconnect from the database
        $this->c_dbi->DB_off();

        // Handle errors
        !$res && die('カロリー市場情報取得エラー');

        // Fetch and return the result
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        return $row;
    }

    /**
     * 商品アクセスログ記録
     * 
     * @param int    $no        商品No
     * @param string $seller_id 出店社ID
     * @param string $uriba     売り場No
     * @param string $page      ページNo
     * @param string $item      商品名
     * @param string $banner    バナーカウントカラム名
     * 
     * @return void
     */
    function set_page_access_log($no, $seller_id, $uriba, $page, $item, $banner)
    {
         //バナー経由時
         $this->c_dbi->DB_on('dami2');
         $bana1='';
         $bana2='';
         $bana3='';
         if($f_banar){
             $bana1=sprintf(',%s',$banner);
             $bana2=',1';
             $bana3=sprintf(',%1$s=%1$s+1',$banner);
         }
         $sql=sprintf('INSERT INTO %1$s(`l_date` ,`l_id` ,`l_item_serial` ,`l_uriba`,`l_page`,`l_item`%2$s) VALUES (\'%10$s\',\'%3$s\',%4$d,%5$d,%6$d,%7$s%8$s) ON DUPLICATE KEY UPDATE l_cnt=l_cnt+1%9$s;'
             , 'log.page_access_log', $bana1
             , $seller_id , $no, $uriba, $page 
             , $this->c_dbi->DB_qq($item), $bana2
             , $bana3
             , date('Y-m-d H:i:s')
         );
         $this->c_dbi->DB_off('dami2');
         
         error_log($sql."\n", 3, '/tmp/page_access_log.sql');
    }

     /**
     * 商品アクセスログ記録(２０１８年から)
     * 
     * @param int    $no        商品No
     * @param string $seller_id 出店社ID
     * @param string $uriba     売り場No
     * @param string $page      ページNo
     * @param string $item      商品名
     * @param string $banner    バナーカウントカラム名
     * 
     * @return void
     */
    function set_page_access_log_since2018($no, $seller_id, $uriba, $page, $item, $banner)
    {
        //バナー経由時
        $this->c_dbi->DB_on('dami2');
		$bana1='';
		$bana2='';
		$bana3='';
		if($f_banar){
			$bana1=sprintf(',%s',$banner);
			$bana2=',1';
			$bana3=sprintf(',%1$s=%1$s+1',$banner);
		}
        $sql=sprintf('INSERT INTO %1$s(`l_date` ,`l_id` ,`l_item_serial` ,`l_uriba`,`l_page`,`l_item`%2$s) VALUES (\'%10$s\',\'%3$s\',%4$d,%5$d,%6$d,%7$s%8$s) ON DUPLICATE KEY UPDATE l_cnt=l_cnt+1%9$s;'
            , 'log.page_access_log_since2018', $bana1
            , $seller_id , $no, $uriba, $page 
            , $this->c_dbi->DB_qq($item), $bana2
            , $bana3
            , date('Y-m-d H:i:s')
        );
        $this->c_dbi->DB_off('dami2');
        
        error_log($sql."\n", 3, '/tmp/page_access_log_since2018.sql');
    }

    public function get_vacation_info($seller_id)
    {
        $this->c_dbi->DB_on('dami2');
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        
        $sql=sprintf('select title,
                    if(char_length(message)>' . $kyugyo_max . ', concat(left(message,' . $kyugyo_max . '),\'...\'), message) as v_message,
                    char_length(message) as ln_message from dami2.m_vacation where m_id=%s'
                    , $c_db->DB_qq($f_m_id));
        $res=mysql_query($sql,$c_db->G_DB);
        $c_db->DB_off();
        !$res && die('長期休業情報取得エラー');
        if($row=mysql_fetch_array($res,MYSQL_ASSOC)){

            $t_message=$row['v_message'];
            if($row['ln_message'] > $kyugyo_max){
                $t_message=$t_message.'<a href="../sup/top.php?id='.$f_m_id.'#topics" target="_blank">(続きを表示)</a><br />';
            }
            $t_message = nl2br($t_message);

            $vacation_info='<br />------------------------------<br />'
                            .'<span style="color:#ff0000;">'
                            .$row['title'].'</span><br />'.$t_message;

            return $vacation_info;
        }else{
            return '';
        }
    }

    public function shubetsu_get($no, $s_id)
    {
        
    }
}


