<?php

namespace Cognixia\DisableRegistration\Plugin;

use Magento\Store\Model\ScopeInterface;
use Magento\Customer\Model\Registration;
use Magento\Framework\App\Config\ScopeConfigInterface;

class DisableRegistration
{
    const XML_PATH_DISABLE_CUSTOMER_REGISTRATION = 'customer/create_account/disable_customer_registration';

    protected $scopeConfig;

    /**
     *
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }


    public function afterIsAllowed(Registration $subject, $result)
    {
        if ($this->scopeConfig->isSetFlag(
            self::XML_PATH_DISABLE_CUSTOMER_REGISTRATION,
            $scopeType = ScopeInterface::SCOPE_STORE
        )) {
            return false;
        }

        return $result;
    }
}
