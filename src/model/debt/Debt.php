<?php
namespace src\model\debt;

use DateTimeImmutable;
use framework\exceptions\InvalidAttributeException;
use framework\utils\constants\PaidUnpaid;
use framework\utils\constants\TrueOrFalse;
use framework\utils\Utils;
use src\dao\DebtDAO;

/**
 * Class Debt
 * @package src\model\debt
 */
class Debt
{
    /** @var int $iId */
    private $iId;
    /** @var int $iDebtorId */
    private $iDebtorId;
    /** @var string $sDescription */
    private $sDescription;
    /** @var float $fAmount */
    private $fAmount;
    /** @var DateTimeImmutable $oDueDate */
    private $oDueDate;
    /** @var int $iStatus */
    private $iStatus;
    /** @var int $iActive */
    private $iActive;
    /** @var DateTimeImmutable $oCreated */
    private $oCreated;
    /** @var DateTimeImmutable $oUpdated */
    private $oUpdated;
    /** @var string $sDebtorName */
    private $sDebtorName;

    /**
     * Create object based on request data
     * @param array $aDados
     * @return Debt
     * @throws InvalidAttributeException
     */
    public static function createFromRequest(array $aDados): Debt
    {
        $oDebt = new Debt();

        $oDebt->validate($aDados);

        $oDebt->setDebtorId(intval($aDados['debtor_id']));
        $oDebt->setDescription($aDados['description']);

        $oDebt->setAmount(floatval($aDados['amount']));

        $oDueDate = DateTimeImmutable::createFromFormat('d/m/Y', $aDados['due_date']);
        $oDebt->setDueDate($oDueDate);

        $oDebt->setCreated((new DateTimeImmutable('NOW')));
        $oDebt->setStatus($aDados['status'] ?? PaidUnpaid::UNPAID);
        $oDebt->setActive(TrueOrFalse::TRUE);

        return $oDebt;
    }

    /**
     * Save debt registry
     */
    public function save()
    {
        $oDebtorDAO = new DebtDAO();
        $oDebtorDAO->save($this);
    }

    /**
     * Delete debt's data from database
     */
    public function delete(): void
    {
        $oDebtorDAO = new DebtDAO();
        $oDebtorDAO->delete($this);
    }

    /**
     * Inactivate debt's data from database
     */
    public function inactivate(): void
    {
        $oDebtDAO = new DebtDAO();
        $oDebtDAO->inactivate($this);
    }

    /**
     * Update debt's data in database
     */
    public function update(array $aDadosUpdate): void
    {
        $this->setAttributes($aDadosUpdate);
        (new DebtDAO())->update($this);
    }

    /**
     * Set attributes in Debt's object
     * @param array $aDados
     */
    public function setAttributes(array $aDados)
    {
        if (!empty($aDados['description'])) {
            $this->setDescription($aDados['description']);
        }
        if (!empty($aDados['debtor_id'])) {
            $this->setDebtorId($aDados['debtor_id']);
        }
        if (!empty($aDados['amount'])) {
            $sAmount = Utils::removeCaracther($aDados['amount']);
            $sAmount = substr_replace($sAmount, '.', -2, 0);
            $this->setAmount($sAmount);
        }
        if (!empty($aDados['due_date'])) {
            $oDueDate = DateTimeImmutable::createFromFormat('d/m/Y', $aDados['due_date']);
            $this->setDueDate($oDueDate);
        }
        if (!is_null($aDados['status'])) {
            $this->setStatus($aDados['status']);
        }
    }

    /**
     * Create debt object based on array
     * @param array $aDados
     * @return Debt
     */
    public static function createFromArray(array $aDados)
    {
        $oDebt = new Debt();

        if (isset($aDados['dbr_name'])) {
            $oDebt->setDebtorName($aDados['dbr_name']);
        }
        $oDebt->setId($aDados['dbt_id']);
        $oDebt->setDescription($aDados['dbt_description']);
        $oDebt->setDebtorId($aDados['dbr_id']);
        $oDebt->setAmount($aDados['dbt_amount']);

        if (!empty($aDados['dbt_due_date'])) {
            $oDueDate = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $aDados['dbt_due_date']);
            $oDebt->setDueDate($oDueDate);
        }

