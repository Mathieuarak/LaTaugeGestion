<?php

namespace App\Models;

use CodeIgniter\Model;

class ChevalModel extends Model
{
    protected $table            = 'cheval';
    protected $primaryKey       = 'idpensions';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'nom',
        'numSire',
        'dateNaissance',
        'dateArrivee',
        'vaccin',
        'clients_idclients',
        
    ];


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
        'numSire' => 'required|exact_length[15]|regex_match[/^[0-9]{15}$/]',
        'dateNaissance' => 'permit_empty|valid_date',
        'dateArrivee' => 'permit_empty|valid_date',
        'vaccin' => 'permit_empty|valid_date'
    ];
    protected $validationMessages   = [
        'nom' => [
            'required' => 'Le nom est obligatoire.',
            'max_length' => 'Le nom ne peut pas dépasser 15 caractères.'
        ],
        'numSire' => [
            'required' => 'Le numéro SIRE est obligatoire.',
            'exact_length' => 'Le numéro SIRE doit contenir exactement 15 chiffres.',
            'regex_match' => 'Le numéro SIRE doit contenir uniquement des chiffres.'
        ],
        'dateNaissance' => [
            'required' => 'La date de naissance est obligatoire.',
            'valid_date' => 'La date de naissance doit être valide.'
        ],
        'dateArrivee' => [
            'required' => "La date d'arrivée est obligatoire.",
            'valid_date' => "La date d'arrivée doit être valide."
        ],
        'vaccin' => [
            'required' => "La date du dernier vaccin est obligatoire.",
            'valid_date' => "La date du dernier vaccin doit être valide."
        ]
        ,
        'total_tarif' => [
            'required' => "Le tarif total est obligatoire.",
            'numeric'  => "Le tarif total doit être un nombre valide."
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

    public function getCheval()
    {

        return $this->findAll();
    }
}
