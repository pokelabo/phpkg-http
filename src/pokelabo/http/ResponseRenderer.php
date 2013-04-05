<?php

namespace pokelabo\http;

class ResponseRenderer {
    public function render($response) {
        header('HTTP/1.1 ' . $response->getStatusCode());

        switch ($response->getOutputType()) {
        case Response::JSON:
            header('Content-Type: application/json; encoding=UTF-8');
            if (defined('JSON_UNESCAPED_UNICODE')) {
                echo json_encode($response->getOutput(), JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode($response->getOutput());
            }
            return;
        case Response::XML:
            // 返却データを生成します。
            $dom = new \DOMDocument('1.0');
            $dom->encoding = "UTF-8";
            // DOMを再帰的に呼び出す無名関数を作成する。
            $proc = function($dom, $dom_obj, $array_obj, $proc) {
                foreach ($array_obj as $key => $value) {
                    // 使用できる文字を英数字と"_"のみとする。ただし、冒頭が数字の場合は置き換え対象とする。
                    $key_name = preg_replace('/[^(a-zA-Z0-9_)]+|^[0-9]/', '_', $key);
                    if (is_array($value)) {
                        // arrayの場合は再起処理を行う。
                        $proc($dom, $dom_obj->appendChild($dom->createElement($key_name)), $value, $proc);
                    } else {
                        // array以外の場合はそのまま出力する。
                        $child = $dom_obj->appendChild($dom->createElement($key_name));
                        $child->appendChild($dom->createTextNode($value));
                        // これを使わなければならない局面がある場合は解放する事。
//                        $child->appendChild($dom->createCDATASection($value));
                    }
                }
            };
            // 再帰的に呼び出してXMLを生成する。
            $proc($dom, $dom->appendChild($dom->createElement('root')), $response->getOutput(), $proc);
            echo $dom->saveXML();
            return;
        default:
            echo $response->getOutput;
            return;
        }
    }
}
