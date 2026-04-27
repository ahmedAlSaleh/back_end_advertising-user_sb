<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PromotionResource\Pages;
use App\Filament\Admin\Resources\PromotionResource\RelationManagers;
use App\Models\Promotion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    protected static ?string $navigationLabel = 'الترويجات النشطة';

    protected static ?string $navigationGroup = 'الإعلانات';

    protected static ?string $modelLabel = 'ترويج';

    protected static ?string $pluralModelLabel = 'الترويجات';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // View-only resource
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('الرقم')
                    ->sortable(),
                Tables\Columns\TextColumn::make('advertisement.title')
                    ->label('الإعلان')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('package.name')
                    ->label('الباقة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'VIP', 'Premium' => 'success',
                        'Basic' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('started_at')
                    ->label('تاريخ البدء')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('تاريخ الانتهاء')
                    ->dateTime()
                    ->sortable()
                    ->color(fn ($record) => $record->isActive() ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('points_paid')
                    ->label('النقاط المدفوعة')
                    ->suffix(' نقطة')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->isActive()),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '>', now())),
                Tables\Filters\Filter::make('expired')
                    ->query(fn (Builder $query): Builder => $query->where('expires_at', '<=', now())),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPromotions::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
