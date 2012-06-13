<?php

class RakutenRws_Api_Definition_MockRwsApi extends RakutenRws_Api_RwsApi
{
    protected
        $versionMap = array(
            '1989-01-08' => '3.0',
            '2012-01-08' => '3.0'
        );

    public function execute($param)
    {
        return new RakutenRws_ApiResponse_RwsResponse(
            'DummyRwsApiMock',
            new RakutenRws_HttpResponse(
                'http://example.com',
                array(),
                200,
                array(),
                json_encode(array(
                    'Body' => 'body',
                    'Header' => array(
                        'Status'    => 'Success',
                        'StatusMsg' => 'msg'
                    )
                ))
            )
        );
    }
}
