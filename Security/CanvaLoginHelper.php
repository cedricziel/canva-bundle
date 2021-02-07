<?php

namespace CedricZiel\CanvaBundle\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CanvaLoginHelper
{
    const SESSION_CANVA_USER = 'canva_user';
    const SESSION_CANVA_BRAND = 'canva_brand';
    const SESSION_CANVA_EXTENSIONS = 'canva_extensions';
    const SESSION_CANVA_STATE = 'canva_state';
    const SESSION_CANVA_TIME = 'canva_time';
    const SESSION_CANVA_SIGNATURES = 'canva_signatures';

    /**
     * Writes Canva.com related information to the session so it can be digested later.
     *
     * @param Request $request
     */
    public static function writeUserInfoToSession(Request $request): void
    {
        $request->getSession()->set(self::SESSION_CANVA_USER, $request->query->get('user'));
        $request->getSession()->set(self::SESSION_CANVA_BRAND, $request->query->get('brand'));
        $request->getSession()->set(self::SESSION_CANVA_EXTENSIONS, $request->query->get('extensions'));
        $request->getSession()->set(self::SESSION_CANVA_STATE, $request->query->get('state'));
        $request->getSession()->set(self::SESSION_CANVA_TIME, $request->query->get('time'));
        $request->getSession()->set(self::SESSION_CANVA_SIGNATURES, $request->query->get('signatures'));
    }

    public static function contextFromRequest(Request $request): array
    {
        if ($request->query->has('user') && $request->query->has('brand')) {
            return [
                'user' => $request->query->get('user'),
                'brand' => $request->query->get('brand'),
                'extensions' => $request->query->get('extensions'),
                'time' => $request->query->getInt('time'),
                'state' => $request->query->get('state'),
                'signatures' => $request->query->get('signatures'),
            ];
        }

        return [];
    }

    public static function sessionContainsCanvaUser(Request $request): bool
    {
        if (!$request->hasSession()) {
            return false;
        }

        return $request->getSession()->has(self::SESSION_CANVA_USER)
            && $request->getSession()->get(self::SESSION_CANVA_USER) !== null;
    }

    public static function createLoginRedirect(string $state): Response
    {
        $url = 'https://canva.com/apps/configured?success=true&state=%s';

        return new RedirectResponse(sprintf($url, $state));
    }
}
