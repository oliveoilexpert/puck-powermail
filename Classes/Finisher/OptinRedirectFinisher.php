<?php

declare(strict_types=1);
namespace UBOS\PuckPowermail\Finisher;

use In2code\Powermail\Domain\Service\RedirectUriService;
use In2code\Powermail\Finisher\AbstractFinisher;
use In2code\Powermail\Finisher\FinisherInterface;
use In2code\Powermail\Utility\FrontendUtility;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Http\ResponseFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class OptinRedirectFinisher
 */
class OptinRedirectFinisher extends AbstractFinisher implements FinisherInterface
{
    /**
     * @var array
     */
    protected array $arguments = [];

    /**
     * Redirect user after form submit with optin enabled before confirmation
     *
     * @return void
     * @throws PropagateResponseException
     */
    public function redirectToUriFinisher(): void
    {
        $uri = $this->contentObject->typoLink_URL(['parameter' => $this->settings['optinPage']['redirect']]);
        if (!empty($uri) && $this->settings['main']['optin'] && !$this->formSubmitted) {
            $responseFactory = GeneralUtility::makeInstance(ResponseFactory::class);
            $response = $responseFactory
                ->createResponse(303)
                ->withAddedHeader('location', $uri);
            throw new PropagateResponseException($response);
        }
    }
    /**
     * Initialize
     */
    public function initializeFinisher(): void
    {
        $this->arguments = FrontendUtility::getArguments();
    }
}
