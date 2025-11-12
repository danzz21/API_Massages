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

    //UPDATE Pesan API
    public function update($id = null) {
        $json = $this->request->getJSON(true);
       
        if(!$id || !$json) {
            return $this->failValidationErrors("Data tidak di temukan", 404);
        }
        if(empty(($json['name'] ?? '')  || empty(($json['text'] ?? '')))) {
            return $this->failValidationErrors("Nama dan Pesan wajib di isi");
        }

    //Mengecek keberadaan data
        $exist = $this->model->find($id);
        if(!$exist) {
            return $this->failValidationErrors("Data tidak di temukan", 404);
    }
    //UPDATE DATA
        $this->model->update($id, [
            'name' => $json['name'],
            'text' => $json['text'],
        ]);
        return $this->respond( [
            'status' => 'success',
            'message' => 'Data berhasil di update'
        ]);
    }

    //show id data
    public function show($id = null) {
        if(!$id) {
            return $this->failValidationErrors("id tidak boleh kosong", 404);
        }
        $data = $this->model->find($id);
        if(!$data) {
            return $this->failValidationErrors("Data tidak di temukan", 404);
    }
    return $this->respond($data);
    }
}