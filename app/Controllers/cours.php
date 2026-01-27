<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\CoursRegModel;
use App\Models\TarifCourRegModel;
use App\Models\CourRegTarifCourRegModel;

class Cours extends BaseController
{
    // LISTE DES COURS
    public function index()
    {
        $db = \Config\Database::connect();

        $cours = $db->table('coursReg c')
            ->select('c.*, cl.nom, cl.prenom,
                      t.tarifCourCollectifs,
                      t.tarifCourADeux,
                      t.tarifCourParticulier,
                      t.tarifTravailCheval')
            ->join('clients cl', 'cl.idclients = c.clients_idclients')
            ->join('courReg_tarifCourReg t', 't.coursReg_idcoursReg = c.idcoursReg', 'left')
            ->get()
            ->getResultArray();

        return view('cours/cours', [
            'cours' => $cours
        ]);
    }

    // FORMULAIRE AJOUT
    public function ajout()
    {
        $clientModel = new ClientModel();
        $tarifModel  = new TarifCourRegModel();

        return view('cours/ajout_cours', [
            'clients' => $clientModel->findAll(),
            'tarifs'  => $tarifModel->first()  // On récupère les tarifs disponibles
        ]);
    }

    // CREATE
    public function store()
    {
        $coursRegModel = new CoursRegModel();
        $linkModel     = new CourRegTarifCourRegModel();

        // 1️⃣ Insert dans coursReg
        $idCoursReg = $coursRegModel->insert([
            'coursDate'         => $this->request->getPost('coursDate'),
            'description'       => $this->request->getPost('description'),
            'clients_idclients' => $this->request->getPost('client')
        ]);

        // 2️⃣ Insert des options dans courReg_tarifCourReg
        $linkModel->insert([
            'coursReg_idcoursReg'        => $idCoursReg,
            'tarifCourReg_idtarifCourReg'=> $this->request->getPost('idTarif'),
            'tarifCourCollectifs'        => $this->request->getPost('tarifCourCollectifs') ? 1 : 0,
            'tarifCourADeux'             => $this->request->getPost('tarifCourADeux') ? 1 : 0,
            'tarifCourParticulier'       => $this->request->getPost('tarifCourParticulier') ? 1 : 0,
            'tarifTravailCheval'         => $this->request->getPost('tarifTravailCheval') ? 1 : 0,
        ]);

        return redirect()->route('cours')->with('success', 'Cours créé avec succès');
    }

    // FORMULAIRE EDIT
    public function edit($id)
    {
        $coursModel = new CoursRegModel();
        $linkModel  = new CourRegTarifCourRegModel();
        $clientModel = new ClientModel();
        $tarifModel  = new TarifCourRegModel();

        return view('cours/edit_cours', [
            'cours'   => $coursModel->find($id),
            'options' => $linkModel->where('coursReg_idcoursReg', $id)->first(),
            'clients' => $clientModel->findAll(),
            'tarifs'  => $tarifModel->first()
        ]);
    }

    // UPDATE
    public function update($id)
    {
        $coursModel = new CoursRegModel();
        $linkModel  = new CourRegTarifCourRegModel();

        // 1️⃣ Update du cours
        $coursModel->update($id, [
            'coursDate'         => $this->request->getPost('coursDate'),
            'description'       => $this->request->getPost('description'),
            'clients_idclients' => $this->request->getPost('client')
        ]);

        // 2️⃣ Update des options
        $linkModel
            ->where('coursReg_idcoursReg', $id)
            ->set([
                'tarifCourCollectifs'   => $this->request->getPost('tarifCourCollectifs') ? 1 : 0,
                'tarifCourADeux'        => $this->request->getPost('tarifCourADeux') ? 1 : 0,
                'tarifCourParticulier'  => $this->request->getPost('tarifCourParticulier') ? 1 : 0,
                'tarifTravailCheval'    => $this->request->getPost('tarifTravailCheval') ? 1 : 0,
            ])->update();

        return redirect()->route('cours')->with('success', 'Cours modifié avec succès');
    }

    // DELETE
    public function delete($id)
    {
        $coursModel = new CoursRegModel();
        $linkModel  = new CourRegTarifCourRegModel();

        // Supprime d'abord les options
        $linkModel->where('coursReg_idcoursReg', $id)->delete();

        // Puis le cours
        $coursModel->delete($id);

        return redirect()->route('cours')->with('success', 'Cours supprimé avec succès');
    }
}
