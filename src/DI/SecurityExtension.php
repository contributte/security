<?php declare(strict_types = 1);

namespace Contributte\Security\DI;

use Contributte\Security\User;
use Nette\Bridges\SecurityTracy\UserPanel;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class SecurityExtension extends CompilerExtension
{


	private $defaults = [
		'debugger' => true,
	];

	/** @var bool */
	private $debugMode;

	public function __construct(bool $debugMode)
	{
		$this->debugMode = $debugMode;
	}

	/**
	 * Register services
	 *
	 * @return void
	 */
	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		$user = $builder->addDefinition($this->prefix('user'))
			->setClass(User::class);

		if ($builder->hasDefinition('security.user')) {
			$builder->removeDefinition('security.user');
			$builder->addAlias('security.user', $this->prefix('user'));
		}

		if ($this->debugMode && $config['debugger']) {
			$user->addSetup('@Tracy\Bar::addPanel', [
				new Statement(UserPanel::class),
			]);
		}
	}

}
