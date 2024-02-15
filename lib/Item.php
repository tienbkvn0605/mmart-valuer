<?php
/**
* 商品に関するクラス
* 2024-01-22   ナム    【開1-23-0021】バルル委託販売機能作成
*/


 require_once('/var/php_class/class_dbi.php');

class Item {
    
    //グローバル変数
    protected $item_serial;
    protected $seller_id;
    protected $input_session_name = 'outlet_katte_item_reg';
    protected $input;
    protected $table_arr = [
        'm_cate1' => 'dami2.m_cate1'
        ,'m_cate2' => 'dami2.m_cate2'
        ,'m_cate3' => 'dami2.m_cate3'
        ,'m_cate4' => 'dami2.m_cate4'
        ,'m_data_dat' => 'dami2.m_data_dat'                            // Mマート商品情報
        ,'valeur_m_data_dat' => 'mmart_uriba.valeur_m_data_dat'
        ,'valeur_m_item_hanyou' => 'mmart_uriba.valeur_m_item_hanyou'  //
        ,'valeur_item_holiday' => 'mmart_uriba.valeur_item_holiday'    // 商品ごとに休業日設定情報
        ,'valeur_holiday_table' => 'mmart_uriba.valeur_holiday_table'  // 休業日設定表情報
        ,'valeur_item_soryo' => 'mmart_uriba.valeur_item_soryo'       // 商品ごとに送料設定情報
        ,'m_item_hanyou' => 'tools_db.m_item_hanyou'                  // Mマート商品ごとに送料設定情報
        ,'valeur_soryo_table' => 'mmart_uriba.valeur_soryo_table'     // 送料設定表情報
        ,'valeur_seller_outlet' => 'mmart_uriba.valeur_seller_outlet'  // バルル出品社情報
        ,'region_master' => 'mmart_tools.seller_delivery_region_master'//地方区分情報
    ];
    protected $db_name = 'mmart_uriba';
    private $c_dbi;
    public function __construct(){
        $this->c_dbi = new G_class_dbi;
    }

    public function ss_save($data):bool {
        $save_flg = false;
        // セッションチェック
        $_SESSION[$this->input_session_name] = $data;
        if(isset($_SESSION[$this->input_session_name])){
            $this->input = $data;
            return true;
        }else{
            return false;
        }
    }

    public function ss_clear():bool {
        $clear_flg = false;
        // セッションにデータがあれば
        if(isset($_SESSION[$this->input_session_name])){
            $this->input = [];
            unset($_SESSION[$this->input_session_name]);
            $clear_flg = true;
        }
        return $clear_flg;
    }

