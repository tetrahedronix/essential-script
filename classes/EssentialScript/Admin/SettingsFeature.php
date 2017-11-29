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

namespace EssentialScript\Admin;

/**
 * Provides the concrete template method and the feature to implement in
 * form of abstract method.
 *
 * @author docwho
 */
abstract class SettingsFeature {
	/**
	 * @var string String as passed by Wordpress filter hook.
	 */
	protected $feature;
	/**
	 * @var string Additional param for checkbox state: enabled/disabled.
	 */
	protected $state;
	/**
	 * @var array Array with boolean values to mark the input.
	 */
	protected $option;
	
	/**
	 * Concrete template method.
	 * 
	 * @param string $infeature
	 * @param string $state
	 * @param array $option
	 * @return object Object reference for using with the filter hook.
	 */
	public function templateMethod( $infeature, $state, $option ) {

		$this->feature = $infeature;
		$this->state = $state;
		$this->option = $option;
		$this->doFeature( $this->feature, $this->state, $this->option );
		
		return $this->feature;
	}
	
	abstract protected function doFeature( $feature, $state, $option );
}
