<?php

declare(strict_types=1);

namespace TwoWayList;

interface ParentListInterface
{
    public const STATUS_HEAD_NEVER_USE = 1;
    public const STATUS_HEAD_ERROR_EMPTY_ELEMENTS = 2;
    public const STATUS_HEAD_SUCCESS = 3;

    public const STATUS_TAIL_NEVER_USE = 1;
    public const STATUS_TAIL_ERROR_EMPTY_ELEMENTS = 2;
    public const STATUS_TAIL_SUCCESS = 3;

    public const STATUS_RIGHT_NEVER_USE = 1;
    public const STATUS_RIGHT_ERROR_CURSOR_NOT_SET = 2;
    public const STATUS_RIGHT_ERROR_NONE_EXIST_RIGHT_ITEM = 2;
    public const STATUS_RIGHT_SUCCESS = 3;

    public const STATUS_GET_NEVER_USER = 1;
    public const STATUS_GET_ERROR_CURSOR_NOT_SET = 2;
    public const STATUS_GET_SUCCESS = 3;

    public const STATUS_REMOVE_NEVER_USE = 1;
    public const STATUS_REMOVE_ERROR_CURSOR_NOT_SET = 2;
    public const STATUS_REMOVE_ERROR_NO_CANDIDATES = 3;
    public const STATUS_REMOVE_SUCCESS = 4;

    public const STATUS_PUT_RIGHT_NEVER_USE = 1;
    public const STATUS_PUT_RIGHT_ERROR_CURSOR_NOT_SET = 2;
    public const STATUS_PUT_RIGHT_SUCCESS = 3;

    public const STATUS_PUT_LEFT_NEVER_USE = 1;
    public const STATUS_PUT_LEFT_ERROR_CURSOR_NOT_SET = 2;
    public const STATUS_PUT_LEFT_SUCCESS = 3;

    public const STATUS_REPLACE_NEVER_USE = 1;
    public const STATUS_REPLACE_ERROR_CURSOR_NOT_SET = 2;
    public const STATUS_REPLACE_SUCCESS = 3;

    public const STATUS_FIND_NEVER_USE = 1;
    public const STATUS_FIND_ERROR_CURSOR_NOT_SET = 2;
    public const STATUS_FIND_ERROR_NO_FOUND = 3;
    public const STATUS_FIND_SUCCESS = 4;

    // предусловие: список не пустой
    // постусловие: устанавливает курсор на первый элемент в списке
    public function head(): void;

    // постусловие: Возвращает константу STATUS_HEAD_*
    // Возвращает статус последней операции head
    public function getHeadStatus(): int;

    // предусловие: список не пустой
    // постусловие: устанавливает курсор на последний элемент в списке
    public function tail(): void;

    // постусловие: Возвращает константу STATUS_TAIL_*
    // Возвращает статус последней операции tail
    public function getStatusTail(): int;

    // постусловие: сдвинуть курсор на один узел вправо
    public function right(): void;

    // постусловие: Возвращает константу STATUS_RIGHT_*
    // Возвращает статус последней операции right
    public function getStatusRight(): int;

    // предусловие: курсор установлен, список не пустой
    // постусловие: получить значение текущего узла
    public function get(): mixed;

    // предусловие: курсор установлен
    // постусловие: вставляет следом за текущим узлом новый узел с заданным значением;
    public function putRight(mixed $value): void;

    // предусловие: курсор установлен
    // постусловие: вставляет перед текущим узлом новый узел с заданным значением;
    public function putLeft(mixed $value): void;

    // предусловие: курсор установлен
    // постусловие: удаляет текущий узел,
    //              Курсор смещается к правому соседу, если он есть.
    //              В противном случае курсор смещается к левому соседу, если он есть.
    public function remove(): void;

    // постусловие: очищает текущий список
    public function clear(): void;

    // постусловие: возвращает количество узлов в списке
    public function size(): int;

    // постусловие: добавляет новый узел в хвост списка
    public function addTail(mixed $value): void;

    // предусловие: курсор установлен
    // постусловие: заменяет значение текущего узла на новое
    public function replace(mixed $value): void;

    // предусловие: курсор установлен
    // постусловие: установить курсор на следующий узел с искомым значением (по отношению к текущему узлу)
    public function find(mixed $value): void;

    // постусловие: удалит узлы с заданным значением
    public function removeAll(mixed $value): void;

    // постусловие: находится ли курсор в начале списка
    public function isHead(): bool;

    // постусловие: находится ли курсор в конце списка
    public function isTail(): bool;

    // постусловие: установлен ли курсор
    public function isValue(): bool;

    // Возвращает статус последней операции get
    public function getStatusGet(): int;

    public function getStatusPutRight(): int;

    public function getStatusPutLeft(): int;

    public function getStatusRemove(): int;

    public function getStatusReplace(): int;

    public function getStatusFind(): int;
}