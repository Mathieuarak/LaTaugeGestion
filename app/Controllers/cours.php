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
    private const OPTIONS_UNIQUE = [
        'tarifCourCollectifsOccasionnel'    => 'Cours collectif (occasionnel)',
        'tarifCourCollectifsRegulier'       => 'Cours collectif (régulier)',
        'tarifCourADeuxOccasionnel'         => 'Cours à deux (occasionnel)',
        'tarifCourADeuxRegulier'            => 'Cours à deux (régulier)',
        'tarifCourParticulier30'            => 'Cours particulier 30 min',
        'tarifCourParticulier1hOccasionnel' => 'Cours particulier 1h (occasionnel)',
        'tarifCourParticulier1hRegulier'    => 'Cours particulier 1h (régulier)',
        'tarifTravailCheval'                => 'Travail du cheval',
    ];

    public function index()
    {
        $db = \Config\Database::connect();

        $clients = $db->table('clients c')
            ->select('
        c.idclients,
        c.nom,
        c.prenom,
        COUNT(DISTINCT cr.idcoursReg) as nbCours,
        COUNT(DISTINCT cf.idcoursfor) as nbForfaits
    ')
            ->join('coursreg cr', 'cr.clients_idclients = c.idclients', 'left')
            ->join('coursforfait cf', 'cf.clients_idclients = c.idclients', 'left')
            ->groupBy('c.idclients')
            ->having('(nbCours > 0 OR nbForfaits > 0)')
            ->get()
            ->getResultArray();

        return view('cours/clients', [
            'clients' => $clients
        ]);
    }
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

        // ===== COURS A L'UNITE =====
        $selectFields = ['c.idcoursReg', 'c.coursDate', 'c.description', 'c.clients_idclients', 'c.paye'];
        foreach (array_keys(self::OPTIONS_UNIQUE) as $field) {
            $selectFields[] = "t.$field as tarif_$field";
            $selectFields[] = "link.$field as link_$field";
        }

        $rawCours = $db->table('coursreg c')
            ->select(implode(', ', $selectFields))
            ->join('courReg_tarifCourReg link', 'link.coursReg_idcoursReg = c.idcoursReg', 'left')
            ->join('tarifCourReg t', 't.idtarifCourReg = link.tarifCourReg_idtarifCourReg', 'left')
            ->where('c.clients_idclients', $idClient)
            ->get()
            ->getResultArray();

        $cours = [];
        foreach ($rawCours as $row) {
            $optionChoisie = '';
            $prix = 0;

            foreach (self::OPTIONS_UNIQUE as $field => $label) {
                if (!empty($row['link_' . $field])) {
                    $optionChoisie = $label;
                    $prix = floatval($row['tarif_' . $field]);
                    break;
                }
            }

            $cours[] = [
                'idcoursReg' => $row['idcoursReg'],
                'coursDate'  => $row['coursDate'],
                'description' => $row['description'],
                'clients_idclients' => $row['clients_idclients'],
                'paye'       => $row['paye'],
                'option'     => $optionChoisie,
                'prix'       => $prix,
            ];
        }


        // ===== FORFAITS =====
        $rawForfaits = $db->table('coursforfait cf')
            ->select('
            cf.idcoursfor,
            cf.dateAjout,
            cf.paye,
            cf.description,
            cf.stade,
            link.tarifCoursCollec10,
            link.tarifCoursDuo10,
            link.tarifCoursSolo10,
            link.travailCheval1,
            link.tarifCoursCollec5,
            link.tarifCoursDuo5,
            link.tarifCoursSolo5,
            link.travailCheval2,
            link.prixFinal
        ')
            ->join(
                'courForfait_tarifCourForfait link',
                'link.coursForfait_idcoursfor = cf.idcoursfor',
                'left'
            )
            ->where('cf.clients_idclients', $idClient)
            ->get()
            ->getResultArray();


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

            $optionChoisie = '';
                $optionField = null;

            foreach ($labels as $field => $label) {
                    if (!empty($row[$field])) {
                        $optionChoisie = $label;
                        $optionField = $field;
                        break;
                    }
            }

            $forfaits[] = [
                'idcoursfor' => $row['idcoursfor'],
                'dateAjout'  => $row['dateAjout'],
                'description' => $row['description'],
                'option'     => $optionChoisie,
                'prixFinal'  => $row['prixFinal'] ?? 0,
                'stade'      => isset($row['stade']) ? intval($row['stade']) : 0,
                'optionField' => $optionField,
                'paye'        => isset($row['paye']) ? intval($row['paye']) : 0
            ];
        }

        // ⭐ SUPER IMPORTANT
        return view('cours/cours_client', [
            'client'   => $client,
            'cours'    => $cours,
            'forfaits' => $forfaits
        ]);
    }


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

        $redirect = $this->request->getPost('redirect');
        if ($redirect && strpos($redirect, site_url()) === 0) {
            return redirect()->to($redirect);
        }

        return redirect()->to(route_to('cours_client', $cours['clients_idclients']));
    }

    public function togglePayeForfait($id)
    {
        $forfaitModel = new CoursForfaitModel();
        $forfait = $forfaitModel->find($id);

        if (!$forfait) {
            return redirect()->back()->with('error', 'Forfait introuvable');
        }

        $forfaitModel->update($id, [
            'paye' => (isset($forfait['paye']) && $forfait['paye']) ? 0 : 1
        ]);

        $redirect = $this->request->getPost('redirect');
        if ($redirect && strpos($redirect, site_url()) === 0) {
            return redirect()->to($redirect);
        }

        return redirect()->to(route_to('cours_client', $forfait['clients_idclients']));
    }
    public function ajout()
    {
        return view('cours/ajout_cours', [
            'clients'       => (new ClientModel())->findAll(),
            'tarifs'        => (new TarifCourRegModel())->first(),
            'tarifsForfait' => (new TarifCourForfaitModel())->findAll()
        ]);
    }

    public function store()
    {
        $type        = $this->request->getPost('type_cours');
        $clientId    = $this->request->getPost('clients_idclients');
        $description = $this->request->getPost('description');

        if (empty($clientId)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez sélectionner un client.');
        }

        // -------------------
        // Cours à l'unité
        // -------------------
        if ($type === 'unique') {

            $option = $this->request->getPost('option_unique');

            if (!array_key_exists($option, self::OPTIONS_UNIQUE)) {
                return redirect()->back()->withInput()->with('error', 'Veuillez sélectionner un tarif.');
            }

            $coursRegModel = new CoursRegModel();
            $linkModel     = new CourRegTarifCourRegModel();
            $tarifModel    = new TarifCourRegModel();

            $tarif = $tarifModel->first();

            $idcoursReg = $coursRegModel->insert([
                'coursDate'         => $this->request->getPost('coursDate'),
                'description'       => $description,
                'clients_idclients' => $clientId
            ]);

            $flags = array_fill_keys(array_keys(self::OPTIONS_UNIQUE), 0);
            $flags[$option] = 1;

            $linkModel->insert(array_merge([
                'coursReg_idcoursReg'         => $idcoursReg,
                'tarifCourReg_idtarifCourReg' => $tarif['idtarifCourReg'],
            ], $flags));
        }

        // -------------------
        // Forfait
        // -------------------
        if ($type === 'forfait') {

            $forfaitOption = $this->request->getPost('forfait_option');

            if (!$forfaitOption) {
                return redirect()->back()->with('error', 'Veuillez sélectionner une option');
            }

            list($fieldChoisi, $tarifId) = explode('|', $forfaitOption);

            $coursForfaitModel = new CoursForfaitModel();
            $liaisonModel      = new CourForfaitTarifCourForfaitModel();
            $tarifModel        = new TarifCourForfaitModel();

            $tarifRow = $tarifModel->find($tarifId);

            if (!$tarifRow || !isset($tarifRow[$fieldChoisi])) {
                return redirect()->back()->with('error', 'Erreur tarif');
            }

            $prixFinal = floatval($tarifRow[$fieldChoisi]);

            $idcoursFor = $coursForfaitModel->insert([
                'clients_idclients' => $clientId,
                'description'       => $description,
                'dateAjout'         => date('Y-m-d')
            ]);

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

            $dataOptions = [
                'coursForfait_idcoursfor'       => $idcoursFor,
                'tarifCourForfait_idtarifCours' => $tarifId,
                'prixFinal'                     => $prixFinal
            ];

            foreach ($fields as $f) {
                $dataOptions[$f] = ($f === $fieldChoisi) ? 1 : 0;
            }

            $liaisonModel->insert($dataOptions);
        }

        return redirect()->route('cours')->with('success', 'Cours créé avec succès');
    }



    public function edit($id)
    {
        $coursRegModel = new CoursRegModel();
        $coursForfaitModel = new CoursForfaitModel();
        $tarifForfaitModel = new TarifCourForfaitModel();

        return view('cours/edit_cours', [
            'cours'          => $coursRegModel->find($id),
            'options'        => (new CourRegTarifCourRegModel())->where('coursReg_idcoursReg', $id)->first(),
            'clients'        => (new ClientModel())->findAll(),
            'tarifs'         => (new TarifCourRegModel())->first(),
            'tarifsForfait'  => $tarifForfaitModel->findAll(),
            'redirectClient' => $this->request->getGet('redirect')
        ]);
    }

    public function update($id)
    {
        $type        = $this->request->getPost('type_cours');
        $clientId    = $this->request->getPost('clients_idclients');
        $description = $this->request->getPost('description');
        $dateCours   = $this->request->getPost('coursDate');

        if (empty($clientId)) {
            return redirect()->back()->withInput()->with('error', 'Veuillez sélectionner un client.');
        }

        if ($type === 'unique') {

            $option = $this->request->getPost('option_unique');

            if (!array_key_exists($option, self::OPTIONS_UNIQUE)) {
                return redirect()->back()->withInput()->with('error', 'Veuillez sélectionner un tarif.');
            }

            $coursModel = new CoursRegModel();
            $linkModel  = new CourRegTarifCourRegModel();
            $tarifModel = new TarifCourRegModel();

            $coursModel->update($id, [
                'coursDate'         => $dateCours,
                'description'       => $description,
                'clients_idclients' => $clientId
            ]);

            $flags = array_fill_keys(array_keys(self::OPTIONS_UNIQUE), 0);
            $flags[$option] = 1;

            $linkModel
                ->where('coursReg_idcoursReg', $id)
                ->set(array_merge([
                    'tarifCourReg_idtarifCourReg' => $tarifModel->first()['idtarifCourReg']
                ], $flags))
                ->update();
        } elseif ($type === 'forfait') {

            $rawOption = $this->request->getPost('forfait_option');

            $coursForfaitModel       = new CoursForfaitModel();
            $tarifForfaitModel       = new TarifCourForfaitModel();
            $liaisonForfaitModel     = new CourForfaitTarifCourForfaitModel();

            $forfait = $coursForfaitModel->find($id);

            if (!$forfait) {
                return redirect()->back()->with('error', 'Forfait introuvable');
            }

            $coursForfaitModel->update($id, [
                'clients_idclients' => $clientId,
                'description'       => $description
            ]);

            if ($rawOption) {
                [$field, $tarifId] = explode('|', $rawOption);

                $tarifRow = $tarifForfaitModel->find($tarifId);
                $prix = ($tarifRow && isset($tarifRow[$field])) ? floatval($tarifRow[$field]) : 0;

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

                $liaisonForfaitModel
                    ->where('coursForfait_idcoursfor', $id)
                    ->set(array_merge($reset, [
                        'tarifCourForfait_idtarifCours' => $tarifId,
                        $field                           => $prix,
                        'prixFinal'                      => $prix
                    ]))
                    ->update();
            } else {
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
                        'prixFinal'          => null,
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

    public function delete($id)
    {
        $coursModel = new CoursRegModel();
        $linkModel  = new CourRegTarifCourRegModel();

        $cours = $coursModel->find($id);
        if (!$cours) return redirect()->back();

        $linkModel->where('coursReg_idcoursReg', $id)->delete();
        $coursModel->delete($id);

        return redirect()->to(route_to('cours_client', $cours['clients_idclients']))
            ->with('success', 'Cours supprimé');
    }

    public function impayes()
    {
        $db = \Config\Database::connect();

        // ===== Cours à l'unité impayés =====
        $selectFields = ['c.idcoursReg', 'c.coursDate', 'c.description', 'cl.idclients', 'cl.nom', 'cl.prenom'];
        foreach (array_keys(self::OPTIONS_UNIQUE) as $field) {
            $selectFields[] = "t.$field as tarif_$field";
            $selectFields[] = "link.$field as link_$field";
        }

        $rawCours = $db->table('coursreg c')
            ->select(implode(', ', $selectFields))
            ->join('clients cl', 'cl.idclients = c.clients_idclients', 'left')
            ->join('courReg_tarifCourReg link', 'link.coursReg_idcoursReg = c.idcoursReg', 'left')
            ->join('tarifCourReg t', 't.idtarifCourReg = link.tarifCourReg_idtarifCourReg', 'left')
            ->where('c.paye', 0)
            ->orderBy('c.coursDate', 'DESC')
            ->get()
            ->getResultArray();

        $impayesCours = [];
        foreach ($rawCours as $row) {
            $option = '';
            $prix = 0;
            foreach (self::OPTIONS_UNIQUE as $field => $label) {
                if (!empty($row['link_' . $field])) {
                    $option = $label;
                    $prix = floatval($row['tarif_' . $field]);
                    break;
                }
            }

            $impayesCours[] = [
                'id'          => $row['idcoursReg'],
                'clientId'    => $row['idclients'],
                'client'      => trim($row['nom'] . ' ' . $row['prenom']),
                'date'        => $row['coursDate'],
                'description' => $row['description'],
                'option'      => $option,
                'prix'        => $prix,
            ];
        }

        // ===== Forfaits impayés =====
        $rawForfaits = $db->table('coursforfait cf')
            ->select('cf.idcoursfor, cf.dateAjout, cf.description, cl.idclients, cl.nom, cl.prenom, link.prixFinal')
            ->join('clients cl', 'cl.idclients = cf.clients_idclients', 'left')
            ->join('courForfait_tarifCourForfait link', 'link.coursForfait_idcoursfor = cf.idcoursfor', 'left')
            ->where('cf.paye', 0)
            ->orderBy('cf.dateAjout', 'DESC')
            ->get()
            ->getResultArray();

        $impayesForfaits = [];
        foreach ($rawForfaits as $row) {
            $impayesForfaits[] = [
                'id'          => $row['idcoursfor'],
                'clientId'    => $row['idclients'],
                'client'      => trim($row['nom'] . ' ' . $row['prenom']),
                'date'        => $row['dateAjout'],
                'description' => $row['description'],
                'prix'        => $row['prixFinal'] ?? 0,
            ];
        }

        $total = array_sum(array_column($impayesCours, 'prix')) + array_sum(array_column($impayesForfaits, 'prix'));

        return view('cours/impayes', [
            'impayesCours'    => $impayesCours,
            'impayesForfaits' => $impayesForfaits,
            'total'           => $total,
        ]);
    }

    public function updateStade($id)
    {
        $step = (int) $this->request->getPost('step');
        if ($step < 0) $step = 0;
        if ($step > 10) $step = 10;

        $coursForfaitModel = new CoursForfaitModel();

        $forfait = $coursForfaitModel->find($id);
        if (!$forfait) {
            return $this->response->setJSON(['success' => false, 'message' => 'Forfait introuvable']);
        }

        $coursForfaitModel->update($id, ['stade' => $step]);

        return $this->response->setJSON(['success' => true, 'stade' => $step]);
    }
}
