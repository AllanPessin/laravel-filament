<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryProductResource\Pages;
use App\Models\CategoryProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class CategoryProductResource extends Resource
{
    protected static ?string $model = CategoryProduct::class;

    protected static ?string $navigationGroup = 'Categorias';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Categorias de Produtos';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->label('Nome')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                // Forms\Components\TextInput::make('name')->required()
                //     ->live(onBlur: true)
                //     ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),,
                Forms\Components\TextInput::make('slug')->required()->unique(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategoryProducts::route('/'),
            'create' => Pages\CreateCategoryProduct::route('/create'),
            'edit' => Pages\EditCategoryProduct::route('/{record}/edit'),
        ];
    }
}
