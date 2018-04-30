<?php declare(strict_types = 1);

/**
 * Test: DI\SecurityExtension
 */

use Contributte\Security\DI\SecurityExtension;
use Contributte\Security\User;
use Nette\Bridges\HttpDI\HttpExtension;
use Nette\Bridges\HttpDI\SessionExtension;
use Nette\Bridges\SecurityDI\SecurityExtension as NSecurityExtension;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

test(function (): void {
	$loader = new ContainerLoader(TEMP_DIR, true);
	$class = $loader->load(function (Compiler $compiler) {
		$compiler->addExtension('security', new NSecurityExtension());
		$compiler->addExtension('http', new HttpExtension());
		$compiler->addExtension('session', new SessionExtension());
		$compiler->addExtension('secured', new SecurityExtension(false));
	}, 1);

	/** @var Container $container */
	$container = new $class();

	Assert::same($container->getByType(User::class), $container->getService('security.user'));
	Assert::true($container->hasService('secured.user'));
	Assert::true($container->hasService('security.user'));
});
