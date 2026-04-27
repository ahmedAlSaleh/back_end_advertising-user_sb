<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReportResource\Pages;
use App\Filament\Admin\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationLabel = 'التقارير';

    protected static ?string $navigationGroup = 'التقارير';

    protected static ?string $modelLabel = 'تقرير';

    protected static ?string $pluralModelLabel = 'التقارير';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options(Report::getStatusLabels())
                    ->required(),
                Forms\Components\Textarea::make('admin_notes')
                    ->label('ملاحظات المسؤول')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('المعرف')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reportable_type')
                    ->label('النوع')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'advertisement' => 'success',
                        'store' => 'info',
                        'trader' => 'warning',
                        'post' => 'primary',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('السبب')
                    ->formatStateUsing(fn (string $state): string => Report::getReasonLabels()[$state] ?? $state)
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('reporter_type')
                    ->label('المُبلغ')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn (string $state): string => Report::getStatusLabels()[$state] ?? $state)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'reviewed' => 'info',
                        'resolved' => 'success',
                        'dismissed' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التبليغ')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(Report::getStatusLabels()),
                Tables\Filters\SelectFilter::make('reportable_type')
                    ->label('النوع')
                    ->options([
                        'advertisement' => 'إعلان',
                        'store' => 'متجر',
                        'trader' => 'تاجر',
                        'post' => 'منشور',
                    ]),
                Tables\Filters\SelectFilter::make('reason')
                    ->label('السبب')
                    ->options(Report::getReasonLabels()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('resolve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Report $record) {
                        $record->update([
                            'status' => 'resolved',
                            'resolved_at' => now(),
                            'resolved_by' => auth()->id(),
                        ]);
                    })
                    ->visible(fn (Report $record) => $record->status !== 'resolved'),
                Tables\Actions\Action::make('dismiss')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Report $record) {
                        $record->update([
                            'status' => 'dismissed',
                            'resolved_at' => now(),
                            'resolved_by' => auth()->id(),
                        ]);
                    })
                    ->visible(fn (Report $record) => $record->status !== 'dismissed'),
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
            'index' => Pages\ListReports::route('/'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Reports are created via API
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }
}
