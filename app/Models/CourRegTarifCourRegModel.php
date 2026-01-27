<?php

namespace App\Models;

use CodeIgniter\Model;

class CourRegTarifCourRegModel extends Model
{
    protected $table = 'courReg_tarifCourReg';

    // Cette table n'a pas de PK auto-incrémentée
    protected $primaryKey = null;
    protected $useAutoIncrement = false;

    protected $returnType = 'array';
    protected $allowedFields = [
        'coursReg_idcoursReg',
        'tarifCourReg_idtarifCourReg',
        'tarifCourCollectifs',
        'tarifCourADeux',
        'tarifCourParticulier',
        'tarifTravailCheval'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
