<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StoreHoursResource\Pages;
use App\Filament\Admin\Resources\StoreHoursResource\RelationManagers;
use App\Models\StoreHours;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoreHoursResource extends Resource
{
    protected static ?string $model = StoreHours::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'المتاجر';

    protected static ?string $navigationLabel = 'ساعات العمل';

    protected static ?string $modelLabel = 'ساعة عمل';

    protected static ?string $pluralModelLabel = 'ساعات العمل';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('store_id')
                    ->label('المتجر')
                    ->relationship('store', 'store_name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('day')
                    ->label('اليوم')
                    ->options(StoreHours::getDayNames())
                    ->required(),

                Forms\Components\Toggle::make('is_closed')
                    ->label('مغلق')
                    ->reactive()
                    ->default(false),

                Forms\Components\TimePicker::make('opens_at')
                    ->label('وقت الفتح')
                    ->seconds(false)
                    ->hidden(fn ($get) => $get('is_closed'))
                    ->required(fn ($get) => !$get('is_closed')),

                Forms\Components\TimePicker::make('closes_at')
                    ->label('وقت الإغلاق')
                    ->seconds(false)
                    ->hidden(fn ($get) => $get('is_closed'))
                    ->required(fn ($get) => !$get('is_closed')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('store.store_name')
                    ->label('المتجر')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('day')
                    ->label('اليوم')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Sunday' => 'warning',
                        'Monday' => 'primary',
                        'Tuesday' => 'success',
                        'Wednesday' => 'info',
                        'Thursday' => 'danger',
                        'Friday' => 'gray',
                        'Saturday' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_closed')
                    ->label('مغلق')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success'),

                Tables\Columns\TextColumn::make('opens_at')
                    ->label('وقت الفتح')
                    ->time('g:i A')
                    ->placeholder('غير متاح')
                    ->sortable(),

                Tables\Columns\TextColumn::make('closes_at')
                    ->label('وقت الإغلاق')
                    ->time('g:i A')
                    ->placeholder('غير متاح')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('store_id')
                    ->relationship('store', 'store_name')
                    ->label('المتجر')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('day')
                    ->label('اليوم')
                    ->options(StoreHours::getDayNames()),

                Tables\Filters\TernaryFilter::make('is_closed')
                    ->label('مغلق'),
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
            ->defaultSort('store_id', 'asc');
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
            'index' => Pages\ListStoreHours::route('/'),
            'create' => Pages\CreateStoreHours::route('/create'),
            'edit' => Pages\EditStoreHours::route('/{record}/edit'),
        ];
    }
}
