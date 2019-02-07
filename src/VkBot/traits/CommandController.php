<?php

namespace VkBot\traits;

trait CommandController
{
    public function commandExecute()
    {
        if (method_exists($this, 'cList')) {
            $list = $this->cList();


            foreach ($list as $cmd) {
                if (!is_array($cmd['text'])) {
                    if ($this->formatText($cmd['text'])) {
                        $this->manyMethodsExecute($cmd['method']);
                        break;
                    }
                } else {
                    foreach ($cmd['text'] as $_text) {
                        if( $this->formatText($_text) ) {
                            $this->manyMethodsExecute($cmd['method']);
                            break;
                        }
                    }
                }
            }
        }
    }

    /**
     * Выполнить несколько методов.
     * @param $methods
     */
    private function manyMethodsExecute($methods) {
        if( is_array($methods) ) {
            foreach ($methods as $method) {
                $this->$method();
            }
        } else {
            $this->$methods();
        }
    }

    private function formatText(String $text) {
        if( substr($text, 0, 1) == '|' ) {
            $pr = ( $this->_config['similar_percent'] != null ) ? $this->_config['similar_percent'] : 75;
            return $this->similarTo($text) > $pr / 100;
        }
        if( substr($text, 0, 2) == "[|" ) {
            return $this->startAs($text);
        }
        if( substr($text, -2, 2) == "|]" ) {
            return $this->endAs($text);
        }
        if( substr($text, 0, 1) == "{" && substr($text, -1, 1) == "}") {
            return $this->contains($text);
        }
        return $text == $this->_text;
    }

}