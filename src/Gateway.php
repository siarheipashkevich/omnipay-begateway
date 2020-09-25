<?php

namespace Omnipay\BeGateway;

use Omnipay\Common\AbstractGateway;
use Omnipay\BeGateway\Message\EripRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class Gateway
 *
 * @package Omnipay\BeGateway
 */
class Gateway extends AbstractGateway
{
    /**
     * Gets the name of the gateway.
     *
     * @return string
     */
    public function getName()
    {
        return 'BeGateway';
    }

    /**
     * Initialize this gateway with default parameters
     *
     * @param array $parameters
     * @return self
     */
    public function initialize(array $parameters = array())
    {
        // todo: настроить httpClient здесь с нужными параметрами чтобы не делать это внутри request
        // https://github.com/hiqdev/omnipay-yandex-kassa

        return parent::initialize($parameters);
    }

    /**
     * Sets the shop id.
     *
     * @param $value
     * @return self
     */
    public function setShopId($value)
    {
        return $this->setParameter('shop_id', $value);
    }

    /**
     * Gets the shop id.
     *
     * @return mixed
     */
    public function getShopId()
    {
        return $this->getParameter('shop_id');
    }

    /**
     * Sets the shop key.
     *
     * @param $value
     * @return self
     */
    public function setShopKey($value)
    {
        return $this->setParameter('shop_key', $value);
    }

    /**
     * Gets the shop key.
     *
     * @return mixed
     */
    public function getShopKey()
    {
        return $this->getParameter('shop_key');
    }

    /**
     * Gets the Erip request.
     *
     * @param array $params
     * @return RequestInterface
     */
    public function purchase(array $params = []): RequestInterface
    {
        // todo: передать доп. параметры для httpClient если они не буду здесь устанавливаться

        return $this->createRequest(EripRequest::class, $params);
    }
}
