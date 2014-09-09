<?php
/**
 * This file is part of the Kappa\Google package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Google\Accounts;

use Kappa\Google\Configurator;
use Kappa\Google\Authenticator;
use Nette\Object;

/**
 * Class ServiceAccount
 *
 * @package Kappa\Google\Accounts
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class ServiceAccount extends Object
{
	/** @var \Kappa\Google\Configurator */
	private $configurator;

	/** @var \Kappa\Google\Authenticator */
	private $authenticator;

	/** @var \Google_Client|null */
	private $client;

	/**
	 * @param Configurator $configurator
	 * @param Authenticator $authenticator
	 */
	public function __construct(Configurator $configurator, Authenticator $authenticator)
	{
		$this->configurator = $configurator;
		$this->authenticator = $authenticator;
	}

	public function getClient()
	{
		if (!$this->client instanceof \Google_Client) {
			$this->client = $this->createClient();
		}
		$client = $this->authenticator->authenticateServiceAccount($this->client);

		return $client;
	}

	/**
	 * @return Configurator
	 */
	public function getConfigurator()
	{
		return $this->configurator;
	}

	/**
	 * @return \Google_Client
	 */
	private function createClient()
	{
		$client = new \Google_Client();
		$client->setApplicationName($this->configurator->appName);

		return $client;
	}
} 