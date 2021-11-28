<?php
/*
This file is part of SeAT

Copyright (C) 2015 to 2020  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace tehraven\Seat\CharacterLocationMap\Http\Controllers;

use Seat\Eveapi\Models\Character\CharacterInfo;
use Seat\Web\Http\Controllers\Controller;

/**
 * Class CharacterMapController.
 *
 * @package tehraven\Seat\CharacterLocationMap\Http\Controllers
 */
class CharacterMapController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function getMap()
    {
        $characterLocations = $this->getCharacterLocations();

        return view('characterlocationmap::map', compact('characterLocations'));
    }

    private function getCharacterLocations()
    {  
        $user = auth()->user();
        $characters = [];

        if ($user->can('character.location')) {
            $characters = $user->characters();
        } else {
            $characters = $user->characters;
        }
    }
}