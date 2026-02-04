<?php

namespace App\Controllers;

use App\Models\CoursForfaitModel;
use App\Models\CourForfaitTarifCourForfaitModel;
use App\Models\TarifCourForfaitModel;

class CoursForfaitController extends BaseController
{
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
            'tarifsForfait' => $tarifModel->findAll()
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

        $forfaitId = $this->request->getPost('forfait_id');
        if ($forfaitId) {
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
