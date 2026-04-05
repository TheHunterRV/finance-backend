<?php

namespace App\Controllers;

use App\Models\RecordModel;

class Records extends BaseController
{
    protected $recordModel;

    public function __construct()
    {
        $this->recordModel = new RecordModel();
    }


    //Only Admin
public function create()
{
    $user = $this->getUserFromToken();


    if (!$user) {
        return $this->response->setJSON([
            'error' => 'Unauthorized'
        ])->setStatusCode(401);
    }

    $data = $this->request->getJSON(true);

    if (!$data) {
        return $this->response->setJSON([
            'error' => 'Invalid input'
        ])->setStatusCode(400);
    }

    $data['created_by'] = $user['id'];

    $this->recordModel->insert($data);

    return $this->response->setJSON([
        'message' => 'Record created',
        'id' => $this->recordModel->getInsertID()
    ])->setStatusCode(201);
}


    // READ (Admin + Analyst)
    public function index()
    {
        $user = $this->checkRole(['admin', 'analyst']);

        if (isset($user['error'])) return $user;

        $records = $this->recordModel
            ->where('created_by', $user['id'])
            ->findAll();

        return $this->response->setJSON($records);
    }

    //  UPDATE (Admin only)
    public function update($id)
    {
        $user = $this->checkRole(['admin']);

        if (isset($user['error'])) return $user;

        $data = $this->request->getJSON(true);

        $this->recordModel->update($id, $data);

        return $this->response->setJSON([
            'message' => 'Record updated'
        ]);
    }

    //  DELETE (Admin only)
    public function delete($id)
    {
        $user = $this->checkRole(['admin']);

        if (isset($user['error'])) return $user;

        $this->recordModel->delete($id);

        return $this->response->setJSON([
            'message' => 'Record deleted'
        ]);
    }
}