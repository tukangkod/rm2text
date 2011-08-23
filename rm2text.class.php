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
 * @copyright     Copyright 2010-2011, tukangkod. (http://kode.fahmi.my)
 * @link          https://github.com/tukangkod/rm2text
 * @version       v0.2
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class rm2text {

	/**
	 *
	 * convert number amount into string
	 * @param float $amount
	 * @return string
	 *
	 */
    public function toRMText($amount) {
		if ($this->isFloat($amount)) {
    		// get the sen part
    		list($num, $float) = $this->doPB($amount);
    	}
    	// get the ringgit part
    	$buf = $this->doChange($this->doNum($this->doWord($num))) . ' ringgit';
    	$sen = trim($this->doChange($this->doNum($this->doWord($float))));
    	$buf .= ($sen)?' '.$sen.' sen':'';

		return $buf;
	}

	/**
	 *
	 * Detect if amount having float
	 * @param float $amount
	 * @return boolean
	 *
	 */
	private function isFloat($amount) {
		$pattern = '/[-+]?[0-9]*\.?[0-9]+/';
		return preg_match($pattern, $amount);
	}

	/**
	 *
	 * Split amount into number and decimal
	 * @param float $amount
	 * @return array
	 */
	private function doPB($amount) {
		return preg_split('/[.]+/', $amount);
	}

	/**
	 *
	 * Change subject into word and remove zero value
	 * @param integer $subject
	 * @return string
	 *
	 */
	private function doWord($subject) {
		$pattern = '/([0-9])([0-9])([0-9])([0-9])([0-9])([0-9])([0-9])/i';
		$replacement = '$1 juta $2 ratus $3 puluh $4 ribu $5 ratus $6 puluh $7';
		$string = preg_replace($pattern, $replacement, str_pad($subject, 7, '0', STR_PAD_LEFT));
		return preg_replace('/(0 (juta|ratus|ribu|puluh|belas)|0)/', '', $string);
	}

	/**
	 *
	 * Replace number into word
	 * @param string $subject
	 * @return string
	 *
	 */
	private function doNum($subject) {
        $number = array(1 => 'satu', 2 => 'dua', 3 => 'tiga', 4 => 'empat', 5 => 'lima', 6 => 'enam', 7 => 'tujuh', 8 => 'lapan', 9 => 'sembilan');
        return str_replace(array_keys($number), array_values($number), $subject);
	}

	/**
	 *
	 * Replace string into readable string
	 * @param string $subject
	 * @return string
	 *
	 */
	private function doChange($subject) {
		$word = array(
		    'satu ratus' => 'seratus',
		    'satu puluh' => 'sepuluh',
			'sepuluh satu' => 'sebelas',
		    'sepuluh dua' => 'dua belas',
		    'sepuluh tiga' => 'tiga belas',
		    'sepuluh empat' => 'empat belas',
		    'sepuluh lima' => 'lima belas',
		    'sepuluh enam' => 'enam belas',
		    'sepuluh tujuh' => 'tujuh belas',
		    'sepuluh lapan' => 'lapan belas',
		    'sepuluh sembilan' => 'sembilan belas',
		    'satu ribu' => 'seribu',
		);
		return str_replace(array_keys($word), array_values($word), $subject);
	}
}