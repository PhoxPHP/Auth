<?php
/**
* @author 	Peter Taiwo
* @version 	1.0.0
*
* MIT License
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

namespace Kit\Auth\Model;

use Kit\Auth\Auth;
use Kit\Glider\Model\Model;

class User extends Model
{

	/**
	* @access 	public
	* @return 	void
	*/
	public function __construct()
	{
		$table = $this->repository()->getConfig('auth_users_table');
		$connection = $this->repository()->getConfig('connection_id');

		$this->table = $table;
		$this->connectionId = $connection;
	}

	/**
	* {@inheritDoc}
	*/
	public function accessibleProperties() : Array
	{
		return [
			'id',
			'email',
			'is_activated',
			'is_blocked'
		];
	}

	/**
	* {@inheritDoc}
	*/
	public function primaryKey() : String
	{
		return 'id';
	}

	/**
	* Returns instance of model.
	*
	* @param 	$repository <Kit\Auth\Auth>
	* @access 	public
	* @static
	* @return 	Object
	*/
	protected function repository()
	{
		return new Auth();
	}

}