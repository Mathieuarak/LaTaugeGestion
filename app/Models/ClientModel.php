<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'clients';
    protected $primaryKey       = 'idclients';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nom', 'prenom', 'adressePost', 'adresseMail', 'tel'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nom' => 'required|max_length[15]',
        'prenom' => 'required|max_length[15]',
        'adressePost' => 'required|max_length[150]',
        'adresseMail' => 'required|valid_email',
        'tel' => 'required|exact_length[10]|numeric',
    ];
    protected $validationMessages   = [
        'nom' => [
            'required' => 'Le nom est obligatoire.',
            'max_length' => 'Le nom ne peut pas dépasser 15 caractères.'
        ],
        'prenom' => [
            'required' => 'Le prénom est obligatoire.',
            'max_length' => 'Le prénom ne peut pas dépasser 15 caractères.'
        ],
        'adressePost' => [
            'required' => 'L\'adresse postale est obligatoire.',
        ],
        'adresseMail' => [
            'required' => 'L\'adresse mail est obligatoire.',
            'valid_email' => 'L\'adresse mail doit être valide.'
        ],
        'tel' => [
            'required' => 'Le numéro de téléphone est obligatoire.',
            'exact_length' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.',
            'numeric' => 'Le numéro de téléphone doit être numérique.'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getClient()
    {

        return $this->findAll();
    }
}
