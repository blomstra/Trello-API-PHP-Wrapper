<?php

/*
 * This file is part of blomstra/trello-php.
 *
 * Copyright (c) 2022 Blomstra Ltd.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Trello\Models;

/**
 * Class Board.
 *
 * @method Board get()
 */
class Board extends BaseObject
{
    /**
     * @var string
     */
    protected $_model = 'boards';

    /**
     * @param array $params
     *
     * @return array
     */
    public function getCards(array $params = []): array
    {
        $data = $this->getPath('cards', $params);

        $tmp = [];
        foreach ($data as $item) {
            $tmp[] = new Card($this->getClient(), $item);
        }

        return $tmp;
    }

    /**
     * @param $card_id
     * @param array $params
     *
     * @return Card
     */
    public function getCard($card_id, array $params = []): Card
    {
        $data = $this->getPath("cards/{$card_id}", $params);

        return new Card($this->getClient(), $data);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getActions(array $params = []): array
    {
        $data = $this->getPath('actions', $params);

        $tmp = [];
        foreach ($data as $item) {
            $tmp[] = new Action($this->getClient(), $item);
        }

        return $tmp;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getLists(array $params = []): array
    {
        $data = $this->getPath('lists', $params);

        $tmp = [];
        foreach ($data as $item) {
            $tmp[] = new Lane($this->getClient(), $item);
        }

        return $tmp;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getLabels(array $params = []): array
    {
        $data = $this->getPath('labels', $params);

        $tmp = [];
        foreach ($data as $item) {
            $tmp[] = new Label($this->getClient(), $item);
        }

        return $tmp;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getMembers(array $params = []): array
    {
        $data = $this->getPath('members', $params);

        $tmp = [];
        foreach ($data as $item) {
            $tmp[] = new Member($this->getClient(), $item);
        }

        return $tmp;
    }

    public function copy($new_name = null, array $copy_fields = [])
    {
        if ($this->getId()) {
            $tmp = new self($this->getClient());
            if (!$new_name) {
                $tmp->name = $this->name.' Copy';
            } else {
                $tmp->name = $new_name;
            }
            $tmp->idBoardSource = $this->getId();

            if (!empty($copy_fields)) {
                $tmp->keepFromSource = implode(',', $copy_fields);
            }

            return $tmp->save();
        }

        return false;
    }
}
