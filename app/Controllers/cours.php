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
                    'description' => $row['description'] ?? '',
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
        $type        = $this->request->getPost('type_cours');
        $clientId    = $this->request->getPost('client');
        $description = $this->request->getPost('description');

        /* =====================================================
       ================= COURS À L'UNITÉ ===================
    ===================================================== */
        if ($type === 'unique') {

            $option = $this->request->getPost('option_unique');

            $coursRegModel = new CoursRegModel();
            $linkModel     = new CourRegTarifCourRegModel();
            $tarifModel    = new TarifCourRegModel();

            $tarif = $tarifModel->first();

            $idcoursReg = $coursRegModel->insert([
                'coursDate'         => $this->request->getPost('coursDate'),
                'description'       => $description,
                'clients_idclients' => $clientId
            ]);

            $linkModel->insert([
                'coursreg_idcoursReg'         => $idcoursReg,
                'tarifCourReg_idtarifCourReg' => $tarif['idtarifCourReg'],
                'tarifCourCollectifs'   => $option === 'tarifCourCollectifs' ? 1 : 0,
                'tarifCourADeux'        => $option === 'tarifCourADeux' ? 1 : 0,
                'tarifCourParticulier'  => $option === 'tarifCourParticulier' ? 1 : 0,
                'tarifTravailCheval'    => $option === 'tarifTravailCheval' ? 1 : 0,
            ]);
        }

        /* =====================================================
       ===================== FORFAIT =======================
    ===================================================== */
        if ($type === 'forfait') {

            $forfaitOption = $this->request->getPost('forfait_option');

            if (!$forfaitOption) {
                return redirect()->back()->with('error', 'Veuillez sélectionner une option');
            }

            list($fieldChoisi, $tarifId) = explode('_', $forfaitOption);

            $coursForfaitModel  = new CoursForfaitModel();
            $liaisonModel       = new CourForfaitTarifCourForfaitModel();
            $tarifModel         = new TarifCourForfaitModel();

            $tarifRow = $tarifModel->find($tarifId);

            if (!$tarifRow || !isset($tarifRow[$fieldChoisi])) {
                return redirect()->back()->with('error', 'Erreur tarif');
            }

            $prixFinal = floatval($tarifRow[$fieldChoisi]);

            // 1️⃣ Création du forfait
            $idcoursFor = $coursForfaitModel->insert([
                'clients_idclients' => $clientId,
                'description'       => $description,
                'dateAjout'         => date('Y-m-d')
            ]);

            // 2️⃣ Création de la ligne pivot
            $dataOptions = [
                'coursForfait_idcoursfor'       => $idcoursFor,
                'tarifCourForfait_idtarifCours' => $tarifId,
                'tarifCoursCollec10' => 0,
                'tarifCoursDuo10'    => 0,
                'tarifCoursSolo10'   => 0,
                'travailCheval1'     => 0,
                'tarifCoursCollec5'  => 0,
                'tarifCoursDuo5'     => 0,
                'tarifCoursSolo5'    => 0,
                'travailCheval2'     => 0,
                'prixFinal'          => $prixFinal
            ];

            // on met uniquement celle choisie à 1
            $dataOptions[$fieldChoisi] = 1;

            $liaisonModel->insert($dataOptions);
        }

        return redirect()->route('cours')->with('success', 'Cours créé avec succès');
    }


    /* =======================
       FORMULAIRE MODIF
    ======================= */
    public function edit($id)
    {
        $coursRegModel = new CoursRegModel();
        $coursForfaitModel = new CoursForfaitModel();
        $tarifForfaitModel = new TarifCourForfaitModel();

        return view('cours/edit_cours', [
            'cours'          => $coursRegModel->find($id),
            'options'        => (new CourRegTarifCourRegModel())->where('coursreg_idcoursReg', $id)->first(),
            'clients'        => (new ClientModel())->findAll(),
            'tarifs'         => (new TarifCourRegModel())->first(),
            'tarifsForfait'  => $tarifForfaitModel->findAll(), // <-- AJOUTÉ
            'redirectClient' => $this->request->getGet('redirect')
        ]);
    }


    /* =======================
       UPDATE COURS
    ======================= */
    public function update($id)
    {
        $type        = $this->request->getPost('type_cours'); // unique | forfait
        $clientId    = $this->request->getPost('client');
        $description = $this->request->getPost('description');
        $dateCours   = $this->request->getPost('coursDate');

        /* =======================
       COURS À L’UNITÉ
    ======================= */
        if ($type === 'unique') {

            $option = $this->request->getPost('option_unique');

            $coursModel = new CoursRegModel();
            $linkModel  = new CourRegTarifCourRegModel();
            $tarifModel = new TarifCourRegModel();

            // 1️⃣ Update du cours
            $coursModel->update($id, [
                'coursDate'         => $dateCours,
                'description'       => $description,
                'clients_idclients' => $clientId
            ]);

            // 2️⃣ Reset toutes les options
            $dataOptions = [
                'tarifCourCollectifs'   => 0,
                'tarifCourADeux'        => 0,
                'tarifCourParticulier'  => 0,
                'tarifTravailCheval'    => 0,
            ];

            // 3️⃣ Activation de l’option choisie si valide
            if ($option && array_key_exists($option, $dataOptions)) {
                $dataOptions[$option] = 1;
            }

            // 4️⃣ Update de la liaison
            $linkModel
                ->where('coursreg_idcoursReg', $id)
                ->set(array_merge([
                    'tarifCourReg_idtarifCourReg' => $tarifModel->first()['idtarifCourReg']
                ], $dataOptions))
                ->update();
        }

        /* =======================
       FORFAIT
    ======================= */ elseif ($type === 'forfait') {

            $rawOption = $this->request->getPost('forfait_option'); // colonne|idTarif

            $coursForfaitModel       = new CoursForfaitModel();
            $tarifForfaitModel       = new TarifCourForfaitModel();
            $liaisonForfaitModel     = new CourForfaitTarifCourForfaitModel();

            // 1️⃣ On récupère le forfait existant
            $forfait = $coursForfaitModel->find($id);

            if (!$forfait) {
                return redirect()->back()->with('error', 'Forfait introuvable');
            }

            // 2️⃣ Update info générale du forfait
            $coursForfaitModel->update($id, [
                'clients_idclients' => $clientId,
                'description'       => $description
            ]);

            if ($rawOption) {
                [$field, $tarifId] = explode('|', $rawOption);

                $tarifRow = $tarifForfaitModel->find($tarifId);
                $prix = ($tarifRow && isset($tarifRow[$field])) ? floatval($tarifRow[$field]) : 0;

                // Reset toutes les colonnes
                $reset = [
                    'tarifCoursCollec10' => null,
                    'tarifCoursDuo10'    => null,
                    'tarifCoursSolo10'   => null,
                    'travailCheval1'     => null,
                    'tarifCoursCollec5'  => null,
                    'tarifCoursDuo5'     => null,
                    'tarifCoursSolo5'    => null,
                    'travailCheval2'     => null,
                ];

                if (!array_key_exists($field, $reset)) {
                    return redirect()->back()->with('error', 'Option de forfait invalide');
                }

                // Update ligne pivot
                $liaisonForfaitModel
                    ->where('coursForfait_idcoursfor', $id)
                    ->set(array_merge($reset, [
                        'tarifCourForfait_idtarifCours' => $tarifId,
                        $field                           => $prix
                    ]))
                    ->update();
            } else {
                // si aucune option sélectionnée → reset total
                $liaisonForfaitModel
                    ->where('coursForfait_idcoursfor', $id)
                    ->set([
                        'tarifCoursCollec10' => null,
                        'tarifCoursDuo10'    => null,
                        'tarifCoursSolo10'   => null,
                        'travailCheval1'     => null,
                        'tarifCoursCollec5'  => null,
                        'tarifCoursDuo5'     => null,
                        'tarifCoursSolo5'    => null,
                        'travailCheval2'     => null,
                    ])->update();
            }
        }

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
