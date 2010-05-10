<?php
/**
 * Change amount into text for ringgit malaysia.
 *
 * Amount to text
 *
 * PHP versions 4 and 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2010, Tukangkod. (http://kode.fahmi.my)
 * @link          http://kode.fahmi.my/projects/rm2text
 * @version       v0.1
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class rm2text
{
    function __construct($amount)
    {
        return $this->toRMText($amount);
    }

    private function toRMText($amount)
    {
        list($ringgit, $sen) = explode('.', $amount);
        $isen = $this->getPuluhBelas($sen);
        
        $arramount = str_split($ringgit);
        $arramount = array_reverse($arramount);

        $camount = count($arramount);
        $iamount = $camount-1;

        $iringgit = null;
        switch($iamount)
        {
            case "6":
                if ($arramount[6] > 0) $iringgit .= $this->nombor($arramount[6]).$this->unit(7).' ';
            case "5":
                if ($arramount[5] > 0) $iringgit .= $this->nombor($arramount[5]).$this->unit(6);
            case "4":
            case "3":
                $pbr = (isset($arramount[4])?$arramount[4]:'0').$arramount[3];
                if ($pbr > 0) $iringgit .= $this->getPuluhBelas($pbr).$this->unit(4);
                if ($pbr == 0 && $arramount[5] > 0) $iringgit .= $this->unit(4);
            case "2":
                if ($arramount[2] > 0) $iringgit .= $this->nombor($arramount[2]).$this->unit(3);
            case "1":
            case "0":
                $pb = (isset($arramount[1])?$arramount[1]:'0').$arramount[0];
                $iringgit .= $this->getPuluhBelas($pb);
                break;
        }
        return ucwords((($iringgit)?$iringgit.' ringgit ':'').(($isen)?$isen.' '.__('cent', true):''));
    }
    
    private function getPuluhBelas($nombor)
    {
        list($puluh, $sa) = str_split($nombor);
        if ($nombor == 0) return '';
        else if ($puluh == 0) return $this->nombor($sa);
        else 
        {
            if ($puluh == 1)
            {
                if ($sa < 2) return $this->nombor(10).$this->unit(strlen($nombor), $nombor);
                return (($sa > 0)?$this->nombor($sa):$this->nombor($puluh)).$this->unit(strlen($nombor), $nombor);
            }
            else
            {
                if ($sa == 0) return $this->nombor($puluh).$this->unit(strlen($nombor), $nombor);
                else return $this->nombor($puluh).$this->unit(strlen($nombor), $nombor).' '.$this->nombor($sa);
            }
        }
    }

    private function nombor($nombor)
    {
        switch($nombor)
        {
            case "0": return ''; break;
            case "1": return 'satu '; break;
            case "2": return 'dua '; break;
            case "3": return 'tiga '; break;
            case "4": return 'empat '; break;
            case "5": return 'lima '; break;
            case "6": return 'enam '; break;
            case "7": return 'tujuh '; break;
            case "8": return 'lapan '; break;
            case "9": return 'sembilan '; break;
            case "10": return 'se'; break;
        }
    }
    
    private function unit($count, $arrno=null)
    {
        if ($arrno == null) $arrno = array(2, 0);
        switch($count)
        {
            case "7": return "juta "; break;
            case "6": return "ratus "; break;
            case "5": return ($arrno[0] == "1")?"belas ":"puluh "; break;
            case "4": return "ribu "; break;
            case "3": return "ratus "; break;
            case "2":
                if ($arrno[0] == 1) return ($arrno[1] > 0)?"belas ":"puluh ";
                else if ($arrno[0] != 0) return "puluh ";
                break;
        }
        return "";
    }
}