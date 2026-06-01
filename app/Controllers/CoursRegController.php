<?php

namespace App\Controllers;

class CoursRegController extends BaseController
{
    protected $coursRegModel;
    protected $clientModel;
    protected $chevalModel;

    public function __construct()
    {
        $this->coursRegModel = model('CoursRegModel');
        $this->clientModel = model('ClientModel');
        $this->chevalModel = model('ChevalModel');
    }

    public function index()
    {
        $data = [
            'cours' => $this->coursRegModel->findAll(),
        ];
        return view('cours/cours_reguliers', $data);
    }

    public function create()
    {
        $data = [
            'clients' => $this->clientModel->findAll(),
            'chevaux' => $this->chevalModel->findAll(),
        ];
        return view('cours/create_regulier', $data);
    }

    public function store()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'clients_idclients' => $this->request->getPost('clients_idclients'),
                'coursDate'         => $this->request->getPost('coursDate'),
                'description'       => $this->request->getPost('description'),
            ];

            if ($this->coursRegModel->save($data)) {
                return redirect()->route('cours_reguliers_liste')->with('success', 'Cours régulier créé');
            }
        }

        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $cours = $this->coursRegModel->find($id);
        if (!$cours) {
            return redirect()->route('cours_reguliers_liste')->with('error', 'Cours non trouvé');
        }

        $data = [
            'cours' => $cours,
            'clients' => $this->clientModel->findAll(),
            'chevaux' => $this->chevalModel->findAll(),
        ];
        return view('cours/edit_regulier', $data);
    }

    public function update($id)
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'idcoursReg'        => $id,
                'clients_idclients' => $this->request->getPost('clients_idclients'),
                'coursDate'         => $this->request->getPost('coursDate'),
                'description'       => $this->request->getPost('description'),
            ];

            if ($this->coursRegModel->save($data)) {
                return redirect()->route('cours_reguliers_liste')->with('success', 'Cours régulier mis à jour');
            }
        }

        return redirect()->back()->withInput();
    }

    public function delete($id)
    {
        if ($this->coursRegModel->delete($id)) {
            return redirect()->route('cours_reguliers_liste')->with('success', 'Cours supprimé');
        }

        return redirect()->back()->with('error', 'Erreur lors de la suppression');
    }
}
