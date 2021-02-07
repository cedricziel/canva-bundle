<?php

namespace CedricZiel\CanvaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class ConfigurationController extends AbstractController
{
    public function add(Request $request)
    {
        throw new NotAcceptableHttpException();
    }

    public function delete(Request $request)
    {
        throw new NotAcceptableHttpException();
    }
}
