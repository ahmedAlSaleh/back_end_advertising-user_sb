<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AdvertisementResource\Pages;
use App\Filament\Admin\Resources\AdvertisementResource\RelationManagers;
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

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'الإعلانات';

    protected static ?string $navigationGroup = 'الإعلانات';

    protected static ?string $modelLabel = 'إعلان';

    protected static ?string $pluralModelLabel = 'الإعلانات';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label('الوصف')
                            ->required()
                            ->maxLength(255)
                            ->rows(3),
                        Forms\Components\Textarea::make('notes')
                            ->label('ملاحظات')
                            ->maxLength(255)
                            ->rows(2),
                        Forms\Components\TextInput::make('price')
                            ->label('السعر')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\Select::make('type')
                            ->label('النوع')
                            ->options([
                                'normal' => 'عادي',
                                'special' => 'مميز',
                            ])
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('الجدولة')
                    ->schema([
                        Forms\Components\DateTimePicker::make('scheduled_at')
                            ->label('تاريخ البدء المجدول')
                            ->native(false)
                            ->seconds(false),
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('تاريخ الانتهاء')
                            ->native(false)
                            ->seconds(false),
                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options(Advertisement::getStatusLabels())
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('المميزة/الترويج')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('مميز'),
                        Forms\Components\DateTimePicker::make('featured_until')
                            ->label('مميز حتى')
                            ->native(false)
                            ->seconds(false),
                        Forms\Components\Select::make('feature_type')
                            ->label('نوع الإبراز')
                            ->options([
                                'none' => 'لا يوجد',
                                'basic' => 'أساسي',
                                'premium' => 'مميز',
                            ]),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('الرقم')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(30)
                    ->sortable(),
                Tables\Columns\TextColumn::make('trader.store.name')
                    ->label('المتجر')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'special' => 'success',
                        'normal' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'scheduled' => 'info',
                        'draft' => 'warning',
                        'paused' => 'gray',
                        'expired' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->label('مجدول')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('ينتهي')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(Advertisement::getStatusLabels())
                    ->multiple(),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'normal' => 'Normal',
                        'special' => 'Special',
                    ]),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
                Tables\Filters\Filter::make('scheduled')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'scheduled')),
                Tables\Filters\Filter::make('expired')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'expired')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
