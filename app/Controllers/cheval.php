<?php

namespace App\Controllers;

use App\Models\ChevalModel;
use App\Models\ClientModel;
use App\Models\TarifModel;
use App\Models\TarifsChevalModel;

class Cheval extends BaseController
{
    public function liste()
    {
        $ChevalModel = model('ChevalModel');
        $search = $this->request->getGet('search');

        if (!empty($search)) {
            $chevaux = $ChevalModel
                ->groupStart()
                ->like('nom', $search)
                ->groupEnd()
                ->findAll();
        } else {
            $chevaux = $ChevalModel->findAll();
        }

        return view('cheval/liste_chevaux', [
            'chevauxListe' => $chevaux,
            'search' => $search
        ]);
    }

    public function ajout()
    {
        $clientModel = model('ClientModel');
        $tarifModel  = model('TarifModel');

        $tarif = $tarifModel->first();

        return view('cheval/ajout_cheval', [
            'clients' => $clientModel->findAll(),
            'tarif'   => $tarif
        ]);
    }

    public function create()
    {
        $chevalModel       = model('ChevalModel');
        $tarifsChevalModel = model('TarifsChevalModel');
        $tarifModel        = model('TarifModel');

        $tarif = $tarifModel->first();
        if (!$tarif) {
            return redirect()->back()->withInput()->with('error', 'Les tarifs ne sont pas définis.');
        }

        $chevalData = [
            'clients_idclients' => $this->request->getPost('clients_idclients'),
            'nom'               => $this->request->getPost('nom'),
            'numSire'           => $this->request->getPost('numSire'),
            'dateNaissance'     => $this->request->getPost('dateNaissance'),
            'dateArrivee'       => $this->request->getPost('dateArrivee'),
            'vaccin'            => $this->request->getPost('vaccin'),
        ];

        if (!$chevalModel->insert($chevalData)) {
            return redirect()->back()->withInput()->with('errors', $chevalModel->errors());
        }

        $chevalId = $chevalModel->getInsertID();

        $options = [
            'pensions_idpensions'   => $chevalId,
            'tarifs_idtarifs'       => $tarif['idtarifs'],
            'alimFloconne'          => $this->request->getPost('alimFloconne') ? 1 : 0,
            'alimFloconne1'         => $this->request->getPost('alimFloconne1') ? 1 : 0,
            'alimFloconne13'        => $this->request->getPost('alimFloconne13') ? 1 : 0,
            'optBoxe'               => $this->request->getPost('optBoxe') ? 1 : 0,
            'optInstallation'       => $this->request->getPost('optInstallation') ? 1 : 0,
            'optPaddockSolo'        => $this->request->getPost('optPaddockSolo') ? 1 : 0,
            'optPaddockDuo'         => $this->request->getPost('optPaddockDuo') ? 1 : 0,
            'optSortiPaddockHerbe'  => $this->request->getPost('optSortiPaddockHerbe') ? 1 : 0,
            'forfaitAutreAlim'      => $this->request->getPost('forfaitAutreAlim') ? 1 : 0,
            'totalTarif'            => $this->request->getPost('total_tarif'),
        ];

        $tarifsChevalModel->insert($options);

        return redirect()->route('chevaux_liste')->with('success', 'Cheval ajouté avec succès.');
    }

    public function show($id)
    {
        $chevalModel       = model('ChevalModel');
        $tarifsChevalModel = model('TarifsChevalModel');
        $tarifModel        = model('TarifModel');
        $clientModel       = model('ClientModel');

        $cheval = $chevalModel->find($id);
        if (!$cheval) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Cheval avec l'ID $id non trouvé");
        }

        $tarifsCheval = $tarifsChevalModel->getByCheval($id);
        $client = $clientModel->find($cheval['clients_idclients']);

        return view('cheval/voir_cheval', [
            'cheval'        => $cheval,
            'client'        => $client,
            'tarifs_cheval' => $tarifsCheval,
            'tarif'         => $tarifModel->first()
        ]);
    }

    public function edit($id)
    {
        $chevalModel       = model('ChevalModel');
        $clientModel       = model('ClientModel');
        $tarifsChevalModel = model('TarifsChevalModel');
        $tarifModel        = model('TarifModel');

        $cheval = $chevalModel->find($id);
        if (!$cheval) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Cheval avec l'ID $id non trouvé");
        }

        $tarifsCheval = $tarifsChevalModel->getByCheval($id);
        $cheval['tarifs_cheval'] = $tarifsCheval ?: [
            'alimFloconne'        => 0,
            'alimFloconne1'       => 0,
            'alimFloconne13'      => 0,
            'optBoxe'             => 0,
            'optInstallation'     => 0,
            'optPaddockSolo'      => 0,
            'optPaddockDuo'       => 0,
            'optSortiPaddockHerbe'=> 0,
            'forfaitAutreAlim'    => 0,
            'totalTarif'          => 0
        ];

        return view('cheval/modif_cheval', [
            'cheval'  => $cheval,
            'clients' => $clientModel->findAll(),
            'tarif'   => $tarifModel->first()
        ]);
    }

    public function update($id)
    {
        $chevalModel       = model('ChevalModel');
        $tarifsChevalModel = model('TarifsChevalModel');

        $chevalModel->update($id, [
            'clients_idclients' => $this->request->getPost('clients_idclients'),
            'nom'               => $this->request->getPost('nom'),
            'numSire'           => $this->request->getPost('numSire'),
            'dateNaissance'     => $this->request->getPost('dateNaissance'),
            'dateArrivee'       => $this->request->getPost('dateArrivee'),
            'vaccin'            => $this->request->getPost('vaccin'),
        ]);

        $optionsData = [
            'alimFloconne'        => $this->request->getPost('alimFloconne') ? 1 : 0,
            'alimFloconne1'       => $this->request->getPost('alimFloconne1') ? 1 : 0,
            'alimFloconne13'      => $this->request->getPost('alimFloconne13') ? 1 : 0,
            'optBoxe'             => $this->request->getPost('optBoxe') ? 1 : 0,
            'optInstallation'     => $this->request->getPost('optInstallation') ? 1 : 0,
            'optPaddockSolo'      => $this->request->getPost('optPaddockSolo') ? 1 : 0,
            'optPaddockDuo'       => $this->request->getPost('optPaddockDuo') ? 1 : 0,
            'optSortiPaddockHerbe'=> $this->request->getPost('optSortiPaddockHerbe') ? 1 : 0,
            'forfaitAutreAlim'    => $this->request->getPost('forfaitAutreAlim') ? 1 : 0,
            'totalTarif'          => $this->request->getPost('total_tarif'),
        ];

        $existing = $tarifsChevalModel->getByCheval($id);
        if ($existing) {
            $tarifsChevalModel->updateByCheval($id, $optionsData);
        } else {
            $optionsData['pensions_idpensions'] = $id;
            $optionsData['tarifs_idtarifs']     = 1;
            $tarifsChevalModel->insert($optionsData);
        }

        return redirect()->route('chevaux_liste')->with('success', 'Cheval modifié avec succès.');
    }

    public function delete($id)
    {
        $chevalModel       = model('ChevalModel');
        $tarifsChevalModel = model('TarifsChevalModel');

        $tarifsChevalModel->where('pensions_idpensions', $id)->delete();
        $chevalModel->delete($id);

        return redirect()->route('chevaux_liste')->with('success', 'Cheval supprimé avec succès.');
    }
}
