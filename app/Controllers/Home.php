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

        return view('index.php', ['stats' => $stats]);
    }
}
