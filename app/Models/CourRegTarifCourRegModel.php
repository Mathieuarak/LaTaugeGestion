<?php

namespace App\Models;

use CodeIgniter\Model;

class CourRegTarifCourRegModel extends Model
{
    protected $table            = 'courreg_tarifcourreg';
    protected $primaryKey       = 'id';               
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'coursreg_idcoursReg',
        'tarifCourReg_idtarifCourReg',
        'tarifCourCollectifs',
        'tarifCourADeux',
        'tarifCourParticulier',
        'tarifTravailCheval',
    ];
}
