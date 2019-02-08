<?php

namespace VkBot;

use VK\CallbackApi\Server\VKCallbackApiServerHandler;
use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiMessagesChatBotFeatureException;
use VK\Exceptions\Api\VKApiMessagesChatUserNoAccessException;
use VK\Exceptions\Api\VKApiMessagesDenySendException;
use VK\Exceptions\Api\VKApiMessagesForwardAmountExceededException;
use VK\Exceptions\Api\VKApiMessagesForwardException;
use VK\Exceptions\Api\VKApiMessagesKeyboardInvalidException;
use VK\Exceptions\Api\VKApiMessagesPrivacyException;
use VK\Exceptions\Api\VKApiMessagesTooLongMessageException;
use VK\Exceptions\Api\VKApiMessagesUserBlockedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;
use VkBot\traits\Chat;
use VkBot\traits\ChatEventsList;
use VkBot\traits\CommandController;
use VkBot\traits\CommandList;
use VkBot\traits\Media;
use VkBot\traits\Utils;

class Core extends VKCallbackApiServerHandler
{
    use Utils;
    use Media;
    use Chat;
    use ChatEventsList;
    use CommandController;
    use CommandList;

    protected $_config;
    protected $_vk;
    protected $_fromUser;
    protected $_actionUser;
    protected $_object;
    protected $_text;
    protected $_attachments;


    protected $_chatMembers;
    protected $_chatMembersIds;
    protected $_chatAdmins;
    protected $_chatAdminsIds;

    /**
     * Core constructor.
     * @param VKApiClient $vk
     * @param array $config
     */
    public function __construct(VKApiClient $vk, array $config)
    {
        $this->_config = $config;
        $this->_vk = $vk;
    }

    /**
     * Подтверждение группы.
     * @param int $group_id
     * @param null|string $secret
     */
    function confirmation(int $group_id, ?string $secret): void
    {
        if ($secret == $this->_config['secret_key'] && $group_id == $this->_config['group_id']) {
            echo $this->_config['confirm_string'];
        }
    }


    /**
     * Обработчик сообщений.
     * @param int $group_id
     * @param null|string $secret
     * @param array $object
     * @throws VKApiException
     * @throws VKClientException
     */
    public function messageNew(int $group_id, ?string $secret, array $object): void
    {

        $this->_fromUser = $this->_vk->users()->get($this->_config['access_token'], [
            'user_ids' => $object['from_id'],
        ])[0];

        if (isset($object['action'])) {
            $this->handleAction($object);
        }
        $text = mb_strtolower(trim($object['text']));
        $this->_text = $text;
        if (method_exists($this, $text) && strpos($text, '_') === false) {
            $this->$text();
        } else {
            $this->commandExecute();
        }
        $this->end();
    }

    /**
     * Выполнить действия беседы.
     * @param $object
     */
    protected function handleAction($object): void
    {
        switch ($object['action']->type) {
            case "chat_invite_user":
                $this->inviteUser();
                $this->end();
                break;
            case "chat_invite_user_by_link":
                $this->inviteUserByLink();
                $this->end();
                break;
            case "chat_kick_user":
                $this->kickUser();
                $this->end();
                break;
            case "chat_photo_update":
                $this->updatePhoto();
                $this->end();
                break;
            case "chat_photo_remove":
                $this->removePhoto();
                $this->end();
                break;
            case "chat_pin_message":
                $this->pinMessage();
                $this->end();
                break;
            case "chat_unpin_message":
                $this->unpinMessage();
                $this->end();
                break;
        }
    }


    /**
     * Получить массив пользователя, который сделали какой-то действие.
     * @return mixed
     * @throws VKApiException
     * @throws VKClientException
     */
    public function getUserAction(): array
    {
        $user = $this->_vk->users()->get($this->_config['access_token'], [
            'user_ids' => $this->_object['action']->member_id,
        ])[0];
        return $user;
    }

    public function parse($event): void
    {
        try {
            if (isset($event->object)) {
                $this->_object = (array)$event->object;
            }
            if ($event->type === 'message_edit') {
                $this->messageNew($event->group_id, $event->secret, $this->_object);
                return;
            }
            parent::parse($event);
        } catch (\Throwable $t) {
            $this->end();
        }
    }

    /**
     * Отправить сообщение пользователю.
     * @param int $peerId
     * @param $message
     * @throws VKApiException
     * @throws VKApiMessagesChatBotFeatureException
     * @throws VKApiMessagesChatUserNoAccessException
     * @throws VKApiMessagesDenySendException
     * @throws VKApiMessagesForwardAmountExceededException
     * @throws VKApiMessagesForwardException
     * @throws VKApiMessagesKeyboardInvalidException
     * @throws VKApiMessagesPrivacyException
     * @throws VKApiMessagesTooLongMessageException
     * @throws VKApiMessagesUserBlockedException
     * @throws VKClientException
     */
    public function sendMessage($message, int $peerId = null): void
    {
        $message = (is_array($message)) ? $message[rand(0, count($message) - 1)] : $message;
        $config = [
            'peer_id' => ($peerId == null) ? $this->_object['peer_id'] : $peerId,
            'message' => $message,
        ];

        if ($this->_attachments != null) {
            $config['attachment'] = (is_array($this->_attachments))
                ? implode(',', $this->_attachments) : $this->_attachments;
        }
        $this->_vk->messages()->send($this->_config['access_token'], $config);
    }

    /**
     * Добавить вложения.
     * @param $attachment
     * @return mixed
     */
    public function attachments($attachment)
    {
        return $this->_attachments = $attachment;
    }

    public function end()
    {
        echo 'ok';
        exit();
    }
}