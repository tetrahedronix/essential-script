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
namespace EssentialScript\Frontend\Scripts;

/**
 * Interface for the concrete components and the abstract decoretor.
 *
 * @author docwho
 */
abstract class Component {

	/**
	 * Essential Script Version for upgrade purposes.
	 * 
	 * @since 0.8
	 */
	const ESSENTIALSCRIPT_VER = '0.7.1';

	/**
	 * @var string Name of the script. Should be unique.
	 */
	protected $handle;
	
	abstract public function enqueueScript();
	abstract public function getHandle();
}
