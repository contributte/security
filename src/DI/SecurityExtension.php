<?php declare(strict_types = 1);

namespace Contributte\Security\DI;

use Contributte\Security\User;
use Nette\Bridges\SecurityTracy\UserPanel;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;

class SecurityExtension extends CompilerExtension
{

	/** @var mixed[] */
	private $defaults = [
		'debug' => false,
	];

	/**
	 * Register services
	 */
	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		$user = $builder->addDefinition($this->prefix('user'))
			->setFactory(User::class);

		if ($builder->hasDefinition('security.user')) {
			$builder->removeDefinition('security.user');
			$builder->addAlias('security.user', $this->prefix('user'));
		}

		if ($config['debug'] === true) {
			$user->addSetup('@Tracy\Bar::addPanel', [
				new Statement(UserPanel::class),
			]);
		}
	}

}
