<?php

namespace Tests;

use AmoPRO\AmoCRM\Auth\Auth;
use AmoPRO\AmoCRM\Auth\Client as AmoClientData;
use AmoPRO\AmoCRM\Client;
use League\OAuth2\Client\Token\AccessToken;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Dotenv\Dotenv;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    const ENV_PATH = __DIR__ . '/../.env';

    protected static $AMO_DOMAIN;
    protected static $ACCESS_TOKEN;
    protected static $REFRESH_TOKEN;
    protected static $AUTHORIZATION_CODE;

    /**
     * @var \AmoPRO\AmoCRM\Client
     */
    protected $client;
    /**
     * @var \AmoPRO\AmoCRM\Auth\Client $amoClientData
     */
    protected $amoClientData;

    protected function setUp(): void
    {
        (new Dotenv())->load(self::ENV_PATH);
        self::$AMO_DOMAIN = $_ENV['AMO_DOMAIN'] ?? null;
        self::$ACCESS_TOKEN = $_ENV['ACCESS_TOKEN'] ?? null;
        self::$REFRESH_TOKEN = $_ENV['REFRESH_TOKEN'] ?? null;
        self::$AUTHORIZATION_CODE = $_ENV['AUTHORIZATION_CODE'] ?? null;

        $CLIENT_ID = $_ENV['CLIENT_ID'] ?? '';
        $CLIENT_SECRET = $_ENV['CLIENT_SECRET'] ?? '';
        $REDIRECT_URL = $_ENV['REDIRECT_URL'] ?? '';

        $this->amoClientData = new AmoClientData($CLIENT_ID, $CLIENT_SECRET, $REDIRECT_URL);

        if (self::$AMO_DOMAIN && (self::$ACCESS_TOKEN || self::$REFRESH_TOKEN || self::$AUTHORIZATION_CODE)) {
            $this->client = new Client($this->_getAuth(), $this->_getLogger());
        } else {
            $this->client = new FakeClient(new Auth('test', $this->amoClientData), new FakeLogger());
        }
    }

    protected function _getAuth()
    {
        $auth = (new Auth(self::$AMO_DOMAIN, $this->amoClientData));

        if (self::$ACCESS_TOKEN || self::$REFRESH_TOKEN) {
            $auth->setAccessToken(new AccessToken([
                'access_token'  => self::$ACCESS_TOKEN ?? 'empty',
                'refresh_token' => self::$REFRESH_TOKEN
            ]));
        }

        if (self::$AUTHORIZATION_CODE) {
            $auth->setAuthorizationCode(self::$AUTHORIZATION_CODE);
        }

        $auth->tokenUpdated(function (AccessToken $token) {
            $env = explode(PHP_EOL, file_get_contents(self::ENV_PATH));
            foreach ($env as $i => $line) {
                if (preg_match('/ACCESS_TOKEN=/i', $line)) {
                    $env[$i] = 'ACCESS_TOKEN=' . $token->getToken();
                }
                if (preg_match('/REFRESH_TOKEN=/', $line)) {
                    $env[$i] = 'REFRESH_TOKEN=' . $token->getRefreshToken();
                }
                // clean AUTHORIZATION_CODE
                if (preg_match('/AUTHORIZATION_CODE=/', $line)) {
                    $env[$i] = 'AUTHORIZATION_CODE=';
                }
            }

            file_put_contents(self::ENV_PATH, implode(PHP_EOL, $env));
        });

        return $auth;
    }

    protected function _getLogger()
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(__DIR__ . '/../test.log', Logger::DEBUG));

        return $log;
    }
}