<?php
/**
* @author 	Peter Taiwo
* @version 	1.0.4
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

namespace Kit\Auth\Uses;

use Kit\Auth\Model\User;

trait BlockAccount
{

	/**
	* Blocks a user account. To unblock an account, @see Kit\Auth\Uses\ActivateAccount.
	* @param 	$criteria <String>|<Integer> Accepts a string or integer. If a string is provided,
	*			then it must be the user's email but if a integer is provided, it must be the user's
	*			id.
	* @access 	public
	* @return 	Boolean
	*/
	public function blockAccount($criteria=null)
	{
		if ($criteria == null) {
			$this->setErrorMessage('Unable to block this account.');
			return false;
		}

		if (gettype($criteria) == 'string') {		
			$user = User::findByEmail($criteria);
		}else if(is_int($criteria)) {
			$user = User::findById($criteria);
		}else{
			return false;
		}

		if (!$user) {
			$this->setErrorMessage('User does not exist.');
			return false;
		}

		$user->is_blocked = 1;
		$user->save();

		return $user;
	}

	/**
	* Unblocks a user account.
	* @param 	$criteria <String>|<Integer> Accepts a string or integer. If a string is provided,
	*			then it must be the user's email but if a integer is provided, it must be the user's
	*			id.
	* @access 	public
	* @return 	Boolean
	*/
	public function unblockAccount($criteria=null)
	{
		if ($criteria == null) {
			$this->setErrorMessage('Unable to unblock this account.');
			return false;
		}

		if (gettype($criteria) == 'string') {		
			$user = User::findByEmail($criteria);
		}else if(is_int($criteria)) {
			$user = User::findById($criteria);
		}else{
			return false;
		}

		if (!$user) {
			$this->setErrorMessage('User does not exist.');
			return false;
		}

		$user->is_blocked = 0;
		$user->save();

		return $user;
	}

}