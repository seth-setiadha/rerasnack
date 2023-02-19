<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HeaderTable extends Component
{
    public $text;
    public $field;
    public $sort;
    public $sortBy;
    public $link;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $field, $sort, $sortBy, $link)
    {
        $this->text = $text;
        $this->field = $field;
        $this->sort = $sort;
        $this->sortBy = $sortBy;       
        $q = request()->query('q');
        $tanggal = request()->query('tanggal');

        $queryString = [];
        if(! empty($q)) {
            $queryString[] = "q=" . $q;
        }
        if(! empty($tanggal)) {
            $queryString[] = "tanggal=" . $tanggal;
        }       

        if($field == $sortBy) {
            if(empty($sort) || $sort == "ASC") {
                $queryString[] = "sortBy=" . $field;
                $queryString[] = "sort=DESC";
            } elseif($sort == "DESC") {
                $queryString[] = "sortBy=" . $field;
                $queryString[] = "sort=ASC";
            }            
        } else {
            $queryString[] = "sortBy=" . $field;
            $queryString[] = "sort=DESC";
        }
        $this->link = $link . "/?" . implode("&", $queryString);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.header-table');
    }
}
