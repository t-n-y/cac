<?php

namespace Cac\BarBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CacBarBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}