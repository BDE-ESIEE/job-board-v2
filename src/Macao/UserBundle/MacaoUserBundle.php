<?php

namespace Macao\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MacaoUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
