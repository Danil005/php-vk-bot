<?php

namespace VkBot\traits;

trait Media
{
    /**
     * Отправить фотографии или фотографию.
     * @param $photos
     * @param int $peerId
     */
    public function sendPhoto($photos, int $peerId = null)
    {
        $this->sender($photos, $peerId, 'photo');
    }

    /**
     * Отправить видео.
     * @param $video
     * @param int $peerId
     */
    public function sendVideo($video, int $peerId = null)
    {
        $this->sender($video, $peerId, 'video');
    }

    /**
     * Отправить документ.
     * @param $docs
     * @param int $peerId
     */
    public function sendDoc($docs, int $peerId = null)
    {
        $this->sender($docs, $peerId, 'doc');
    }

    /**
     * Отправить записи со стены.
     * @param $walls
     * @param int $peerId
     */
    public function sendWall($walls, int $peerId = null)
    {
        $this->sender($walls, $peerId, 'wall');
    }

    /**
     * Отправить опрос.
     * @param $polls
     * @param int $peerId
     */
    public function sendPoll($polls, int $peerId = null)
    {
        $this->sender($polls, $peerId, 'poll');
    }

    /**
     * Отправить товар.
     * @param $items
     * @param int $peerId
     */
    public function sendMarket($items, int $peerId = null)
    {
        $this->sender($items, $peerId, 'market');
    }

    /**
     * Отправить товар.
     * @param $audio
     * @param int $peerId
     */
    public function sendAudio($audio, int $peerId = null)
    {
        $this->sender($audio, $peerId, 'audio');
    }

    /**
     * @param $data
     * @param int|null $peerId
     * @param string $type
     */
    private function sender($data, int $peerId, string $type)
    {
        $config = [
            'peer_id' => ($peerId == null) ? $this->_object['peer_id'] : $peerId,
        ];

        $config['attachment'] = (is_array($data))
            ? $type . '-' . implode(',', $data) : $type . '-' . $data;

        $this->_vk->messages()->send($this->_config['access_token'], $config);
    }

}