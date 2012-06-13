<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

/**
 * ApiResponse
 *
 * @package RakutenRws
 */
abstract class RakutenRws_ApiResponse implements
    IteratorAggregate,
    ArrayAccess
{
    protected
        $httpResponse = null,
        $operation    = null,
        $isOk         = true,
        $code         = null,
        $message      = "",
        $data         = null,
        $iterator     = null;

    /**
     * Constructor
     *
     * @param string $operation The operation
     * @param RakutenRws_HttpResponse $response
     */
    public function __construct($operation, RakutenRws_HttpResponse $response)
    {
        $this->operation = $operation;
        $this->httpResponse  = $response;

        $this->handleResponse();
    }

    abstract protected function handleResponse();

    /**
     * Returns if request is successful.
     *
     * @return boolean
     */
    public function isOk() {
        return $this->isOk;
    }

    /**
     * Gets the operation
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Gets the HttpResponse
     *
     * @return RakutenRws_HttpResponse
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * Gets the status code
     *
     * @return int
     */
    public function getCode()
    {
        if ($this->code === null) {
            return $this->httpResponse->getCode();
        }

        return $this->code;
    }

    /**
     * Sets iterator
     *
     * @param array|Iterator
     * @throws BadMethodCallException
     */
    public function setIterator($data)
    {
        if (is_array($data)) {
            $this->iterator = new ArrayIterator($data);

            return;
        } else if ($data instanceof Iterator) {
            $this->iterator = $data;

            return;
        }

        throw new BadMethodCallException();
    }

    /**
     * Check response has the iterator
     *
     * @return boolean
     */
    public function hasIterator()
    {
        return null !== $this->iterator;
    }

    /**
     * Gets the iterator
     *
     * @return Iterator
     */
    public function getIterator()
    {
        return $this->iterator;
    }


    /**
     * Gets response data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Gets the response message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new LogicException("Cannot set data");
    }

    public function offsetUnset($offset)
    {
        throw new LogicException("Cannot unset data");
    }
}
