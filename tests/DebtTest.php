<?php

use framework\exceptions\InvalidAttributeException;
use PHPUnit\Framework\TestCase;
use src\dao\DebtDAO;
use src\model\debt\Debt;
use src\model\debtor\Debtor;

/**
 * Class DebtTest
 */
class DebtTest extends TestCase
{
    /**
     * Test save fake debt
     * @throws InvalidAttributeException
     */
    public function testDebtGeneral()
    {
        $oDebtor = $this->saveDebtor();

        $oDebt = $this->saveDebt($oDebtor);

        $oDebtDAO = new DebtDAO();
        $oDebt = $oDebtDAO->find($oDebt->getId());
        $this->assertTrue(!is_null($oDebt->getId()));

        $aDebt = [
            'dbt_id' => $oDebt->getId(),
            'description' => "Testando atualização",
            'amount' => 111.11,
            'due_date' => '05/05/2005',
            'status' => '0'
        ];

        $oDebt->update($aDebt);

        $oDebt = $oDebtDAO->find($oDebt->getId());

        $this->assertEquals("Testando atualização", $oDebt->getDescription());
        $this->assertEquals(111.11, $oDebt->getAmount());
        $this->assertEquals(0, $oDebt->getStatus());
        $this->assertEquals(1, $oDebt->getActive());
        $this->assertEquals('05/05/2005', $oDebt->getDueDate()->format('d/m/Y'));
        $this->assertTrue(!is_null($oDebt->getUpdated()));

        $oDebt->delete();

        $oDebt = $oDebtDAO->find($oDebt->getId());
        $this->assertFalse(!is_null($oDebt->getId()));

        $oDebtor->delete();
    }

    /**
     * Save debtor registry
     * @return Debtor
     * @throws InvalidAttributeException
     */
    public function saveDebtor(): Debtor
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm321@gmail.com',
            'cpf_cnpj' => '01234567890',
            'birthdate' => '12/01/1994',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Deputado Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste',
            'neighborhood' => 'Bairro Teste',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $oDebtor = Debtor::createFromRequest($aDados);
        $oDebtor->save();
        return $oDebtor;
    }

    /**
     * @param Debtor $oDebtor
     * @return Debt
     * @throws InvalidAttributeException
     */
    public function saveDebt(Debtor $oDebtor): Debt
    {
        $aDados = [
            'debtor_id' => $oDebtor->getId(),
            'description' => 'Descrição para dívida teste',
            'amount' => '123.50',
            'due_date' => '05/10/2021'
        ];

        $oDebt = Debt::createFromRequest($aDados);
        $oDebt->save();
        return $oDebt;
    }
}