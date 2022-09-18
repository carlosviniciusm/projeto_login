<?php
namespace src\dao;

use DateTimeImmutable;
use Exception;
use framework\system\Connection;
use framework\utils\constants\TrueOrFalse;
use PDO;
use PDOException;
use RuntimeException;
use src\model\debt\Debt;
use src\model\debt\DebtList;

/**
 * Class DebtDAO
 * @package src\dao
 */
class DebtDAO
{
    /**
     * @param int $iId
     * @return Debt
     */
    public function find(int $iId): Debt
    {
        $sSql = "SELECT * FROM dbt_debt WHERE dbt_id = ?";

        try {
            $stmt = $this->getStatement($sSql);

            $stmt->bindParam(1, $iId);

            $stmt->execute();
            $aDebt = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException("Error when consulting debt.", 500, $e);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        if (!$aDebt) {
            return new Debt();
        }

        return Debt::createFromArray($aDebt);
    }

    /**
     * Save debt data in database
     * @param Debt $oDebt
     */
    public function save(Debt $oDebt): void {
        $sSql = "INSERT INTO dbt_debt(dbr_id, dbt_description, dbt_amount,
                                        dbt_status, dbt_due_date, dbt_created) VALUES (?,?,?,?,?,?)";

        $oDebt->setCreated(new DateTimeImmutable('NOW'));

        $aDebt = $oDebt->toArray();

        try {
            $oConnection = Connection::getConnection();
            $oConnection->beginTransaction();

            $stmt = $oConnection->prepare($sSql);
            if (!$stmt) {
                throw new PDOException("Error to prepare query string.");
            }

            $stmt->execute($aDebt);
        } catch (PDOException $e) {
            $oConnection->rollBack();
            throw new PDOException("Error to save debt. " . $e->getMessage());
        }

        $oDebt->setId($oConnection->lastInsertId());
        $oConnection->commit();
    }

    /**
     * Update debt's data in database
     * @param Debt $oDebt
     */
    public function update(Debt $oDebt): void {
        $sSql = "UPDATE dbt_debt 
                    SET dbr_id = ?,
                    dbt_description = ?,
                    dbt_amount = ?,
                    dbt_status = ?,
                    dbt_due_date = ?,
                    dbt_updated = ?
                WHERE dbt_id = ?";

        $aDebt = $oDebt->toArray();
        array_pop($aDebt);
        $aDebt[] = (new DateTimeImmutable('now'))->format('Y-m-d H:i:s');
        $aDebt[] = $oDebt->getId();

        try {
            $oConnection = Connection::getConnection();
            $oConnection->beginTransaction();

            $stmt = $oConnection->prepare($sSql);
            if (!$stmt) {
                throw new PDOException("Error to prepare query string.");
            }

            $stmt->execute($aDebt);
            $oConnection->commit();
        } catch (PDOException $e) {
            $oConnection->rollBack();
            throw new PDOException("Error to update debt. " . $e->getMessage());
        }
    }

    /**
     * Inactivate debt's data in database
     * @param Debt $oDebt
     */
    public function inactivate(Debt $oDebt): void {
        $sSql = "UPDATE dbt_debt SET dbt_active = ? WHERE dbt_id = ?";

        $aDebt[] = TrueOrFalse::FALSE;
        $aDebt[] = $oDebt->getId();

        try {
            $oConnection = Connection::getConnection();
            $oConnection->beginTransaction();

            $stmt = $oConnection->prepare($sSql);
            if (!$stmt) {
                throw new PDOException("Error to prepare query string.");
            }

            $stmt->execute($aDebt);
            $oConnection->commit();
        } catch (PDOException $e) {
            $oConnection->rollBack();
            throw new PDOException("Error to inactivate debt. " . $e->getMessage());
        }
    }

    /**
     * Delete debt registry from database
     * @param Debt $oDebt
     * @return void
     */
    public function delete(Debt $oDebt): void {
        $sSql = "DELETE FROM dbt_debt WHERE dbt_id = ?";

        try {
            $oConnection = Connection::getConnection();
            $oConnection->beginTransaction();

            $stmt = $oConnection->prepare($sSql);
            if (!$stmt) {
                throw new PDOException("Error to prepare query string.");
            }

            $stmt->execute([$oDebt->getId()]);

            $oConnection->commit();
        } catch (PDOException $e) {
            $oConnection->rollBack();
            throw new PDOException("Error deleting debt. " . $e->getMessage());
        }
    }

    /**
     * @param string $sSql
     * @return \PDOStatement
     */
    public function getStatement(string $sSql): \PDOStatement
    {
        $oConnection = Connection::getConnection();

        $stmt = $oConnection->prepare($sSql);

        if (!$stmt) {
            throw new PDOException();
        }
        return $stmt;
    }

    /**
     * Find all active registry
     * @return DebtList
     */
    public static function findAllActive()
    {
        $sSql = "SELECT dbr.dbr_name, dbt.* FROM dbt_debt dbt
                    INNER JOIN dbr_debtor dbr on dbt.dbr_id = dbr.dbr_id 
                        WHERE dbt_active = ?";

        try {
            $oConnection = Connection::getConnection();

            $stmt = $oConnection->prepare($sSql);

            if (!$stmt) {
                throw new PDOException();
            }

            $iTrue = TrueOrFalse::TRUE;
            $stmt->bindParam(1, $iTrue);

            $stmt->execute();
            $aaDebt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException("Error when consulting debtor.", 500, $e);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        if (empty($aaDebt)) {
            return new DebtList();
        }

        return DebtList::createFromArray($aaDebt);
    }
}