<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AddressResource\Pages;
use App\Filament\Admin\Resources\AddressResource\RelationManagers;
use App\Models\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'العناوين';

    protected static ?string $navigationGroup = 'الإعدادات';

    protected static ?string $modelLabel = 'عنوان';

    protected static ?string $pluralModelLabel = 'العناوين';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('addressable_id')
                    ->label('معرف الكيان')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('addressable_type')
                    ->label('نوع الكيان')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('street')
                    ->label('الشارع')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label('المدينة')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->label('المحافظة')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->label('البلد')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('postal_code')
                    ->label('الرمز البريدي')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('addressable_id')
                    ->label('معرف الكيان')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('addressable_type')
                    ->label('نوع الكيان')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->label('الشارع')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('المدينة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->label('المحافظة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('البلد')
                    ->searchable(),
                Tables\Columns\TextColumn::make('postal_code')
                    ->label('الرمز البريدي')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
