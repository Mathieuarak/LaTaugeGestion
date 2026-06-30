<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifCourRegModel extends Model
{
    protected $table = 'tarifCourReg';
    protected $primaryKey = 'idtarifCourReg';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'tarifCourCollectifs',
        'tarifCourADeux',
        'tarifCourParticulier30',
        'tarifCourParticulier60',
        'tarifTravailCheval'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}