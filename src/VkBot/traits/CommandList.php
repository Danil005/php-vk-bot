<?php

namespace VkBot\traits;

trait CommandList
{
    protected function cList()
    {
        return [
            [
                'text' => 'опа',
                'method' => '_opa'
            ],
        ];
    }

    protected function _opa()
    {
        $this->sendPhoto('170365985_456239031');
    }
}