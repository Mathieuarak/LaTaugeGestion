<?php

namespace App\Models;

use CodeIgniter\Model;

class CoursRegModel extends Model
{
    protected $table = 'coursReg';          // Nom exact de la table
    protected $primaryKey = 'idcoursReg';   // Clé primaire exacte
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'coursDate',
        'description',
        'clients_idclients'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
