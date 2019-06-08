<?php declare(strict_types = 1);

namespace Contributte\Security\DI;

use Contributte\Security\User;
use Nette\Bridges\SecurityTracy\UserPanel;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\Statement;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use stdClass;

/**
 * @property-read stdClass $config
 */
class SecurityExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'debug' => Expect::bool(false),
		]);
	}

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->config;

		$user = $builder->addDefinition($this->prefix('user'))
			->setFactory(User::class);

		if ($builder->hasDefinition('security.user')) {
			$builder->removeDefinition('security.user');
			$builder->addAlias('security.user', $this->prefix('user'));
		}

		if ($config->debug === true) {
			$user->addSetup('@Tracy\Bar::addPanel', [
				new Statement(UserPanel::class),
			]);
		}
	}

}
