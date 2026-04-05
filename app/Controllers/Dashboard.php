<?php

namespace App\Controllers;

use App\Models\RecordModel;

class Dashboard extends BaseController
{
    protected $recordModel;

    public function __construct()
    {
        $this->recordModel = new RecordModel();
    }
    public function index()
{
    $user = $this->getUserFromToken();

    if (!$user) {
        return $this->response->setJSON([
            'error' => 'Unauthorized'
        ])->setStatusCode(401);
    }

    // 🔥 ROLE-BASED LOGIC
    if ($user['role'] === 'admin' || $user['role'] === 'analyst') {
        // Admin & Analyst → ALL records
        $records = $this->recordModel->findAll();
    } else {
        // Viewer → ONLY own records
        $records = $this->recordModel
            ->where('created_by', $user['id'])
            ->findAll();
    }

    $income = 0;
    $expense = 0;

    foreach ($records as $r) {
        if ($r['type'] === 'income') {
            $income += $r['amount'];
        } else {
            $expense += $r['amount'];
        }
    }

    return $this->response->setJSON([
        'totalIncome' => $income,
        'totalExpense' => $expense,
        'netBalance' => $income - $expense
    ]);
}
}
