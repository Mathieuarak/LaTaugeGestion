<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifModel extends Model
{
    protected $table         = 'tarifs';
    protected $primaryKey    = 'idtarifs';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'tarifBase',
        'alimFloconne',
        'alimFloconne1',
        'alimFloconne13',
        'optBoxe',
        'optInstallation',
        'optPaddockSolo',
        'optPaddockDuo',
        'optSortiPaddockHerbe',
        'forfaitAutreAlim'
    ];

    public function getTarif($id = 1)
    {
        return $this->find($id);
    }
}
