<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title><?php echo((DF_site_name));?> || ログイン画面</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script type="text/javascript">

    jQuery( function() {
        $(".togglePassword").click(function (e) {
            e.preventDefault();
            var type = $(this).parent().parent().find("#p_pass").attr("type");
            if(type == "password"){
                $(this).text('表示');
                $(this).parent().parent().find("#p_pass").attr("type","text");
            }else if(type == "text"){
                $(this).text('非表示');
                $(this).parent().parent().find("#p_pass").attr("type","password");
            }
        });

    } );

    // ログインチェック
    function F_form_check($f_form){
        var id = $f_form['p_id'].value;
        var pass = $f_form['p_pass'].value;
        if(!id){
            alert('IDを入力してください。');
            $('#p_id').focus();
            return false;
        }
        if(!pass){
            alert('パスワードを入力してください。');
            $('#p_pass').focus();
            return false;
        }

        $f_form.submit();
        $('.login').prop('disabled', true);
    }
    
    </script>
    <style>
        .link_css{
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }
        .link_css a{
            background: url('/outlet/img/arrow_white.png') 10px center no-repeat;
            padding-left: 25px;
        }
    </style>
</head>
    <body>
        <section > 
            <nav class="navbar fixed-top border-bottom border-body text-light p-3" style="background-color: #712cf9; border-color: #712cf9">
                <div class="container-fluid">
                    <h3 class="mb-0">
                        【バルル委託出店社】専用管理画面 ログイン画面
                    </h3>
                    <ul class="mb-0">
                        <li  class="nav-item link_css"><a class="text-light " href="/outlet/" target="_blank">卸・即売市場トップ</a></li>
                        <li  class="nav-item link_css"><a class="text-light " href="/agree/agree_valeur_seller.php" target="_blank">ご利用規約</a></li>
                    </ul>
                </div>
            </nav>
                
            <div class="container-sm h-100 d-flex align-items-center justify-content-center position-relative">
                <div 
                    class="alert alert-danger position-absolute" 
                    role="alert" 
                    style="display: <?php echo ($show_mess ? 'block': 'none')?>; top: 15%;bottom: auto;">
                    ログインエラーです。入力したID・パスワードをご確認ください。
                </div>
                <form method="post" action="/outlet/valeur/admin/login.php" target="_self" name="login_form">
                    <div class="card">
                        <div class="card-header">
                            <b><h4 class="mb-0">御社IDとパスワードを入力してログインしてください。</h4></b>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="p_id" class="form-label">ID：</label>
                                <input type="text" class="form-control" id="p_id" name="p_id" maxlength="50" required>
                            </div>
                            <div class="mb-3">
                                <label for="p_pass" class="form-label">パスワード：</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" type="password" id="p_pass" name="p_pass" maxlength="50" required/>
                                    <button class="btn btn-secondary togglePassword" id="" style="cursor: pointer;">
                                        表示
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-body-secondary  text-center">
                            <input type="hidden" name="p_type" id="p_type" value="login">
                            <button type="button" class="btn btn-primary ps-5 pe-5 login" onclick="F_form_check(this.form)">ログイン</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</html>
