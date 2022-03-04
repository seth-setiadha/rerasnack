<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public $model;

    public $q;
    public $perPage;

    public function __construct()
    {
        $this->model = new User();

        $this->q = request()->query('q');
        $this->perPage = intval(request()->query('perPage'));
        $this->perPage = $this->perPage > 0 && $this->perPage <= 100 ? $this->perPage : 15;
    }

    public function index() {
        $data = $this->model->select("id", "name", "email")->orderBy("name", "ASC");
        if(! empty($this->q)) {
            $data->where(function($query)  {
                $query->where('name', 'LIKE', '%' . $this->q . '%')
                ->orWhere('email', 'LIKE', '%' . $this->q . '%');
            });                    
        }
        return ["data" => $data->paginate($this->perPage)->withQueryString(), "q" => $this->q];
    }
}