<?php namespace BehatEditorServices;


class BehatEndPointsTest extends BaseTests {

    public static $baseUrl = 'http://b2.vbox.local/behat_editor_services_v2/sites';

    public function testEndPointGetSitesAll()
    {
        $request_url = static::$baseUrl;
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSite()
    {
        $request_url = static::$baseUrl . '/123';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesTests()
    {
        $request_url = static::$baseUrl . '/123/tests';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesTest()
    {
        $request_url = static::$baseUrl . '/123/tests/324';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesTestReportsAll()
    {
        $request_url = static::$baseUrl . '/123/tests/324/reports';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesTestReportsOne()
    {
        $request_url = static::$baseUrl . '/123/tests/324/reports/444';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }


    public function testEndPointGetSitesReportsAll()
    {
        $request_url = static::$baseUrl . '/123/reports';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesReportOne()
    {
        $request_url = static::$baseUrl . '/123/reports/324';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesReportsTagsXZY()
    {
        $request_url = static::$baseUrl . '/123/reports/324/tags/123';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }


    public function testEndPointGetSitesReportsUrlsXZY()
    {
        $request_url = static::$baseUrl . '/123/reports/324/urls/123';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesBatches()
    {
        $request_url = static::$baseUrl . '/123/batches';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesBatchesOne()
    {
        $request_url = static::$baseUrl . '/123/batches/234';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }


    public function testEndPointGetSitesTagsAll()
    {
        $request_url = static::$baseUrl . '/123/tags';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesTokensAll()
    {
        $request_url = static::$baseUrl . '/123/tokens';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesTestsTokens()
    {
        $request_url = static::$baseUrl . '/123/tests/234/tokens';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointGetSitesTestsTokensOne()
    {
        $request_url = static::$baseUrl . '/123/tests/234/tokens/444';
        $http_code   = $this->curl($request_url);
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointPostSitesTests()
    {
        $request_url    = static::$baseUrl . '/123/tests';
        $http_code      = $this->curl($request_url, 'POST');
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointPostSitesTestsReports()
    {
        $request_url    = static::$baseUrl . '/123/tests/345/reports';
        $http_code      = $this->curl($request_url, 'POST');
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointPostSitesBatches()
    {
        $request_url    = static::$baseUrl . '/123/batches';
        $http_code      = $this->curl($request_url, 'POST');
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointPostSitesTestsTokens()
    {
        $request_url    = static::$baseUrl . '/123/tests/345/tokens';
        $http_code      = $this->curl($request_url, 'POST');
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointPutSitesTests()
    {
        $request_url    = static::$baseUrl . '/123/tests/345';
        $http_code      = $this->curl($request_url, 'PUT');
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointPutSitesTestsReports()
    {
        $request_url    = static::$baseUrl . '/123/tests/345/reports/444';
        $http_code      = $this->curl($request_url, 'PUT');
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointPutBatches()
    {
        $request_url    = static::$baseUrl . '/123/batches/345';
        $http_code      = $this->curl($request_url, 'PUT');
        $this->assertEquals('200', $http_code);
    }

    public function testEndPointPutSitesTestsTokens()
    {
        $request_url    = static::$baseUrl . '/123/tests/345/tokens/444';
        $http_code      = $this->curl($request_url, 'PUT');
        $this->assertEquals('200', $http_code);
    }

    public function curl($request_url, $method = null)
    {
        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        if ($method != null) {
            if($method == 'POST') {
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, array());
            }
            if($method == 'PUT') {
                curl_setopt($curl, CURLOPT_PUT, 1);
                curl_setopt($curl, CURLOPT_PUT, array());
            }
        }
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, FALSE);
        curl_setopt($curl, CURLOPT_FAILONERROR, FALSE);
        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        return $http_code;
    }
}