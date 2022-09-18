<html>
<?php

use framework\utils\constants\PaidUnpaid;
use framework\utils\Utils;
use src\model\debtor\Debtor;

$sId = isset($oDebt) ? $oDebt->getId() : "";
$sDebtorId = $oDebt->getDebtorId() ?? "";
$sDescription = $oDebt->getDescription();
$sAmount = $oDebt->getAmount() ?? "";
$sDueDate = !is_null($oDebt->getDueDate()) ? $oDebt->getDueDate()->format('d/m/Y') : "";
$sStatus = isset($oDebt) ? $oDebt->getStatus() : "";
$sAction = empty($sId) ? 'save' : '../update';
$sTitle = empty($sId) ? 'Cadastro de Dívida' : 'Edição da Dívida';

include_once 'src/view/home/header.php';

?>
<link rel="stylesheet" href="<?php Utils::importCss('debt', 'debt'); ?>" crossorigin="anonymous">
<link rel="stylesheet" href="<?php Utils::importCss('jquery-ui'); ?>" crossorigin="anonymous">
<body>
<?php include_once 'src/view/home/menu.php'; ?>
<div>
    <form class="needs-validation" novalidate action="<?php echo $sAction; ?>" id="form-debt" method="post">
        <input type="hidden" value="<?php echo $sId; ?>" name="id">
        <div class="col-md-6 offset-md-3" style="margin-top: 10px">
            <h2 style="text-align: center"><?php echo $sTitle; ?></h2>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="debtor_id">Devedor</label><span> *</span>
                    <select class="form-control" name="debtor_id" id="debtor_id">
                        <option>Selecione um devedor</option>
                        <?php
                        /** @var Debtor $oDebtor */
                        $bChecked = '';
                        foreach ($loDebtor as $oDebtor) {
                            if ($oDebtor->getId() == $sDebtorId) {
                                $bChecked = 'selected';
                            }
                            echo "<option {$bChecked} value={$oDebtor->getId()}>{$oDebtor->getName()}</option>";
                            $bChecked = '';
                        }
                        ?>
                    </select>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">O devedor é obrigatório</div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="amount">Valor</label><span> *</span>
                    <input type="text" onkeyup="formatValue()" class="form-control" value="<?php echo $sAmount ?>"
                           name="amount" id="amount" placeholder="somente números"
                           required>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Valor do título é obrigatório</div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="due_date">Data de validade</label><span> *</span>
                    <input type="text" class="form-control" value="<?php echo $sDueDate ?>" name="due_date"
                           id="due_date" required>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Data de validade é obrigatória</div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="description">Descrição</label><span> *</span>
                    <textarea class="form-control" name="description" id="description"
                              required><?php echo $sDescription ?></textarea>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Descrição é obrigatória</div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-5 mb-3">
                    <label for="status">Status</label><span> *</span><br>
                    <?php
                    $sUnpaidChecked = '';
                    $sPaidChecked = '';
                    if ($sStatus == PaidUnpaid::UNPAID) {
                        $sPaidChecked = '';
                        $sUnpaidChecked = 'checked';
                    } else {
                        $sPaidChecked = 'checked';
                        $sUnpaidChecked = '';
                    }
                    ?>
                    <input type="radio" class="status" name="status" id="active" value="1"
                           required <?php echo $sPaidChecked; ?>>Paga
                    <input type="radio" class="status" name="status" id="inactive" value="0"
                           required <?php echo $sUnpaidChecked; ?>>Em aberto
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">O status é obrigatório</div>
                </div>
            </div>
            <?php
            if (is_null($oDebt->getId())) { ?>
                <button class="btn btn-primary" id="save" type="submit">Cadastrar</button>
            <?php } else { ?>
                <button class="btn btn-primary" id="update" type="submit">Atualizar</button>
            <?php } ?>
        </div>
    </form>
</div>
<div id="status-msg" class="col-md-6 offset-md-3" style=""></div>
</body>
<?php include_once 'src/view/home/footer.php'; ?>
<script src="<?php Utils::importJs('debt', 'debt'); ?>"></script>
<script src="<?php Utils::importJs('jquery-ui'); ?>"></script>