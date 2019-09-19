<?php

namespace NextcloudApiWrapper;

use GuzzleHttp\Psr7\Response;

class NextcloudResponse
{
    /**
     * @var Response
     */
    protected $guzzle;

    /**
     * @var array
     */
    protected $body;

    public function __construct(Response $guzzle)
    {
        $this->guzzle   = $guzzle;

        try {
            $this->body = json_decode($guzzle->getBody()->getContents(), true)['ocs'];
        } catch (\Exception $e) {
            throw new NCException($guzzle, "Failed parsing response");
        }
    }

    /**
     * Returns nextcloud status message
     * @return string|null
     */
    public function getStatus() {

        return $this->body['meta']['status'] ?? null;
    }

    /**
     * Returns nextcloud message
     * @return string|null
     */
    public function getMessage() {

        return $this->body['meta']['message'] ?? null;
    }

    /**
     * Returns nextcloud status code
     * @return int|null
     */
    public function getStatusCode() {

        return $this->body['meta']['statuscode'] ?? null;
    }

    /**
     * Returns nextcloud response data if any
     * @return array|null
     */
    public function getData() {

        return $this->body['data'] ?? null;
    }

    /**
     * Returns the raw guzzle response
     * @return Response
     */
    public function getRawResponse() {

        return $this->guzzle;
    }
}
