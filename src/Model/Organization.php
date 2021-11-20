<?php

namespace Trello\Model;

/**
 * Class Organization
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
