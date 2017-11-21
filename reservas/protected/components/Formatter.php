<?php /**
    This file is part of Sistema de Reservas.
    Copyright (C) 2017  Tarlis Tortelli Portela <tarlis@tarlis.com.br>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/?>
<?php 
class Formatter extends CFormatter
{
    /**
     * @var array the format used to format a number with PHP number_format() function.
     * Three elements may be specified: "decimals", "decimalSeparator" and 
     * "thousandSeparator". They correspond to the number of digits after 
     * the decimal point, the character displayed as the decimal point,
     * and the thousands separator character.
     * new: override default value: 2 decimals, a comma (,) before the decimals 
     * and no separator between groups of thousands
    */
    public $numberFormat=array('decimals'=>2, 'decimalSeparator'=>',', 'thousandSeparator'=>'');
 
    /**
     * Formats the value as a number using PHP number_format() function.
     * new: if the given $value is null/empty, return null/empty string
     * @param mixed $value the value to be formatted
     * @return string the formatted result
     * @see numberFormat
     */
    public function number($value) {
        if($value === null) return null;    // new
        if($value === '') return '';        // new
        //return number_format($value, $this->numberFormat['decimals'], $this->numberFormat['decimalSeparator'], $this->numberFormat['thousandSeparator']);
        return str_replace('.',$this->numberFormat['decimalSeparator'], Yii::app()->getNumberFormatter()->format("0.00",$value));
    }

	/*
	 * new function unformatNumber():
	 * turns the given formatted number (string) into a float
	 * @param string $formatted_number A formatted number
	 * (usually formatted with the formatNumber() function)
	 * @return float the 'unformatted' number
	 */
	public function unformatNumber($formatted_number) {
		if ($formatted_number === null)
			return null;
		if ($formatted_number === '')
			return '';
		if (is_double($formatted_number) || is_float($formatted_number))
			return $formatted_number;
		// only 'unformat' if parameter is not float already

		$value = str_replace($this -> numberFormat['thousandSeparator'], '', $formatted_number);
		$value = str_replace($this -> numberFormat['decimalSeparator'], '.', $value);
		return (double)$value;
	}
	
	public function currency($value) {
		return $this->formatNumber($value);
	}
	
	public function decimal($value, $decimals) {
		if ($value === null)
			return null;
		// new
		if ($value === '')
			return '';
		// new
		return number_format($value, $decimals, $this -> numberFormat['decimalSeparator'], $this -> numberFormat['thousandSeparator']);
	}
	
	public function date_ymd($value) {
		// return Yii::app()->dateFormatter->format(Yii::app()->locale->dateFormat,strtotime($value));
		return Yii::app()->dateFormatter->format("yyyy-MM-dd",strtotime($value));
	}
	
	public function date_dmy($value) {
		// return Yii::app()->dateFormatter->format(Yii::app()->locale->dateFormat,strtotime($value));
		return Yii::app()->dateFormatter->format("yyyy-MM-dd",strtotime($value));
	}
	
	public function datetime($value) {
		// return Yii::app()->dateFormatter->format(Yii::app()->locale->dateFormat,strtotime($value));
		return Yii::app()->dateFormatter->format("yyyy-MM-dd HH:mm:ss",strtotime($value));
	}
	
	public function unformatDate($value) {
		return date('Y-m-d', CDateTimeParser::parse($value, Yii::app()->locale->dateFormat));
	}
	
	public function month($value) {
		return Yii::app()->dateFormatter->format('MM',strtotime($value));
	}
}