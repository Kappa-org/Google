<?php
/**
 * This file is part of the Kappa\Google package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Google;

/**
 * Interface ITokenStorage
 * @package Kappa\Google
 */
interface ITokenStorage
{
	/**
	 * Get last access token for service account
	 *
	 * @param string $email
	 * @return string
	 */
	public function getAccessToken($email);

	/**
	 * Set new access token after token expire
	 *
	 * @param string $email
	 * @param string $token
	 */
	public function setAccessToken($email, $token);
} 