<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum Status: string implements HasLabel, HasColor
{
    case PUBLISHED = 'Published';
    case DRAFT = 'Draft';
    case ARCHIVED = 'Archived';

    public function getLabel(): string|null
    {
        return match ($this) {
            self::PUBLISHED => 'Publicado',
            self::DRAFT => 'Rascunho',
            self::ARCHIVED => 'Arquivado',
            default => null,
        };
    }

    public function getColor(): string|null
    {
        return null;
    }
}
