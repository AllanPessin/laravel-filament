<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\CategoryProduct;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationLabel = 'Produtos';

    protected static ?string $navigationIcon = 'heroicon-c-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->label('Título')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->required()->unique(),
                Section::make([
                    Forms\Components\DatePicker::make('start_date')
                        ->required()
                        ->label('Data início')
                        ->default(fn(?string $date = null) => $date ? Carbon::now($date) : Carbon::now()),
                    Forms\Components\DatePicker::make('end_date')->label('Data fim'),
                    Forms\Components\Select::make('category_id')
                        ->relationship(name: 'category', titleAttribute: 'name')
                        ->label('Categoria')
                        ->required(),
                ])->columns(['1' => 3, 'lg' => 3]),
                Forms\Components\RichEditor::make('content')->required()->columnSpanFull()->label('Conteúdo'),
                Forms\Components\Textarea::make('summary')->required()->rows(8)->columnSpanFull()->label('Resumo'),
            ])->columns(['sm' => 1]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Título'),
                Tables\Columns\TextColumn::make('category.name')->label('Categoria'),
                Tables\Columns\TextColumn::make('start_date')->label('Data início'),
                Tables\Columns\TextColumn::make('end_date')->label('Data fim'),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->options(fn(): array => CategoryProduct::query()->pluck('name', 'id')->all())
                    ->label('Categorias'),
            ])->persistFiltersInSession()
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
