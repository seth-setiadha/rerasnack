<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;

class Items extends Component
{
    public $search, $isEmpty = '';
    
    public function render()
    {
        if (! is_null($this->search)) {
            $items = Item::search($this->search)->take(5)->get();
            $this->isEmpty = '';
        } else {
            $items = [];
            $this->isEmpty = __('Nothings Found.');
        }
        
        return view('livewire.items', [
            'items' => $items,
        ]);

        // return view('livewire.items', [
        //     'items' => Item::where('item_name', $this->searchItem)->get(),
        // ]);
    }
}
