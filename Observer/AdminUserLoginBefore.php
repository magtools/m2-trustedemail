<?php

namespace Mtools\TrustedEmail\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Mtools\TrustedEmail\Helper\Data as TrustedEmailHelper;

class AdminUserLoginBefore implements ObserverInterface
{
    /**
     * @var TrustedEmailHelper
     */
    protected $trustedEmailHelper;

    /**
     * AdminUserLoginBefore constructor.
     *
     * @param TrustedEmailHelper $trustedEmailHelper
     */
    public function __construct(TrustedEmailHelper $trustedEmailHelper)
    {
        $this->trustedEmailHelper = $trustedEmailHelper;
    }

    /**
     * @param Observer $observer
     *
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        $user = $observer->getEvent()->getUser();

        if ($user === null) {
            return;
        }

        $email = !empty($user->getEmail()) ? $user->getEmail() : '';
        $domain = substr(strrchr($email, "@"), 1);
        $allowedDomains = $this->trustedEmailHelper->getDomainList();

        if (empty($allowedDomains)) {
            return;
        }

        if (!in_array($domain, $allowedDomains)) {
            throw new LocalizedException(__('Something went wrong with reCAPTCHA.'));
        }
    }
}
