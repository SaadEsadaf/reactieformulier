<?php

namespace News\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NewsCoreBundle extends Bundle
{
    /**
     * Sets FOSUserBundle as a parent of your NewsCoreBundle.
     *
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
