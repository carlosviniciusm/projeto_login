<?php
namespace src\model\debtor;

use DateTimeImmutable;
use framework\exceptions\InvalidAttributeException;
use framework\utils\constants\CreditorDebtor;
use framework\utils\constants\TrueOrFalse;
use framework\utils\Utils;
use src\dao\DebtorDAO;

/**
 * Class Debtor
 * @package src\model\debtor
 */
class Debtor
{
    /** @var int $iId */
    private $iId;
    /** @var string $sName */
    private $sName;
    /** @var string $sEmail */
    private $sEmail;
    /** @var string $sCpfCnpj */
    private $sCpfCnpj;
    /** @var DateTimeImmutable $oBirthdate */
    private $oBirthdate;
    /** @var string $sPhoneNumber */
    private $sPhoneNumber;
    /** @var string $sZipcode */
    private $sZipcode;
    /** @var string $sAddress */
    private $sAddress;
    /** @var string $sNumber */
    private $sNumber;
    /** @var string $sComplement */
    private $sComplement;
    /** @var string $sNeighborhood */
    private $sNeighborhood;
    /** @var string $sCity */
    private $sCity;
    /** @var string $sState */
    private $sState;
    /** @var int $iStatus */
    private $iStatus;
    /** @var bool $bActive */
    private $bActive;
    /** @var DateTimeImmutable $oCreated */
    private $oCreated;
    /** @var DateTimeImmutable $oUpdated */
    private $oUpdated;

    /**
     * Debtor constructor.
     */
    public function __construct()
    {
        $this->iStatus = CreditorDebtor::DEBTOR;
        $this->bActive = TrueOrFalse::TRUE;
    }

    /**
     * Register debtor's data in database
     */
    public function save(): void
    {
        $oDebtorDAO = new DebtorDAO();
        $oDebtorDAO->save($this);
    }

    /**
     * Update debtor's data in database
     */
    public function update(array $aDadosUpdate): void
    {
        $this->setAttributes($aDadosUpdate);
        (new DebtorDAO())->update($this);
    }

    /**
     * Delete debtor's data from database
     */
    public function delete(): void
    {
        $oDebtorDAO = new DebtorDAO();
        $oDebtorDAO->delete($this);
    }

    /**
     * Inactivate debtor
     */
    public function inactivate(): void
    {
        $oDebtorDAO = new DebtorDAO();
        $oDebtorDAO->inactivate($this);
    }

    /**
     * Create Debtor object from array
     * @param array $aDados
     * @return Debtor
     */
    public static function createFromArray(array $aDados): Debtor
    {
        $oDebtor = new Debtor();

        if (isset($aDados['dbr_id'])) {
            $oDebtor->setId($aDados['dbr_id']);
        }

        if (isset($aDados['dbr_name'])) {
            $oDebtor->setName($aDados['dbr_name']);
        }

        if (isset($aDados['dbr_email'])) {
            $oDebtor->setEmail($aDados['dbr_email']);
        }

        if (isset($aDados['dbr_zipcode'])) {
            $oDebtor->setZipcode($aDados['dbr_zipcode']);
        }

        if (isset($aDados['dbr_cpf_cnpj'])) {
            $oDebtor->setCpfCnpj($aDados['dbr_cpf_cnpj']);
        }

        if (isset($aDados['dbr_address'])) {
            $oDebtor->setAddress($aDados['dbr_address']);
        }

        if (isset($aDados['dbr_number'])) {
            $oDebtor->setNumber($aDados['dbr_number']);
        }

        if (isset($aDados['dbr_neighborhood'])) {
            $oDebtor->setNeighborhood($aDados['dbr_neighborhood']);
        }

        if (isset($aDados['dbr_city'])) {
            $oDebtor->setCity($aDados['dbr_city']);
        }

        if (isset($aDados['dbr_state'])) {
            $oDebtor->setState($aDados['dbr_state']);
        }

        if (isset($aDados['dbr_created'])) {
            $oCreated = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $aDados['dbr_created']);
            $oDebtor->setCreated($oCreated);
        }

        if (isset($aDados['dbr_birthdate'])) {
            $oBirthdate = DateTimeImmutable::createFromFormat('Y-m-d', $aDados['dbr_birthdate']);
            $oDebtor->setBirthdate($oBirthdate);
        }

        if (isset($aDados['dbr_phone_number'])) {
            $oDebtor->setPhoneNumber($aDados['dbr_phone_number']);
        }

        if (isset($aDados['dbr_complement'])) {
            $oDebtor->setComplement($aDados['dbr_complement']);
        }