    //------------------------------------------------------------------------バルル商品登録機能
    /*****************************
    新規商品情報登録

    新規登録商品情報を登録

    引数	$f_pic	=	画像ファイル名
            $f_id	=	出店社id名
            $f_post	=	ポスト値配列
            $f_catekey=	カテゴリキー
            $f_catekey4=カテゴリキー4
            $f_catekey5=カテゴリキー5

    戻り値　登録シリアル(ai_serial)
    ******************************/
    function set_item_new_valeur($f_id,$f_post){
        $ret_serial=0;
        
        $this->c_dbi->DB_on($this->db_name);
        //シリアル番号最大値
        $sql = sprintf('SELECT max(m_serial) AS max FROM %s WHERE m_id=%s;'
            ,$this->table_arr['valeur_m_data_dat']
            ,$this->c_dbi->DB_q($f_id)
        );
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(('商品情報取得エラー:1'));
        $row = mysqli_fetch_array($res,MYSQLI_ASSOC);

        $m_serial = $row['max']+1;

        //商品順番最大値
        $sql=sprintf('SELECT max(m_order) AS max FROM %s WHERE m_id=%s;'
            ,$this->table_arr['valeur_m_data_dat']
            ,$this->c_dbi->DB_q($f_id)
        );
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(('商品情報取得エラー:2'));
        $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
        $m_order = $row['max']+1;
       
        //商品情報格納
        //単位
        $t_tani_kind=$f_post['tani1'];
        $t_tani_num='';
        $t_tani_ex='';
        if($f_post['tani2']){
            $t_tani_num=$f_post['tani2'];
        }
        if($f_post['tani3']){
            $t_tani_ex=sprintf('(%1$s)',$f_post['tani3']);
        }
        $t_tani=sprintf('%1$s%2$s%3$s',$t_tani_num,$t_tani_kind,$t_tani_ex);
        //産地
        $t_santi=sprintf('%s'.DF_sanchi_sep.'%s',$f_post['sanchi'],$f_post['kakouchi']);
        //詳しい説明
        $f_post['setsumei']=str_replace("\r\n",'<br>',$f_post['setsumei']);

        $t_koukai=1;	//公開
        
        //在庫数
        // 在庫表示のチェックボックスにチェックを入れ、かつ在庫数を0以上で入力していた場合のみ表示
        $m_zaiko_disp_flg = 0;
        $t_m_zaiko = 'NULL';
        $t_m_item_total_weight = 'NULL';
        
        if( (isset($f_post['zaiko_disp_flg']) && $f_post['zaiko_disp_flg'] == 'on') && $f_post['zaiko'] > 0){
            $m_zaiko_disp_flg = 1;
            $t_m_zaiko=$f_post['zaiko'];
            $t_m_item_total_weight = $f_post['total_weight'];
        }
       
        //掲載期限
        $t_m_disp_limit=@$f_post['m_disp_limit_y'].'/'.@$f_post['m_disp_limit_m'].'/'.@$f_post['m_disp_limit_d'].' '.@$f_post['m_disp_limit_h'].':00:00';
        if(@$f_post['m_disp_limit_y']=='' || @$f_post['m_disp_limit_m']=='' || @$f_post['m_disp_limit_d']=='' || @$f_post['m_disp_limit_h']==''){
            $t_m_disp_limit='NULL';
        }

        $f_pic1 = (isset($f_post['new_pic']) && $f_post['new_pic'] != '') ? ($f_post['new_pic']) : 'NULL';
        $f_pic2 = (isset($f_post['new_pic2']) && $f_post['new_pic2'] != '') ? ($f_post['new_pic2']) : 'NULL';
        $f_pic3 = (isset($f_post['new_pic3']) && $f_post['new_pic3'] != '') ? ($f_post['new_pic3']) : 'NULL';
        $f_pic4 = (isset($f_post['new_pic4']) && $f_post['new_pic4'] != '') ? ($f_post['new_pic4']) : 'NULL';
        $f_pic5 = (isset($f_post['new_pic5']) && $f_post['new_pic5'] != '') ? ($f_post['new_pic5']) : 'NULL';
        $f_pic6 = (isset($f_post['new_pic6']) && $f_post['new_pic6'] != '') ? ($f_post['new_pic6']) : 'NULL';
        $f_pic7 = (isset($f_post['new_pic7']) && $f_post['new_pic7'] != '') ? ($f_post['new_pic7']) : 'NULL';
       
        
        $cate3_arr_all = $this->get_cate3_all();

        if($f_post['cate1no'] && $f_post['cate2no'] && $f_post['cate3no']){
            $f_cate3 = $cate3_arr_all[$f_post['cate1no']][$f_post['cate2no']][$f_post['cate3no']];

            if(isset($f_post['cate4no']) && $f_post['cate4no'] != 0){
                $cate4_arr_all = $this->get_cate4_all();
                $f_cate4 = $cate4_arr_all[$f_post['cate1no']][$f_post['cate2no']][$f_post['cate3no']][$f_post['cate4no']];
                
            }
        }
        $f_cate4_text = isset($f_cate4['c_search4']) ? $f_cate4['c_search4']: '';
        
        $f_post['order_point'] = isset($f_post['order_point']) ? $f_post['order_point'] :'';

        $sql=sprintf('INSERT INTO
            %s(
            m_serial
            ,m_id,m_item,m_tanka,m_tanka_tani,m_keitai
            ,m_lot_small,m_nisugata,m_size,m_bikou,m_sanchi
            ,m_shoumi,m_hozon,m_menu,m_teikan
            ,m_setsumei

            ,m_kanbai,m_pic1,m_nouki,m_souryou
            ,m_jisseki,m_key
            ,m_cate_shop
            ,m_cate_m
            ,m_price_lot,m_pic2,m_zairyou,m_kaitou
            ,m_cate_m2,m_cate_m3,m_cate_m4,m_cate_m5,m_cate_m6
            ,m_order
            ,m_koukai_flg

            ,m_item_kana
            ,m_zaiko
            ,m_teikyo
            ,m_zaiko_disp_flg
            ,m_disp_limit
            ,order_point,m_lot_weight,m_eiyou

            ,item_total_weight
            ,m_pic3
            ,m_pic4
            ,m_pic5
            ,m_pic6
            ,m_pic_eiyo
            ,pic4_catch_copy
            ,pic5_catch_copy
            ,created
            )
            VALUES(
            %d
            ,%s,%s,%d,%s,%s
            ,%s,%s,%s,%s,%s
            ,%s,%s,%s,%s
            ,%s

            ,%s,%s,%s,%s
            ,%s,%s
            ,%s
            ,%s
            ,%d,%s,%s,%s
            ,%s,%s,%s,%s,%s
            ,%d
            ,%d

            ,%s
            ,%s
            ,%s
            ,%d
            ,%s
            ,%d,%s,%s

            ,%s
            ,%s
            ,%s
            ,%s
            ,%s
            ,%s
            ,%s
            ,%s
            ,NOW()
            );'
            ,$this->table_arr['valeur_m_data_dat']

            ,$m_serial
            ,$this->c_dbi->DB_qq($f_id),$this->c_dbi->DB_qq($f_post['item']),$this->c_dbi->DB_q($f_post['tanka']),$this->c_dbi->DB_qq($t_tani),$this->c_dbi->DB_qq($f_post['keitai'])
            ,$this->c_dbi->DB_qq($f_post['lot']),$this->c_dbi->DB_qq($f_post['nisugata']),$this->c_dbi->DB_qq($f_post['size']),$this->c_dbi->DB_qq($f_post['bikou']),$this->c_dbi->DB_qq($t_santi)
            ,$this->c_dbi->DB_qq(isset($f_post['kigen']) ? $f_post['kigen'] : NULL),$this->c_dbi->DB_qq($f_post['hozon']),$this->c_dbi->DB_qq($f_post['menu']),$this->c_dbi->DB_qq($f_post['teikan'])
            ,$this->c_dbi->DB_qq($f_post['setsumei'])

            ,$this->c_dbi->DB_qq(''),$this->c_dbi->DB_qq($f_pic1),$this->c_dbi->DB_qq($f_post['nouki']),$this->c_dbi->DB_qq($f_post['souryou'])
            ,$this->c_dbi->DB_qq($f_post['jisseki']),'NULL'
            ,$this->c_dbi->DB_qq(isset($f_post['cateshop']) ? $f_post['cateshop'] : NULL)
            ,$this->c_dbi->DB_qq(@$f_cate3['c_search3'])
            ,$this->c_dbi->DB_q($f_post['lotkingaku']),$this->c_dbi->DB_qq($f_pic2),$this->c_dbi->DB_qq($f_post['zairyo']),$this->c_dbi->DB_qq($f_post['kaitou'])
            ,$this->c_dbi->DB_qq($f_cate4_text),'NULL','NULL',$this->c_dbi->DB_qq($f_post['cate5no']),'NULL'
            ,$m_order
            ,$t_koukai

            ,$this->c_dbi->DB_qq($f_post['kana'])
            ,$this->c_dbi->DB_qq($t_m_zaiko)
            ,$this->c_dbi->DB_qq($t_m_zaiko)
            ,$m_zaiko_disp_flg
            ,$this->c_dbi->DB_qq($t_m_disp_limit)
            ,$this->c_dbi->DB_q($f_post['order_point']),$this->c_dbi->DB_q($f_post['m_lot_weight']),$this->c_dbi->DB_qq($f_post['eiyou'])

            ,$this->c_dbi->DB_qq($t_m_item_total_weight)
            ,$this->c_dbi->DB_qq($f_pic3)
            ,$this->c_dbi->DB_qq($f_pic4)
            ,$this->c_dbi->DB_qq($f_pic5)
            ,$this->c_dbi->DB_qq($f_pic6)
            ,$this->c_dbi->DB_qq($f_pic7)
            ,$this->c_dbi->DB_qq(isset($f_post['pic4_catch_copy']) ? $f_post['pic4_catch_copy'] : NULL)
            ,$this->c_dbi->DB_qq(isset($f_post['pic5_catch_copy']) ? $f_post['pic5_catch_copy'] : NULL)
        );

        
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(('商品情報新規記録エラー:3'));
        $ret_serial = $this->c_dbi->insert_id();
        
        // 送料の格納
        if($ret_serial){
            $this->set_item_soryo($f_post['select_soryo_table'], $f_id, $ret_serial);
            $this->set_item_calendar($f_post['select_holiday_table'], $f_id, $ret_serial);
        }
       

        //カロリーカテゴリ成分登録
        if($f_post['cate1no'] == 9){
            $sql = sprintf('INSERT INTO %1$s(ai_serial
            , c_energy, c_suibun, c_tanpaku, c_shishitsu, c_tansui
            , c_kaibun, c_na, c_k, c_ca, c_mg
            , c_p, c_fe, c_zn, c_lechi, c_kalo
            , c_b1, c_b2, c_c, c_seni, c_shokuen
            )
            VALUES(
                %2$s, %3$s, %4$s, %5$s, %6$s
                ,%7$s, %8$s, %9$s, %10$s, %11$s
                ,%12$s ,%13$s, %14$s, %15$s, %16$s
                ,%17$s ,%18$s, %19$s, %20$s, %21$s
                ,%22$s
            )
            ON DUPLICATE KEY UPDATE 
            c_energy=%3$s, c_suibun=%4$s, c_tanpaku=%5$s, c_shishitsu=%6$s, c_tansui=%7$s
            , c_kaibun=%8$s, c_na=%9$s, c_k=%10$s, c_ca=%11$s, c_mg=%12$s
            , c_p=%13$s, c_fe=%14$s, c_zn=%15$s, c_lechi=%16$s, c_kalo=%17$s
            , c_b1=%18$s, c_b2=%19$s, c_c=%20$s, c_seni=%21$s, c_shokuen=%22$s;'
            , $this->table_arr['valeur_m_item_hanyou']
            , $this->c_dbi->DB_qq($ret_serial)
            , $this->c_dbi->DB_qq($f_post['c_energy']), $this->c_dbi->DB_qq($f_post['c_suibun']), $this->c_dbi->DB_qq($f_post['c_suibun']), $this->c_dbi->DB_qq($f_post['c_shishitsu']), $this->c_dbi->DB_qq($f_post['c_tansui'])
            , $this->c_dbi->DB_qq($f_post['c_kaibun']), $this->c_dbi->DB_qq($f_post['c_na']), $this->c_dbi->DB_qq($f_post['c_k']), $this->c_dbi->DB_qq($f_post['c_ca']), $this->c_dbi->DB_qq($f_post['c_mg'])
            , $this->c_dbi->DB_qq($f_post['c_p']), $this->c_dbi->DB_qq($f_post['c_fe']), $this->c_dbi->DB_qq($f_post['c_zn']), $this->c_dbi->DB_qq($f_post['c_lechi']), $this->c_dbi->DB_qq($f_post['c_kalo'])
            , $this->c_dbi->DB_qq($f_post['c_b1']), $this->c_dbi->DB_qq($f_post['c_b2']), $this->c_dbi->DB_qq($f_post['c_c']), $this->c_dbi->DB_qq($f_post['c_seni']), $this->c_dbi->DB_qq($f_post['c_shokuen']));
            
            $res = $this->c_dbi->DB_exec($sql);
            !$res && die(('成分情報新規記録エラー'));
        }

