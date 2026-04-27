<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PromotionPackageResource\Pages;
use App\Filament\Admin\Resources\PromotionPackageResource\RelationManagers;
use App\Models\PromotionPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromotionPackageResource extends Resource
{
    protected static ?string $model = PromotionPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'باقات الترويج';

    protected static ?string $navigationGroup = 'الإعلانات';

    protected static ?string $modelLabel = 'باقة ترويج';

    protected static ?string $pluralModelLabel = 'باقات الترويج';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('الاسم')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('duration_days')
                    ->label('المدة (أيام)')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price_points')
                    ->label('السعر (نقاط)')
                    ->required()
                    ->numeric(),
                Forms\Components\KeyValue::make('benefits')
                    ->label('المميزات')
                    ->reorderable(),
                Forms\Components\Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_days')
                    ->label('المدة')
                    ->suffix(' أيام')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_points')
                    ->label('السعر')
                    ->money('USD', divideBy: 1)
                    ->suffix(' نقطة')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('نشط'),
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
            'index' => Pages\ListPromotionPackages::route('/'),
            'create' => Pages\CreatePromotionPackage::route('/create'),
            'edit' => Pages\EditPromotionPackage::route('/{record}/edit'),
        ];
    }
}
