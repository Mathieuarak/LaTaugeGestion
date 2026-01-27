<?php

namespace App\Controllers;

class tarif extends BaseController
{
    public function index()
    {
        $clientModel = model('ClientModel');
        $tarifModel  = model('TarifModel');

        $tarif = $tarifModel->first();

        return view('cheval/ajout_cheval', [
            'clients' => $clientModel->findAll(),
            'tarif'   => $tarif
        ]);
    }
}
