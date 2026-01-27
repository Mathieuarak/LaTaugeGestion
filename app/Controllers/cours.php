<?php

namespace App\Controllers;

class cours extends BaseController
{
    public function index()
    {
        return view('cours/cours.php');
    }

    public function ajout()
    {
        $clientModel = new \App\Models\ClientModel();
        $clients = $clientModel->findAll();
        
        return view('cours/ajout_cours.php', [
            'clients' => $clients
        ]);
    }
}
