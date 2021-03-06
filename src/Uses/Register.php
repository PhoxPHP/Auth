<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Auth\Uses\Register
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

use Kit\Auth\Auth;
use Kit\Prop\Hashing;
use Kit\Auth\Model\User;

trait Register
{

	/**
	* Registers a new user.
	*
	* @param 	$email <String>
	* @param 	$password <String>
	* @param 	$fields <Array>
	* @return 	<Mixed>
	*/
	public function register($email, $password, Array $fields=[])
	{
		$autoLogin = $this->getConfig('auto_login');
		$user = new User($this);
		$exists = User::findByEmail($email);

		if ($exists) {
			$this->setErrorMessage(
				$this->getMessage('auth.register.user_exists')
			);
			return false;
		}

		if ($this->getConfig('auto_activate') == true) {
			$user->is_activated = 1;
		}

		$user->confirmation_code = uniqid();
		$user->email = $email;
		$user->password = Hashing::make($password);

		if (count(array_keys($fields)) > 0) {
			foreach($fields as $key => $value) {
				$user->$key = $value;
			}
		}

		$user->save();

		if ($autoLogin == false) {
			return true;
		}

		return $this->login(
			$email,
			$password
		);
	}

}