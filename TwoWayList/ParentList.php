<?php

declare(strict_types=1);

namespace TwoWayList;

class ParentList implements ParentListInterface
{
    private ?Node $head;
    private ?Node $tail;

    private int $statusHead = self::STATUS_HEAD_NEVER_USE;
    private int $statusTail = self::STATUS_TAIL_NEVER_USE;
    private int $statusRight = self::STATUS_RIGHT_NEVER_USE;
    private int $statusGet = self::STATUS_GET_NEVER_USER;
    private int $statusPutRight = self::STATUS_PUT_RIGHT_NEVER_USE;
    private int $statusPutLeft = self::STATUS_PUT_LEFT_NEVER_USE;
    private int $statusRemove = self::STATUS_REMOVE_NEVER_USE;
    private int $statusReplace = self::STATUS_REPLACE_NEVER_USE;
    private int $statusFind = self::STATUS_FIND_NEVER_USE;

    protected ?Node $cursor = null;

    public function head(): void
    {
        $this->statusHead = self::STATUS_HEAD_ERROR_EMPTY_ELEMENTS;
        if (!empty($this->list)) {
            $this->statusHead = self::STATUS_HEAD_SUCCESS;
            $this->cursor = $this->head;
        }
    }

    public function getHeadStatus(): int
    {
        return $this->statusHead;
    }

    public function tail(): void
    {
        $this->statusTail = self::STATUS_TAIL_ERROR_EMPTY_ELEMENTS;
        if (!empty($this->list)) {
            $this->statusTail = self::STATUS_TAIL_SUCCESS;
            $this->cursor = $this->list[count($this->list) - 1];
        }
    }

    public function getStatusTail(): int
    {
        return $this->statusTail;
    }

    public function right(): void
    {
        if (null === $this->cursor) {
            $this->statusRight = self::STATUS_RIGHT_ERROR_CURSOR_NOT_SET;
            return;
        }
        if (null === $this->cursor->next) {
            $this->statusRight = self::STATUS_RIGHT_ERROR_NONE_EXIST_RIGHT_ITEM;
            return;
        }

        $this->cursor = $this->cursor->next;
        $this->statusRight = self::STATUS_RIGHT_SUCCESS;
    }

    public function get(): mixed
    {
        if (null === $this->cursor) {
            $this->statusGet = self::STATUS_GET_ERROR_CURSOR_NOT_SET;
            return 0;
        }
        $this->statusGet = self::STATUS_GET_SUCCESS;
        return $this->cursor->value;
    }

    public function putRight(mixed $value): void
    {
        if (null == $this->cursor) {
            $this->statusPutRight = self::STATUS_PUT_RIGHT_ERROR_CURSOR_NOT_SET;
            return;
        }

        $next = $this->cursor->next;
        if (null === $next) {
            $this->cursor->next = new Node($value, $this->cursor, $next);
        } else {
            $cursorNext = $this->cursor->next;
            $node = new Node($value, $this->cursor, $cursorNext);
            $this->cursor->next = $node;
            $cursorNext->prev = $node;
        }
        $this->statusPutRight = self::STATUS_PUT_RIGHT_SUCCESS;
    }

    public function putLeft(mixed $value): void
    {
        if (null == $this->cursor) {
            $this->statusPutLeft = self::STATUS_PUT_LEFT_ERROR_CURSOR_NOT_SET;
            return;
        }

        $prev = $this->cursor->prev;
        if (null === $prev) {
            $this->cursor->prev = new Node($value, null, $this->cursor);
        } else {
            $prevCursor = $this->cursor->prev;
            $node = new Node($value, $prevCursor, $this->cursor);
            $this->cursor->prev = $node;
            $prevCursor->next = $node;
        }
        $this->statusPutLeft = self::STATUS_PUT_LEFT_SUCCESS;
    }

    public function remove(): void
    {
        if (null === $this->cursor) {
            $this->statusRemove = self::STATUS_REMOVE_ERROR_CURSOR_NOT_SET;
            return;
        }

        $prev = $this->cursor->prev;
        $next = $this->cursor->next;
        if (null === $prev and null === $next) {
            $this->statusRemove = self::STATUS_REMOVE_ERROR_NO_CANDIDATES;
            return;
        }

        $this->statusRemove = self::STATUS_REMOVE_SUCCESS;

        $this->cursor = $prev;
        if (null === $prev) {
            $this->cursor = $next;
        }
    }

    public function clear(): void
    {
        $this->cursor = null;
    }

    public function size(): int
    {
        $count = 1;
        $next = $this->cursor->next;
        while ($next !== null) {
            $count += 1;
            $next = $next->next;
        }
        return $count;
    }

    public function addTail(mixed $value): void
    {
        if ($this->isEmpty()) {
            $this->head = $this->tail = new Node($value, null, null);
            return;
        }

        $tail = $this->tail;
        $this->tail = new Node($value, $tail, null);
        if (null !== $tail) {
            $tail->next = $this->tail;
        }
    }

    public function replace(mixed $value): void
    {
        if (null === $this->cursor) {
            $this->statusReplace = self::STATUS_REPLACE_ERROR_CURSOR_NOT_SET;
            return;
        }

        $this->cursor->value = $value;
        $this->statusReplace = self::STATUS_REPLACE_SUCCESS;
    }

    public function find(mixed $value): void
    {
        if (null === $this->cursor) {
            $this->statusFind = self::STATUS_FIND_ERROR_CURSOR_NOT_SET;
            return;
        }

        $this->statusFind = self::STATUS_FIND_ERROR_NO_FOUND;

        $current = $this->cursor->next;
        while ($current !== null) {
            if ($current->value !== $value) {
                $current = $current->next;
            } else {
                $this->cursor = $current;
                $current = null;
                $this->statusFind = self::STATUS_FIND_SUCCESS;
            }
        }
    }

    public function removeAll(mixed $value): void
    {
        $current = $this->head;
        while ($current !== null) {
            if ($current->value === $value) {
                $prev = $current->prev;
                $next = $current->next;
                if ($prev !== null) {
                    $prev->next = $next;
                }
                if ($next !== null) {
                    $next->prev = $prev;
                }
            }
        }
    }

    public function isHead(): bool
    {
        return $this->cursor === $this->head;
    }

    public function isTail(): bool
    {
        return $this->cursor === $this->tail;
    }

    public function isValue(): bool
    {
        return null !== $this->cursor;
    }

    public function getStatusRight(): int
    {
        return $this->statusRight;
    }

    private function isEmpty(): bool
    {
        return null === $this->head;
    }

    private function isOneItem(): bool
    {
        return $this->head === $this->tail;
    }

    public function getStatusGet(): int
    {
        return $this->statusGet;
    }

    public function getStatusPutRight(): int
    {
        return $this->statusPutRight;
    }

    public function getStatusPutLeft(): int
    {
        return $this->statusPutLeft;
    }

    public function getStatusRemove(): int
    {
        return $this->statusRemove;
    }

    public function getStatusReplace(): int
    {
        return $this->statusReplace;
    }

    public function getStatusFind(): int
    {
        return $this->statusFind;
    }
}