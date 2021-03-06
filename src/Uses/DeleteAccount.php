<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Auth\Uses\DeleteAccount
* @license 		MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

namespace Kit\Auth\Uses;

use Kit\Auth\Model\User;

trait DeleteAccount
{

	/**
	* Deletes a user account using user id or email.
	*
	* @param 	$criteria <String>|<Integer>
	* @access 	public
	* @return 	<Mixed>
	*/
	public function deleteAccount($criteria=null)
	{
		if ($criteria == null) {
			$this->setErrorMessage(
				$this->getMessage('auth.delete.empty_criteria')
			);
			return false;
		}

		if (gettype($criteria) == 'string') {
			$user = User::findByEmail($criteria);
		}else if(is_int($criteria)) {
			$user = User::findById($criteria);
		}else{
			return false;
		}

		$user->delete();

		return true;
	}

}