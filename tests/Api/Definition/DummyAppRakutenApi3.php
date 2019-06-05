<?php

namespace Rakuten\WebService\Api\Definition;

use Rakuten\WebService\Api\AppRakutenApi;

class DummyAppRakutenApi3 extends AppRakutenApi
{
    protected
        $versionMap = array(
            '1989-01-08' => '19890108'
        );

    public function getService()
    {
        return 'DummyService';
    }

    public function getOperation()
    {
        return 'DummyOperation3';
    }

    public function getMethod()
    {
        return 'POST';
    }
}
