<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LikeResource\Pages;
use App\Filament\Admin\Resources\LikeResource\RelationManagers;
use App\Models\Like;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LikeResource extends Resource
{
    protected static ?string $model = Like::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-thumb-up';

    protected static ?string $navigationLabel = 'الإعجابات';

    protected static ?string $navigationGroup = 'التفاعلات';

    protected static ?string $modelLabel = 'إعجاب';

    protected static ?string $pluralModelLabel = 'الإعجابات';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('post_id')
                    ->label('المنشور')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->label('المستخدم')
                    ->numeric(),
                Forms\Components\TextInput::make('trader_id')
                    ->label('التاجر')
                    ->numeric(),
                Forms\Components\Toggle::make('like')
                    ->label('إعجاب')
                    ->required(),
                Forms\Components\Toggle::make('dislike')
                    ->label('عدم إعجاب')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('post_id')
                    ->label('المنشور')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->label('المستخدم')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('trader_id')
                    ->label('التاجر')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('like')
                    ->label('إعجاب')
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
                Tables\Columns\IconColumn::make('dislike')
                    ->label('عدم إعجاب')
                    ->boolean(),
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
            'index' => Pages\ListLikes::route('/'),
            'create' => Pages\CreateLike::route('/create'),
            'edit' => Pages\EditLike::route('/{record}/edit'),
        ];
    }
}
