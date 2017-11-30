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
namespace EssentialScript\Frontend\Pages;

/**
 * Aggregated with the Strategy interface serves to separate a request from
 * a concrete strategy.
 *
 * @author docwho
 */
class Context {
	/**
	 * @var object keeps an instance of the concrete strategy.
	 */
	private $strategy;
	
	/**
	 * Setup class.
	 * 
	 * @param \EssentialScript\Frontend\Pages\Strategy $strategy
	 */
	public function __construct( Strategy $strategy ) {
		
		$this->strategy = $strategy;
	}
	
	/**
	 * Implements the Strategy method.
	 * 
	 * @param object $filter_obj Object reference to the filter.
	 */
	public function display( $filter_obj ) {
		
		$this->strategy->display( $filter_obj );
	}
}
