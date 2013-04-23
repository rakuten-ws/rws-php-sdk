<?php

class RakutenRws_Api_Definition_DummyAppRakutenApi4 extends RakutenRws_Api_AppRakutenApi
{
    protected
        $versionMap = array(
            '1989-01-08' => 'RakutenRws_Api_Definition_DummyRwsApi1'
        ),
        $isRequiredAccessToken = false;

    public function getService()
    {
        return 'DummyService';
    }

    public function getOperation()
    {
        return 'DummyOperation4';
    }
}
