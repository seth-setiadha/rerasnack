<?php

namespace App\Repositories;

use App\Models\Tempnotes;

class TempnotesRepository
{
    public $model;

    public $q;
    public $tanggalTransaksi;
    public $sort;
    public $sortBy;
    public $perPage;

    public function __construct()
    {     
        $this->model = new Tempnotes();

        $this->q = request()->query('q');
        $this->tanggalTransaksi = request()->query('tanggal');
        $this->sort = request()->query('sort');
        $this->sortBy = request()->query('sortBy');
        $this->perPage = intval(request()->query('perPage'));
        $this->perPage = $this->perPage > 0 && $this->perPage <= 100 ? $this->perPage : 15;
    }

    public function index() {
        $data = $this->model->select("tempnotes.*", "items.item_name", "items.item_code")
                ->leftJoin('items', 'items.id', '=', 'tempnotes.item_id');
        if(! empty($this->q)) {
            $data->where(function($query) {
                $query->where('items.item_name', 'LIKE', '%' . $this->q . '%')
                        ->orWhere('tempnotes.tanggal', 'LIKE', '%' . $this->q . '%')
                        ->orWhere('tempnotes.updated_at', 'LIKE', '%' . $this->q . '%')
                        ->orWhere('items.item_code', 'LIKE', '%' . $this->q . '%');
            });                    
        }
        if(! empty($this->sortBy)) { 
            if(empty($this->sort) && ! in_array($this->sort, ['ASC', 'DESC'])) {
                $this->sort = 'DESC';
            }
            $data->orderBy($this->sortBy, $this->sort);
        } else {
            $data->orderBy("tempnotes.tanggal", "DESC");
        }
        return ["data" => $data->paginate($this->perPage)->withQueryString(), "q" => $this->q, "tanggal" => $this->tanggalTransaksi, "sortBy" => $this->sortBy, "sort" => $this->sort];
    }

    public function update($tempnote, $data) {
        $tempnote->tanggal = $data['tanggal'];
        if(! empty($data['item_id'])) { $tempnote->item_id = $data['item_id']; }
        $tempnote->harga = $data['harga'];
        $tempnote->note = $data['note'];
        return $tempnote->save();
    }

}