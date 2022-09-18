<?php
namespace src\model\debtor;

use SplObjectStorage;

/**
 * Class DebtorList
 * @package src\model\debtor
 */
class DebtorList extends SplObjectStorage
{
    /**
     * Create list from array
     * @param array $aaDebtor
     * @return DebtorList
     */
    public static function createFromArray(array $aaDebtor): DebtorList
    {
        $loDebtor = new DebtorList();
        foreach ($aaDebtor as $aDebtor) {
            $oDebtor = Debtor::createFromArray($aDebtor);
            $loDebtor->attach($oDebtor);
        }

        return $loDebtor;
    }
}