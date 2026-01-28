<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\CoursRegModel;
use App\Models\TarifCourRegModel;
use App\Models\CourRegTarifCourRegModel;

class Cours extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $clients = $db->table('coursreg c')
            ->select('cl.idclients, cl.nom, cl.prenom, COUNT(c.idcoursReg) as nbCours')
            ->join('clients cl', 'cl.idclients = c.clients_idclients')
            ->groupBy('cl.idclients')
            ->get()
            ->getResultArray();

        return view('cours/clients', [
            'clients' => $clients
        ]);
    }

    public function coursClient($idClient)
    {
        $db = \Config\Database::connect();
        $client = $db->table('clients')->where('idclients', $idClient)->get()->getRowArray();
        if (!$client) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Client introuvable");
        }

        $cours = $db->table('coursreg c')
            ->select('c.*, cl.nom, cl.prenom,
                  t.tarifCourCollectifs as tarifCollectif,
                  t.tarifCourADeux as tarifDeux,
                  t.tarifCourParticulier as tarifParticulier,
                  t.tarifTravailCheval as tarifCheval,
                  link.tarifCourCollectifs as optCollectif,
                  link.tarifCourADeux as optDeux,
                  link.tarifCourParticulier as optParticulier,
                  link.tarifTravailCheval as optCheval,
                  c.paye')
            ->join('clients cl', 'cl.idclients = c.clients_idclients')
            ->join('courReg_tarifCourReg link', 'link.coursreg_idcoursReg = c.idcoursReg', 'left')
            ->join('tarifcourreg t', 't.idtarifCourReg = link.tarifCourReg_idtarifCourReg', 'left')
            ->where('c.clients_idclients', $idClient)
            ->get()
            ->getResultArray();

        return view('cours/cours_client', [
            'client' => $client,
            'cours'  => $cours
        ]);
    }

    public function togglePaye($id)
    {
        $coursModel = new CoursRegModel();
        $cours = $coursModel->find($id);
        if (!$cours) return redirect()->back()->with('error', 'Cours introuvable.');

        // Toggle le paiement
        $nouveauPaye = $cours['paye'] ? 0 : 1;
        $coursModel->update($id, ['paye' => $nouveauPaye]);

        // Redirection vers la page du client
        return redirect()->to(route_to('cours_client', $cours['clients_idclients']));
    }





    public function ajout()
    {
        $clientModel = new ClientModel();
        $tarifModel  = new TarifCourRegModel();

        return view('cours/ajout_cours', [
            'clients' => $clientModel->findAll(),
            'tarifs'  => $tarifModel->first()
        ]);
    }

    public function store()
    {
        $coursRegModel = new CoursRegModel();
        $linkModel     = new CourRegTarifCourRegModel();

        $idcoursReg = $coursRegModel->insert([
            'coursDate'         => $this->request->getPost('coursDate'),
            'description'       => $this->request->getPost('description'),
            'clients_idclients' => $this->request->getPost('client')
        ]);
        $linkModel->insert([
            'coursreg_idcoursReg'        => $idcoursReg,
            'tarifCourReg_idtarifCourReg' => $this->request->getPost('idTarif'),
            'tarifCourCollectifs'        => $this->request->getPost('tarifCourCollectifs') ? 1 : 0,
            'tarifCourADeux'             => $this->request->getPost('tarifCourADeux') ? 1 : 0,
            'tarifCourParticulier'       => $this->request->getPost('tarifCourParticulier') ? 1 : 0,
            'tarifTravailCheval'         => $this->request->getPost('tarifTravailCheval') ? 1 : 0,
        ], false);


        return redirect()->route('cours')->with('success', 'Cours créé avec succès');
    }

    public function edit($id)
    {
        $redirectClient = $this->request->getGet('redirect');
        $coursModel = new CoursRegModel();
        $linkModel  = new CourRegTarifCourRegModel();
        $clientModel = new ClientModel();
        $tarifModel  = new TarifCourRegModel();

        return view('cours/edit_cours', [
            'cours'   => $coursModel->find($id),
            'options' => $linkModel->where('coursReg_idcoursReg', $id)->first(),
            'clients' => $clientModel->findAll(),
            'tarifs'  => $tarifModel->first(),
            'redirectClient' => $redirectClient,
        ]);
    }



    public function update($id)
    {
        $coursModel = new CoursRegModel();
        $linkModel  = new CourRegTarifCourRegModel();

        $coursModel->update($id, [
            'coursDate'         => $this->request->getPost('coursDate'),
            'description'       => $this->request->getPost('description'),
            'clients_idclients' => $this->request->getPost('client')
        ]);

        $linkModel
            ->where('coursreg_idcoursReg', $id)
            ->set([
                'tarifCourCollectifs'   => $this->request->getPost('tarifCourCollectifs') ? 1 : 0,
                'tarifCourADeux'        => $this->request->getPost('tarifCourADeux') ? 1 : 0,
                'tarifCourParticulier'  => $this->request->getPost('tarifCourParticulier') ? 1 : 0,
                'tarifTravailCheval'    => $this->request->getPost('tarifTravailCheval') ? 1 : 0,
            ])->update();

        $redirectClient = $this->request->getPost('redirectClient');
        if ($redirectClient) {
            return redirect()->to(route_to('cours_client', $redirectClient))->with('success', 'Cours modifié avec succès');
        }

        return redirect()->route('cours')->with('success', 'Cours modifié avec succès');
    }



    public function delete($id)
    {
        $coursModel = new CoursRegModel();
        $linkModel  = new CourRegTarifCourRegModel();

        $cours = $coursModel->find($id);
        if (!$cours) return redirect()->back()->with('error', 'Cours introuvable.');

        $linkModel->where('coursreg_idcoursReg', $id)->delete();
        $coursModel->delete($id);

        // Redirection vers la page du client
        return redirect()->to(route_to('cours_client', $cours['clients_idclients']))->with('success', 'Cours supprimé');
    }
}
