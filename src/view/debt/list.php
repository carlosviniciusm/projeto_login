<html>
<?php

use framework\utils\constants\PaidUnpaid;
use framework\utils\Utils;
use src\model\debt\Debt;
use src\model\debt\DebtList;

include_once 'src/view/home/header.php';
?>
<link rel="stylesheet" href="<?php Utils::importCss('debtor', 'debtor'); ?>" crossorigin="anonymous">
<link rel="stylesheet" href="<?php Utils::importCss('fontawesome/css/all.min'); ?>" crossorigin="anonymous">
<body>
<?php include_once 'src/view/home/menu.php'; ?>
<div class="container">
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Devedor</th>
            <th scope="col">Valor</th>
            <th scope="col">Data de vencimento</th>
            <th scope="col">Status</th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php
        /** @var DebtList $loDebt */
        if ($loDebt->count() > 0) {
            /** @var Debt $oDebt */
            foreach ($loDebt as $oDebt) {
                $sAmount = Utils::formatFloatToBr($oDebt->getAmount());
                $sStatus = $oDebt->getStatus() == PaidUnpaid::UNPAID ? 'Em aberto' : 'Pago';
                echo "<div><tr>";
                echo "<th scope=\"row\">{$oDebt->getId()}</th>";
                echo "<td class='name'>{$oDebt->getDebtorName()}</td>";
                echo "<td>{$sAmount}</td>";
                echo "<td>{$oDebt->getDueDate()->format('d/m/Y')}</td>";
                echo "<td>{$sStatus}</td>";
                echo "<td>";
                echo "<a href='edit/{$oDebt->getId()}' id='debt_edit'>";
                echo "<i title='Editar devedor' class='fa fa-edit'></i></a>";
                echo "<span style='color: white'> * </span>";
                echo "<a href='#' id='debt_delete' data-id='{$oDebt->getId()}'><i class='fa fa-trash'></i></a></td>";
                echo "</tr></div>";
            }
        } else {
        ?>
        </tbody>
    </table>
</div>
<?php
echo "<div class='msg-empty'>Não existe nenhuma dívida cadastrada.</div> ";
}
?>
</body>
<?php include_once 'src/view/home/footer.php'; ?>
<script src="<?php Utils::importJs('debt', 'debt'); ?>"></script>
</html>