<?php

namespace UBOS\PuckPowermail\Xclass;

use In2code\Powermail\Domain\Model\Mail;
use In2code\Powermail\Domain\Service\Mail\ReceiverMailSenderPropertiesService as ReceiverMailSenderPropertiesServiceOrigin;
use In2code\Powermail\Domain\Repository\MailRepository;
use In2code\Powermail\Events\ReceiverMailSenderPropertiesGetSenderEmailEvent;
use In2code\Powermail\Events\ReceiverMailSenderPropertiesGetSenderNameEvent;
use In2code\Powermail\Utility\TypoScriptUtility;
use In2code\Powermail\Utility\ConfigurationUtility;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\Exception as ExceptionExtbaseObject;

/**
 * Class ReceiverMailSenderPropertiesService to get email array for sender attributes
 */
class ReceiverMailSenderPropertiesService extends ReceiverMailSenderPropertiesServiceOrigin
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @param Mail $mail
     * @param array $settings
     */
    public function __construct(Mail $mail, array $settings)
    {
        parent::__construct($mail, $settings);
        $this->eventDispatcher = GeneralUtility::makeInstance(EventDispatcherInterface::class);
    }

    /**
     * Get sender email from configuration in fields and params. If empty, take default from TypoScript
     *
     * @return string
     * @throws ExceptionExtbaseObject
     */
    public function getSenderEmail(): string
    {
        $senderEmail = ConfigurationUtility::getDefaultMailFromAddress();
        $senderEmail = TypoScriptUtility::overwriteValueFromTypoScript(
            $senderEmail,
            $this->configuration['receiver.']['default.'],
            'senderEmail'
        );
        /** @var ReceiverMailSenderPropertiesGetSenderEmailEvent $event */
        $event = $this->eventDispatcher->dispatch(
            GeneralUtility::makeInstance(ReceiverMailSenderPropertiesGetSenderEmailEvent::class, $senderEmail, $this)
        );
        return $event->getSenderEmail();
    }

    /**
     * Get sender name from configuration in fields and params. If empty, take default from TypoScript
     *
     * @return string
     * @throws ExceptionExtbaseObject
     */
    public function getSenderName(): string
    {
        if ($this->settings['receiver']['name'] !== '') {
            $senderName = $this->settings['receiver']['name'];
        } else {
            $senderName = ConfigurationUtility::getDefaultMailFromName();
            $senderName = TypoScriptUtility::overwriteValueFromTypoScript(
                $senderName,
                $this->configuration['receiver.']['default.'],
                'senderName'
            );
        }
        /** @var ReceiverMailSenderPropertiesGetSenderNameEvent $event */
        $event = $this->eventDispatcher->dispatch(
            GeneralUtility::makeInstance(ReceiverMailSenderPropertiesGetSenderNameEvent::class, $senderName, $this)
        );
        return $event->getSenderName();
    }
}
