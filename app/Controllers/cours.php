<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\CoursRegModel;
use App\Models\TarifCourRegModel;
use App\Models\CourRegTarifCourRegModel;

use App\Models\CoursForfaitModel;
use App\Models\TarifCourForfaitModel;
use App\Models\CourForfaitTarifCourForfaitModel;

class Cours extends BaseController
{
    /* =======================
       LISTE DES CLIENTS
    ======================= */
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

    /* =======================
       COURS D’UN CLIENT
    ======================= */
    public function coursClient($idClient)
    {
        $db = \Config\Database::connect();

        $client = $db->table('clients')
            ->where('idclients', $idClient)
            ->get()
            ->getRowArray();

        if (!$client) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Client introuvable');
        }

        // Cours à l’unité
        $cours = $db->table('coursreg c')
            ->select('c.*,
                t.tarifCourCollectifs as tarifCollectif,
                t.tarifCourADeux as tarifDeux,
                t.tarifCourParticulier as tarifParticulier,
                t.tarifTravailCheval as tarifCheval,
                link.tarifCourCollectifs as optCollectif,
                link.tarifCourADeux as optDeux,
                link.tarifCourParticulier as optParticulier,
                link.tarifTravailCheval as optCheval
            ')
            ->join('courReg_tarifCourReg link', 'link.coursreg_idcoursReg = c.idcoursReg', 'left')
            ->join('tarifcourreg t', 't.idtarifCourReg = link.tarifCourReg_idtarifCourReg', 'left')
            ->where('c.clients_idclients', $idClient)
            ->get()
            ->getResultArray();

        // Forfaits: récupérer les lignes jointes et regrouper par enregistrement de forfait
        $rawForfaits = $db->table('coursForfait cf')
            ->select('cf.*, link.*, tf.*')
            ->join('courForfait_tarifCourForfait link', 'link.coursForfait_idcoursfor = cf.idcoursfor', 'left')
            ->join('tarifcourforfait tf', 'tf.idtarifCours = link.tarifCourForfait_idtarifCours', 'left')
            ->where('cf.clients_idclients', $idClient)
            ->get()
            ->getResultArray();

        // labels pour les champs de forfait (doit correspondre à ceux utilisés dans les vues)
        $labels = [
            'tarifCoursCollec10' => 'Cours collectif 10',
            'tarifCoursDuo10'    => 'Cours à deux 10',
            'tarifCoursSolo10'   => 'Cours solo 10',
            'travailCheval1'     => 'Travail cheval 1',
            'tarifCoursCollec5'  => 'Cours collectif 5',
            'tarifCoursDuo5'     => 'Cours à deux 5',
            'tarifCoursSolo5'    => 'Cours solo 5',
            'travailCheval2'     => 'Travail cheval 2'
        ];

        $forfaits = [];
        foreach ($rawForfaits as $row) {
            $id = $row['idcoursfor'] ?? null;
            if (!$id) continue;

            if (!isset($forfaits[$id])) {
                $forfaits[$id] = [
                    'idcoursfor' => $id,
                    'dateAjout'  => $row['dateAjout'] ?? null,
                    'description'=> $row['description'] ?? '',
                    'options'    => []
                ];
            }

            // parcourir les champs connus et ajouter une option si la valeur présente > 0
            foreach (array_keys($labels) as $field) {
                $prix = 0;
                if (isset($row[$field]) && is_numeric($row[$field]) && floatval($row[$field]) > 0) {
                    $prix = floatval($row[$field]);
                } elseif (isset($row["{$field}"]) && !empty($row["{$field}"])) {
                    // fallback (au cas où la colonne serait non numérique)
                    $prix = floatval($row["{$field}"]);
                }

                if ($prix > 0) {
                    $forfaits[$id]['options'][] = [
                        'nom'  => $labels[$field],
                        'prix' => $prix
                    ];
                }
            }
        }

        // réindexer en tableau séquentiel
        $forfaits = array_values($forfaits);

        return view('cours/cours_client', [
            'client'   => $client,
            'cours'    => $cours,
            'forfaits' => $forfaits
        ]);
    }

    /* =======================
       TOGGLE PAYÉ
    ======================= */
    public function togglePaye($id)
    {
        $coursModel = new CoursRegModel();
        $cours = $coursModel->find($id);

        if (!$cours) {
            return redirect()->back()->with('error', 'Cours introuvable');
        }

        $coursModel->update($id, [
            'paye' => $cours['paye'] ? 0 : 1
        ]);

        return redirect()->to(route_to('cours_client', $cours['clients_idclients']));
    }

    /* =======================
       AJOUT COURS
    ======================= */
    public function ajout()
    {
        return view('cours/ajout_cours', [
            'clients'       => (new ClientModel())->findAll(),
            'tarifs'        => (new TarifCourRegModel())->first(),
            'tarifsForfait' => (new TarifCourForfaitModel())->findAll()
        ]);
    }

