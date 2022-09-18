<?php
namespace src\controller;

use Exception;
use framework\exceptions\InvalidAttributeException;
use src\dao\DebtDAO;
use src\dao\DebtorDAO;
use src\model\debt\Debt;

/**
 * Class debtController
 * @package src\controller
 */
class debtController
{
    /** @var array */
    private $aDados;

    /**
     * debtController constructor.
     * @param $aDados
     */
    public function __construct($aDados) {
        $this->aDados = $aDados;
    }

    /**
     * Home page
     * @param array $aDados
     * @return void
     * @author Carlos Vinicius cvmm321@gmail.com
     * @since 1.0.0
     */
    public function list(array $aDados): void {
        $loDebt = DebtDAO::findAllActive();

        include_once "src/view/debt/list.php";
    }

    /**
     * Save debt registry
     * @param array $aDados
     */
    public function save(array $aDados): void
    {
        try {
            $oDebt = Debt::createFromRequest($aDados);
            $oDebt->save();
            $aReturn = ['msg' => 'O cadastro da dívida foi realizado com sucesso!', 'status' => true, 'path' => 'list'];
        } catch (Exception $e) {
            $aReturn = ['msg' => 'Erro ao salvar a dívida: '.$e->getMessage(), 'status' => false, 'path' => 'register'];
        }

        echo json_encode($aReturn);
    }

    /**
     * Open view to register debt
     */
    public function register()
    {
        $oDebt = new Debt();
        $loDebtor = DebtorDAO::findDebtorAjax();
        include_once "src/view/debt/form.php";
    }

    /**
     * @param array $aDados
     */
    public function edit(array $aDados): void
    {
        $loDebtor = DebtorDAO::findDebtorAjax();
        $oDebt = (new DebtDAO())->find($aDados['id']);
        include_once "src/view/debt/form.php";
    }

    /**
     * @param array $aDados
     */
    public function update(array $aDados): void
    {
        try {
            if (empty($aDados['id'])) {
                throw new InvalidAttributeException('Debt\'s id is empty.');
            }

            $oDebt = (new DebtDAO())->find($aDados['id']);
            $oDebt->update($aDados);
            $aReturn = ['msg' => 'O registro da dívida foi atualizado com sucesso!', 'status' => true, 'path' => '../list'];
        } catch (Exception $e) {
            $aReturn = ['msg' => 'Erro ao atualizar o registro: '.$e->getMessage(), 'status' => false, 'path' => '../register'];
        }

        echo json_encode($aReturn);
    }

    /**
     * Inactivate debt
     * @param array $aDados
     */
    public function delete(array $aDados)
    {
        $aReturn = ['status' => true];
        try {
            $oDebt = (new DebtDAO())->find($aDados['id']);
            $oDebt->inactivate();
        } catch (Exception $e) {
            $aReturn = ['status' => false];
        }

        echo json_encode($aReturn);
    }

}