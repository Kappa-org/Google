<?php
/**
 * This file is part of the Booking package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Google\DI;

use Kappa\Google\InvalidArgumentException;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Nette\Utils\Validators;

/**
 * Class GoogleExtension
 *
 * @package Kappa\Google\DI
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class GoogleExtension extends CompilerExtension
{
	/** @var array */
	private $defaultConfig = [
		'appName' => null,
		'clientId' => null,
		'email' => null,
		'key' => null,
		'scopes' => ['profile', 'email']
	];

	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaultConfig);
		$builder = $this->getContainerBuilder();

		Validators::assert($config['appName'], 'string', 'application name');
		Validators::assert($config['clientId'], 'string', 'client id');
		Validators::assert($config['email'], 'string', 'email');
		if (!file_exists($config['key']) || !is_readable($config['key'])) {
			throw new InvalidArgumentException("Key file '{$config['key']}' has not been found or readable");
		}

		$configurator = new Statement('Kappa\Google\Configurator', [
			$config['appName'],
			$config['clientId'],
			$config['email'],
			$config['key'],
			$config['scopes']
		]);

		$builder->addDefinition($this->prefix('authenticator'))
			->setClass('Kappa\Google\Authenticator')
			->setArguments([
				$configurator
			]);

		$builder->addDefinition($this->prefix('serviceAccount'))
			->setClass('Kappa\Google\Accounts\ServiceAccount')
			->setArguments([
				$configurator
			]);
	}
}