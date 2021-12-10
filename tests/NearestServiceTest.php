<?php

namespace Dmgctrlr\LaraOsrm\Tests;

use PHPUnit\Framework\TestCase;
use Dmgctrlr\LaraOsrm\NearestServiceRequest;
use Dmgctrlr\LaraOsrm\Models\LatLng; 

class NearestServiceTest extends TestCase
{
    /**
     * In order to be able to test against the demo server, we need to
     * wait a bit between requests. We don't need to finish our test fasts
     * but we do need them to be reliable.
     *
     * @return void
     */
    private function delayBetweenSending()
    {
        sleep(5);
    }

    private function getOsrmConfig()
    {
        return [
            'host' => env('OSRM_HOST', 'tripr.project-osrm.org'),
            'port' => env('OSRM_PORT', '80'),
        ];
    }
    /**
     * Check we can make a request, and get an Ok back.
     */
    public function testCanRequestNearest()
    {
        $request = new NearestServiceRequest($this->getOsrmConfig());
        $request->setCoordinates([
            new LatLng(52.537307, 13.428395)]);
        $this->delayBetweenSending();
        $response = $request->send();
        $this->assertEquals('Ok', $response->getStatus());
        $this->assertEquals(1,count($response->getWaypoints()));
    }
 

    /**
     * Check we can make a request, and get an Ok back.
     */
    public function testUrlGeneration()
    {
        $request = new NearestServiceRequest($this->getOsrmConfig());
        $request->setCoordinates([
            new LatLng(51.618060, -0.239197)]);

        $this->assertEquals(
            'router.project-osrm.org:80/nearest/v1/driving/-0.239197,51.61806?number=1',
            $request->getUrl()
        );     

        $request->addOption(['number' => 2]);
        $this->assertEquals(
            'router.project-osrm.org:80/nearest/v1/driving/-0.239197,51.61806?number=2',
            $request->getUrl(),
            'adjust number of waypoints nearest'
        ); 

    }
}
