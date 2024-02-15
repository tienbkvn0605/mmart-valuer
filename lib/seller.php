<?php
/**
* 2024-01-22   ナム    【開1-23-0021】バルル委託販売機能作成
*/

 require_once('/var/php_class/class_dbi.php');

class Seller {
    
    //グローバル変数
    protected $seller_id;
    protected $input_session_name = 'outlet_katte_item_reg';
    protected $table_arr = [
        'm_cate1' => 'dami2.m_cate1'
        ,'m_cate2' => 'dami2.m_cate2'
        ,'m_cate3' => 'dami2.m_cate3'
        ,'m_cate4' => 'dami2.m_cate4'
        ,'valeur_m_data_dat' => 'mmart_uriba.valeur_m_data_dat'
        ,'valeur_m_item_hanyou' => 'mmart_uriba.valeur_m_item_hanyou'  //
        ,'valeur_item_holiday' => 'mmart_uriba.valeur_item_holiday'    // 商品ごとに休業日設定情報
        ,'region_master' => 'mmart_tools.seller_delivery_region_master'//地方区分情報
        ,'valeur_seller_outlet'  => 'mmart_uriba.valeur_seller_outlet'    // バルルｓ出店者情報
        ,'seller_outlet'         => 'dami2.seller_outlet'           // 即売、ソクハン出品社情報
    ];
    private $c_dbi;
    protected $db_name = 'mmart_uriba';
    public function __construct(){
        $this->c_dbi = new G_class_dbi;
    }

    public function ss_save($data):bool {
        $save_flg = false;
        // セッションチェック
        $_SESSION[$this->input_session_name] = $data;
        if(isset($_SESSION[$this->input_session_name])){
            return true;
        }else{
            return false;
        }
    }

    public function ss_clear():bool {
        $clear_flg = false;
        // セッションにデータがあれば
        if(isset($_SESSION[$this->input_session_name])){
            unset($_SESSION[$this->input_session_name]);
            $clear_flg = true;
        }
        return $clear_flg;
    }
    /**
     * バルル出品者情報チェック
     *
     * @param [type] $f_id
     * @param [type] $f_pass
     * @return array
     */
    public function get_seller_valeur($f_id) {
   
        $this->c_dbi->DB_on($this->db_name);
        
        $sql = sprintf('SELECT t1.serial, t1.day_debut, t1.valeur_coname, t1.valeur_tantou
        , t1.valeur_kakunin_flg, t1.valeur_mail, t1.valeur_id
        FROM %1$s AS t1
        WHERE binary(t1.valeur_id)=%2$s
        ;'
        , $this->table_arr['valeur_seller_outlet']
        , $this->c_dbi->DB_qq($f_id)
        );
        
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die('バルル出品者情報チェックチェックエラー#'.__LINE__);
        $ret_arr = [];
        $rtn = mysqli_fetch_array($res, MYSQLI_ASSOC);
        
        return $rtn;
    }

    /**
     * convert japanese
     *
     * @param string $text
     * @param string $type
     * @return string
     */
    public function Fcv($text,$type="ja"){
        $res = "";
        if($type=="ja"){
            $res = mb_convert_encoding($text, "UTF-8", "SJIS");
        }else{
            $res = mb_convert_encoding($text, "SJIS", "UTF-8");
        }
        return $res;
    }

    //関数----------------------------------------------
    /*****************************
    ログインチェック

    id, passでの出品社名を取得

    引数	$f_id	=	取得id
            $f_pass	=	取得pass

    戻り値　出品社名
    ******************************/
    function F_check_login($f_id){
        $this->c_dbi->DB_on($this->db_name);
        $ret_shop = [];
        if($f_id==''){
            return $ret_shop;
        }
        $this->c_dbi->DB_on($this->db_name);
            $sql = sprintf('SELECT t1.valeur_coname, t1.valeur_id, t1.valeur_mail, t1.valeur_tantou
                ,t1.valeur_kakunin_flg, t1.day_debut
            FROM %1$s AS t1
            WHERE 
                t1.valeur_id LIKE %2$s 
                AND t1.day_debut IS NOT NULL 
                AND t1.valeur_kakunin_flg = 1
                AND t1.valeur_kakunin_date IS NOT NULL;'
            , $this->table_arr['valeur_seller_outlet']
            , $this->c_dbi->DB_qq($f_id));
        mysqli_set_charset($this->c_dbi->G_DB, 'utf8');
        $res = $this->c_dbi->DB_exec($sql);
        !$res && die(mb_convert_encoding('ログインチェックエラー#', 'sjis', 'utf-8' ).__LINE__);
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $ret_shop  =$row;
        return $ret_shop;
    }
     
    //------------------------------------------------------------------------メール送信に関する処理 終了/

    function F_check_id($f_table,$f_cal,$f_id,$site=NULL,$site_value=NULL,$open_flg=NULL){
       
            $ret_count=0;
            $where = '';
            if($site){
                $where = sprintf(' AND %1$s = "%2$s"',$site,$site_value);
            }
        
            if($open_flg =='open'){
                $where .= ' AND status <= 4 ';
            }elseif($open_flg =='close'){
                $where .= ' AND status >= 5 ';
            }
            
            $this->c_dbi->DB_on($this->db_name);
                $sql=sprintf('SELECT count(%1$s) AS t_c
                FROM %2$s WHERE %1$s=%3$s 
                %4$s;'
                ,$f_cal
                ,$f_table
                ,$this->c_dbi->DB_qq($f_id)
                ,$where);
                $res=$this->c_dbi->DB_exec($sql);
          
            !$res && die('検索エラー');
            $row=mysqli_fetch_array($res,MYSQLI_ASSOC);
            $ret_count=$row['t_c'];
            return $ret_count;
        }
}
?>