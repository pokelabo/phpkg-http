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
 * HTTP response.
 */
class Response {
    const JSON = 'json';
    const XML = 'xml';

    /**
     * HTTP status code, which will be sent to the client.
     * @var int
     */
    protected $_status_code = 200;

    /**
     * Output content, which will be sent to the client.
     */
    protected $_output;

    /**
     * Type of output content. 
     * @var string|null 
     */
    protected $_output_type;
    
    /**
     * Get the response status code.
     * @return int status_code
     */
    public function getStatusCode() {
        return $this->_status_code;
    }

    /**
     * Set the response status code.
     * @param int $status_code
     */
    public function setStatusCode($status_code) {
        $this->_status_code = $status_code;
    }

    /**
     * Get type of output content.
     * @return mixed
     */
    public function getOutputType() {
        return $this->_output_type;
    }

    /**
     * Get the response output content.
     * @return mixed
     */
    public function getOutput() {
        return $this->_output;
    }

    /**
     * Set the response output content.
     * @param mixed $data
     */
    public function setOutput($data) {
        $this->_output = $data;
    }

    /**
     * Set the Content-Type output content.
     * @param mixed $data
     */
    public function setContentTypeOutput($data) {
        if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], "xml")) {
            // XMLの処理
            $this->setXmlOutput($data);
        } else {
            // JSONの処理
            $this->setJsonOutput($data);
        }
    }
    
    /**
     * Set the response output content.
     * @param mixed $data
     */
    public function setJsonOutput($data) {
        $this->_output_type = self::JSON;
        $this->_output = $data;
    }
    
    /**
     * Set the response output content.
     * @param mixed $data
     */
    public function setXmlOutput($data) {
        $this->_output_type = self::XML;
        $this->_output = $data;
    }
}
