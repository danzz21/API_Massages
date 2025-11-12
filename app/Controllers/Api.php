<?php

namespace App\Controllers;
use App\Models\MessageModel;
use CodeIgniter\RESTful\ResourceController;

class Api extends ResourceController
{
    protected $modelName = 'App\Models\MessageModel';
    protected $format    = 'json';
    //Get/api/messages
    public function index()
    {
        $data = $this->model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    //Post/api/messages
    public function create() {
        $json = $this->request->getJSON(true);
        if(!$json || empty(($json['name'] ?? '')  || empty(($json['text'] ?? '')))) {
            return $this->failValidationErrors("Nama dan Pesan wajib di isi");
        }

        $this->model->insert([
            'name' => $json['name'],
            'text' => $json['text'],
        ]);
        return $this->respondCreated(['status' => 'success' ,'data'=>$json]);
    }
}