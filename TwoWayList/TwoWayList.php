<?php

declare(strict_types=1);

namespace TwoWayList;

class TwoWayList extends ParentList
{
    public const STATUS_LEFT_NEVER_USE = 1;
    public const STATUS_LEFT_ERROR_LEFT_ITEM_NOT_EXISTS = 2;
    public const STATUS_LEFT_CURSOR_NOT_SET = 3;
    public const STATUS_LEFT_SUCCESS= 3;

    private int $statusLeft = self::STATUS_LEFT_NEVER_USE;

    // предусловие: список не пустой и курсор установлен
    // постусловие: сдвигает курсор на один узел влево
    public function left(): void
    {
        if (null === $this->cursor) {
            $this->statusLeft = self::STATUS_LEFT_CURSOR_NOT_SET;
            return;
        }
        if (null === $this->cursor->prev) {
            $this->statusLeft = self::STATUS_LEFT_ERROR_LEFT_ITEM_NOT_EXISTS;
            return;
        }

        $this->cursor = $this->cursor->next;
        $this->statusLeft = self::STATUS_LEFT_SUCCESS;
    }

    // Возвращает статус STATUS_LEFT_*
    public function getStatusLeft(): int
    {
        return $this->statusLeft;
    }
}