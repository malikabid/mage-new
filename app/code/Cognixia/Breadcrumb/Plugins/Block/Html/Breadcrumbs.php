<?php

namespace Cognixia\Breadcrumb\Plugins\Block\Html;

use Magento\Theme\Block\Html\Breadcrumbs as OrignialCrumbClass;

class Breadcrumbs
{

    public function aroundAddCrumb(OrignialCrumbClass $subject, callable $proceed, $crumbName, $crumbInfo)
    {
        $crumbInfo['label'] .= "(!a)";
        $proceed($crumbName, $crumbInfo);
    }


    public function beforeAddCrumb(OrignialCrumbClass $subject, $crumbName, $crumbInfo)
    {
        isset($crumbInfo['link'])?$crumbInfo['link'] .= "#" : "";
        return [$crumbName, $crumbInfo];
    }
}
