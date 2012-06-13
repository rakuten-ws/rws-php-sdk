<?php

class RakutenRws_Api_Definition_DummyAppRakutenApi1 extends RakutenRws_Api_AppRakutenApi
{
    protected
        $versionMap = array(
            '19890108' => '19890108',
            '20120108' => '20120108'
        );

    public function getService()
    {
        return 'DummyService';
    }

    public function getOperation()
    {
        return 'DummyOperation1';
    }
}
