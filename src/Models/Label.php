<?php

namespace Trello\Models;

use InvalidArgumentException;

class Label extends BaseObject
{
    protected $_model = 'labels';

    const LABEL_COLOR_YELLOW = 'yellow';
    const LABEL_COLOR_PURPLE = 'purple';
    const LABEL_COLOR_BLUE = 'blue';
    const LABEL_COLOR_RED = 'red';
    const LABEL_COLOR_GREEN = 'green';
    const LABEL_COLOR_ORANGE = 'orange';
    const LABEL_COLOR_BLACK = 'black';
    const LABEL_COLOR_SKY = 'sky';
    const LABEL_COLOR_PINK = 'pink';
    const LABEL_COLOR_LIME = 'lime';

    const LABEL_COLORS = [
        self::LABEL_COLOR_YELLOW,
        self::LABEL_COLOR_PURPLE,
        self::LABEL_COLOR_BLUE,
        self::LABEL_COLOR_RED,
        self::LABEL_COLOR_GREEN,
        self::LABEL_COLOR_ORANGE,
        self::LABEL_COLOR_BLACK,
        self::LABEL_COLOR_SKY,
        self::LABEL_COLOR_PINK,
        self::LABEL_COLOR_LIME,
    ];

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

    public static function randomColor()
    {
        return self::LABEL_COLORS[array_rand(self::LABEL_COLORS)];
    }
}
