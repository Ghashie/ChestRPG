<?php

namespace Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures;

use Symfony\Component\Routing\Attribute\Route;

/**
 * @Route("/here", name="lol", methods={"GET", "POST"}, schemes={"https"})
 */
class InvokableController
{
    public function __invoke()
    {
    }
}
