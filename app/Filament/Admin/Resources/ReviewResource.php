<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReviewResource\Pages;
use App\Filament\Admin\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'المراجعات';

    protected static ?string $navigationGroup = 'المراجعات والتقييمات';

    protected static ?string $modelLabel = 'مراجعة';

    protected static ?string $pluralModelLabel = 'المراجعات';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->label('المستخدم')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('reviewable_id')
                    ->label('المعرف')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('reviewable_type')
                    ->label('النوع')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rating')
                    ->label('التقييم')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('review')
                    ->label('المراجعة')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->label('المستخدم')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewable_id')
                    ->label('المعرف')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewable_type')
                    ->label('النوع')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('التقييم')
                    ->numeric()
                    ->sortable(),
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
                //
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
