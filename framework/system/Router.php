<?php

namespace framework\system;

/**
 * Class Router
 * @package framework\system
 */
class Router
{
    /** @var string $sAction */
    private $sAction;

    private $oEntity;
    /** @var array $aData */
    private $aData;

    /**
     * Configure route
     */
    public function init()
    {
        if (empty($_REQUEST['controller'])) {
            $_REQUEST['controller'] = "home";
        }

        $sController = "src\controller\\" . $_REQUEST['controller'] . "Controller";
        if (class_exists($sController)) {
            $this->oEntity = new $sController($_REQUEST);
            $this->sAction = !empty($_REQUEST['action']) ? $_REQUEST['action'] : "list" ;

            if (method_exists($sController, $this->sAction)) {
                $this->aData = $_REQUEST;
            }
        }

        if (is_null($this->sAction)) {
            $this->sAction = 'list';
        }

    }

    /**
     * Route
     */
    public function route()
    {
        $sAction = $this->sAction;
        $this->oEntity->$sAction($this->aData);
    }
}