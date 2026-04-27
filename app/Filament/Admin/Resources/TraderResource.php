<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TraderResource\Pages;
use App\Filament\Admin\Resources\TraderResource\RelationManagers;
use App\Models\Trader;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TraderResource extends Resource
{
    protected static ?string $model = Trader::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'التجار';

    protected static ?string $navigationGroup = 'المستخدمين';

    protected static ?string $modelLabel = 'تاجر';

    protected static ?string $pluralModelLabel = 'التجار';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('store_id')
                    ->label('المتجر')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('city')
                    ->label('المدينة')
                    ->maxLength(255),
                Forms\Components\TextInput::make('owner_contact_number')
                    ->label('رقم التواصل مع المالك')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('whatsapp_number')
                    ->label('رقم الواتساب')
                    ->maxLength(255),
                Forms\Components\TextInput::make('telegram_number')
                    ->label('رقم التليجرام')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('social_media_link')
                    ->label('رابط التواصل الاجتماعي')
                    ->maxLength(255),
                Forms\Components\Textarea::make('store_description')
                    ->label('وصف المتجر')
                    ->maxLength(500)
                    ->placeholder('أدخل وصف المتجر (اختياري)')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('store_id')
                    ->label('المتجر')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('المدينة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_contact_number')
                    ->label('رقم التواصل')
                    ->searchable(),
                Tables\Columns\TextColumn::make('whatsapp_number')
                    ->label('رقم الواتساب')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telegram_number')
                    ->label('رقم التليجرام')
                    ->searchable(),
                Tables\Columns\TextColumn::make('social_media_link')
                    ->label('رابط التواصل الاجتماعي')
                    ->searchable(),
                Tables\Columns\TextColumn::make('store_description')
                    ->label('وصف المتجر')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(),
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
                Tables\Filters\SelectFilter::make('city')
                    ->label('المدينة')
                    ->options(fn () => Trader::distinct()->pluck('city', 'city')),
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
            'index' => Pages\ListTraders::route('/'),
            'create' => Pages\CreateTrader::route('/create'),
            'edit' => Pages\EditTrader::route('/{record}/edit'),
        ];
    }
}
