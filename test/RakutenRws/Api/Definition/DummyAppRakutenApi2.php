<?php

namespace RakutenRws\Api\Definition;

use RakutenRws\Api\AppRakutenApi;

class DummyAppRakutenApi2 extends AppRakutenApi
{
    protected
        $versionMap = array(
            '1989-01-08' => '19890108'
        ),
        $isRequiredAccessToken = false;

    public function getService()
    {
        return 'DummyService';
    }

    public function getOperation()
    {
        return 'DummyOperation2';
    }
}
