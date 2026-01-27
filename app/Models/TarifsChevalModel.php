<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifsChevalModel extends Model
{
    protected $table         = 'tarifs_cheval';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'pensions_idpensions',
        'tarifs_idtarifs',
        'alimFloconne',
        'alimFloconne1',
        'alimFloconne13',
        'optBoxe',
        'optInstallation',
        'optPaddockSolo',
        'optPaddockDuo',
        'optSortiPaddockHerbe',
        'forfaitAutreAlim',
        'totalTarif'
    ];

    public function getByCheval(int $chevalId)
    {
        return $this->where('pensions_idpensions', $chevalId)->first();
    }

    public function updateByCheval(int $chevalId, array $data)
    {
        return $this->where('pensions_idpensions', $chevalId)
                    ->set($data)
                    ->update();
    }
}
