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
class ActiveRecord extends CActiveRecord {
	
	private $_globalSearch;
	
	public function setAttributes($values, $safeOnly = true) {
		if (!is_array($values))
			return;
		$attributes = array_flip($safeOnly ? $this->getSafeAttributeNames() : $this->attributeNames());
		
		foreach ($values as $name => $value) {
			if (isset($attributes[$name])) {
				$column = $this -> getTableSchema() -> getColumn($name);// new
				if (stripos($column -> dbType, 'decimal') !== false || stripos($column -> dbType, 'double') !== false
					 || stripos($column -> dbType, 'float') !== false) {// new
					
					$value = Yii::app()->format->unformatNumber($value);// new
					
				}
				$this->$name = $value;
			} else if ($safeOnly)
				$this->onUnsafeAttribute($name, $value);
		}
		
	}
	
	public function getGlobalSearch() {
		return $this->_globalSearch;
	}
	
	public function setGlobalSearch($q) {
		return $this->_globalSearch = $q;
	}

}
