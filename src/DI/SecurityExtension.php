<?php

namespace Contributte\Security\DI;

use Contributte\Security\User;
use Nette\DI\CompilerExtension;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class SecurityExtension extends CompilerExtension
{

	/**
	 * Register services
	 *
	 * @return void
	 */
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('user'))
			->setClass(User::class);

		if ($builder->hasDefinition('security.user')) {
			$builder->removeDefinition('security.user');
			$builder->addAlias('security.user', $this->prefix('user'));
		}
	}

}
