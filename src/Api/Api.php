<?php


namespace Booni3\Linnworks\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Api
{
    protected $applicationId;
    protected $applicationSecret;
    protected $token;

    protected $bearer;
    protected $server;

    public function __construct($applicationId, $applicationSecret, $token, $bearer = null, $server = null)
    {
        $this->applicationId = $applicationId;
        $this->applicationSecret = $applicationSecret;
        $this->token = $token;
        $this->bearer = $bearer;
        $this->server = $server;
    }

    /**
     * {@inheritdoc}
     */
    public function _get($url = null, array $parameters = [])
    {
        return $this->execute('get', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _post($url = null, array $parameters = [])
    {
        return $this->execute('post', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function execute($httpMethod, $url, array $parameters = [])
    {
        try {
            $response = $this->getClient()->{$httpMethod}($url, [
                'form_params' => $parameters,
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => $this->bearer
                ]
            ]);
            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $e) {
            throw $e;
        }
    }

    /**
     * Returns an Http client instance.
     *
     * @return Client
     */
    protected function getClient()
    {
        $server = $this->server ??'https://api.linnworks.net';
        return new Client([
            'base_uri' => $server . '/api/', 'handler' => $this->createHandler()
        ]);
    }

    /**
     * Create the client handler.
     *
     * @return \GuzzleHttp\HandlerStack
     */
    protected function createHandler()
    {
        return null;
    }

}