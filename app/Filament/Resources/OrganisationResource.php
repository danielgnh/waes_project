<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganisationResource\Pages;
use App\Models\Organisation;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Table;

class OrganisationResource extends Resource
{
    protected static ?string $model = Organisation::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function getNavigationLabel(): string
    {
        /** @var User $user */
        $user = auth()->user();

        if (auth()->check() && $user->hasRole('admin')) {
            return __('All Organisations');
        }

        return __('My Organisation');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Media Data')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('organisation_logo')
                            ->label(__('Logotype of the Organisation'))
                            ->collection('logotype'),
                    ]),
                Tabs::make('Tabs')
                    ->columns(2)
                    ->tabs([
                        Tabs\Tab::make('Global Information')
                            ->icon('heroicon-m-building-storefront')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->columnSpanFull()
                                    ->label("Organisation's Name"),
                                Textarea::make('description')
                                    ->label('Description')
                                    ->required()
                                    ->columnSpanFull()
                                    ->autosize(),
                                Forms\Components\Select::make('status')
                                    ->required()
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'pending' => 'Pending',
                                        'blocked' => 'Blocked',
                                    ])
                                    ->label('Status'),
                                Forms\Components\Select::make('manager_id')
                                    ->options(User::query()->pluck('email', 'id'))
                                    ->label('Contact Manager'),
                                Select::make('users')
                                    ->columnSpanFull()
                                    ->multiple()
                                    ->label('People')
                                    ->relationship('users', 'email')
                                    ->options(User::query()->pluck('email', 'id')),
                            ]),
                        Tabs\Tab::make('Location')
                            ->icon('heroicon-m-map-pin')
                            ->schema([
                                Forms\Components\TextInput::make('address')
                                    ->required()

                                    ->label("Organisation's Address"),
                                Forms\Components\TextInput::make('city')
                                    ->required()
                                    ->label('City'),
                                Forms\Components\TextInput::make('state')
                                    ->label('State'),
                                Forms\Components\TextInput::make('country')
                                    ->required()
                                    ->label('Country'),
                                Forms\Components\TextInput::make('zip_codeß')
                                    ->required()
                                    ->label('Postal Code'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Start Date')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('manager.email')
                    ->label('Project Manager')

                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListOrganisations::route('/'),
            'create' => Pages\CreateOrganisation::route('/create'),
            'edit' => Pages\EditOrganisation::route('/{record}/edit'),
        ];
    }
}
