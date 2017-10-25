<?php

/*
 * Copyright (C) 2017 docwho
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace EssentialScript\Admin\Settings;

/**
 * Declares the factory method. It defines a default implementation of the
 * factory method too.
 *
 * @author docwho
 */
abstract class Creator {
	
	/**
	 * The factory method as defined by GoF.
	 */
	protected abstract function factoryMethod( Setting $setting );

	/**
	 * Default implementation of the factory method.
	 * 
	 * @param object $settingNow The item reference
	 * @return object The new concrete setting.
	 */
	public function doFactory( $settingNow ) {
		
		$itemSetting = $settingNow;
		return $this->factoryMethod( $itemSetting );
	}
}
