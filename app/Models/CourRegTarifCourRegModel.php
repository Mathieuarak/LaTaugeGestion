<?php

namespace App\Models;

use CodeIgniter\Model;

class CourRegTarifCourRegModel extends Model
{
    protected $table            = 'courReg_tarifCourReg';
    protected $primaryKey       = 'id';               
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'coursReg_idcoursReg',
        'tarifCourReg_idtarifCourReg',
        'tarifCourCollectifs',
        'tarifCourADeux',
        'tarifCourParticulier',
        'tarifTravailCheval',
    ];
}
