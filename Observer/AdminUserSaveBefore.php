<?php

namespace Mtools\TrustedEmail\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Mtools\TrustedEmail\Helper\Data as TrustedEmailHelper;

class AdminUserSaveBefore implements ObserverInterface
{
    /**
     * @var TrustedEmailHelper
     */
    protected $trustedEmailHelper;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * AdminUserSaveBefore constructor.
     *
     * @param TrustedEmailHelper $trustedEmailHelper
     * @param RequestInterface   $request
     */
    public function __construct(
        TrustedEmailHelper $trustedEmailHelper,
        RequestInterface $request
    ) {
        $this->trustedEmailHelper = $trustedEmailHelper;
        $this->request = $request;
    }

    /**
     * @param Observer $observer
     *
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        $postData = $this->request->getPostValue();

        $email = isset($postData['email']) ? $postData['email'] : '';

        if ($email) {
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
}
