<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Post information')
                    ->description('Informações do post')
                    ->schema([
                        TextInput::make('title')
                            ->hint('Titulo do post')
                            ->label('Titulo')
                            ->placeholder('Titulo do post')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set) {
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->hint('Slug do post')
                            ->label('Slug')
                            ->placeholder('Slug do post')
                            ->required(),
                    ])->columns(2),

                Section::make('Conteudo')
                    ->description('Conteudo do post')
                    ->schema([
                        RichEditor::make('content')
                            ->helperText('Conteudo do post')
                            ->label('Conteudo do post')
                            ->required()

                    ])->columnSpanFull(),
                Section::make('Post  Thumb')
                    ->description('Thumbail do post')
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->image()
                            ->helperText('Thumbail do post')
                            ->label('Thumbail do post')
                            ->directory('thumbs')
                            ->required(),
                    ])->columnSpanFull(),

                Section::make('Categorias e tags')
                    ->description('Escolha as categorias e tags')
                    ->schema([
                        Select::make('category_id')
                            ->label('categoria')
                            ->searchable()
                            ->options(
                                \App\Models\Category::all()->pluck('name', 'id')
                            ),

                        TagsInput::make('tags')
                            ->label('tags')
                        
//                        Select::make('tags')
//                            ->nullable()
//                            ->label('Tags')
//                            ->searchable()
//                            ->preload()
//                            ->multiple()
//                            ->relationship('tags', 'tag_name')

                    ])->columns(2),

                Section::make('Publicado')
                    ->schema([
                        Select::make('is_published')
                            ->options([
                                0 => 'Não',
                                1 => 'Sim'
                            ])
                            ->label('Publicado')
                            ->required()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titulo')
                    ->searchable()
                    ->sortable()
                    ->limit(15),

                Tables\Columns\IconColumn::make('is_published')
                    ->sortable()
                    ->boolean()
                    ->label('Publicado'),

                TextColumn::make('user.name')
                    ->label('Autor')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->color('primary'),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
