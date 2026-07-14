<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $debutMois = date('Y-m-01');
        $finMois   = date('Y-m-t');

        $stats = [
            'clients' => $db->table('clients')->countAllResults(),
            'chevaux' => $db->table('cheval')->countAllResults(),
            'coursMois' => $db->table('coursreg')
                ->where('coursDate >=', $debutMois)
                ->where('coursDate <=', $finMois)
                ->countAllResults()
                + $db->table('coursforfait')
                ->where('dateAjout >=', $debutMois)
                ->where('dateAjout <=', $finMois)
                ->countAllResults(),
            'impayes' => $db->table('coursreg')->where('paye', 0)->countAllResults()
                + $db->table('coursforfait')->where('paye', 0)->countAllResults(),
        ];

        // Alertes vaccination : rappel supposé annuel, signalé 30 jours avant échéance
        // (à ajuster si la cadence réelle de rappel diffère).
        $chevauxVaccin = $db->table('cheval ch')
            ->select('ch.idpensions, ch.nom, ch.vaccin, ch.clients_idclients, cl.nom as clientNom, cl.prenom as clientPrenom')
            ->join('clients cl', 'cl.idclients = ch.clients_idclients', 'left')
            ->where('ch.vaccin IS NOT NULL')
            ->get()
            ->getResultArray();

        $today = new \DateTime();
        $vaccinAlertes = [];

        foreach ($chevauxVaccin as $ch) {
            if (empty($ch['vaccin']) || $ch['vaccin'] === '0000-00-00') {
                continue;
            }

            $dateRappel = (new \DateTime($ch['vaccin']))->modify('+1 year');
            $joursRestants = (int) $today->diff($dateRappel)->format('%r%a');

            if ($joursRestants <= 30) {
                $vaccinAlertes[] = [
                    'idpensions' => $ch['idpensions'],
                    'nom'        => $ch['nom'],
                    'client'     => trim($ch['clientNom'] . ' ' . $ch['clientPrenom']),
                    'jours'      => $joursRestants,
                ];
            }
        }

        usort($vaccinAlertes, static fn($a, $b) => $a['jours'] <=> $b['jours']);

        return view('index.php', [
            'stats' => $stats,
            'vaccinAlertes' => $vaccinAlertes,
        ]);
    }
}
