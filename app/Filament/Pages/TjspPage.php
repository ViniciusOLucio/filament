<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class TjspPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'TjSP';
    protected static ?string $navigationGroup = 'Atalhos';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.tjsp-page';
}
