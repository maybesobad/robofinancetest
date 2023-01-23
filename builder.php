<?php
class builder
{
    protected $_conn;
    public $_limit;
    public $_page;
    protected $_query;
    public $_total;

    public function __construct($conn, $query)
    {

        $this->_conn = $conn;
        $this->_query = $query;

        $rs = $this->_conn->query($this->_query);
        $this->_total = $rs->num_rows;

    }
    public function getTable($page = 1, $limit = 3)
    {

        $this->_limit = $limit;
        $this->_page = $page;

        $query = $this->_query . " LIMIT " . (($this->_page - 1) * $this->_limit) . ", $this->_limit";

        $rs = $this->_conn->query($query);

        while ($row = $rs->fetch_assoc()) {
            $results[] = $row;
        }

        if (empty($results)) {
            return ['error' => 'Данные не обнаружены'];
        }

        $table = '<thead><tr>';

        foreach ($results as $value) {
            foreach ($value as $key => $data) {
                $table .= '<th>' . $key . '</th>';
            }
            $table .= '</tr>';
            break;
        }

        $table .= '</thead><tbody>';
        foreach ($results as $value) {
            $table .= '<tr>';
            foreach ($value as $data) {
                $table .= '<td>' . $data . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</tbody>';

        return $table;
    }

    public function getPaginator($links = 7, $ul_class = '', $li_class = '', $a_class = '', $num_of_query = 1)
    {

        $last = ceil($this->_total / $this->_limit);

        $start = (($this->_page - $links) > 0) ? $this->_page - $links + 1 : 1;
        $end = (($this->_page + $links) < $last) ? $this->_page + $links - 1 : $last;

        $paginator = '<ul class="' . $ul_class . '">';
        $paginator .= $this->_page == 1 ? '' :
        '<li class="' . $li_class . '" data-limit=' . $this->_limit . ' data-page=' . ($this->_page - 1) . ' data-query=' . $num_of_query . '>
            <a class="' . $a_class . '">&laquo;</a></li>';

        if ($start > 1) {
            $paginator .= '<li class="' . $li_class . '" data-limit=' . $this->_limit . ' data-page=1 data-query=' . $num_of_query . '><a class="' . $a_class . '">1</a></li>';
        }
        if ($start > 2) {
            $paginator .= '<li class="' . $li_class . ' disabled"><span class="' . $a_class . '">...</span></li>';
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($this->_page == $i) {
                $paginator .= '<li class="' . $li_class . ' active" ><a class="' . $a_class . '">' . $i . '</a></li>';
            } else {
                $paginator .= '<li class="' . $li_class . '" data-limit=' . $this->_limit . ' data-page=' . $i . ' data-query=' . $num_of_query . ' ><a class="' . $a_class . '">' . $i . '</a></li>';
            }

        }

        if ($end < $last) {
            $paginator .= '<li class="' . $li_class . ' disabled"><span class="' . $a_class . '">...</span></li>';
            $paginator .= '<li class="' . $li_class . '" data-limit=' . $this->_limit . ' data-page=' . $last . ' data-query=' . $num_of_query . ' ><a class="' . $a_class . '">' . $last . '</a></li>';
        }

        $paginator .= $this->_page == $last ? '' :
        '<li class="' . $li_class . '" data-limit=' . $this->_limit . ' data-page=' . ($this->_page + 1) . ' data-query=' . $num_of_query . ' ><a class="' . $a_class . '">&raquo;</a></li>';
        $paginator .= '</ul>';

        return $paginator;
    }
}
