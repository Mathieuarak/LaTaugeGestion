<?php

namespace App\Controllers;

class Client extends BaseController
{
    public function client()
    {
        $clientModel = model('ClientModel');

        $search = $this->request->getGet('search');

        if (!empty($search)) {
            $client = $clientModel
                ->groupStart()
                ->like('nom', $search)
                ->orLike('prenom', $search)
                ->groupEnd()
                ->findAll();
        } else {
            $client = $clientModel->findAll();
        }

        return view('client/liste_clients', [
            'clientListe' => $client,
            'search' => $search
        ]);
    }


    public function ajout()
    {
        return view('client/ajout_client');
    }

    public function create()
    {
        $ClientModel = model('ClientModel');

        $telRaw = $this->request->getPost('tel');
        $telDigits = preg_replace('/\D+/', '', $telRaw);

        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'adressePost' => $this->request->getPost('adressePost'),
            'adresseMail' => $this->request->getPost('adresseMail'),
            'tel' => $telDigits,
        ];

        if ($ClientModel->insert($data)) {
            return redirect()->route('liste_clients')->with('success', 'client ajouté avec succès.');
        } else {
            return redirect()->back()->withInput()->with('errors', $ClientModel->errors());
        }
    }

    public function edit($id)
    {
        $ClientModel = model('ClientModel');
        $client = $ClientModel->find($id);

        if (!$client) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Client avec l'ID $id non trouvé");
        }

        return view('client/modif_client', [
            'client' => $client
        ]);
    }

    public function update($id)
    {
        $ClientModel = model('ClientModel');

        $telRaw = $this->request->getPost('tel');
        $telDigits = preg_replace('/\D+/', '', $telRaw);

        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'adressePost' => $this->request->getPost('adressePost'),
            'adresseMail' => $this->request->getPost('adresseMail'),
            'tel' => $telDigits,
        ];

        if ($ClientModel->update($id, $data)) {
            return redirect()->route('liste_clients')->with('success', 'client modifié avec succès.');
        } else {
            return redirect()->back()->withInput()->with('errors', $ClientModel->errors());
        }
    }

    public function delete($id)
    {
        $ClientModel = model('ClientModel');

        if ($ClientModel->delete($id)) {
            return redirect()->to(route_to('liste_clients'))
                ->with('success', 'Client supprimé avec succès.');
        } else {
            return redirect()->to(route_to('liste_clients'))
                ->with('error', 'Échec de la suppression du client.');
        }
    }
    public function show($idclients)
    {
        $ClientModel = model('ClientModel');
        $client = $ClientModel->find($idclients);
        if (! $client) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Client avec l'ID $idclients non trouvé");
        }

        $ChevalModel = model('ChevalModel');
        $chevaux = $ChevalModel->where('clients_idclients', $idclients)->findAll();

        return view('client/voir_client', [
            'client' => $client,
            'chevaux' => $chevaux,
        ]);
    }
}
