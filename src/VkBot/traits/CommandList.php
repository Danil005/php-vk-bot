<?php

namespace VkBot\traits;

trait CommandList
{
    protected function hello()
    {
        $this->sendMessage('Hello!');
    }


}