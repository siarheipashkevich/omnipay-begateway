<?php

namespace Omnipay\BeGateway\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class EripResponse
 *
 * @package Omnipay\BeGateway\Message
 */
class EripResponse extends AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        [$data, $isSuccessful] = [$this->data, false];

        if (isset($data['transaction'])) {
            $isSuccessful = isset($data['transaction']['status']) && $data['transaction']['status'] === 'pending';
        }

        return $isSuccessful;
    }

    /**
     * Gets a reference provided by the gateway to represent this transaction.
     *
     * @return string
     */
    public function getTransactionReference(): string
    {
        return $this->data['transaction']['uid'];
    }

    /**
     * Gets a response code from the payment gateway.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->data['transaction']['erip']['account_number'];
    }
}
