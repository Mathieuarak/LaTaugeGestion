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

        'tarifCourCollectifsOccasionnel',
        'tarifCourCollectifsRegulier',
        'tarifCourADeuxOccasionnel',
        'tarifCourADeuxRegulier',
        'tarifCourParticulier30',
        'tarifCourParticulier1hOccasionnel',
        'tarifCourParticulier1hRegulier',
        'tarifTravailCheval',
    ];
}