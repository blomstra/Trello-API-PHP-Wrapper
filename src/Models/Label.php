<?php

namespace Trello\Models;

use InvalidArgumentException;

class Label extends BaseObject
{
    protected $_model = 'labels';

    /**
     * @return BaseObject
     */
    public function save()
    {
        if (empty($this->name)) {
            throw new InvalidArgumentException('Missing required field "name"');
        }

        if (empty($this->color)) {
            throw new InvalidArgumentException('Missing required filed "color" - color that the label should have');
        }

        if (empty($this->idBoard)) {
            throw new InvalidArgumentException('Missing required filed "idBoard" - id of the board that the label should be added to');
        }

        return parent::save();
    }
}
