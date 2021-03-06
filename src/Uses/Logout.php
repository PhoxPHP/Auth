<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Auth\Uses\Logout
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

trait Logout
{

	/**
	* Logs a user out.
	*
	* @access 	public
	* @return 	<Mixed>
	*/
	public function logout()
	{
		session_destroy();
		session_unset();

		// in case sessoion_destory does not work, this will invalidate the sessions.
		$_SESSION = [];

		setcookie(
			// cookie name
			'remember',
			// cookie value
			null,
			// cookie alive time
			time() - 3600,
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

}