<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title><?php echo(escape($config['title']));?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    
    <script type="text/javascript">

    jQuery( function() {
      
    } );
    
    </script>
    
</head>


<body>
    <section class="container-fluid mt-3"> 
       <?php include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_header.php')?>
        <a href="/outlet/valeur/seller/itemreg.php" class="btn btn-outline-primary">登録商品申請に戻る</a>
        <div class="p-3">
            <p class="mb-0 text-danger">※休業日を設定して休業日カレンダーを登録してください。</p>
            <p class="mb-0 text-danger">※休業日カレンダーは最大で10個まで登録できます。</p>
            <p class="mb-0 text-danger">※登録済みの休業日カレンダーを商品登録申請時に選択できるようになります。</p>
        </div>
        <div class="row p-3">
            <div class="col col-md-8" >
                <div class="alert alert-<?php echo (isset($error_mess['status']) && $error_mess['status'] == 'ok' ? 'success': 'danger')?>" role="alert" style="<?php echo isset($error_mess['mess']) && !empty($error_mess['mess']) ? 'display: block' : 'display: none'?>">
                    <?php echo isset($error_mess['mess']) ? $error_mess['mess'] : '';?>
                </div>
                <div class="row ">
                    <div class="col-md-8 shadow-sm p-3 mb-5 bg-body-tertiary rounded">
                        <form name="f_base" id="register" action="/outlet/valeur/seller/calendar_reg.php" method="post" onSubmit="return false" >
                            <div class="mb-3" style="max-width: 300px">
                                <label for="holiday_name" class="form-label" >休業日設定カレンダー名<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="holiday_name" name="holiday_name" maxlength="100" required>
                                <div class="invalid-feedback">
                                    休業日設定表名が既に存在します。
                                </div>

                            </div>
                            <label for="calendar_table_name" class="form-label" >休業日カレンダー<span class="text-danger">*</span></label>
                            <div class="text-center">
                                <table cellspacing=0 cellpadding=1 >
                                    <tr>
                                        <td align=middle valign="top">
                                        
                                            <!-- 営業日・カレンダー当月 -->
                                            <?php echo $disp_rest1; ?>
                                            <!-- 営業日・カレンダー当月 end -->
                                        
                                        </td>
                                        <td align=middle>&nbsp;</td>
                                        <td align=middle valign="top">
                                        <!-- 営業日・カレンダー翌月 -->
                                                <?php echo $disp_rest2;?>
                                            <!-- 営業日・カレンダー翌月 end -->
                                        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=3></td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <input type="hidden" name="selected_calendar" id="selected_calendar" value="" />
                                <input type="hidden" name="p_kind" id="p_kind" value="" />
                                <button class="btn btn-primary" id="set_calendar">休業日カレンダー設定</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                
                <!-- 休業日設定表リスト -->
                <?php if(!empty($holiday_arr)):?>
                    <div class="row">
                        <h4 class="mb-0">登録済み休業日カレンダーリスト</h4>
                        <div class="row row-cols-1 row-cols-md-4 g-4 mt-0">
                            
                            <?php foreach ($holiday_arr as $key => $holiday) { 
                                $f_holiday_arr = explode(',', $holiday['kyugyou_date']);
                                ?>
                                <div class="col">
                                    <div class="card border-secondary mb-3">
                                        <div class="card-header">
                                            <?php echo $holiday['holiday_name']?>
                                            <button data-holiday_serial="<?php echo $holiday['serial'] ?>" class="btn btn-danger pt-0 pb-0 float-end remove_holiday_by_serial">削除</button>
                                        </div>
                                        <div class="card-body text-secondary">
                                            <ol class="list-group list-group-numbered">
                                                <?php foreach ($f_holiday_arr as $v) {
                                                    echo '<li class="list-group-item">'.$v.'</li>';
                                                } ?>
                                            </ol>
                                            
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>                           
                        
                        </div>
                    </div>
                <?php endif;?>
                
            </div>
        </div>
    </section>
</body>
<script src="/outlet/valeur/common/js/tpl_kyugyouhi_settei.js?<?php echo time();?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</html>
