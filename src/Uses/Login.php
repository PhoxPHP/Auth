<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Auth\Uses\Login
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

use Kit\Prop\Hashing;
use Kit\Auth\Model\User;

trait Login
{

	/**
	* Logs a user in.
	*
	* @param 	$email <String>
	* @param 	$password <String>
	* @param 	$remember <Boolean>
	* @access 	public
	* @return 	<Mixed>
	*/
	public function login(String $email, String $password, Bool $remember=false)
	{
		$activationCheckEnabled = $this->getConfig('activation_check');
		$user = User::findByEmail($email);

		if (!$user) {
			$this->setErrorMessage(
				$this->getMessage('auth.login.user_not_found')
			);
			return false;
		}

		if (!Hashing::match($password, $user->password)) {
			$this->setErrorMessage(
				$this->getMessage('auth.login.incorrect_password')
			);
			return false;
		}

		if ($user->is_blocked == 1) {
			$this->setErrorMessage(
				$this->getMessage('auth.login.blocked')
			);
			return false;
		}

		if ($activationCheckEnabled && $user->is_activated == 0) {
			$this->setErrorMessage(
				$this->getMessage('auth.login.not_activated')
			);
			return false;
		}

		$sessionToken = Hashing::make(
			$email . '_' . $user->id,
			5
		);

		$user->id = $user->id;
		$user->session_token = $sessionToken;
		$user->save();

		$sessionName = $this->getConfig('auth_login_session_name');

		if (session_status() == 0) {
			session_start();
		}

		$_SESSION[$sessionName] = $sessionToken;
		$_SESSION['SID'] = $user->id;

		// If $remember is set to true, set remember me cookie.
		if ($remember == true) {
			setcookie(
				// cookie name
				'remember',
				// cookie value
				$sessionToken,
				// cookie alive time
				$this->getConfig('cookie_alive_time'),
				// cookie server path
				$this->getConfig('cookie_path'),
				// cookie domain path
				$this->getConfig('cookie_domain'),
				// cookie connection security
				$this->getConfig('cookie_secure_connection'),
				// cookie http only
				$this->getConfig('cookie_http_only')
			);
		}

		$loginRedirect = $this->getConfig('auth_login_url');
		$canAutoRedirect = $this->getConfig('auto_redirect');

		if (!$canAutoRedirect) {
			return true;
		}

		header("Location: $loginRedirect");
	}

	/**
	* Checks if user is logged in.
	*
	* @access 	public
	* @return 	<Boolean>
	*/
	public function isLoggedIn() : Bool
	{
		$sessionName = $this->getConfig('auth_login_session_name');
		if (session_status() == 0) {
			session_start();
		}

		if (!isset($_SESSION[$sessionName])) {
			return false;
		}

		$user = User::findBySession_Token($_SESSION[$sessionName]);
		if (!$user) {
			$this->logout();
			return false;
		}

		return true;
	}

}