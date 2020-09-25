<?php

namespace Omnipay\BeGateway\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class EripRequest
 *
 * @package Omnipay\BeGateway\Message
 */
class EripRequest extends AbstractRequest
{
    /**
     * BePaid base url for requests.
     *
     * @var string
     */
    protected $apiBaseUrl = 'https://api.bepaid.by';

    /**
     * Gets the amount.
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->getParameter('amount');
    }

    /**
     * Sets the order id.
     *
     * @param int $value
     * @return AbstractRequest
     */
    public function setOrderId(int $value): AbstractRequest
    {
        return $this->setParameter('order_id', $value);
    }

    /**
     * Gets the order id.
     *
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->getParameter('order_id');
    }

    /**
     * Sets the tracking id.
     *
     * @param int $value
     * @return AbstractRequest
     */
    public function setTrackingId($value)
    {
        return $this->setParameter('tracking_id', $value);
    }

    /**
     * Gets the tracking id.
     *
     * @return int
     */
    public function getTrackingId()
    {
        return $this->getParameter('tracking_id');
    }

    /**
     * Sets the language of the payment.
     *
     * @param string $value
     * @return AbstractRequest
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * Gets the language of the payment.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * Sets the email of the payment.
     *
     * @param string $value
     * @return AbstractRequest
     */
    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    /**
     * Gets the email of the payment.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getParameter('email');
    }

    /**
     * Sets the request notify URL.
     *
     * @param string $value
     * @return AbstractRequest
     */
    public function setNotifyUrl($value)
    {
        return $this->setParameter('notify_url', $value);
    }

    /**
     * Gets the request notify URL.
     *
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }

    /**
     * Sets the erip account number.
     *
     * @param string $value
     * @return AbstractRequest
     */
    public function setEripAccountNumber($value)
    {
        return $this->setParameter('erip_account_number', $value);
    }

    /**
     * Gets the erip account number.
     *
     * @return string
     */
    public function getEripAccountNumber()
    {
        return $this->getParameter('erip_account_number');
    }

    /**
     * Sets the erip service no.
     *
     * @param string $value
     * @return AbstractRequest
     */
    public function setEripServiceNo($value)
    {
        return $this->setParameter('erip_service_no', $value);
    }

    /**
     * Gets the erip service no.
     *
     * @return string
     */
    public function getEripServiceNo()
    {
        return $this->getParameter('erip_service_no');
    }

    /**
     * Sets the erip service info.
     *
     * @param array $value
     * @return AbstractRequest
     */
    public function setEripServiceInfo(array $value)
    {
        return $this->setParameter('erip_service_info', $value);
    }

    /**
     * Gets the erip service info.
     *
     * @return array
     */
    public function getEripServiceInfo(): array
    {
        return $this->getParameter('erip_service_info');
    }

    /**
     * Sets the erip instructions.
     *
     * @param array $value
     * @return AbstractRequest
     */
    public function setEripInstructions(array $value)
    {
        return $this->setParameter('erip_instructions', $value);
    }

    /**
     * Gets the erip instructions.
     *
     * @return array
     */
    public function getEripInstructions()
    {
        return $this->getParameter('erip_instructions');
    }

    /**
     * Gets the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return [
            'request' => [
                'amount' => $this->getAmount(),
                'currency' => $this->getCurrency(),
                'description' => $this->getDescription(),
                'order_id' => $this->getOrderId(),
                'tracking_id' => $this->getTrackingId(),
                'notification_url' => $this->getNotifyUrl(),
                'ip' => '127.0.0.1',
                'email' => $this->getEmail(),
                'payment_method' => [
                    'type' => 'erip',
                    'account_number' => $this->getEripAccountNumber(),
                    'service_no' => $this->getEripServiceNo(),
                    'service_info' => $this->getEripServiceInfo(),
                    'instruction' => $this->getEripInstructions(),
                ],
            ],
        ];
    }

    /**
     * Gets the endpoint.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return sprintf('%s/%s', $this->apiBaseUrl, 'beyag/payments');
    }

    /**
     * Gets the headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Sends the request with specified data.
     *
     * @param mixed $data
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        // todo: eщё надо установить
        // 'timeout' => 30,
        // 'auth' => [
        //     $params['shop_id'],
        //     $params['shop_key'],
        //  ],

        $response = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            $this->getHeaders(),
            [
                // https://github.com/thephpleague/omnipay-sagepay/blob/master/src/Message/AbstractRequest.php#L208
                'json' => $data,
            ]
        );

        $response = json_decode($response->getBody(), true);

        return $this->response = new EripResponse($this, $response);
    }
}
