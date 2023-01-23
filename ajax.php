<?php
include_once 'builder.php';
include_once 'db.php';
include_once 'config.php';

if (isset($_GET['check'])) {
    echo json_encode(ajaxResponser());
}
function ajaxResponser()
{

    global $QUERYS;
    global $LIMIT;
    global $PAGE;
    global $LINKS;
    global $QUERY;

    $query = isset($_GET['query']) ? $_GET['query'] : $QUERY;

    if (isset($_GET['check'])) {
        $query = $_GET['check'];
    }

    $sql = $QUERYS[$query];

    $mysqli = getConnection();

    if ($mysqli->connect_errno) {
        return ['error' => $mysqli->connect_error];
    }

    $limit = (isset($_GET['limit'])) ? $_GET['limit'] : $LIMIT;
    $page = (isset($_GET['page'])) ? $_GET['page'] : $PAGE;
    $links = (isset($_GET['links'])) ? $_GET['links'] : $LINKS;

    $builder = new builder($mysqli, $sql);
    $table = $builder->getTable($page, $limit);

    if (isset($table['error'])) {
        return $table;
    }
    $paginator = $builder->getPaginator($links, 'pagination justify-content-center', 'page-item', 'page-link', $query);

    $mysqli->close();

    return ['table' => $table, 'paginator' => $paginator];
}
