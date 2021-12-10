<?php

namespace Dmgctrlr\LaraOsrm\Responses;

use Dmgctrlr\LaraOsrm\AbstractResponse; 

class NearestServiceResponse extends AbstractResponse
{
    public function getWaypoints()
    {
        return $this->responseData->waypoints;
    }
}
