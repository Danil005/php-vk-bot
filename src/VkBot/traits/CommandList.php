<?php

namespace VkBot\traits;

trait CommandList
{
    protected function cList()
    {
        return [
            [
                'text' => ['привет', 'дарова'],
                'method' => '_hello'
            ],
        ];
    }

    protected function _hello()
    {

    }
}