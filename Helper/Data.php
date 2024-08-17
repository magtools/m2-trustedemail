<?php

namespace Mtools\TrustedEmail\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\State;

class Data extends AbstractHelper
{
    const XML_PATH_DOMAIN_LIST = 'mtools/trusted_email/domain_list';

    /**
     * @var State
     */
    protected $appState;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param State $appState
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        State $appState
    ) {
        parent::__construct($context);
        $this->appState = $appState;
    }

    /**
     * Get the list of trusted domains
     *
     * @return array
     */
    public function getDomainList()
    {
        if ($this->appState->getMode() === State::MODE_DEVELOPER) {
            return [];
        }

        $domains = $this->scopeConfig->getValue(
            self::XML_PATH_DOMAIN_LIST,
            ScopeInterface::SCOPE_STORE
        );

        $domains = !empty($domains) ? $domains : '';

        return !empty($domains) ? array_map('trim', explode(',', $domains)) : [];
    }
}
