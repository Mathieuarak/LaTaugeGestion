<?php

namespace App\Models;

use CodeIgniter\Model;

class CoursRegModel extends Model
{
    protected $table            = 'coursreg';
    protected $primaryKey       = 'idcoursReg';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'coursDate',
        'description',
        'clients_idclients', 
        'paye'
    ];
}
