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
namespace EssentialScript\Admin\Settings\Feature;
/**
 * Description of FileFeature
 *
 * @author docwho
 */
class Defer extends \EssentialScript\Admin\SettingsFeature {
	
	protected function doFeature( $feature, $state, $option ) {
		$this->feature = $feature;
		$this->state = $state;
		$this->option = $option;
		$ischecked = checked( $this->option['defer'], true, false );
		$this->feature .=<<<FEATURE
<ul><li><label for="defer">
	<input type="checkbox" 
		id="defer"
		name="essentialscript_options[filefeature][defer]" %s %s>Defer
	<span class="input-indicator">HTML5</span></label>
</li></ul>
FEATURE;
		$this->feature = sprintf($this->feature, $ischecked, $this->state );
	}
	
	
}
