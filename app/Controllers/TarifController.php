<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class TarifController extends BaseController
{
    protected $tarifModel;

    public function __construct()
    {
        $this->tarifModel = model('TarifModel');
    }

    public function index()
    {
        $data = [
            'tarifs' => $this->tarifModel->findAll(),
        ];
        return view('tarif/index', $data);
    }

    public function create()
    {
        return view('tarif/create');
    }

    public function store()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'libelle' => $this->request->getPost('libelle'),
                'prix' => $this->request->getPost('prix'),
            ];

            if ($this->tarifModel->save($data)) {
                return redirect()->route('tarifs_liste')->with('success', 'Tarif créé avec succès');
            }
        }

        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $tarif = $this->tarifModel->find($id);
        if (!$tarif) {
            return redirect()->route('tarifs_liste')->with('error', 'Tarif non trouvé');
        }

        return view('tarif/edit', ['tarif' => $tarif]);
    }

    public function update($id)
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'id' => $id,
                'libelle' => $this->request->getPost('libelle'),
                'prix' => $this->request->getPost('prix'),
            ];

            if ($this->tarifModel->save($data)) {
                return redirect()->route('tarifs_liste')->with('success', 'Tarif mis à jour avec succès');
            }
        }

        return redirect()->back()->withInput();
    }

    public function delete($id)
    {
        if ($this->tarifModel->delete($id)) {
            return redirect()->route('tarifs_liste')->with('success', 'Tarif supprimé avec succès');
        }

        return redirect()->back()->with('error', 'Erreur lors de la suppression');
    }
}
