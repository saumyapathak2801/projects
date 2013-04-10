<?php
/*
	Id3v1 - Class for manipulating Id3v1 tags
	Copyright (C) 2007  Karol Babioch

	This program is free software; you can
	redistribute it  and/or modify it under the terms
	of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of
	the License, or (at your option) any later version.

	This program is distributed in the hope that it
	will be useful, but WITHOUT ANY WARRANTY; without
	even the implied warranty of MERCHANTABILITY or
	ITNESS FOR A PARTICULAR PURPOSE. See the GNU
	General Public License for more details.

	You should have received a copy of the GNU
	General Public License along with this program;
	if not, write to the Free Software Foundation,
	Inc., 51 Franklin St, Fifth Floor, Boston,
	MA 02110, USA
*/

/**
 * @package Id3v1
 */

/**
 * Enabling full error reporting
 */
error_reporting(E_STRICT|E_ALL);

/**
 * Requiring Id3v1 class
 */
require_once 'class.Id3v1.php';

/**
 * Initialising Id3v1 object
 */
$id3v1 = new Id3v1('test.mp3');
/**
 * Retrieving Id3 tag "title".
 */
echo $id3v1->setTitle('Test title');
/**
 * Works the same
 */
echo $id3v1->title = 'Test title';
/**
 * Finally you have to save the changes
 */
$id3v1->save();

/**
 * The class also offers a fluent interface
 */
$id3v1
    ->setTitle('Test title')
    ->setArtist('Test artist')
    ->setYear(2007)
    ->save();

/**
 * I hove this help files could give you a view in the quick and easy
 * api behind this class. All other information you can get out of the
 * api documentation or by contacting me.
 */