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
 * Overrides the factory method to return an instance of a concrete fieldset.
 *
 * @author docwho
 */
class FieldCreator extends \EssentialScript\Admin\Settings\Creator {
	
	/**
	 * Concrete factory method.
	 * 
	 * @param \EssentialScript\Admin\Settings\Setting $field The field instance.
	 * @return mixed 
	 */
	protected function factoryMethod( Setting $field ) {

		return ( $field->provideItem() );
	}
}
