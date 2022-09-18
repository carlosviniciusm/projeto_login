<?php

use framework\exceptions\InvalidAttributeException;
use PHPUnit\Framework\TestCase;
use src\dao\DebtorDAO;
use src\model\debtor\Debtor;

/**
 * Class DebtorTest
 */
class DebtorTest extends TestCase
{
    /**
     * Test save fake debtor
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveGeneral()
    {
        $this->saveDebtor();

        $oDebtorDAO = new DebtorDAO();
        $oDebtor = $oDebtorDAO->findByCpfCnpj('01234567890');
        $this->assertTrue(!is_null($oDebtor->getId()));
    }

    /**
     * Test save same CPF/CNPJ
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveSameCpf()
    {
        $aDados = [
            'name' => 'Carlos Teste',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '01234567890',
            'birthdate' => '15/01/1996',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $oDebtor = Debtor::createFromRequest($aDados);
        $this->expectException(PDOException::class);
        $oDebtor->save();
        $oDebtorDAO = new DebtorDAO();
        $oDebtor = $oDebtorDAO->findByCpfCnpj('01234567890');
        $this->assertTrue(!is_null($oDebtor->getId()));
    }

    /**
     * Test delete fake debtor
     */
    public function testDebtorDelete()
    {
        $oDebtorDAO = new DebtorDAO();
        $oDebtor = $oDebtorDAO->findByCpfCnpj('01234567890');

        $this->assertTrue(!is_null($oDebtor->getId()));

        $oDebtor->delete();

        $oDebtor = $oDebtorDAO->findByCpfCnpj('01234567890');
        $this->assertFalse(!is_null($oDebtor->getId()));
    }

    /**
     * Test save name empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveNameEmpty()
    {
        $aDados = [
            'name' => '',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '1234567890',
            'birthdate' => '15/01/1996',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test save email empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveEmailEmpty()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => '',
            'cpf_cnpj' => '1234567890',
            'birthdate' => '15/01/1996',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test save cpf/cnpj empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveCpfCnpjEmpty()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '',
            'birthdate' => '15/01/1996',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test save birthdate empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveBirthdateEmpty()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '1234567890',
            'birthdate' => '',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test save phone number empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSavePhoneNumberEmpty()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '1234567890',
            'birthdate' => '12/01/1994',
            'phone_number' => '',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test save zipcode empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveZipcodeEmpty()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '1234567890',
            'birthdate' => '12/01/1994',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test save address empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveAddressEmpty()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '1234567890',
            'birthdate' => '12/01/1994',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => '',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test save number empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveNumberEmpty()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '1234567890',
            'birthdate' => '12/01/1994',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test save neighborhood empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveNeighborhoodEmpty()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '1234567890',
            'birthdate' => '12/01/1994',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Complemento Teste',
            'neighborhood' => '',
            'city' => 'Aracaju',
            'state' => 'SE'
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test save city empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveCityEmpty()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '1234567890',
            'birthdate' => '12/01/1994',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => '',
            'state' => 'SE'
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test save state empty
     * @throws InvalidAttributeException
     */
    public function testDebtorSaveStateEmpty()
    {
        $aDados = [
            'name' => 'Carlos Vinicius',
            'email' => 'cvmm121@gmail.com',
            'cpf_cnpj' => '1234567890',
            'birthdate' => '12/01/1994',
            'phone_number' => '(79) 9 9999-9999',
            'zipcode' => '99999-999',
            'address' => 'Rua Teste',
            'number' => '25',
            'complement' => 'Conjunto Teste 2',
            'neighborhood' => 'Bairro Teste 2',
            'city' => 'Aracaju',
            'state' => ''
        ];

        $this->expectException(InvalidAttributeException::class);
        $oDebtor = Debtor::createFromRequest($aDados);
    }

    /**
     * Test update debtor's data
     * @throws InvalidAttributeException
     */
    public function testDebtorUpdate()
    {
        $this->saveDebtor();

        $oDebtor = (new DebtorDAO())->findByCpfCnpj('01234567890');
        $this->assertTrue(!is_null($oDebtor->getId()));

        $aDadosUpdate = [
            'id' => $oDebtor->getId(),
            'name' => 'Carlos Vinicius Atualização',
            'email' => 'cvmm321atualizado@gmail.com',
            'cpf_cnpj' => '14725836905',
            'birthdate' => '01/01/2000',
            'phone_number' => '(79) 9 8888-8888',
            'zipcode' => '11111-111',
            'address' => 'Rua Atualização',
            'number' => '005544',
            'complement' => 'Conjunto Atualização',
            'neighborhood' => 'Bairro Atualização',
            'city' => 'Maceió',
            'state' => 'AL'
        ];

        $oDebtorFound = (new DebtorDAO())->find($aDadosUpdate['id']);
        $oDebtorFound->update($aDadosUpdate);

        $oDebtorUpdated = (new DebtorDAO())->find($aDadosUpdate['id']);
        $this->assertTrue($oDebtorUpdated->getName() == 'Carlos Vinicius Atualização');
        $this->assertTrue($oDebtorUpdated->getEmail() == 'cvmm321atualizado@gmail.com');
        $this->assertTrue($oDebtorUpdated->getCpfCnpj() == '14725836905');
        $this->assertTrue($oDebtorUpdated->getBirthdate()->format('d/m/Y') == '01/01/2000');
        $this->assertTrue($oDebtorUpdated->getPhoneNumber() == '79988888888');
        $this->assertTrue($oDebtorUpdated->getZipcode() == '11111111');
        $this->assertTrue($oDebtorUpdated->getAddress() == 'Rua Atualização');
        $this->assertTrue($oDebtorUpdated->getNumber() == '005544');
        $this->assertTrue($oDebtorUpdated->getComplement() == 'Conjunto Atualização');
        $this->assertTrue($oDebtorUpdated->getNeighborhood() == 'Bairro Atualização');
        $this->assertTrue($oDebtorUpdated->getCity() == 'Maceió');
        $this->assertTrue($oDebtorUpdated->getState() == 'AL');
        $this->assertTrue(!is_null($oDebtorUpdated->getUpdated()));
        $oDebtorUpdated->delete();
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
}