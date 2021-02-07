<?php

namespace CedricZiel\CanvaBundle\Http;

use Canva\Request as CanvaRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

final class CanvaRequestArgumentResolver implements ArgumentValueResolverInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        $class = $argument->getType();
        if (!is_string($class)) {
            return false;
        }

        if (strlen($class) < 10) {
            return false;
        }

        $haystack = class_implements($class);
        return in_array(\Canva\Request::class, $haystack, true);
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $body = $request->getContent();

        $obj = $this->serializer->deserialize($body, $argument->getType(), 'json');
        $request->attributes->set($argument->getName(), $obj);
    }
}
