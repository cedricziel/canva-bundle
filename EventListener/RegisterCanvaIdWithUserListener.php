<?php

namespace CedricZiel\CanvaBundle\EventListener;

use App\Security\AppLoginFormAuthenticator;
use CedricZiel\CanvaBundle\Model\CanvaRecognized;
use CedricZiel\CanvaBundle\Security\CanvaLoginHelper;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class RegisterCanvaIdWithUserListener
{
    /**
     * @var TokenStorageInterface
     */
    private TokenStorageInterface $tokenStorage;

    /**
     * @var ObjectManager
     */
    private ObjectManager $manager;

    public function __construct(TokenStorageInterface $tokenStorage, ObjectManager $manager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->manager = $manager;
    }

    public function __invoke(RequestEvent $event)
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
        $this->manager->flush($user);

        $event->setResponse(CanvaLoginHelper::createLoginRedirect($contextFromRequest['state']));
    }
}
