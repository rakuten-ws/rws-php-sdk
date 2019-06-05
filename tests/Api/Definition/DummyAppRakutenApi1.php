<?php

namespace Rakuten\WebService\Api\Definition;

use Rakuten\WebService\Api\AppRakutenApi;

class DummyAppRakutenApi1 extends AppRakutenApi
{
    protected
        $versionMap = array(
            '1989-01-08' => '19890108',
            '2012-01-08' => '20120108'
        ),
        $autoSetIterator = true;

    public function getService()
    {
        return 'DummyService';
    }

    public function getOperation()
    {
        return 'DummyOperation1';
    }
}
