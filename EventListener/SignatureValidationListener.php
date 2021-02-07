<?php

namespace CedricZiel\CanvaBundle\EventListener;

use Canva\HttpHelper;
use Canva\Request as CanvaRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class SignatureValidationListener
{
    public const ATTRIBUTE_SIGNATURE_VALID = '_canva_signature_valid';

    private string $canvaSecret;

    public function __construct(string $canvaSecret)
    {
        $this->canvaSecret = $canvaSecret;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$request->headers->has(CanvaRequest::HEADER_TIMESTAMP)) {
            return;
        }

        $timestampHeader = $request->headers->get(CanvaRequest::HEADER_TIMESTAMP);
        if ($timestampHeader === null || !HttpHelper::verifyTimestamp($timestampHeader, time())) {
            $request->attributes->set(self::ATTRIBUTE_SIGNATURE_VALID, false);

            throw new HttpException(401, 'Timestamp skew is too large.');
        }

        $path = parse_url($request->getUri(), PHP_URL_PATH);
        $operation = '';
        switch (true) {
            case str_ends_with($path, '/configuration'):
                $operation = '/configuration';
                break;
            case str_ends_with($path, '/configuration/delete'):
                $operation = '/configuration/delete';
                break;
            case str_ends_with($path, '/publish/resources/find'):
                $operation = '/publish/resources/find';
                break;
            case str_ends_with($path, '/publish/resources/get'):
                $operation = '/publish/resources/get';
                break;
            case str_ends_with($path, '/publish/resources/upload'):
                $operation = '/publish/resources/upload';
                break;
            default:
                throw new HttpException(Response::HTTP_UNAUTHORIZED, 'Unknown operation');
        }

        $signature = HttpHelper::calculatePostSignature(
            $timestampHeader,
            $operation,
            $request->getContent(),
            $this->canvaSecret
        );

        $signatureHeader = $request->headers->get(CanvaRequest::HEADER_SIGNATURES);
        if ($signatureHeader === null || !in_array($signature, explode(',', $signatureHeader), true)) {
            $request->attributes->set(self::ATTRIBUTE_SIGNATURE_VALID, false);

            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'Signatures do not match');
        }

        $request->attributes->set(self::ATTRIBUTE_SIGNATURE_VALID, true);
    }
}
