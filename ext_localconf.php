<?php

use In2code\Powermail\Domain\Service\Mail\ReceiverMailSenderPropertiesService as ReceiverMailSenderPropertiesServiceOrigin;
use In2code\Powermail\Domain\Service\Mail\SendOptinConfirmationMailPreflight as SendOptinConfirmationMailPreflightOrigin;
use UBOS\PuckPowermail\Xclass\ReceiverMailSenderPropertiesService;
use UBOS\PuckPowermail\Xclass\SendOptinConfirmationMailPreflight;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][ReceiverMailSenderPropertiesServiceOrigin::class] = [
    'className' => ReceiverMailSenderPropertiesService::class,
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][SendOptinConfirmationMailPreflightOrigin::class] = [
    'className' => SendOptinConfirmationMailPreflight::class,
];