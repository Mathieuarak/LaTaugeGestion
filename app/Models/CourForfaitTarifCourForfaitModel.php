<?php

namespace App\Models;

use CodeIgniter\Model;

class CourForfaitTarifCourForfaitModel extends Model
{
    protected $table            = 'courForfait_tarifCourForfait';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'coursForfait_idcoursfor',
        'tarifCourForfait_idtarifCours',
        'tarifCoursCollec10',
        'tarifCoursDuo10',
        'tarifCoursSolo10',
        'travailCheval1',
        'tarifCoursCollec5',
        'tarifCoursDuo5',
        'tarifCoursSolo5',
        'travailCheval2',
        'prixFinal'
    ];
}
