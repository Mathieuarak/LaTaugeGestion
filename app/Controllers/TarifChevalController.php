<?php

namespace App\Controllers;

class TarifChevalController extends BaseController
{
    protected $tarifsChevalModel;

    public function __construct()
    {
        $this->tarifsChevalModel = model('TarifsChevalModel');
    }

    public function index()
    {
        $data = [
            'tarifs_cheval' => $this->tarifsChevalModel->findAll(),
        ];
        return view('tarif/tarif_cheval', $data);
    }

    public function assign()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'cheval_id' => $this->request->getPost('cheval_id'),
                'tarif_id' => $this->request->getPost('tarif_id'),
            ];

            if ($this->tarifsChevalModel->save($data)) {
                return redirect()->back()->with('success', 'Tarif assigné au cheval avec succès');
            }
        }

        return redirect()->back()->with('error', 'Erreur lors de l\'assignation');
    }

    public function remove()
    {
        $id = $this->request->getPost('id');
        if ($this->tarifsChevalModel->delete($id)) {
            return redirect()->back()->with('success', 'Tarif retiré avec succès');
        }

        return redirect()->back()->with('error', 'Erreur lors de la suppression');
    }
}
