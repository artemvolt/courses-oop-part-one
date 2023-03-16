<?php

declare(strict_types=1);

interface BoundedStackInterface
{
    // предусловие: кол-во элементов не должно превышать максимальное количество
    public static function create(array $items, int $maxElements): static;

    // предусловие: стек не полон
    // постусловие: добавлен элемент в список
    public function push(mixed $value): void;

    // предусловие: стек не пуст
    // постусловие: из списка удален верхний элемент
    public function pop(): void;

    // предусловие: стек не пуст
    // постусловие: возвращается верхний элемент
    public function peek(): mixed;

    // постусловие: возвращает статус STATUS_CREATE_*
    public function getStatusCreate(): int;

    // постусловие: возвращает статус STATUS_PUSH_*
    public function getStatusPush(): int;

    // постусловие: возвращает статус STATUS_POP_*
    public function getStatusPop(): int;

    // постусловие: возвращает статус STATUS_PICK_*
    public function getStatusPick(): int;

    // постусловие: очищает элементы и возвращает статусы методов push, pick, pop в неиспользованное состояние
    // статус создания выставляется в SUCCESS
    public function clear(): void;

    // постусловие: возвращает размер массива
    public function size(): int;
}

class BoundedStack implements BoundedStackInterface
{
    public const STATUS_CREATE_SUCCESS = 2;
    public const STATUS_CREATE_ERROR_MAX_SIZE_ITEMS = 3;

    public const STATUS_PUSH_NEVER_USE = 1;
    public const STATUS_PUSH_ERROR_MAX_SIZE_ITEMS = 2;
    public const STATUS_PUSH_SUCCESS = 3;

    public const STATUS_POP_NEVER_USE = 1;
    public const STATUS_POP_ERROR_EMPTY_LIST = 2;
    public const STATUS_POP_SUCCESS = 3;

    public const STATUS_PICK_NEVER_USE = 1;
    public const STATUS_PICK_ERROR_EMPTY_LIST = 2;
    public const STATUS_PICK_SUCCESS = 3;

    protected int $statusCreate;
    protected int $statusPush;
    protected int $statusPop;
    protected int $statusPick;

    protected array $items;
    protected int $maxItems;

    private function __construct()
    {
    }

    public static function create(array $items, int $maxElements): static
    {
        $stack = new self();
        $stack->statusPush = self::STATUS_PUSH_NEVER_USE;
        $stack->statusCreate = self::STATUS_CREATE_ERROR_MAX_SIZE_ITEMS;
        $stack->statusPop = self::STATUS_POP_NEVER_USE;
        $stack->statusPick = self::STATUS_PICK_NEVER_USE;
        if (count($items) <= $maxElements) {
            $stack->statusCreate = self::STATUS_CREATE_SUCCESS;
            $stack->items = $items;
        }
        return $stack;
    }

    public function push(mixed $value): void
    {
        $this->statusPush = self::STATUS_PUSH_ERROR_MAX_SIZE_ITEMS;
        if (count($this->items) < $this->maxItems) {
            $this->statusPush = self::STATUS_PUSH_SUCCESS;
            $this->items[] = $value;
        }
    }

    public function pop(): void
    {
        $this->statusPop = self::STATUS_POP_ERROR_EMPTY_LIST;
        if (!empty($this->items)) {
            $this->statusPop = self::STATUS_POP_SUCCESS;
        }
    }

    public function peek(): mixed
    {
        if (!empty($this->items)) {
            $this->statusPick = self::STATUS_PICK_SUCCESS;
            return $this->items[0];
        }

        $this->statusPick = self::STATUS_PICK_ERROR_EMPTY_LIST;
        return 'ERROR';
    }

    public function getStatusCreate(): int
    {
        return $this->statusCreate;
    }

    public function getStatusPush(): int
    {
        return $this->statusPush;
    }

    public function getStatusPop(): int
    {
        return $this->statusPop;
    }

    public function getStatusPick(): int
    {
        return $this->statusPick;
    }

    public function clear(): void
    {
        $this->statusPush = self::STATUS_PUSH_NEVER_USE;
        $this->statusPop = self::STATUS_POP_NEVER_USE;
        $this->statusPick = self::STATUS_PICK_NEVER_USE;
        $this->statusCreate = self::STATUS_CREATE_SUCCESS;
        $this->items = [];
    }

    public function size(): int
    {
        return count($this->items);
    }
}