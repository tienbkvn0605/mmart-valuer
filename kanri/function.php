<?php
require_once('/var/www/html3/outlet/valeur/lib/config.php');
require_once('/var/php_class/class_dbi.php');
//DBオブジェクト実体化
$c_dbi=new G_class_dbi;
$c_seller = new Seller;

$action = "";
if(isset($_REQUEST["action_type"]) && $action = $_REQUEST["action_type"]);
if($action == "make_pass"){
	$password = F_make_password();
    echo json_encode($password);
    exit;
};
if($action == "confirm"){
    $data = $_POST;
	require_once('/var/www/html3/outlet/valeur/kanri/tpl/tpl_seller_reg_confirm.php');
    unset($_POST);
    exit;
};
if($action == "edit"){

};

if($action == "submit"){
    $data = mb_convert_encoding($_POST,"SJIS","UTF-8");
    $data['valeur_mtantou'] = $_SESSION["LOGIN_USER"];

    // 重複IDチェック
    $p_id = $data['resign_id'];
	$K_m = $c_seller -> F_check_id('dami2.seller_mmart','m_id',$p_id);
	$K_mm_open = $c_seller -> F_check_id('dami2.seller_master','id',$p_id,'site','m','open');
	$K_mo = $c_seller -> F_check_id('dami2.seller_mmart_old','m_id',$p_id);
	$K_mm_close = $c_seller -> F_check_id('dami2.seller_master','id',$p_id,'site','m','close');
	$K_o = $c_seller -> F_check_id('dami2.seller_outlet','out_id',$p_id);
	$k_oo = $c_seller -> F_check_id('dami2.seller_outlet_t','out_id',$p_id);
	$k_va = $c_seller -> F_check_id('mmart_uriba.valeur_seller_outlet','valeur_id',$p_id);
    
	if($K_m == 0 && $K_mm_open == 0 && $K_mo == 0 
	&& $K_mm_close == 0 && $K_o == 0 &&$k_oo == 0 && $k_va == 0){
        $resual = F_insert_resign($data);
	}else{
        die(mb_convert_encoding('ID重複のエアー', 'SJIS', 'auto'));
    }

    unset($data);
    unset($_POST);

    $done_mess = mb_convert_encoding('バルル委託出店社申し込みが完了しました。\n新規バルル委託出店社申し込みページに戻ります。', 'SJIS', 'auto');
    echo '<script>
        alert("'.$done_mess.'");
        window.location = "https://'.$_SERVER['HTTP_HOST'].'/outlet/valeur/kanri/seller_reg.php";
    </script>';
    exit;
};
/**
 * 登録出品社保存
 *
 * @param array $data
 * @return bool
 */
function F_insert_resign($data){
    global $c_dbi;

    $c_dbi->DB_on('mmart_uriba');

    $sql=sprintf('INSERT INTO `mmart_uriba`.`valeur_seller_outlet`(
        `site`, `valeur_id`, `valeur_pass`, `valeur_coname`, `valeur_tel`,
        `valeur_mail`, `valeur_tantou`, `valeur_zip1`, `valeur_zip2`, `valeur_add1`,
        `valeur_add2`, `valeur_item`, `valeur_listed`, `valeur_capital`, `valeur_annual_sales`,
        `created`, `valeur_mtantou`
    )
    VALUES(
        "m", %1$s, %2$s, %3$s, %4$s,
        %5$s, %6$s, %7$s, %8$s, %9$s,
        %10$s, %11$s, %12$d, %13$d, %14$d,
        NOW(), %15$s )', 
     $c_dbi->DB_qq(isset($data["resign_id"]) ? $data["resign_id"] : ''),
     $c_dbi->DB_qq(isset($data["resign_pass"]) ? $data["resign_pass"] : ''),
     $c_dbi->DB_qq(isset($data["corp"]) ? $data["corp"] : ''),
     $c_dbi->DB_qq(isset($data["tel"]) ? $data["tel"] : ''),
     $c_dbi->DB_qq(isset($data["mail"]) ? $data["mail"] : ''),          //5
     $c_dbi->DB_qq(isset($data["name"]) ? $data["name"] : ''),
     $c_dbi->DB_qq(isset($data["zip1"]) ? $data["zip1"] : ''),
     $c_dbi->DB_qq(isset($data["zip2"]) ? $data["zip2"] : ''),
     $c_dbi->DB_qq(isset($data["address"]) ? $data["address"] : ''),
     $c_dbi->DB_qq(isset($data["address_2"]) ? $data["address_2"] : ''),    //10
     $c_dbi->DB_qq(isset($data["item"]) ? $data["item"] : ''),
     $c_dbi->DB_q(isset($data["listed"]) ? $data["listed"] : ''),
     $c_dbi->DB_q(isset($data["capital"]) ? $data["capital"] : ''),
     $c_dbi->DB_q(isset($data["annual_sales"]) ? $data["annual_sales"] : ''),
     $c_dbi->DB_q(isset($data["valeur_mtantou"]) ? $data["valeur_mtantou"] : ''),
    );
    
    $res=$c_dbi->DB_exec($sql);
    
    $c_dbi->DB_off();

    return $res;
}

/**
 * ランダムパスワード生成
 * 仕様文字は英数字、紛らわしい文字は使用しない(1,l,I,o,O,0)
 * 
 * @param   int $f_length   生成文字数
 * @return  string 生成パスワード
 */
function F_make_password($f_length=8){
    // $f_pwseed = '23456789abcdefghijk mn pqrstuvwxyzABCDEFGH JKLMN PQRSTUVWXYZ';
    // 生成種
    $f_pwseed = [];
    $f_pwseed[] = 'abcdefghijkmnpqrstuvwxyz';
    $f_pwseed[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $f_pwseed[] = '23456789';
    $f_pwseed_count = count($f_pwseed);

    $f_pw = [];
    for($i=0;$i<$f_pwseed_count;$i++){
        $f_myseed = str_split($f_pwseed[$i]);   // １文字ずつ配列
        $f_myseed_count = count($f_myseed); // 種文字数
        // 種からの生成数
        $f_maxlength = (random_int(0,1)) ? floor($f_length/$f_pwseed_count) : ceil($f_length/$f_pwseed_count);
        if(($f_pwseed_count-1)==$i){
            $f_maxlength = $f_length - count($f_pw);   // 最後は残り生成数
        }
        // 種から生成する
        for($j=0;$j<$f_maxlength;$j++){
            $f_pw[] = $f_myseed[random_int(0,($f_myseed_count-1))];
        }
    }
    shuffle($f_pw);
    $f_password = join('',$f_pw);

    return $f_password;
}