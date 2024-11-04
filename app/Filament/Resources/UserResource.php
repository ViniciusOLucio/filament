<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Blueprint\Models\Model;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

// Ajustado para o caminho correto

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Usuários';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone'];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('tabs')
                    ->tabs([
                        // Aba 1: Dados do usuário
                        Tab::make('User data')
                            ->schema([
                                Section::make('Informações do usuário')
                                    ->description(function ($operation) {
                                        if ($operation === 'create') {
                                            return 'Crie um novo usuário';
                                        }
                                        return 'Atualize as informações do usuário';
                                    })
                                    ->icon('heroicon-o-user')
                                    ->columns(2)
                                    ->collapsible()
                                    ->schema([

                                        TextInput::make('name')
                                            ->hint('John Doe')
                                            ->rules(['required'])
                                            ->label('Nome')
                                            ->placeholder('Nome do usuário')
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'O nome é obrigatório.',
                                            ]),

                                        TextInput::make('email')
                                            ->hint('john.doe@email.com')
                                            ->rules(['required'])
                                            ->unique(ignoreRecord: true)
                                            ->email()
                                            ->placeholder('Email do usuário')
                                            ->required(),

                                        TextInput::make('password')
                                            ->hint('Bh12çIoLL101ÇaQ')
                                            ->rules(['required'])
                                            ->label('Senha')
                                            ->password()
                                            ->placeholder('Senha do usuário')
                                            ->required()
                                            ->visibleOn('create')
                                            ->afterStateHydrated(function ($component, $state) {
                                                if ($state) {
                                                    $component->state(bcrypt($state));
                                                }
                                            }),

                                        TextInput::make('phone')
                                            ->hint('(00) 00000-0000')
                                            ->label('Telefone')
                                            ->mask('(99) 99999-9999')
                                            ->placeholder('(__) _____-____'),

                                    ]),
                            ]),

                        // Aba 2: Avatar
                        Tab::make('Avatar')
                            ->schema([
                                Section::make('Avatar do usuário')
                                    ->schema([

                                        FileUpload::make('avatar')
                                            ->image()
                                            ->directory('avatars')
                                            ->columns(2)
                                            ->imageEditor(),
                                    ]),
                            ]),

                        // Aba 3: Administrador
                        Tab::make('Administrador')
                            ->schema([
                                Section::make('Administrador')
                                    ->description('Escolha se o usuário é administrador')
                                    ->schema([
                                        Toggle::make('is_admin')
                                            ->label('Administrador')
                                            ->hint('Escolha o status do usuário'),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('avatar')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->circular(),
                Tables\Columns\TextInputColumn::make('name')

                    ->label('Nome')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),



                Tables\Columns\TextInputColumn::make('email')
                    ->label('E-Mail')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),

                Tables\Columns\TextInputColumn::make('phone')
                    ->label('Telefone')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('is_admin')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Administrador'),

                Tables\Columns\TextColumn::make('comments_count')
                    ->label('Comentários')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color(function($state):string {
                        if ($state >= 2) {
                          return 'success' ;
                        }else{
                            return 'danger' ;
                        }
                    })
                    ->sortable()
                    ->counts('comments'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Criado em...'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Atualizado em...'),

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'success';
    }
}
