<?php declare(strict_types = 1);

namespace PHPStan\Rules\PhpDoc;

use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<RequireExtendsDefinitionTraitRule>
 */
class RequireExtendsDefinitionTraitRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		$reflectionProvider = $this->createReflectionProvider();

		return new RequireExtendsDefinitionTraitRule(
			$reflectionProvider,
			new RequireExtendsCheck(
				new ClassCaseSensitivityCheck($reflectionProvider, true),
				true,
			),
		);
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/incompatible-require-extends.php'], [
			[
				'PHPDoc tag @phpstan-require-extends cannot contain final class IncompatibleRequireExtends\SomeFinalClass.',
				126,
			],
			[
				'PHPDoc tag @phpstan-require-extends contains non-object type *NEVER*.',
				140,
			],
			[
				'PHPDoc tag @phpstan-require-extends can only be used once.',
				171,
			],
		]);
	}

}
