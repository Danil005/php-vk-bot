<?php

namespace VkBot\traits;

trait Chat
{
    /**
     * Получить список участников беседы.
     * @param int $chatId
     * @return mixed
     */
    public function getChatMembers(int $chatId = null)
    {
        return $this->parse($chatId, '_chatMembers');
    }

    /**
     * Получить список id-ов участников беседы.
     * @param int $chatId
     * @return mixed
     */
    public function getChatMembersIds(int $chatId = null)
    {
        return $this->parse($chatId, '_chatMembersIds');
    }

    /**
     * Получить список администраторов беседы.
     * @param int $chatId
     * @return mixed
     */
    public function getChatAdmins(int $chatId = null)
    {
        return $this->parse($chatId, '_chatAdmins');
    }

    /**
     * Получить список id-ов администраторов беседы.
     * @param int $chatId
     * @return mixed
     */
    public function getChatAdminsIds(int $chatId = null)
    {
        return $this->parse($chatId, '_chatAdminsIds');
    }

    private function parse(int $chatId, string $var)
    {
        $chatId = ( $chatId == null ) ? $this->_object['peer_id'] : $chatId;
        if( empty($this->$var[$chatId]) ) {
            $this->loadChatMembers($chatId);
        }

        return $this->$var[$chatId];
    }
}