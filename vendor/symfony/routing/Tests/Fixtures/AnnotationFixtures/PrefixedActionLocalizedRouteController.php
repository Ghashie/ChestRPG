<?php

namespace Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures;

use Symfony\Component\Routing\Attribute\Route;

/**
 * @Route("/prefix")
 */
class PrefixedActionLocalizedRouteController
{
    /**
     * @Route(path={"en": "/path", "nl": "/pad"}, name="action")
     */
    public function action()
    {
    }
}
