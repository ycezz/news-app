<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\FormsComponent;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function form(Form $form): Form //form untuk tambah & edit data
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')
                ->required()
                // ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                // ->live(debounce: 250)
                ->maxLength(255),

                // Forms\Components\TextInput::make('slug')
                // ->required()
                // ->disabled(),

                Forms\Components\FileUpload::make('icon')
                ->image()
                ->required(),
            ]);
    }

    public static function table(Table $table): Table //table untuk menampilkan data yg sudah ditambahkan
    {
        return $table
            ->columns([
                // Menampilkan data category
                Tables\Columns\TextColumn::make('name')
                ->searchable(), // <- fitur searching
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\ImageColumn::make('icon'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