        if (isset($aDados['dbr_updated'])) {
            $oUpdated = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $aDados['dbr_updated']);
            $oDebtor->setUpdated($oUpdated);
        }

        return $oDebtor;
    }

    /**
     * Create Debtor objet from request (view)
     * @param array $aDados
     * @return Debtor
     * @throws InvalidAttributeException
     */
    public static function createFromRequest(array $aDados)
    {
        $oDebtor = new Debtor();

        $oDebtor->validate($aDados);

        $oDebtor->setName($aDados['name']);
        $oDebtor->setEmail($aDados['email']);

        $sCpfCnpj = Utils::removeCaracther($aDados['cpf_cnpj']);
        $oDebtor->setCpfCnpj($sCpfCnpj);

        $oBirthdate = DateTimeImmutable::createFromFormat('d/m/Y', $aDados['birthdate']);
        $oDebtor->setBirthdate($oBirthdate);

        $sNumber = Utils::removeCaracther($aDados['phone_number']);
        $oDebtor->setPhoneNumber($sNumber);

        $sZipCode = Utils::removeCaracther($aDados['zipcode']);
        $oDebtor->setZipcode($sZipCode);

        $oDebtor->setAddress($aDados['address']);

        $oDebtor->setNumber($aDados['number']);

        if (!empty($aDados['complement'])) {
            $oDebtor->setComplement($aDados['complement']);
        }

        if (!empty($aDados['neighborhood'])) {
            $oDebtor->setNeighborhood($aDados['neighborhood']);
        }

        if (!empty($aDados['city'])) {
            $oDebtor->setCity($aDados['city']);
        }

        if (!empty($aDados['state'])) {
            $oDebtor->setState($aDados['state']);
        }

        return $oDebtor;
    }

    /**
     * Create array using Debtor object data
     * @return array
     */
    public function toArray(): array
    {
        $aDebtor = [
            $this->sName,
            $this->sEmail,
            $this->sCpfCnpj,
            $this->sPhoneNumber,
            $this->sZipcode,
            $this->sAddress,
            $this->sNumber,
            $this->sComplement,
            $this->sNeighborhood,
            $this->sCity,
            $this->sState,
            $this->iStatus,
            $this->bActive
        ];

        if (!is_null($this->oBirthdate)) {
            $aDebtor[] = $this->oBirthdate->format('Y-m-d');
        }

        if (!is_null($this->oCreated)) {
            $aDebtor[] = $this->oCreated->format('Y-m-d H:i:s');
        }

        if (!is_null($this->getUpdated())) {
            $aDebtor[] = $this->getUpdated()->format('Y-m-d H:i:s');
        }

        return $aDebtor;
    }

    /**
     * Validate filling in the fields
     * @param array $aDados
     * @throws InvalidAttributeException
     */
    public function validate(array $aDados)
    {
        if (empty($aDados['name'])) {
            throw new InvalidAttributeException('Nome é obrigatório.');
        }

        if (empty($aDados['email'])) {
            throw new InvalidAttributeException('E-mail é obrigatório.');
        }

        $sCpfCnpj = Utils::removeCaracther($aDados['cpf_cnpj']);
        if (empty($sCpfCnpj) || (strlen($sCpfCnpj) < 11 || strlen($sCpfCnpj) > 14)) {
            throw new InvalidAttributeException('CPF/CNPJ '.$sCpfCnpj.' é inválido.');
        }

        if (empty($aDados['birthdate'])) {
            throw new InvalidAttributeException('Data de nascimento é obrigatória.');
        }

        if (empty($aDados['phone_number'])) {
            throw new InvalidAttributeException('Telefone é obrigatório.');
        }

        $sZipcode = Utils::removeCaracther($aDados['zipcode']);
        if (empty($sZipcode) || strlen($sZipcode) != 8 ) {
            throw new InvalidAttributeException('CEP'.$sZipcode.' é inválido.');
        }

        if (empty($aDados['address'])) {
            throw new InvalidAttributeException('Endereço é obrigatório.');
        }

        if (empty($aDados['number'])) {
            throw new InvalidAttributeException('Número é obrigatório.');
        }

        if (empty($aDados['neighborhood'])) {
            throw new InvalidAttributeException('Bairro é obrigatório.');
        }

        if (empty($aDados['city'])) {
            throw new InvalidAttributeException('Cidade é obrigatória.');
        }

        if (empty($aDados['state'])) {
            throw new InvalidAttributeException('UF é obrigatória.');
        }
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->bActive;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->iId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->sName ?? "";
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->sEmail;
    }

    /**
     * @return string
     */
    public function getCpfCnpj()
    {
        return $this->sCpfCnpj;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getBirthdate()
    {
        return $this->oBirthdate;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->sPhoneNumber;
    }

    /**
     * @return string
     */
    public function getZipcode()
    {
        return $this->sZipcode;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->sAddress;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->sNumber;
    }

    /**
     * @return string
     */
    public function getComplement()
    {
        return $this->sComplement;
    }

    /**
     * @return string
     */
    public function getNeighborhood()
    {
        return $this->sNeighborhood;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->sCity;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->sState;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->iStatus;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreated()
    {
        return $this->oCreated;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdated()
    {
        return $this->oUpdated;
    }

    /**
     * @param int $iId
     */
    public function setId(int $iId): void
    {
        $this->iId = $iId;
    }

    /**
     * @param string $sName
     */
    public function setName(string $sName): void
    {
        $this->sName = $sName;
    }

    /**
     * @param string $sEmail
     */
    public function setEmail(string $sEmail): void
    {
        $this->sEmail = $sEmail;
    }

    /**
     * @param string $sCpfCnpj
     */
    public function setCpfCnpj(string $sCpfCnpj): void
    {
        $this->sCpfCnpj = $sCpfCnpj;
    }

    /**
     * @param \DateTimeImmutable $oBirthdate
     */
    public function setBirthdate(\DateTimeImmutable $oBirthdate): void
    {
        $this->oBirthdate = $oBirthdate;
    }

    /**
     * @param string $sPhoneNumber
     */
    public function setPhoneNumber(string $sPhoneNumber): void
    {
        $this->sPhoneNumber = $sPhoneNumber;
    }

    /**
     * @param string $sZipcode
     */
    public function setZipcode(string $sZipcode): void
    {
        $this->sZipcode = $sZipcode;
    }

    /**
     * @param string $sAddress
     */
    public function setAddress(string $sAddress): void
    {
        $this->sAddress = $sAddress;
    }

    /**
     * @param string $sNumber
     */
    public function setNumber(string $sNumber): void
    {
        $this->sNumber = $sNumber;
    }

    /**
     * @param string $sComplement
     */
    public function setComplement(string $sComplement): void
    {
        $this->sComplement = $sComplement;
    }

    /**
     * @param string $sNeighborhood
     */
    public function setNeighborhood(string $sNeighborhood): void
    {
        $this->sNeighborhood = $sNeighborhood;
    }

    /**
     * @param string $sCity
     */
    public function setCity(string $sCity): void
    {
        $this->sCity = $sCity;
    }

    /**
     * @param string $sState
     */
    public function setState(string $sState): void
    {
        $this->sState = $sState;
    }

    /**
     * @param bool $bActive
     */
    public function setActive(bool $bActive): void
    {
        $this->bActive = $bActive;
    }

    /**
     * @param \DateTimeImmutable $oCreated
     */
    public function setCreated(\DateTimeImmutable $oCreated): void
    {
        $this->oCreated = $oCreated;
    }

    /**
     * @param DateTimeImmutable $oUpdated
     */
    public function setUpdated(DateTimeImmutable $oUpdated): void
    {
        $this->oUpdated = $oUpdated;
    }

    /**
     * @param array $aDadosUpdate
     */
    public function setAttributes(array $aDadosUpdate): void
    {
        if (!empty($aDadosUpdate['name'])) {
            $this->setName($aDadosUpdate['name']);
        }
        if (!empty($aDadosUpdate['email'])) {
            $this->setEmail($aDadosUpdate['email']);
        }
        if (!empty($aDadosUpdate['cpf_cnpj'])) {
            $sCpfCnpj = Utils::removeCaracther($aDadosUpdate['cpf_cnpj']);
            $this->setCpfCnpj($sCpfCnpj);
        }
        if (!empty($aDadosUpdate['birthdate'])) {
            $oBirthdate = DateTimeImmutable::createFromFormat('d/m/Y', $aDadosUpdate['birthdate']);
            $this->setBirthdate($oBirthdate);
        }
        if (!empty($aDadosUpdate['phone_number'])) {
            $sPhoneNumber = Utils::removeCaracther($aDadosUpdate['phone_number']);
            $this->setPhoneNumber($sPhoneNumber);
        }
        if (!empty($aDadosUpdate['zipcode'])) {
            $sZipCode = Utils::removeCaracther($aDadosUpdate['zipcode']);
            $this->setZipcode($sZipCode);
        }
        if (!empty($aDadosUpdate['address'])) {
            $this->setAddress($aDadosUpdate['address']);
        }
        if (!empty($aDadosUpdate['number'])) {
            $this->setNumber($aDadosUpdate['number']);
        }
        if (!empty($aDadosUpdate['complement'])) {
            $this->setcomplement($aDadosUpdate['complement']);
        }
        if (!empty($aDadosUpdate['neighborhood'])) {
            $this->setNeighborhood($aDadosUpdate['neighborhood']);
        }
        if (!empty($aDadosUpdate['city'])) {
            $this->setCity($aDadosUpdate['city']);
        }
        if (!empty($aDadosUpdate['state'])) {
            $this->setState($aDadosUpdate['state']);
        }

        $this->setUpdated(new DateTimeImmutable('NOW'));
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return !is_null($this->iId);
    }
}