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

class Member extends BaseObject
{
    protected $_model = 'members';

    /**
     * @return array
     */
    public function getBoards(): array
    {
        $data = $this->getPath('boards');

        $tmp = [];
        foreach ($data as $item) {
            $tmp[] = new Board($this->getClient(), $item);
        }

        return $tmp;
    }

    /**
     * @return array
     */
    public function getOrganizations(): array
    {
        $data = $this->getPath('organizations');

        $tmp = [];
        foreach ($data as $item) {
            $tmp[] = new Organization($this->getClient(), $item);
        }

        return $tmp;
    }

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
}
