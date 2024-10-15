<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdvertisementResource\Pages;
use App\Filament\Resources\AdvertisementResource\RelationManagers;
use App\Models\Advertisement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdvertisementResource extends Resource
{
    protected static ?string $model = Advertisement::class;

    protected static ?string $navigationIcon = 'heroicon-o-funnel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //Menampilkan data advertisement
                Forms\Components\TextInput::make('link')
                ->activeUrl()
                ->required()
                ->maxLength(255),

                Forms\Components\FileUpload::make('thumbnail')
                ->required()
                ->image(),

                Forms\Components\Select::make('is_active')
                ->options([
                    'active' => 'Active',
                    'not_active' => 'Not Active'
                ])
                ->required(),

                Forms\Components\Select::make('type')
                ->options([
                    'banner' => 'Banner',
                    'square' => 'Square',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // menampilkan data yang sudah ditambahkan
                Tables\Columns\TextColumn::make('link')
                ->searchable(),

                Tables\Columns\TextColumn::make('is_active')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'not_active' => 'danger',})
                    // coba
                    ->label('Active Status')
                    ->formatStateUsing(function ($state) {
                        return $state === 'active' ? 'Active' : 'Not Active';
                    }),

                Tables\Columns\ImageColumn::make('thumbnail'),
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
            'index' => Pages\ListAdvertisements::route('/'),
            'create' => Pages\CreateAdvertisement::route('/create'),
            'edit' => Pages\EditAdvertisement::route('/{record}/edit'),
        ];
    }
}
