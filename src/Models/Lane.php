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

use InvalidArgumentException;

class Lane extends BaseObject
{
    protected $_model = 'lists';

    /**
     * @return BaseObject
     */
    public function save()
    {
        if (empty($this->name)) {
            throw new InvalidArgumentException('Missing required field "name"');
        }

        if (empty($this->idBoard)) {
            throw new InvalidArgumentException('Missing required filed "idBoard" - id of the board that the list should be added to');
        }

        if (empty($this->pos)) {
            $this->pos = 'bottom';
        } else {
            if ($this->pos !== 'top' && $this->pos !== 'bottom' && $this->pos <= 0) {
                throw new InvalidArgumentException("Invalid pos value {$this->pos}. Valid Values: A position. top, bottom, or a positive number");
            }
        }

        return parent::save();
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
