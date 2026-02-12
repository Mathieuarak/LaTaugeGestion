<?php

namespace App\Models;

use CodeIgniter\Model;

class CoursForfaitModel extends Model
{
    protected $table = 'coursforfait';
    protected $primaryKey = 'idcoursfor';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'description',
        'dateAjout',
        'stade',
        'paye',
        'clients_idclients',
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
