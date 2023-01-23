<?php
include_once 'ajax.php';

error_reporting(E_ALL ^ E_WARNING);

$result = ajaxResponser();

?>
<!DOCTYPE html>
    <head>
        <title>Отдел кадров</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6/dist/css/bootstrap.min.css">
        <style>
            li{
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="container">
                <h1>Отдел кадров</h1>
                <div class="btn-group btn-group-toggle d-flex justify-content-between" data-toggle="buttons">
                    <label class="btn btn-outline-primary active">
                        <input class="query" type="radio" name="options" value="1"> Испытательный срок
                    </label>
                    <label class="btn btn-outline-primary">
                        <input class="query" type="radio" name="options" value="2"> Уволенные
                    </label>
                    <label class="btn btn-outline-primary">
                        <input class="query" type="radio" name="options" value="3"> Начальники
                    </label>
                </div>
            <table class="table table-striped table-condensed table-bordered table-rounded">
                <?php
if (empty($result['error'])) {
    if (isset($result['table'])) {
        echo $result['table'];
    }

}
?>
            </table>
            <div class="paginator">
            <?php
if (empty($result['error'])) {
    if (isset($result['paginator'])) {
        echo $result['paginator'];
    }

}
?>
            </div>
        </div>
        <script>
            <?php if (isset($result['error'])) {?>
                $('table').html('<?=$result['error']?>');
            <?php }?>
        </script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6/dist/js/bootstrap.min.js"></script>
        <script src="ajax.js"></script>
    </body>
</html>