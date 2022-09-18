<?php
namespace framework\utils;

/**
 * Class Utils
 * @package framework\utils
 */
class Utils
{
    /**
     * Remove caracther of a string
     * @param string $sValue
     * @return string
     */
    public static function removeCaracther(string $sValue): string
    {
        return preg_replace("/[^0-9]/", "", $sValue);
    }

    /**
     * Import javascripts files dynamically
     * @param string $sFile
     * @param string $sModule
     */
    public static function importJs(string $sFile, string $sModule = ''): void
    {
        $sModule = !empty($sModule) ? $sModule : 'general';
        echo '/public/js/'.$sModule.'/'.$sFile.'.js';
    }

    /**
     * Import css files dynamically
     * @param string $sFile
     * @param string $sModule
     */
    public static function importCss(string $sFile, string $sModule = ''): void
    {
        $sModule = !empty($sModule) ? $sModule : 'general';
        echo '/public/css/'.$sModule.'/'.$sFile.'.css';
    }

    /**
     * Add mask on CPF or CNPJ
     * @param string $sCpfCnpj
     * @return string
     */
    public static function addMaskCpfCnpj(string $sCpfCnpj)
    {
        $sCpfCnpj = preg_replace("/[^0-9]/", "", $sCpfCnpj);
        $iQtd = strlen($sCpfCnpj);

        if($iQtd >= 11) {

            if($iQtd === 11 ) {

                $sCpfCnpjFormatado = substr($sCpfCnpj, 0, 3) . '.' .
                    substr($sCpfCnpj, 3, 3) . '.' .
                    substr($sCpfCnpj, 6, 3) . '.' .
                    substr($sCpfCnpj, 9, 2);
            } else {
                $sCpfCnpjFormatado = substr($sCpfCnpj, 0, 2) . '.' .
                    substr($sCpfCnpj, 2, 3) . '.' .
                    substr($sCpfCnpj, 5, 3) . '/' .
                    substr($sCpfCnpj, 8, 4) . '-' .
                    substr($sCpfCnpj, -2);
            }

            return $sCpfCnpjFormatado;
        } else {
            return 'Documento inválido';
        }
    }

    /**
     * Add mask on phone number
     * @param string $sNumero
     * @return array|string|string[]
     */
    public static function addMaskPhoneNumber(string $sNumero)
    {
        if(strlen($sNumero) == 10){
            $sNumeroNovo = substr_replace($sNumero, '(', 0, 0);
            $sNumeroNovo = substr_replace($sNumeroNovo, '9', 3, 0);
            $sNumeroNovo = substr_replace($sNumeroNovo, ')', 3, 0);
            $sNumeroNovo = substr_replace($sNumeroNovo, '-', -4, 0);
        }else{
            $sNumeroNovo = substr_replace($sNumero, '(', 0, 0);
            $sNumeroNovo = substr_replace($sNumeroNovo, ')', 3, 0);
            $sNumeroNovo = substr_replace($sNumeroNovo, '-', -4, 0);
        }
        return $sNumeroNovo;
    }

    /**
     * Format amount to BR
     * @param string $sAmount
     * @return string
     */
    public static function formatFloatToBr(string $sAmount)
    {
        return "R$ ".number_format($sAmount, 2, ",", ".");
    }
}