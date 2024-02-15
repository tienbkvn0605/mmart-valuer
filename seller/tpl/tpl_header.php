
<nav class="navbar navbar-expand-lg text-light rounded pt-2 pb-2 mb-3" style="background-color: #a9a6ff; border-color: #a9a6ff">
  <div class="container-fluid">
    <h3 class="mb-0 text-dark">
        <span class="badge bg-secondary"><?php echo mb_convert_encoding($A_seller['valeur_coname'], 'utf-8', 'auto')?></span><span class="fw-bold" style="font-size: 20px;">　<?php echo $header_title;?></span>
    </h3>

    <ul class="list-group list-group-horizontal">
        <li class="list-group-item pt-2">ログイン者：<span class="badge bg-secondary fs-5 mt-1"><?php echo mb_convert_encoding($A_seller['valeur_tantou'], 'utf-8', 'auto') ?? '太郎'?></span></li>
        <li class="list-group-item ">
            <a href="/outlet/valeur/admin/login.php?p_type=logout" type="button" class="btn btn-warning" onclick="return confirm('管理画面をログアウトします\nよろしいですか？');">ログアウト</a>
        </li>
     </ul>
    </div>
  </div>
</nav>