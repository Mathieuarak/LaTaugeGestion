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
        'tarifCourCollectifsOccasionnel',
        'tarifCourCollectifsRegulier',
        'tarifCourADeuxOccasionnel',
        'tarifCourADeuxRegulier',
        'tarifCourParticulier30',
        'tarifCourParticulier1hOccasionnel',
        'tarifCourParticulier1hRegulier',
        'tarifTravailCheval'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}