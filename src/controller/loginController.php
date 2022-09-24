<?php
namespace src\controller;

class loginController
{

    /** @var array */
    private $aDados;

    /**
     * Login page
     * @param array $aDados
     * @return void
     * @author Carlos Vinicius cvmm321@gmail.com
     * @since 1.0.0
     */
    public function index(array $aDados): void {
        include_once "src/view/login/login.php";
    }


}