<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ViewResource\Pages;
use App\Filament\Admin\Resources\ViewResource\RelationManagers;
use App\Models\View;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ViewResource extends Resource
{
    protected static ?string $model = View::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static ?string $navigationLabel = 'إحصائيات المشاهدة';

    protected static ?string $navigationGroup = 'التحليلات';

    protected static ?string $modelLabel = 'مشاهدة';

    protected static ?string $pluralModelLabel = 'المشاهدات';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // View-only resource, no form needed
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('المعرف')
                    ->sortable(),
                Tables\Columns\TextColumn::make('viewable_type')
                    ->label('النوع')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'advertisement' => 'success',
                        'store' => 'info',
                        'post' => 'warning',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('viewable_id')
                    ->label('معرف العنصر')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->default('ضيف')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('عنوان IP')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ المشاهدة')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('viewable_type')
                    ->label('النوع')
                    ->options([
                        'advertisement' => 'إعلان',
                        'store' => 'متجر',
                        'post' => 'منشور',
                    ]),
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
            'index' => Pages\ListViews::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
