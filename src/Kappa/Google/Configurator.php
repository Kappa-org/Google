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
 * Class Configurator
 *
 * @package Kappa\Google
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class Configurator extends Object
{
	/** @var string */
	public $appName;

	/** @var string */
	public $clientId;

	/** @var string */
	public $email;

	/** @var string */
	public $key;

	/** @var array */
	public $scopes;

	/**
	 * @param string $appName
	 * @param string $clientId
	 * @param string $email
	 * @param string $key
	 * @param array $scopes
	 */
	public function __construct($appName, $clientId, $email, $key, array $scopes)
	{
		$this->appName = $appName;
		$this->clientId = $clientId;
		$this->email = $email;
		$this->key = $key;
		$this->scopes = $scopes;
	}
} 