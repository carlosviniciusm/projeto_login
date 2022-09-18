<?php
namespace src\controller;

class homeController
{

    /** @var array */
    private $aDados;

    /**
     * Home page
     * @param array $aDados
     * @return void
     * @author Carlos Vinicius cvmm321@gmail.com
     * @since 1.0.0
     */
    public function list(array $aDados): void {
        include_once "src/view/home/home.php";
    }
}