<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RechargeCodeResource\Pages;
use App\Filament\Admin\Resources\RechargeCodeResource\RelationManagers;
use App\Models\RechargeCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RechargeCodeResource extends Resource
{
    protected static ?string $model = RechargeCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationLabel = 'أكواد الشحن';

    protected static ?string $navigationGroup = 'المالية';

    protected static ?string $modelLabel = 'كود شحن';

    protected static ?string $pluralModelLabel = 'أكواد الشحن';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('الكود')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->label('السعر')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('point_number')
                    ->label('عدد النقاط')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_used')
                    ->label('مستخدم')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('الكود')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('point_number')
                    ->label('عدد النقاط')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_used')
                    ->label('مستخدم')
                    ->boolean(),
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
                Tables\Filters\TernaryFilter::make('is_used')
                    ->label('مستخدم'),
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
            'index' => Pages\ListRechargeCodes::route('/'),
            'create' => Pages\CreateRechargeCode::route('/create'),
            'edit' => Pages\EditRechargeCode::route('/{record}/edit'),
        ];
    }
}
