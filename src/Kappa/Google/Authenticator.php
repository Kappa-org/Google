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

use Nette\Object;

/**
 * Class Authenticator
 *
 * @package Kappa\Google\Security
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class Authenticator extends Object
{
	/** @var \Kappa\Google\Configurator */
	private $configurator;

	/** @var \Kappa\Google\ITokenStorage */
	private $tokenStorage;

	/**
	 * @param Configurator $configurator
	 * @param ITokenStorage $tokenStorage
	 */
	public function __construct(Configurator $configurator, ITokenStorage $tokenStorage)
	{
		$this->configurator = $configurator;
		$this->tokenStorage = $tokenStorage;
	}

	/**
	 * @param \Google_Client $client
	 * @return \Google_Client
	 */
	public function authenticateServiceAccount(\Google_Client $client)
	{
		$token = $this->tokenStorage->getAccessToken($this->configurator->email);
		if ($token === null || json_decode($token) === null) {
			$token = $this->createServiceAccountToken($client);
			$this->tokenStorage->setAccessToken($this->configurator->email, $token);
		}
		$client->setAccessToken($token);
		if ($client->isAccessTokenExpired()) {
			$client->setAccessToken($this->createServiceAccountToken($client));
			$this->tokenStorage->setAccessToken($this->configurator->email, $client->getAccessToken());
		}

		return $client;
	}

	/**
	 * @param \Google_Client $client
	 * @return string
	 */
	private function createServiceAccountToken(\Google_Client $client)
	{
		$credentials = new \Google_Auth_AssertionCredentials(
			$this->configurator->email,
			$this->configurator->scopes,
			file_get_contents($this->configurator->key)
		);
		$client->setAssertionCredentials($credentials);
		if($client->getAuth()->isAccessTokenExpired()) {
			$client->getAuth()->refreshTokenWithAssertion($credentials);
		}

		return $client->getAccessToken();
	}
}