    /* =======================
       ENREGISTREMENT COURS
    ======================= */
    public function store()
    {
        $type = $this->request->getPost('type_cours'); // unique ou forfait
        $clientId = $this->request->getPost('client');
        $description = $this->request->getPost('description');

        if ($type === 'unique') {
            $option = $this->request->getPost('option_unique');

            $coursRegModel = new CoursRegModel();
            $linkModel     = new CourRegTarifCourRegModel();

            $idcoursReg = $coursRegModel->insert([
                'coursDate'         => $this->request->getPost('coursDate'),
                'description'       => $description,
                'clients_idclients' => $clientId
            ]);

            $linkModel->insert([
                'coursreg_idcoursReg'         => $idcoursReg,
                'tarifCourReg_idtarifCourReg' => $this->request->getPost('idTarif'),
                'tarifCourCollectifs'   => $option === 'tarifCourCollectifs' ? 1 : 0,
                'tarifCourADeux'        => $option === 'tarifCourADeux' ? 1 : 0,
                'tarifCourParticulier'  => $option === 'tarifCourParticulier' ? 1 : 0,
                'tarifTravailCheval'    => $option === 'tarifTravailCheval' ? 1 : 0
            ]);
        } elseif ($type === 'forfait') {

            $forfaitOption = $this->request->getPost('forfait_option');
            if (!$forfaitOption) {
                return redirect()->back()->with('error', 'Veuillez sélectionner une option de forfait');
            }

            list($field, $forfaitId) = explode('_', $forfaitOption);

            $coursForfaitModel = new CoursForfaitModel();
            $coursForfaitTarifModel = new CourForfaitTarifCourForfaitModel();
            $tarifForfaitModel = new TarifCourForfaitModel();

            // 1️⃣ Créer l’enregistrement général
            $idcoursFor = $coursForfaitModel->insert([
                'clients_idclients' => $clientId,
                'description'       => $description,
                'dateAjout'         => date('Y-m-d')
            ]);

            // 2️⃣ Créer la ligne pivot avec uniquement l'option sélectionnée
            $tarifRow = $tarifForfaitModel->find($forfaitId);
            $prix = 0;
            if ($tarifRow && isset($tarifRow[$field]) && is_numeric($tarifRow[$field])) {
                $prix = floatval($tarifRow[$field]);
            }

            $data = [
                'coursForfait_idcoursfor'       => $idcoursFor,
                'tarifCourForfait_idtarifCours' => $forfaitId,
                $field                           => $prix
            ];

            $coursForfaitTarifModel->insert($data);
        }

        return redirect()->route('cours')->with('success', 'Cours créé avec succès');
    }

    /* =======================
       FORMULAIRE MODIF
    ======================= */
    public function edit($id)
    {
        return view('cours/edit_cours', [
            'cours'          => (new CoursRegModel())->find($id),
            'options'        => (new CourRegTarifCourRegModel())->where('coursreg_idcoursReg', $id)->first(),
            'clients'        => (new ClientModel())->findAll(),
            'tarifs'         => (new TarifCourRegModel())->first(),
            'redirectClient' => $this->request->getGet('redirect')
        ]);
    }

    /* =======================
       UPDATE COURS
    ======================= */
    public function update($id)
    {
        $coursModel = new CoursRegModel();
        $linkModel  = new CourRegTarifCourRegModel();

        $option = $this->request->getPost('option_unique');

        $coursModel->update($id, [
            'coursDate'         => $this->request->getPost('coursDate'),
            'description'       => $this->request->getPost('description'),
            'clients_idclients' => $this->request->getPost('client')
        ]);

        $linkModel
            ->where('coursreg_idcoursReg', $id)
            ->set([
                'tarifCourCollectifs'   => $option === 'tarifCourCollectifs' ? 1 : 0,
                'tarifCourADeux'        => $option === 'tarifCourADeux' ? 1 : 0,
                'tarifCourParticulier'  => $option === 'tarifCourParticulier' ? 1 : 0,
                'tarifTravailCheval'    => $option === 'tarifTravailCheval' ? 1 : 0
            ])->update();

        $redirectClient = $this->request->getPost('redirectClient');
        if ($redirectClient) {
            return redirect()->to(route_to('cours_client', $redirectClient))
                ->with('success', 'Cours modifié avec succès');
        }

        return redirect()->route('cours')->with('success', 'Cours modifié avec succès');
    }

    /* =======================
       SUPPRESSION
    ======================= */
    public function delete($id)
    {
        $coursModel = new CoursRegModel();
        $linkModel  = new CourRegTarifCourRegModel();

        $cours = $coursModel->find($id);
        if (!$cours) return redirect()->back();

        $linkModel->where('coursreg_idcoursReg', $id)->delete();
        $coursModel->delete($id);

        return redirect()->to(route_to('cours_client', $cours['clients_idclients']))
            ->with('success', 'Cours supprimé');
    }
}
