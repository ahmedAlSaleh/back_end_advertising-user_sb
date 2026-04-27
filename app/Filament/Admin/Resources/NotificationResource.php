<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NotificationResource\Pages;
use App\Filament\Admin\Resources\NotificationResource\RelationManagers;
use App\Models\Notification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?string $navigationLabel = 'الإشعارات';

    protected static ?string $navigationGroup = 'الإعدادات';

    protected static ?string $modelLabel = 'إشعار';

    protected static ?string $pluralModelLabel = 'الإشعارات';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->label('النوع')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('data')
                    ->label('البيانات')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('read_at')
                    ->label('قُرئ في'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('notifiable_type')
                    ->label('لـ')
                    ->searchable(),
                Tables\Columns\IconColumn::make('read_at')
                    ->label('مقروء')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->getStateUsing(fn ($record) => $record->read_at !== null),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                Tables\Filters\Filter::make('unread')
                    ->label('غير مقروء')
                    ->query(fn (Builder $query): Builder => $query->whereNull('read_at')),
                Tables\Filters\SelectFilter::make('type')
                    ->label('النوع')
                    ->options(fn () => Notification::distinct()->pluck('type', 'type')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListNotifications::route('/'),
            'create' => Pages\CreateNotification::route('/create'),
            'edit' => Pages\EditNotification::route('/{record}/edit'),
        ];
    }
}
