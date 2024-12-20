<?php

namespace App\Filament\Resources;

use App\Enums\Status;
use App\Filament\Resources\CategoryProductResource\Pages;
use App\Models\CategoryProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;

class CategoryProductResource extends Resource
{
    protected static ?string $model = CategoryProduct::class;

    protected static ?string $navigationGroup = 'Categorias';

    protected static ?string $navigationLabel = 'Categorias de Produtos';

    protected static ?string $navigationIcon = 'heroicon-c-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->label('Nome')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->required()->unique(),
                Forms\Components\Select::make('status')->options(Status::class)->default('Published'),
            ])->columns(['sm' => 1, 'lg' => 3]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('products_count')->counts('products'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(Status::class)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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

    public static function canDelete($record): bool
    {
        return !$record->products()->exists();
    }
}
