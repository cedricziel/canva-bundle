<?php

namespace CedricZiel\CanvaBundle\Security;

use Canva\Configuration\Response\ErrorResponse;
use Canva\Error;
use CedricZiel\CanvaBundle\EventListener\SignatureValidationListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Serializer\SerializerInterface;

final class CanvaAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function supports(Request $request)
    {
        if (!$request->attributes->getBoolean(SignatureValidationListener::ATTRIBUTE_SIGNATURE_VALID)) {
            return false;
        }

        if ($request->getContentType() !== 'json') {
            return false;
        }

        $jsonDecode = json_decode($request->getContent(), true);

        return isset($jsonDecode['user']);
    }

    public function getCredentials(Request $request)
    {
        $jsonDecode = json_decode($request->getContent(), true);

        return $jsonDecode['user'];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (null === $credentials) {
            return null;
        }

        $user = $userProvider->loadUserByUsername($credentials);
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $errorResponse = new ErrorResponse(Error::CODE_CONFIGURATION_REQUIRED);

        // for some reason, canva want their 401 sugar-coated as 200
        return new JsonResponse(
            $this->serializer->serialize($errorResponse, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $errorResponse = new ErrorResponse(Error::CODE_CONFIGURATION_REQUIRED);

        // for some reason, canva want their 401 sugar-coated as 200
        return new JsonResponse(
            $this->serializer->serialize($errorResponse, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
