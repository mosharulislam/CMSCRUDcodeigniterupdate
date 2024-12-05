<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route to display all records
$routes->get('/', 'CRUDController::index');

// Route for inserting new records
$routes->post('insert', 'CRUDController::insert');
$routes->post('insertManual', 'CRUDController::insertManual');

$routes->post('deleteMultiple', 'CRUDController::deleteMultiple');
$routes->post('deleteRandom', 'CRUDController::deleteRandom');
$routes->post('editMultiple', 'CRUDController::editMultiple');
$routes->post('editRandom', 'CRUDController::editRandom');
