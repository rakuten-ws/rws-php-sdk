<?php

class RakutenRws_Api_Definition_DummyAppRakutenApi3 extends RakutenRws_Api_AppRakutenApi
{
    protected
        $versionMap = array(
            '19890108' => '19890108'
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
