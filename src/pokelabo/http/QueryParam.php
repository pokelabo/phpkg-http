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

use ArrayObject;

class QueryParam extends ArrayObject {
    public function get($key, $default_value = null) {
        if ($this->offsetExists($key)) {
            return $this->offsetGet($key);
        }

        return $default_value;
    }
}
