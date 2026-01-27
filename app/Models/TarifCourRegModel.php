<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifCourRegModel extends Model
{
    protected $table = 'tarifCourReg';         // Nom exact de la table
    protected $primaryKey = 'idtarifCourReg';  // Clé primaire exacte
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'tarifCourCollectifs',
        'tarifCourADeux',
        'tarifCourParticulier',
        'tarifTravailCheval'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