        if (!is_null($aDados['dbt_status'])) {
            $oDebt->setStatus($aDados['dbt_status']);
        }

        if (!is_null($aDados['dbt_active'])) {
            $oDebt->setActive($aDados['dbt_active']);
        }

        $oCreated = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $aDados['dbt_created']);
        $oDebt->setCreated($oCreated);

        if (!empty($aDados['dbt_updated'])) {
            $oUpdated = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $aDados['dbt_updated']);
            $oDebt->setUpdated($oUpdated);
        }

        return $oDebt;
    }

    /**
     * Create array using data from debt object
     * @return array
     */
    public function toArray()
    {
        $aDebt = [
            $this->iDebtorId,
            $this->sDescription,
            $this->fAmount,
            $this->iStatus
        ];

        if (!is_null($this->oDueDate)) {
            $aDebt[] = $this->oDueDate->format('Y-m-d');
        }

        if (!is_null($this->oCreated)) {
            $aDebt[] = $this->getCreated()->format('Y-m-d H:i:s');
        }

        if (!is_null($this->oUpdated)) {
            $aDebt[] = $this->getUpdated()->format('Y-m-d H:i:s');
        }

        return $aDebt;
    }

    /**
     * Validate data from request
     * @param array $aDados
     * @throws InvalidAttributeException
     */
    private function validate(array $aDados)
    {
        if (!isset($aDados['description'])) {
            throw new InvalidAttributeException('Name is empty.');
        }

        if (is_null($aDados['amount'])) {
            throw new InvalidAttributeException('Name is empty.');
        }

        if (!isset($aDados['due_date'])) {
            throw new InvalidAttributeException('Name is empty.');
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->iId;
    }

    /**
     * @param int $iId
     */
    public function setId(int $iId): void
    {
        $this->iId = $iId;
    }

    /**
     * @return int
     */
    public function getDebtorId()
    {
        return $this->iDebtorId;
    }

    /**
     * @param int $iDebtorId
     */
    public function setDebtorId(int $iDebtorId): void
    {
        $this->iDebtorId = $iDebtorId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->sDescription ?? "";
    }

    /**
     * @param string $sDescription
     */
    public function setDescription(string $sDescription): void
    {
        $this->sDescription = $sDescription;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->fAmount;
    }

    /**
     * @param float $fAmount
     */
    public function setAmount(float $fAmount): void
    {
        $this->fAmount = $fAmount;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDueDate()
    {
        return $this->oDueDate;
    }

    /**
     * @param DateTimeImmutable $oDueDate
     */
    public function setDueDate(DateTimeImmutable $oDueDate): void
    {
        $this->oDueDate = $oDueDate;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->iStatus;
    }

    /**
     * @param int $iStatus
     */
    public function setStatus(int $iStatus): void
    {
        $this->iStatus = $iStatus;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->iActive;
    }

    /**
     * @param int $iActive
     */
    public function setActive(int $iActive): void
    {
        $this->iActive = $iActive;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreated(): DateTimeImmutable
    {
        return $this->oCreated;
    }

    /**
     * @param DateTimeImmutable $oCreated
     */
    public function setCreated(DateTimeImmutable $oCreated): void
    {
        $this->oCreated = $oCreated;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdated(): ?DateTimeImmutable
    {
        return $this->oUpdated;
    }

    /**
     * @param DateTimeImmutable $oUpdated
     */
    public function setUpdated(DateTimeImmutable $oUpdated): void
    {
        $this->oUpdated = $oUpdated;
    }

    public function setDebtorName(string $sDebtorName)
    {
        $this->sDebtorName = $sDebtorName;
    }

    /**
     * @return string
     */
    public function getDebtorName(): string
    {
        return $this->sDebtorName ?? "";
    }
}