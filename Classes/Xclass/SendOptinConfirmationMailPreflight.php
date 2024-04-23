<?php

declare(strict_types=1);
namespace UBOS\PuckPowermail\Xclass;

use In2code\Powermail\Domain\Service\Mail\SendOptinConfirmationMailPreflight as SendOptinConfirmationMailPreflightOrigin;
use In2code\Powermail\Domain\Service\Mail\SenderMailPropertiesService;
use In2code\Powermail\Domain\Model\Mail;
use In2code\Powermail\Utility\FrontendUtility;
use In2code\Powermail\Utility\HashUtility;
use In2code\Powermail\Utility\ObjectUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;


/**
 * Class SendOptinConfirmationMailPreflight
 */
class SendOptinConfirmationMailPreflight extends SendOptinConfirmationMailPreflightOrigin
{
    /**
     * @param Mail $mail
     * @return void
     * @throws InvalidConfigurationTypeException
     */
    public function sendOptinConfirmationMail(Mail $mail): void
    {
        $senderService = GeneralUtility::makeInstance(SenderMailPropertiesService::class, $this->settings);
        $email = [
            'template' => 'Mail/OptinMail',
            'receiverEmail' => $this->mailRepository->getSenderMailFromArguments($mail),
            'receiverName' => $this->mailRepository->getSenderNameFromArguments(
                $mail,
                [$this->conf['sender.']['default.'], 'senderName']
            ),
            'senderEmail' => $senderService->getSenderEmail(),
            'senderName' => $senderService->getSenderName(),
            'replyToEmail' => $senderService->getSenderEmail(),
            'replyToName' => $senderService->getSenderName(),
            'subject' => $this->settings['optin']['subject'],
            'rteBody' => $this->settings['optin']['body'],
            'format' => $this->settings['sender']['mailformat'],
            'variables' => [
                'hash' => HashUtility::getHash($mail),
                'hashDisclaimer' => HashUtility::getHash($mail, 'disclaimer'),
                'mail' => $mail,
                'L' => FrontendUtility::getSysLanguageUid(),
            ],
        ];
        $this->sendMailService->sendMail($email, $mail, $this->settings, 'optin');
    }
}
