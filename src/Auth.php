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

namespace Kit\Auth;

use Kit\Auth\Uses\Login;
use Kit\Auth\Uses\Logout;
use Kit\Auth\Uses\Register;
use Kit\Auth\Uses\BlockAccount;
use Kit\Auth\Uses\ChangePassword;
use Kit\Auth\Uses\ActivateAccount;
use Kit\Auth\Contracts\AuthContract;

class Auth implements AuthContract
{
	
	use Login,
	Logout,
	Register,
	BlockAccount,
	ChangePassword,
	ActivateAccount;

	/**
	* @var 		$errors
	* @access 	protected
	* @static
	*/
	protected static $error = null;

	/**
	* @var 		$hasError
	* @access 	protected
	*/
	protected 	$hasError = false;

	/**
	* Returns a configuration using the provided key.
	*
	* @param 	$key <String>
	* @access 	public
	* @return 	Mixed
	*/
	public function getConfig($key=null)
	{
		$configFile = include 'config.php';
		return $configFile[$key] ?? null;
	}

	/**
	* Returns authentication errors.
	*
	* @access 	public
	* @static
	* @return 	String
	*/
	public static function getAuthError() : String
	{
		return Auth::$error;
	}

	/**
	* Sets error message.
	*
	* @param 	$message <String>
	* @access 	public
	*/
	public function setErrorMessage(String $message)
	{
		Auth::$error = $message;
		$this->setErrorStatus(false);
	}

	/**
	* Checks if an error has occured.
	*
	* @access 	public
	* @return 	Boolean
	*/
	public function hasError()
	{
		return $this->hasError;
	}

	/**
	* Sets the error statuc when an error occurs.
	*
	* @param 	$statuc <Boolean>
	* @access 	protected
	* @return 	void
	*/
	protected function setErrorStatus(Bool $status)
	{
		$this->hasError = true;
	}
}