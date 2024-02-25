<?php

namespace App\Controller;

use App\Api\BlockchainApi;
use App\Service\BlockchainCalculator;
use Slim\Http\Request;
use Slim\Http\Response;

class BlockchainController extends AbstractController
{
    private BlockchainApi $api;
    private BlockchainCalculator $calculator;

    public function __construct(Request $request, Response $response, array $routeParams = [])
    {
        $this->api        = new BlockchainApi();
        $this->calculator = new BlockchainCalculator();
        parent::__construct($request, $response, $routeParams);
    }

    public function rates()
    {
        $this->calculator->setData($this->api->getData());
        $currency = (string)$this->request->getParam('currency');

        return $this->successResponse(
            $this->calculator->rates($currency)
        );
    }

    /**
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function convert()
    {
        $this->calculator->setData($this->api->getData());
        $currencyFrom = (string)$this->request->getParam('from');
        $currencyTo   = (string)$this->request->getParam('to');
        $value        = (float)$this->request->getParam('value');

        return $this->successResponse(
            $this->calculator->convert($currencyFrom, $currencyTo, $value)
        );
    }

    /**
     * @return void
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function setCalculatorByRequest()
    {
        $this->calculator = new BlockchainCalculator($this->api->getData());
    }
}