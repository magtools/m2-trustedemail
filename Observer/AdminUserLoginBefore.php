<?php

namespace Mtools\TrustedEmail\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Mtools\TrustedEmail\Helper\Data as TrustedEmailHelper;

class AdminUserLoginBefore implements ObserverInterface
{
    protected $trustedEmailHelper;

    public function __construct(TrustedEmailHelper $trustedEmailHelper)
    {
        $this->trustedEmailHelper = $trustedEmailHelper;
    }

    public function execute(Observer $observer)
    {
        $user = $observer->getEvent()->getModel();
        $email = $user->getEmail();
        $domain = substr(strrchr($email, "@"), 1);
        $allowedDomains = $this->trustedEmailHelper->getDomainList();

        if (empty($allowedDomains)) {
            return;
        }

        if (!in_array($domain, $allowedDomains)) {
            throw new LocalizedException(__('The domain of your email address is not allowed for login.'));
        }
    }
}
