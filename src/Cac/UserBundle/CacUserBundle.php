<?php

namespace Cac\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CacUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}