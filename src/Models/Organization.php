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
 * Class Organization.
 *
 * @method Organization get()
 */
class Organization extends BaseObject
{
    protected $_model = 'organizations';

    /**
     * @param array $params
     *
     * @return array
     */
    public function getBoards(array $params = []): array
    {
        $data = $this->getPath('boards', $params);

        $tmp = [];
        foreach ($data as $item) {
            $tmp[] = new Board($this->getClient(), $item);
        }

        return $tmp;
    }
}
