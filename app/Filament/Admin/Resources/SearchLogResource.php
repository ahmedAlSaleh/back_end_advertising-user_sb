<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SearchLogResource\Pages;
use App\Filament\Admin\Resources\SearchLogResource\RelationManagers;
use App\Models\SearchLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SearchLogResource extends Resource
{
    protected static ?string $model = SearchLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'إحصائيات البحث';

    protected static ?string $navigationGroup = 'التحليلات';

    protected static ?string $modelLabel = 'سجل بحث';

    protected static ?string $pluralModelLabel = 'سجلات البحث';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('keyword')
                    ->label('الكلمة المفتاحية')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label('المدينة')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price_min')
                    ->label('السعر الأدنى')
                    ->numeric(),
                Forms\Components\TextInput::make('price_max')
                    ->label('السعر الأقصى')
                    ->numeric(),
                Forms\Components\TextInput::make('rating_min')
                    ->label('التقييم الأدنى')
                    ->numeric(),
                Forms\Components\TextInput::make('results_count')
                    ->label('عدد النتائج')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('keyword')
                    ->label('الكلمة المفتاحية')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('city')
                    ->label('المدينة')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_min')
                    ->label('السعر الأدنى')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_max')
                    ->label('السعر الأقصى')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating_min')
                    ->label('التقييم الأدنى')
                    ->numeric(1)
                    ->sortable(),
                Tables\Columns\TextColumn::make('results_count')
                    ->label('النتائج')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_ip')
                    ->label('عنوان IP')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ البحث')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('من'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('إلى'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListSearchLogs::route('/'),
            'create' => Pages\CreateSearchLog::route('/create'),
            'view' => Pages\ViewSearchLog::route('/{record}'),
            'edit' => Pages\EditSearchLog::route('/{record}/edit'),
        ];
    }
}
