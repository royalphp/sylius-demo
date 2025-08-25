<?php

namespace App\Utils;

interface GridHelperInterface
{
    final public const string GRID_ACTION = 'action';

    final public const string GRID_FIELD = 'field';

    final public const string GRID_FILTER = 'filter';

    final public const array GRID_PARTS = [
        self::GRID_ACTION,
        self::GRID_FIELD,
        self::GRID_FILTER,
    ];

    public function getUserAccessHelper(): UserAccessHelperInterface;

    public function getUserThemeHelper(): UserThemeHelperInterface;

    public function getTemplateByTheme(string $type, string $name): string;
}
