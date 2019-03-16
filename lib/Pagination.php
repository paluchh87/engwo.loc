<?php

namespace lib;

class Pagination
{
    private $max = 4;
    private $route;
    private $current_page;
    private $total;
    private $amount;

    public function __construct($route, $total, $limit = 2)
    {
        $this->route = $route;
        $this->total = $total;
        $this->amount = ceil($total / $limit);
        $this->setCurrentPage();
    }

    public function checkPage($page)
    {
        if ($page <= 0) {
            $page = '1';
        }
        if ($page > $this->amount) {
            $page = (string)$this->amount;
        }
        if ($this->route['page'] != $page) {
            $this->route['page'] = $page;
            $this->setCurrentPage();
        }

        return $page;
    }

    public function get()
    {
        $links = null;
        $limits = $this->limits();
        $html = '<nav><ul class="pagination">';
        for ($page = $limits['start']; $page <= $limits['end']; $page++) {
            if ($page == $this->current_page) {
                $links .= '<li class="page-item active"><span class="page-link">' . $page . '</span></li>';
            } else {
                $links .= $this->generateHtml($page);
            }
        }
        if (!is_null($links)) {
            if ($this->current_page > 1) {
                $links = $this->generateHtml(1, 'Начало') . $links;
            }
            if ($this->current_page < $this->amount) {
                $links .= $this->generateHtml($this->amount, 'Конец');
            }
        }
        $html .= $links . ' </ul></nav>';

        return $html;
    }

    private function generateHtml($page, $text = null)
    {
        if (!$text) {
            $text = $page;
        }
        if ($this->route['name'] == 'Admin') {
            return '<li class="page-item"><a class="page-link" href="/engwo/admin/' . $this->route['action'] . '/' . $page . '">' . $text . '</a></li>';
        }
        if ($this->route['name'] == 'Main') {
            return '<li class="page-item"><a class="page-link" href="/engwo/' . $this->route['action'] . '/' . $page . '">' . $text . '</a></li>';
        }
        return false;
    }

    private function limits()
    {
        $left = $this->current_page - round($this->max / 2);
        $start = $left > 0 ? $left : 1;
        if ($start + $this->max <= $this->amount) {
            $end = $start > 1 ? $start + $this->max : $this->max;
        } else {
            $end = $this->amount;
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }

        return [
            'start' => $start,
            'end' => $end
        ];
    }

    private function setCurrentPage()
    {
        if (isset($this->route['page'])) {
            $this->current_page = $this->route['page'];
        } else {
            $this->current_page = 1;
        }
    }
}
