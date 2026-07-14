<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes d'authentification Shield (login, register, logout)
service('auth')->routes($routes);

/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES - Nécessitent une authentification
|--------------------------------------------------------------------------
*/
$routes->group('', ['filter' => 'session'], static function ($routes) {
    
    $routes->get('/', 'Home::index', ['as' => 'index']);

    /*
    |--------------------------------------------------------------------------
    | CHEVAUX
    |--------------------------------------------------------------------------
    */
    $routes->get('chevaux_liste', 'cheval::liste', ['as' => 'chevaux_liste']);
    $routes->get('ajout_cheval', 'cheval::ajout', ['as' => 'cheval_ajout']);
    $routes->post('cheval-create', 'cheval::create', ['as' => 'cheval_create']);
    $routes->get('cheval_voir-(:num)', 'cheval::show/$1', ['as' => 'cheval_voir']);
    $routes->get('cheval_modif-(:num)', 'cheval::edit/$1', ['as' => 'cheval_modifier']);
    $routes->post('cheval_update-(:num)', 'cheval::update/$1', ['as' => 'cheval_update']);
    $routes->post('cheval-supprimer-(:num)', 'cheval::delete/$1', ['as' => 'cheval_supprimer']);

    /*
    |--------------------------------------------------------------------------
    | CLIENTS
    |--------------------------------------------------------------------------
    */
    $routes->get('liste_clients', 'Client::client', ['as' => 'liste_clients']);
    $routes->get('client_ajout', 'Client::ajout', ['as' => 'client_ajout']);
    $routes->post('client-create', 'Client::create', ['as' => 'client_create']);
    $routes->get('client_voir-(:num)', 'Client::show/$1', ['as' => 'client_voir']);
    $routes->get('client_modif-(:num)', 'Client::edit/$1', ['as' => 'modif_client']);
    $routes->post('client_update-(:num)', 'Client::update/$1', ['as' => 'client_update']);
    $routes->post('client-supprimer-(:num)', 'Client::delete/$1', ['as' => 'client_supprimer']);

    /*
    |--------------------------------------------------------------------------
    | TARIFS PENSION
    |--------------------------------------------------------------------------
    */
    $routes->get('tarifs', 'TarifController::index', ['as' => 'tarifs_liste']);
    $routes->get('tarif-ajout', 'TarifController::create', ['as' => 'tarif_ajout']);
    $routes->post('tarif-create', 'TarifController::store', ['as' => 'tarif_create']);
    $routes->get('tarif-modifier-(:num)', 'TarifController::edit/$1', ['as' => 'tarif_modifier']);
    $routes->post('tarif-update-(:num)', 'TarifController::update/$1', ['as' => 'tarif_update']);
    $routes->post('tarif-supprimer-(:num)', 'TarifController::delete/$1', ['as' => 'tarif_supprimer']);

    /*
    |--------------------------------------------------------------------------
    | TARIFS PAR CHEVAL
    |--------------------------------------------------------------------------
    */
    $routes->get('tarifs-cheval', 'TarifChevalController::index', ['as' => 'tarifs_cheval_liste']);
    $routes->post('tarif-cheval-assign', 'TarifChevalController::assign', ['as' => 'tarif_cheval_assign']);
    $routes->post('tarif-cheval-remove', 'TarifChevalController::remove', ['as' => 'tarif_cheval_remove']);

    /*
    |--------------------------------------------------------------------------
    | TARIFS COURS
    |--------------------------------------------------------------------------
    */
    $routes->get('cours', 'Cours::index', ['as' => 'cours']);
    $routes->get('cours/impayes', 'Cours::impayes', ['as' => 'cours_impayes']);
    $routes->get('cours/clients/(:num)', 'Cours::coursClient/$1', ['as' => 'cours_client']);
    $routes->post('cours/toggle-paye/(:num)', 'Cours::togglePaye/$1', ['as' => 'cours_toggle_paye']);
    $routes->get('ajout_cours', 'Cours::ajout', ['as' => 'ajout_cours']);
    $routes->post('tarif-cours-create', 'Cours::store', ['as' => 'tarif_cours_create']);
    $routes->get('tarif-cours-modifier-(:num)', 'Cours::edit/$1', ['as' => 'tarif_cours_modifier']);
    $routes->post('tarif-cours-update-(:num)', 'Cours::update/$1', ['as' => 'tarif_cours_update']);
    $routes->post('tarif-cours-supprimer-(:num)', 'Cours::delete/$1', ['as' => 'tarif_cours_supprimer']);

    /*
    |--------------------------------------------------------------------------
    | COURS AU FORFAIT
    |--------------------------------------------------------------------------
    */
    $routes->get('cours-forfaits', 'CoursForfaitController::index', ['as' => 'cours_forfaits_liste']);
    $routes->get('cours-forfait-ajout', 'CoursForfaitController::create', ['as' => 'cours_forfait_ajout']);
    $routes->post('cours-forfait-create', 'CoursForfaitController::store', ['as' => 'cours_forfait_create']);
    $routes->get('cours-forfait-modifier-(:num)', 'CoursForfaitController::edit/$1', ['as' => 'cours_forfait_modifier']);
    $routes->post('cours-forfait-update-(:num)', 'CoursForfaitController::update/$1', ['as' => 'cours_forfait_update']);
    $routes->post('cours-forfait-supprimer-(:num)', 'CoursForfaitController::delete/$1', ['as' => 'cours_forfait_supprimer']);
    $routes->post('cours-forfait-toggle-paye/(:num)', 'Cours::togglePayeForfait/$1', ['as' => 'cours_forfait_toggle_paye']);
    $routes->post('cours/updateStade/(:num)', 'Cours::updateStade/$1', ['as' => 'cours_update_stade']);

    /*
    |--------------------------------------------------------------------------
    | COURS RÉGULIERS
    |--------------------------------------------------------------------------
    */
    $routes->get('cours-reguliers', 'CoursRegController::index', ['as' => 'cours_reguliers_liste']);
    $routes->get('cours-regulier-ajout', 'CoursRegController::create', ['as' => 'cours_regulier_ajout']);
    $routes->post('cours-regulier-create', 'CoursRegController::store', ['as' => 'cours_regulier_create']);
    $routes->get('cours-regulier-modifier-(:num)', 'CoursRegController::edit/$1', ['as' => 'cours_regulier_modifier']);
    $routes->post('cours-regulier-update-(:num)', 'CoursRegController::update/$1', ['as' => 'cours_regulier_update']);
    $routes->post('cours-regulier-supprimer-(:num)', 'CoursRegController::delete/$1', ['as' => 'cours_regulier_supprimer']);
});

