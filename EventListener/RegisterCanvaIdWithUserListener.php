<?php

namespace CedricZiel\CanvaBundle\EventListener;

use App\Entity\Security\User;
use App\Security\AppLoginFormAuthenticator;
use App\Security\CanvaLoginHelper;
use CedricZiel\CanvaBundle\Model\CanvaRecognized;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

final class RegisterCanvaIdWithUserListener
{
    /**
     * @var TokenStorage
     */
    private TokenStorage $tokenStorage;

    /**
     * @var ObjectManager
     */
    private ObjectManager $manager;

    public function __construct(TokenStorage $tokenStorage, ObjectManager $manager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->manager = $manager;
    }

    public function __invoke(ResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        // only act on the login route.
        if (AppLoginFormAuthenticator::LOGIN_ROUTE !== $request->attributes->get('_route')) {
            return;
        }

        // skip if no user
        if (null === $this->tokenStorage->getToken()) {
            return;
        }

        $contextFromRequest = CanvaLoginHelper::contextFromRequest($request);

        // only act if there are actual canva query parameters
        if ($contextFromRequest === []) {
            return;
        }

        /** @var CanvaRecognized $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $user->setCanvaId($contextFromRequest['user']);

        $this->manager->persist($user);

        $event->setResponse(CanvaLoginHelper::createLoginRedirect($contextFromRequest['state']));
    }
}
