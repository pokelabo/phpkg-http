<?php

namespace pokelabo\http;

class InputData {
    const FORM = 'application/x-www-form-urlencoded';
    
    /**
     * Input data, sent from client.
     * @var null|string
     */
    protected $_input_data;

    /**
     * Input stream.
     * @var null|resource
     */
    protected $_input_stream;

    /**
     * Parsed data.
     * @var null|mixed
     */
    protected $_parsed_data;

    /**
     * Parse input data.
     * @param int $method method to parse
     * @return mixed
     */
    public function parse($method = self::FORM) {
        if (isset($this->_parsed_data)) {
            return $this->_parsed_data;
        }

        if (!isset($this->_input_data)) {
            $stream = $this->getInputStream();
            if (isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] <= 4096) {
                $this->_input_data = @fread($stream, $_SERVER['CONTENT_LENGTH']);
            } else {
                $this->_input_data = '';
                while (!feof($stream)) {
                    $this->_input_data .= @fread($stream, 4096);
                }
            }
        }

        switch ($this->getContentType()) {
        case 'application/x-www-form-urlencoded':
            parse_str($this->_input_data, $this->_parsed_data);
            break;
        case 'application/json':
            $this->_parsed_data = json_decode($this->_input_data, true);
            break;
        default:
            $this->_parsed_data = $this->_input_data;
            break;
        }

        return $this->_parsed_data;
    }

    /**
     * Parse input data.
     * @param int $method method to parse
     * @return mixed
     */
    public function getInputStream() {
        if ($this->_input_stream === null) {
            $this->_input_stream = fopen('php://input', 'r');
        }
        return $this->_input_stream;
    }

    /**
     * Get content type of the input content.
     * @return string
     */
    protected function getContentType() {
        $headers = getallheaders();
        foreach ($headers as $field => $value) {
            $field = strtolower($field);
            if ($field !== 'content-type') continue;

            list($content_type) = explode(';', $value);
            return strtolower(trim($content_type));
        }

        return self::FORM;
    }
}
