<?php
namespace src\model\debt;

use SplObjectStorage;

/**
 * Class DebtList
 * @package src\model\debt
 */
class DebtList extends SplObjectStorage
{
    /**
     * @param array $aaDebt
     * @return DebtList
     */
    public static function createFromArray(array $aaDebt): DebtList
    {
        $loDebt = new DebtList();
        foreach ($aaDebt as $aDebt) {
            $oDebt = Debt::createFromArray($aDebt);
            $loDebt->attach($oDebt);
        }

        return $loDebt;
    }

}