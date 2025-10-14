<?php
namespace App\Kipedreiro\Controllers\Admin;

use App\Kipedreiro\Core\Flash;
use App\Kipedreiro\Core\Redirect;

abstract class AdminController extends AuthenticatedController{
    public function __construct() {

        // se a pessoa estiver logada, verifica se ela é um administrador
        parent::__construct();
        if ($this->session->get('usuario_tipo') !== 'admin') {
            Redirect::redirecionarComMensagem(
                'admin/dashboard',
                'error',
                 'Você não tem permissão para acessar esta área.'
                ); 
        }
    }
}