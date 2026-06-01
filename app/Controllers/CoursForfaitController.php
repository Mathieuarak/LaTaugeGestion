<?php

namespace App\Controllers;

use App\Models\CoursForfaitModel;
use App\Models\CourForfaitTarifCourForfaitModel;
use App\Models\TarifCourForfaitModel;
use App\Models\ClientModel;
use App\Models\TarifCourRegModel;

class CoursForfaitController extends BaseController
{
    public function index()
    {
        $model = new CoursForfaitModel();
        $cours = $model->findAll();

        return view('cours/cours_forfaits_liste', [
            'cours' => $cours
        ]);
    }

    public function create()
    {
        $tarifModel = new TarifCourForfaitModel();
        $clientModel = new ClientModel();

        return view('cours/create_forfait', [
            'tarifsForfait' => $tarifModel->findAll(),
            'clients' => $clientModel->findAll()
        ]);
    }

    public function store()
    {
        $model = new CoursForfaitModel();
        $pivot = new CourForfaitTarifCourForfaitModel();
        $tarifModel = new TarifCourForfaitModel();

        if ($this->request->getMethod() === 'post') {
            $data = [
                'clients_idclients' => $this->request->getPost('clients_idclients'),
                'description'       => $this->request->getPost('description'),
                'dateAjout'        => date('Y-m-d')
            ];

            $coursId = $model->insert($data);
            $forfaitId = $this->request->getPost('forfait_id');

            if ($forfaitId && $coursId) {
                $tarifRow = $tarifModel->find($forfaitId);
                $pivotData = [
                    'coursForfait_idcoursfor' => $coursId,
                    'tarifCourForfait_idtarifCours' => $forfaitId
                ];

                $fields = ['tarifCoursCollec10','tarifCoursDuo10','tarifCoursSolo10','travailCheval1','tarifCoursCollec5','tarifCoursDuo5','tarifCoursSolo5','travailCheval2'];
                foreach ($fields as $f) {
                    if (isset($tarifRow[$f]) && is_numeric($tarifRow[$f]) && floatval($tarifRow[$f])>0) {
                        $pivotData[$f] = floatval($tarifRow[$f]);
                    }
                }
                $pivot->insert($pivotData);
            }

            return redirect()->route('cours')->with('success', 'Forfait créé avec succès');
        }

        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $model = new CoursForfaitModel();
        $pivot = new CourForfaitTarifCourForfaitModel();
        $tarifModel = new TarifCourForfaitModel();

        $cours = $model->find($id);
        if (!$cours) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Forfait introuvable');
        }

        $link = $pivot->where('coursForfait_idcoursfor', $id)->first();

        return view('cours/edit_forfait', [
            'cours' => $cours,
            'link'  => $link,
            'tarifsForfait' => $tarifModel->findAll(),
            'clients' => (new ClientModel())->findAll(),
            'tarifs'  => (new TarifCourRegModel())->first()
        ]);
    }

    public function update($id)
    {
        $model = new CoursForfaitModel();
        $pivot = new CourForfaitTarifCourForfaitModel();
        $tarifModel = new TarifCourForfaitModel();

        $cours = $model->find($id);
        if (!$cours) return redirect()->back()->with('error', 'Forfait introuvable');

        $model->update($id, [
            'description' => $this->request->getPost('description'),
            'dateAjout'   => $this->request->getPost('dateAjout')
        ]);

        // remplacer le lien pivot
        $pivot->where('coursForfait_idcoursfor', $id)->delete();

        // Support both old 'forfait_id' (single tarif row) and new 'forfait_option' (field|id)
        $rawOption = $this->request->getPost('forfait_option');
        $forfaitId = $this->request->getPost('forfait_id');

        if ($rawOption) {
            [$fieldChoisi, $tarifId] = explode('|', $rawOption);
            $tarifRow = $tarifModel->find($tarifId);

            if ($tarifRow && isset($tarifRow[$fieldChoisi])) {
                $prix = floatval($tarifRow[$fieldChoisi]);

                $fields = [
                    'tarifCoursCollec10',
                    'tarifCoursDuo10',
                    'tarifCoursSolo10',
                    'travailCheval1',
                    'tarifCoursCollec5',
                    'tarifCoursDuo5',
                    'tarifCoursSolo5',
                    'travailCheval2'
                ];

                // create pivot row with the chosen field set to the price and prixFinal
                $dataOptions = [
                    'coursForfait_idcoursfor'       => $id,
                    'tarifCourForfait_idtarifCours' => $tarifId,
                    'prixFinal'                     => $prix
                ];
                foreach ($fields as $f) {
                    $dataOptions[$f] = ($f === $fieldChoisi) ? $prix : null;
                }

                $pivot->insert($dataOptions);
            }
        } elseif ($forfaitId) {
            // legacy: insert all numeric fields from tarif row
            $tarifRow = $tarifModel->find($forfaitId);
            $data = [
                'coursForfait_idcoursfor' => $id,
                'tarifCourForfait_idtarifCours' => $forfaitId
            ];
            $fields = ['tarifCoursCollec10','tarifCoursDuo10','tarifCoursSolo10','travailCheval1','tarifCoursCollec5','tarifCoursDuo5','tarifCoursSolo5','travailCheval2'];
            foreach ($fields as $f) {
                if (isset($tarifRow[$f]) && is_numeric($tarifRow[$f]) && floatval($tarifRow[$f])>0) {
                    $data[$f] = floatval($tarifRow[$f]);
                }
            }
            $pivot->insert($data);
        }

        return redirect()->to(route_to('cours_client', $cours['clients_idclients']))->with('success', 'Forfait modifié');
    }

    public function delete($id)
    {
        $model = new CoursForfaitModel();
        $pivot = new CourForfaitTarifCourForfaitModel();

        $cours = $model->find($id);
        if (!$cours) return redirect()->back();

        $pivot->where('coursForfait_idcoursfor', $id)->delete();
        $model->delete($id);

        return redirect()->to(route_to('cours_client', $cours['clients_idclients']))->with('success', 'Forfait supprimé');
    }
}
