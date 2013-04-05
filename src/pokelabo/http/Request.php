<?php
/*
 * This file is part of the Pokelabo PHP Library.
 *
 * (c) Pokelabo, INC. <support@pokelabo.co.jp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace pokelabo\http;

/**
 * HTTP requeset.
 */
class Request {
    /**
     * Array of query parameters sent by the client.
     * @var array
     */
    protected $_query_param_map;

    /**
     * Input data sent by the client.
     * @var mixed
     */
    protected $_input;

    /**
     * hash data sent by the client.
     * [user#123] -> 123
     * @var int
     */
    protected $_id;

    /**
     * Contructor.
     */
    public function __construct() {
        $this->_query_param_map = new QueryParam($_GET);
    }

    /**
     * Get the hash param.
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Set the hash param.
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * Get the query parameter array.
     * @return array
     */
    public function getQueryParam() {
        return $this->_query_param_map;
    }

    /**
     * Get the input content.
     * @return mixed
     */
    public function getInput() {
        if (!$this->_input) {
            $input_data = new InputData();
            $this->_input = $input_data->parse();
        }

        return $this->_input;
    }

    /**
     * Get the input stream.
     * @return mixed
     */
    public function getInputStream() {
        $input_data = new InputData();
        return $input_data->getInputStream();
    }
}
