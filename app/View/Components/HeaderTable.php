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

        $this->link = $link . "/?sortBy=" . $field . "&sort=" . "ASC";

        if($field == $sortBy) {
            if(empty($sort)) {
                // $this->link = $link . "/?sortBy=" . $field . "&sort=" . "ASC";
            } elseif($sort == "ASC") {
                $this->link = $link . "/?sortBy=" . $field . "&sort=" . "DESC";
            } elseif($sort == "DESC") {
                $this->link = $link;
            }            
        }
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
