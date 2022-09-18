<?php
namespace src\controller;

use Exception;
use framework\exceptions\InvalidAttributeException;
use framework\utils\Utils;
use src\dao\DebtorDAO;
use src\model\debtor\Debtor;

/**
 * Class debtorController
 * @package src\controller
 */
class debtorController
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
        $loDebtor = DebtorDAO::findAllActive();

        include_once "src/view/debtor/list.php";
    }

    /**
     * Save debtor registry
     * @param array $aDados
     */
    public function save($aDados): void
    {
        try {
            if (isset($aDados['cpf_cnpj'])) {
                $sCpfCnpj = Utils::removeCaracther($aDados['cpf_cnpj']);
                $oDebtor = (new DebtorDAO())->findByCpfCnpj($sCpfCnpj);
                if ($oDebtor->hasId()) {
                    echo json_encode(['msg' => 'Esse CPF/CNPJ já está cadastrado em nossa base!', 'status' => false]);
                    die();
                }
            }

            $oDebtor = Debtor::createFromRequest($aDados);
            $oDebtor->save();

            $aReturn = ['msg' => 'O cadastro do devedor foi realizado com sucesso!', 'status' => true, 'path' => 'list'];
        } catch (Exception $e) {
            $aReturn = ['msg' => 'Erro ao salvar o devedor: '.$e->getMessage(), 'status' => false, 'path' => 'register'];
        }

        echo json_encode($aReturn);
    }

    /**
     * Update debtor registry
     * @param array $aDados
     */
    public function update(array $aDados): void
    {
        try {
            if (empty($aDados['id'])) {
                throw new InvalidAttributeException('Debtor\'s id is empty.');
            }

            $oDebtor = (new DebtorDAO())->find($aDados['id']);
            $oDebtor->update($aDados);
            $aReturn = ['msg' => 'O registro do devedor foi atualizado com sucesso!', 'status' => true, 'path' => '../list'];
        } catch (Exception $e) {
            $aReturn = ['msg' => 'Erro ao atualizar o registro: '.$e->getMessage(), 'status' => false, 'path' => '../register'];
        }

        echo json_encode($aReturn);
    }

    /**
     * Open view to register debtor
     */
    public function register($a)
    {
        $oDebtor = new Debtor();
        include_once "src/view/debtor/form.php";
    }

    /**
     * Inactivate debtor
     * @param array $aDados
     */
    public function delete(array $aDados)
    {
        $aReturn = ['status' => true];
        try {
            $oDebtor = (new DebtorDAO())->find($aDados['id']);
            $oDebtor->inactivate();
        } catch (Exception $e) {
            $aReturn = ['status' => false];
        }

        echo json_encode($aReturn);
    }

    public function edit(array $aDados)
    {
        $oDebtor = (new DebtorDAO())->find($aDados['id']);
        include_once "src/view/debtor/form.php";
    }

}