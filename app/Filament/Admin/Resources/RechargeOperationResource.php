<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RechargeOperationResource\Pages;
use App\Filament\Admin\Resources\RechargeOperationResource\RelationManagers;
use App\Models\RechargeOperation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RechargeOperationResource extends Resource
{
    protected static ?string $model = RechargeOperation::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'عمليات الشحن';

    protected static ?string $navigationGroup = 'المالية';

    protected static ?string $modelLabel = 'عملية شحن';

    protected static ?string $pluralModelLabel = 'عمليات الشحن';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('trader.owner_contact_number')
                    ->label('التاجر')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('الكود')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
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
                            ->when($data['created_from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
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
            'index' => Pages\ListRechargeOperations::route('/'),
            'create' => Pages\CreateRechargeOperation::route('/create'),
            'edit' => Pages\EditRechargeOperation::route('/{record}/edit'),
        ];
    }
}