        return $ret_serial;
    }
    /*****************************
    第一カテゴリ取得

    引数	なし

    戻り値 $arr['カテゴリ名']=シリアル
    ******************************/
    public function get_cate1_all(){
        
        $ret_arr=array();
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('SELECT c_cate1 AS title,c_serial1 AS value 
            FROM %s 
            ORDER BY c_position ASC;'
        ,$this->table_arr['m_cate1']);
             
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die('第一カテゴリ取得エラー'. $this->c_dbi->err());
          while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
            $ret_arr[$row['title']]=$row['value'];
        }
        return $ret_arr;

    }

    /*****************************
    第二カテゴリ取得すべて

    戻り値 $arr['カテゴリ名']=シリアル
    ******************************/
    function get_cate2_all(){
        $ret_arr=array();
        $this->c_dbi->DB_on($this->db_name);

        $sql=sprintf('SELECT c_serial1, c_serial2, c_cate2 
        FROM %1$s WHERE 1
        ORDER BY c_serial2 ASC;'
        , $this->table_arr['m_cate2']
        );
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die('第二カテゴリ取得エラー'. $this->c_dbi->err());
          while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
            $ret_arr[$row['c_serial1']][$row['c_cate2']]=$row['c_serial2'];
        }
        return mb_convert_encoding($ret_arr, 'UTF-8', 'auto');
    }

    /*****************************
    第二カテゴリ取得

    戻り値 $arr['カテゴリ名']=シリアル
    ******************************/
    function get_cate2_by_serial($cate1_serial){
        $ret_arr=array();
        $this->c_dbi->DB_on($this->db_name);

        $sql=sprintf('SELECT c_serial1, c_serial2, c_cate2 
        FROM %1$s WHERE 1 AND c_serial1 = %2$d
        ORDER BY c_serial2 ASC;'
        , $this->table_arr['m_cate2']
        , $this->c_dbi->DB_q($cate1_serial)
        );
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die('第二カテゴリ取得エラー'. $this->c_dbi->err());
          while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
            $ret_arr[$row['c_serial2']]=$row['c_cate2'];
        }
        
        return $ret_arr;
    }
    
    /*****************************
    第三カテゴリ取得

    戻り値 $arr['カテゴリ名']=シリアル
    ******************************/
    function get_cate3_by_serial($cate1_serial, $cate2_serial){
        $ret_arr=array();
        $this->c_dbi->DB_on($this->db_name);

        $sql=sprintf('SELECT c_serial3, c_cate3, c_search3
        FROM %1$s WHERE 1 
            AND c_serial1 = %2$d
            AND c_serial2 = %3$d
        ORDER BY c_serial1 ASC;'
        , $this->table_arr['m_cate3']
        , $this->c_dbi->DB_q($cate1_serial)
        , $this->c_dbi->DB_q($cate2_serial)
        );   
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die('第三カテゴリ取得エラー'. $this->c_dbi->err());
          while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
            $ret_arr[$row['c_serial3']]=$row['c_cate3'];
        }
        
        return $ret_arr;
    }

    /*****************************
    第四カテゴリ取得

    戻り値 $arr['カテゴリ名']=シリアル
    ******************************/
    function get_cate4_by_serial($cate1_serial, $cate2_serial, $cate3_serial){
        $ret_arr=array();
        $this->c_dbi->DB_on($this->db_name);

        $sql=sprintf('SELECT c_serial4, c_cate4, c_search4
        FROM %1$s WHERE 1 
            AND c_serial1 = %2$d
            AND c_serial2 = %3$d
            AND c_serial3 = %4$d
        ORDER BY c_serial1 ASC;'
        , $this->table_arr['m_cate4']
        , $this->c_dbi->DB_q($cate1_serial)
        , $this->c_dbi->DB_q($cate2_serial)
        , $this->c_dbi->DB_q($cate3_serial)
        );   
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die('第四カテゴリ取得エラー'. $this->c_dbi->err());
          while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
            $ret_arr[$row['c_serial4']]=$row['c_cate4'];
        }
        
        return $ret_arr;
    }

    /*****************************
    第三カテゴリ取得すべて

    戻り値 $arr['カテゴリ名']=シリアル
    ******************************/
    function get_cate3_all(){
       
        $ret_arr=array();
        
        $this->c_dbi->DB_on($this->db_name);
        $sql=sprintf('SELECT c_serial3, c_serial2, c_serial1, c_cate3, c_search3
        FROM %1$s WHERE 1
        ORDER BY c_serial1 ASC;'
        , $this->table_arr['m_cate3']
        );   
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die('第三カテゴリ取得エラー'. $this->c_dbi->err());
          while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
            $ret_arr[$row['c_serial1']][$row['c_serial2']][$row['c_serial3']]=array('c_serial3'=>$row['c_serial3'],'c_cate3'=>$row['c_cate3'],'c_search3'=>$row['c_search3']);
        }
        return mb_convert_encoding($ret_arr, 'UTF-8', 'auto');
    }

    /*****************************
    第四カテゴリ取得すべて

    戻り値 $arr['カテゴリ名']=シリアル
    ******************************/
    function get_cate4_all(){
        $ret_arr=array();
        
        $this->c_dbi->DB_on($this->db_name);
        $sql=sprintf('SELECT c_serial4, c_serial3, c_serial2, c_serial1, c_cate4, c_search4 
        FROM %1$s WHERE 1;'
        , $this->table_arr['m_cate4']
        );
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die('第四カテゴリ取得エラー'. $this->c_dbi->err());
          while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
            $ret_arr[$row['c_serial1']][$row['c_serial2']][$row['c_serial3']][$row['c_serial4']]=array('c_serial4'=>$row['c_serial4'],'c_cate4'=>$row['c_cate4'],'c_search4'=>$row['c_search4']);
        }
        return mb_convert_encoding($ret_arr, 'UTF-8', 'auto');
    }

    /*****************************
    同一商品名数取得

    指定id社の同一商品名の数を取得する

    引数	$f_id	=	出店社id
            $f_item	=	商品名

    戻り値　商品数
    ******************************/
    function get_sameitemcount($f_id,$f_item){
        $ret_count=0;
        $this->c_dbi->DB_on($this->db_name);
        $sql=sprintf('SELECT count(*) AS t_count FROM %s
        WHERE m_id=%s AND m_item=%s;'
        , $this->table_arr['valeur_m_data_dat']
        , $this->c_dbi->DB_qq($f_id)
        , $this->c_dbi->DB_qq(mb_convert_encoding($f_item, 'sjis', 'auto')));
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(('同一商品名数取得エラー'));
        $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
        
        $ret_count=$row['t_count'];
        return $ret_count;
    }

    /**
     * 地方区分情報取得
     */
    function get_region_master(){
        $rtn_arr=array();
        
        $this->c_dbi->DB_on('mmart_tools');
        $sql = sprintf('SELECT serial, region, pref
        FROM %1$s
        WHERE del_flg = 0
        ;'
        , $this->table_arr['region_master']
        );
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        
        !$res && die('地方区分情報取得エラー:');
        while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
            @$rtn_arr[$row['serial']]['region']=$row['region'];
            @$rtn_arr[$row['serial']]['pref']=explode(',',$row['pref']);
        }
        
        return $rtn_arr;
    }

    /**
     * 送料設定表保存
     */
    function set_soryo_table($data){
        global $config; // configファイル
        $this->c_dbi->DB_on($this->db_name);
        
        $res_flg  = false;
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('SELECT *
            FROM %1$s 
            WHERE valeur_id = %2$s AND del_flg = 0
            GROUP BY soryo_master_serial;'
            , $this->table_arr['valeur_soryo_table']
            , $this->c_dbi->DB_qq($data['valeur_id'])
        );
        $res = $this->c_dbi->DB_exec($sql);
    
        !$res && die('送料設定表情報取得エラー:');
        $total_arr = [];
        while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
            $total_arr[] = $row;
        }
        $cnt = 0;
        if(!empty($total_arr)){
            $cnt = count($total_arr);
        }
        $cnt_name = $this->soryo_table_name_check($data);
        
        if((int)$cnt < $config['soryo_calendar_reg_count'] && (int)$cnt_name == 0){
            $sql = sprintf('SELECT max(soryo_master_serial) AS max_serial 
                FROM %1$s 
                WHERE valeur_id = %2$s AND del_flg = 0'
                , $this->table_arr['valeur_soryo_table']
                , $this->c_dbi->DB_qq($data['valeur_id'])
            );
            $res = $this->c_dbi->DB_exec($sql);
            $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
            $max_serial = isset($row['max_serial']) && (int)$row['max_serial'] > 0 ? $row['max_serial'] + 1 : 1;
            
            
            foreach ($data['soryo_data'] as $region_serial => $value) {
                if(!empty($value)){
                    
                    foreach ($value as $key => $soryo) {
                        
                       foreach ($soryo as $pref => $v) {

                            $sql = sprintf('INSERT INTO %1$s(
                                soryo_master_serial , valeur_id, region_serial, region_label, pref
                                , size, weight, fee, soryo_name, created
                                )
                                VALUES(
                                    %2$d, %3$s, %4$d, %5$s, %6$s
                                    ,%7$d, %8$d, %9$s, %10$s, NOW()
                                );'
                            , $this->table_arr['valeur_soryo_table']
                            , $this->c_dbi->DB_q($max_serial)
                            , $this->c_dbi->DB_qq($data['valeur_id'])
                            , $this->c_dbi->DB_q(($region_serial))
                            , $this->c_dbi->DB_qq(isset($v['region_label']) ? mb_convert_encoding(trim($v['region_label']), 'SJIS', 'auto'): '')   //5
                            , $this->c_dbi->DB_qq(mb_convert_encoding(trim($pref), 'SJIS', 'auto'))
                            , $this->c_dbi->DB_q($v['size'])
                            , $this->c_dbi->DB_q($v['weight'])
                            , $this->c_dbi->DB_q($v['price'])
                            , $this->c_dbi->DB_q(trim($data['soryo_table_name']))
                            // , $this->c_dbi->DB_qq(trim('常温'))               //10
                            );
                            
                             $res = $this->c_dbi->DB_exec($sql);
                             !$res && die(mb_convert_encoding('送料設定エラー', 'SJIS', 'auto'));
                       }
                    }
                }
            }
            $res_flg = true;
            return $res_flg;
        }
        return $res_flg;
        
    }
    

     /**
     * 休業日設定表を削除
     *
     * @param [type] $data
     * @return void
     */
    function remove_soryo_by_serial($data){
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('DELETE FROM %1$s WHERE soryo_master_serial = %2$s AND valeur_id = %3$s;'
            , $this->table_arr['valeur_soryo_table']
            , $this->c_dbi->DB_q($data['soryo_master_serial'])
            , $this->c_dbi->DB_qq($data['valeur_id'])
        );
        
       $this->c_dbi->DB_exec($sql);
    }

    /**
     * 配送料日設定保存
     */
    function set_item_soryo($soryo_master_serial, $seller_id, $ai_serial){
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('INSERT INTO %1$s(
            ai_serial, valeur_id, soryo_master_serial, created
            )
            VALUES(
                %2$d, %3$s, %4$d, NOW()
            );'
        , $this->table_arr['valeur_item_soryo']
        , $this->c_dbi->DB_q($ai_serial)
        , $this->c_dbi->DB_qq($seller_id)
        , $this->c_dbi->DB_q($soryo_master_serial)
        );
        
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(mb_convert_encoding('商品ごとに配送料設定保存エラー', 'SJIS', 'auto'));
    }

    /**
     * 休業日設定保存
     */
    function set_item_calendar($holiday_serial, $seller_id, $ai_serial){
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('INSERT INTO %1$s(
            ai_serial, valeur_id, holiday_serial, created
            )
            VALUES(
                %2$d, %3$s, %4$d, NOW()
            );'
        , $this->table_arr['valeur_item_holiday']
        , $this->c_dbi->DB_q($ai_serial)
        , $this->c_dbi->DB_qq($seller_id)
        , $this->c_dbi->DB_q($holiday_serial)
        );
        
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(mb_convert_encoding('商品ごとに休業日設定保存エラー', 'SJIS', 'auto'));
    }


     /**
     * 休業日設定表
     */
    function set_holiday_table($holiday_data){
        global $config; // configファイル
        $res_flg  = false;
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('SELECT count(*) AS cnt 
            FROM %1$s 
            WHERE valeur_id = %2$s AND del_flg = 0;'
            , $this->table_arr['valeur_holiday_table']
            , $this->c_dbi->DB_qq($holiday_data['valeur_id'])
        );
        $res = $this->c_dbi->DB_exec($sql);
    
        !$res && die('休業日設定表情報取得エラー:');
        $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
        $cnt = 0;
        if(!empty($row)){
            $cnt = $row['cnt'];
        }
        $cnt_name = $this->holiday_table_name_check($holiday_data);
        if((int)$cnt < $config['soryo_calendar_reg_count'] && $cnt_name == 0){
            $sql = sprintf('INSERT INTO %1$s(
                holiday_name, valeur_id, kyugyou_date, created
                )
                VALUES(
                    %2$s, %3$s, %4$s, NOW()
                );'
            , $this->table_arr['valeur_holiday_table']
            , $this->c_dbi->DB_qq($holiday_data['holiday_name'])
            , $this->c_dbi->DB_qq($holiday_data['valeur_id'])
            , $this->c_dbi->DB_qq($holiday_data['kyugyou_date'])
            );
            
            $res = $this->c_dbi->DB_exec($sql);
            !$res && die(mb_convert_encoding('休業日設定表保存エラー', 'SJIS', 'auto'));
            $res_flg  = true;
            return $res_flg;
        }else{
            $res_flg  = false;
        }
        return $res_flg;
    }


     /**
     * 休業日設定表
     */
    function holiday_table_name_check($holiday_data){
        
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('SELECT count(*) AS cnt 
            FROM %1$s 
            WHERE valeur_id = %2$s AND holiday_name = %3$s AND del_flg = 0;'
            , $this->table_arr['valeur_holiday_table']
            , $this->c_dbi->DB_qq($holiday_data['valeur_id'])
            , $this->c_dbi->DB_qq($holiday_data['holiday_name'])
        );
        $res = $this->c_dbi->DB_exec($sql);
        
        !$res && die('休業日設定表情報取得エラー:');
        $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
        $cnt = 0;
        if(!empty($row)){
            $cnt = $row['cnt'];
        }
        
        return $cnt;
    }

     /**
     * 全て休業日設定表情報取得
     */
    function get_all_holiday($S_id){
        $res_arr = [];
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('SELECT t1.*
            FROM %1$s AS t1
            INNER JOIN %2$s AS t2 ON t2.valeur_id = t1.valeur_id AND t2.del_flg = 0
            WHERE t1.valeur_id = %3$s AND t1.del_flg = 0;'
            , $this->table_arr['valeur_holiday_table']
            , $this->table_arr['valeur_seller_outlet']
            , $this->c_dbi->DB_qq($S_id)
        );
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        
        !$res && die('休業日設定表情報取得エラー:');
        while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
            $res_arr[] = $row;
        }
        
        
        return $res_arr;
    }

    /**
     * 休業日設定表を削除
     *
     * @param [type] $data
     * @return void
     */
    function remove_holiday_by_serial($data){
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('DELETE FROM %1$s WHERE serial = %2$s AND valeur_id = %3$s;'
            , $this->table_arr['valeur_holiday_table']
            , $this->c_dbi->DB_q($data['serial'])
            , $this->c_dbi->DB_qq($data['valeur_id'])
        );
        
       $this->c_dbi->DB_exec($sql);
    }

    
    /**
     * 送料設定表
     */
    function soryo_table_name_check($holiday_data){
        
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('SELECT count(*) AS cnt 
            FROM %1$s 
            WHERE valeur_id = %2$s AND soryo_name = %3$s AND del_flg = 0;'
            , $this->table_arr['valeur_soryo_table']
            , $this->c_dbi->DB_qq($holiday_data['valeur_id'])
            , $this->c_dbi->DB_qq(trim($holiday_data['soryo_table_name']))
        );
        $res = $this->c_dbi->DB_exec($sql);
        
        !$res && die('送料設定表情報取得エラー:');
        $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
        $cnt = 0;
        if(!empty($row)){
            $cnt = $row['cnt'];
        }
        
        return $cnt;
    }

     /**
     * 全て配送料表情報取得
     */
    function get_all_soryo_table($S_id){
        $res_arr = [];
        $this->c_dbi->DB_on($this->db_name);
        $sql = sprintf('SELECT t1.*
            FROM %1$s AS t1
            INNER JOIN %2$s AS t2 ON t2.valeur_id = t1.valeur_id AND t2.del_flg = 0
            WHERE t1.valeur_id = %3$s AND t1.del_flg = 0;'
            , $this->table_arr['valeur_soryo_table']
            , $this->table_arr['valeur_seller_outlet']
            , $this->c_dbi->DB_qq($S_id)
        );
        mysqli_set_charset($this->c_dbi->G_DB, "utf8");
        $res = $this->c_dbi->DB_exec($sql);
        
        !$res && die('配送料表情報取得エラー:');
        while ($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
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
     * メールデータ格納
     *
     * @param	array	$f_set_values
     *
     * @return	int
     */
    function insert_seller_out_mail ($f_set_values) {
        $ret_serial = 0;
        // メール格納テーブルのカラム
        $out_mail_column = array(
            'order_serial',
            'seller_id',
            'buyer_id',
            'kind',
            'title',
            'maildata',
            'created',
        );
        $set	= implode(',', $out_mail_column);
    
        $this->c_dbi->DB_on('mmart_uriba');
    
        $sql = sprintf(' INSERT INTO `mmart_uriba`.`out_mail` (
                %1$s
            ) values (
                %2$d, %3$s, %4$s, %5$d, %6$s
                , %7$s, NOW()
            )'
            , $set
            , $f_set_values['order_serial']
            , $this->c_dbi->DB_qq($f_set_values['seller_id'])
            , $this->c_dbi->DB_qq($f_set_values['buyer_id'])
            , $f_set_values['kind']
            , $this->c_dbi->DB_qq($f_set_values['title'])
            , $this->c_dbi->DB_qq($f_set_values['maildata'])
        );
    
        $res = $this->c_dbi->DB_exec($sql);
        $ret_serial = $this->c_dbi->insert_id();
        $this->c_dbi->DB_off();
        !$res && die('メールデータ 挿入エラー');

        return $ret_serial;
    }

    /**
     * 出品社登録取得
     */
    function get_all_items($S_id){
        $ret_arr = [];
        $this->c_dbi->DB_on($this->db_name);
        $sql=sprintf('SELECT 
                TB_i.*
                ,TB_c3.c_serial1
                ,TB_c3.c_serial2
                ,TB_c3.c_serial3
                ,TB_c1.c_cate1
                ,TB_c2.c_cate2
                ,TB_c3.c_cate3
                ,TB_c4.c_cate4 
            FROM %1$s AS TB_i
            LEFT JOIN %3$s AS TB_c3 ON TB_i.m_cate_m = TB_c3.c_search3
            LEFT JOIN %4$s AS TB_c1 ON TB_c3.c_serial1 = TB_c1.c_serial1
            LEFT JOIN %5$s AS TB_c2 ON TB_c3.c_serial1 = TB_c2.c_serial1 AND TB_c3.c_serial2 = TB_c2.c_serial2
            LEFT JOIN %6$s AS TB_c4 ON TB_i.m_cate_m2 = TB_c4.c_search4 AND TB_c3.c_serial1 = TB_c4.c_serial1 AND TB_c3.c_serial2 = TB_c4.c_serial2 AND TB_c3.c_serial3 = TB_c4.c_serial3
            WHERE TB_i.m_id = %2$s AND del_flg = 0;'
        , $this->table_arr['valeur_m_data_dat']
        , $this->c_dbi->DB_qq($S_id)
        , $this->table_arr['m_cate3']
        , $this->table_arr['m_cate1']
        , $this->table_arr['m_cate2']
        , $this->table_arr['m_cate4']
    );
        mysqli_set_charset($this->c_dbi->G_DB, 'utf8');
        
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(mb_convert_encoding('出品社登録商品エラー', 'SJIS', 'auto'));
        while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)){
            $ret_arr[] = $row;
        }
        
        return $ret_arr;
    }
    
    /**
     * 商品情報取得
     */
    function get_item_info($ai_serial, $S_id=""){
        $ret_arr = [];
        $this->c_dbi->DB_on($this->db_name);
        $f_condition = '';
        if(!empty($S_id)){
            $f_condition = sprintf('AND TB_i.m_id = %1$s', $this->c_dbi->DB_qq($S_id));
        }
        $sql=sprintf('SELECT 
            TB_i.*

            ,TB_c3.c_serial1
			,TB_c3.c_serial2
			,TB_c3.c_serial3
			,TB_c1.c_cate1
			,TB_c2.c_cate2
			,TB_c3.c_cate3
			,TB_c4.c_cate4

            ,TB_seller.valeur_coname
            ,TB_seller.valeur_tantou
            ,TB_seller.valeur_mail
            
            FROM %1$s AS TB_i
            LEFT JOIN %3$s AS TB_c3 ON TB_i.m_cate_m = TB_c3.c_search3
            LEFT JOIN %4$s AS TB_c1 ON TB_c3.c_serial1 = TB_c1.c_serial1
            LEFT JOIN %5$s AS TB_c2 ON TB_c3.c_serial1 = TB_c2.c_serial1 AND TB_c3.c_serial2 = TB_c2.c_serial2
            LEFT JOIN %6$s AS TB_c4 ON TB_i.m_cate_m2 = TB_c4.c_search4 AND TB_c3.c_serial1 = TB_c4.c_serial1 AND TB_c3.c_serial2 = TB_c4.c_serial2 AND TB_c3.c_serial3 = TB_c4.c_serial3
            LEFT JOIN %8$s AS TB_seller ON TB_i.m_id = TB_seller.valeur_id AND TB_seller.day_debut IS NOT NULL
            WHERE TB_i.ai_serial = %7$d %2$s '
        , $this->table_arr['valeur_m_data_dat']
        , $f_condition
        , $this->table_arr['m_cate3']
        , $this->table_arr['m_cate1']
        , $this->table_arr['m_cate2']       //5
        , $this->table_arr['m_cate4']
        , $this->c_dbi->DB_q($ai_serial)
        , $this->table_arr['valeur_seller_outlet']
        );
        
        mysqli_set_charset($this->c_dbi->G_DB, 'utf8');
        $res = $this->c_dbi->DB_exec($sql);

        !$res && die(mb_convert_encoding('出品社登録商品エラー#'.__LINE__, 'SJIS', 'auto'));
        $ret_arr = mysqli_fetch_array($res,MYSQLI_ASSOC);
        
        return $ret_arr;
    }

    /**
     * 価格再設定処理
     *
     * @param [type] $data
     * @return void
     */
    function re_set_price($data){
        $this->c_dbi->DB_on($this->db_name);
        $ret = false;
        $sql = sprintf('UPDATE %1$s 
            SET
                m_tanka = %2$d
                ,m_price_lot = %3$d
                ,review_flg = 0
            WHERE
                m_id = %4$s AND ai_serial = %5$d;'
            , $this->table_arr['valeur_m_data_dat']
            , $this->c_dbi->DB_q($data['m_tanka'])
            , $this->c_dbi->DB_q($data['m_price_lot'])
            , $this->c_dbi->DB_qq($data['seller_id'])
            , $this->c_dbi->DB_q($data['ai_serial'])
        );
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(mb_convert_encoding('商品の価格再設定処理エラー', 'SJIS', 'auto'));
        $ret = true;
        return $ret;
    }

    /**
     * 社長は商品の公開を承認することを行います。
     * dami2.m_data_datにインサート
     * @param [type] $ai_serial バルル商品ai_serial
     * @return void
     */
    function set_item_m_data_data($ai_serial){
        $ret_serial=0;
        
        // バルル商品チェック
        $valeur_item = $this->get_item_info($ai_serial);
        if(!empty($valeur_item['m_data_data_ai_serial']) || ( !empty($valeur_item['shounin_flg']) && !empty($valeur_item['shounin_time']) )){
            die(mb_convert_encoding('指定した商品を公開しています。他の商品を確認して承認してください。', 'SJIS', 'auto'));
        }

        $this->c_dbi->DB_on('dami2');
        //「m_data_dat」バルル商品のシリアル番号最大値
        $sql = sprintf('SELECT max(m_serial) AS max FROM %s WHERE m_id=%s;'
            ,$this->table_arr['m_data_dat']
            ,$this->c_dbi->DB_q(DF_m_data_dat_valeur_id)
        );
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(mb_convert_encoding('Mマート商品情報取得エラー:1', 'SJIS', 'auto'));
        $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
      

        $m_serial = $row['max']+1;

        //商品順番最大値
        $sql=sprintf('SELECT max(m_order) AS max FROM %s WHERE m_id=%s;'
            ,$this->table_arr['m_data_dat']
            ,$this->c_dbi->DB_q(DF_m_data_dat_valeur_id)
        );
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(mb_convert_encoding('商品情報取得エラー:2', 'SJIS', 'auto'));
        $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
        $m_order = $row['max']+1;

        
        //商品情報格納
        $sql = sprintf('INSERT INTO
            %1$s(
            m_serial, m_id, m_item, m_tanka, m_tanka_tani, m_keitai, m_lot_small, m_nisugata, m_size, m_bikou
            , m_sanchi, m_shoumi, m_hozon, m_menu, m_teikan, m_setsumei, m_kanbai, m_pic1, m_nouki, m_souryou
            , m_jisseki, m_key, m_cate_shop, m_cate_m, m_price_lot, m_pic2, m_zairyou, m_kaitou, m_cate_m2, m_cate_m3
            , m_cate_m4, m_cate_m5, m_cate_m6, m_order, m_koukai_flg, m_item_kana, m_zaiko, m_teikyo, m_zaiko_disp_flg, m_disp_limit
            , order_point, m_lot_weight, m_eiyou, item_total_weight, m_pic3, m_pic4, m_pic5, m_pic6, m_pic_eiyo, pic4_catch_copy
            , pic5_catch_copy
            )
            SELECT 
            %5$d AS m_serial, %6$s AS m_id, m_item, m_tanka, m_tanka_tani, m_keitai, m_lot_small, m_nisugata, m_size, m_bikou
            , m_sanchi, m_shoumi, m_hozon, m_menu, m_teikan, m_setsumei, m_kanbai, m_pic1, m_nouki, m_souryou
            , m_jisseki, m_key, m_cate_shop, m_cate_m, m_price_lot, m_pic2, m_zairyou, m_kaitou, m_cate_m2, m_cate_m3
            , m_cate_m4, m_cate_m5, m_cate_m6, %7$d, m_koukai_flg, m_item_kana, m_zaiko, m_teikyo, m_zaiko_disp_flg, m_disp_limit
            , order_point, m_lot_weight, m_eiyou, item_total_weight, m_pic3, m_pic4, m_pic5, m_pic6, m_pic_eiyo, pic4_catch_copy
            , pic5_catch_copy
            
            FROM %2$s
            WHERE ai_serial = %3$s AND m_id = %4$s;
           '
            ,$this->table_arr['m_data_dat']
            ,$this->table_arr['valeur_m_data_dat']
            ,$this->c_dbi->DB_q($valeur_item['ai_serial'])
            ,$this->c_dbi->DB_qq($valeur_item['m_id'])
            ,$this->c_dbi->DB_q($m_serial)
            ,$this->c_dbi->DB_qq(DF_m_data_dat_valeur_id)
            ,$this->c_dbi->DB_q($m_order)
        );

        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(mb_convert_encoding('Mマート商品情報新規記録エラー:3', 'SJIS', 'auto'));
        $ret_serial = $this->c_dbi->insert_id();
        
    
        //カロリーカテゴリ成分登録
        // if($valeur_item['cate1no'] == 9){
        //     $sql = sprintf('INSERT INTO %1$s(
        //         ai_serial, c_energy, c_suibun, c_tanpaku, c_shishitsu
        //         , c_tansui, c_kaibun, c_na, c_k, c_ca
        //         , c_mg, c_p, c_fe, c_zn, c_lechi
        //         , c_kalo, c_b1, c_b2, c_c, c_seni
        //         , c_shokuen
        //     )
        //     SELECT 
        //         %4$d AS ai_serial, c_energy, c_suibun, c_tanpaku, c_shishitsu
        //         , c_tansui, c_kaibun, c_na, c_k, c_ca
        //         , c_mg, c_p, c_fe, c_zn, c_lechi
        //         , c_kalo, c_b1, c_b2, c_c, c_seni
        //         , c_shokuen
        //     FROM %2$s
        //     WHERE ai_serial = %3$s;'
        //     , $this->table_arr['valeur_m_item_hanyou']
        //     , $this->table_arr['m_item_hanyou']
        //     , $this->c_dbi->DB_qq($valeur_item['ai_serial'])
        //     , $this->c_dbi->DB_qq($ret_serial)
        //     );
        //     $res = $this->c_dbi->DB_exec($sql);
        //     !$res && die(mb_convert_encoding('成分情報新規記録エラー', 'SJIS', 'auto'));
        // }
        
        
        return [$ret_serial, $m_serial];

    }

    /**
     * バルル商品データを更新する
     * 社長公開承認
     * @param [type] $valeur_ai_serial  バルル商品のシリアル
     * @param [type] $m_data_dat_ai_serial  Mマートで公開済みの商品シリアル
     * @return void
     */
    function update_valeur_m_data_data($valeur_ai_serial, $m_data_dat_ai_serial){
        $this->c_dbi->DB_on($this->db_name);
        $ret = false;
        $sql = sprintf('UPDATE %1$s 
            SET 
                m_data_data_ai_serial = %3$d
                , shounin_flg = 1
                , shounin_time = NOW() 
            WHERE ai_serial = %2$d;'
            , $this->table_arr['valeur_m_data_dat']
            , $this->c_dbi->DB_q($valeur_ai_serial)
            , $this->c_dbi->DB_q($m_data_dat_ai_serial)
        );
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(mb_convert_encoding('バルル商品情報更新エラー#', __LINE__));
        $ret = true;
        return $ret;
    }
}
?>