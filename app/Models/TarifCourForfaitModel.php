<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifCourForfaitModel extends Model
{
    protected $table = 'tarifcourforfait';
    protected $primaryKey = 'idtarifCours';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'tarifCoursCollec10',
        'tarifCoursDuo10',
        'tarifCoursSolo10',
        'travailCheval1',
        'tarifCoursCollec5',
        'tarifCoursDuo5',
        'tarifCoursSolo5',
        'travailCheval2'
    ];
}
