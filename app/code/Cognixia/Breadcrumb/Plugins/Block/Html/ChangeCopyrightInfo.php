<?php

namespace Cognixia\Breadcrumb\Plugins\Block\Html;

use Magento\Theme\Block\Html\Footer;

class ChangeCopyrightInfo
{

    public function afterGetCopyright(Footer $subject, $result)
    {
        return str_replace("Magento","Adobe Commerce", $result);
    }
}