<?php

namespace App\Models;

use CodeIgniter\Model;

class CoursForfaitModel extends Model
{
    protected $table = 'coursForfait';
    protected $primaryKey = 'idcoursfor';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'description',
        'dateAjout',
        'stade',
        'paye',
        'clients_idclients'
    ];
}
