<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Saade\FilamentAutograph\Forms\Components\Enums\DownloadableFormat;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationLabel(): string
    {
        /** @var User $user */
        $user = auth()->user();

        if (auth()->check() && $user->hasRole('admin')) {
            return __('All Users');
        }

        return __('My Profile');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profile Image')
                    ->schema([
                        Forms\Components\FileUpload::make('profile_image')
                            ->image()
                            ->label(__('Profile Image'))
                            ->imageCropAspectRatio('1:1')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                            ]),
                    ]),
                Tabs::make('Tabs')
                    ->columns(2)
                    ->tabs([
                        Tabs\Tab::make('Details')
                            ->icon('heroicon-m-user')
                            ->schema([

                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('Name'),
                                Forms\Components\TextInput::make('first_name')
                                    ->required()
                                    ->label('First Name'),
                                Forms\Components\TextInput::make('last_name')
                                    ->required()
                                    ->label('Last Name'),
                                Forms\Components\TextInput::make('email')
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('name', explode('@', $state)[0]))
                                    ->required()
                                    ->label('Email'),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->label('Phone'),
                                Forms\Components\TextInput::make('salutation')
                                    ->label('Salutation'),
                                DatePicker::make('birthday')
                                    ->label('Birthday'),
                                SignaturePad::make('signature')
                                    ->label(__('Your signature'))
                                    ->dotSize(2.0)
                                    ->lineMinWidth(0.5)
                                    ->lineMaxWidth(2.5)
                                    ->throttle(16)
                                    ->minDistance(5)
                                    ->velocityFilterWeight(0.7)
                                    ->filename('autograph')
                                    ->downloadable()
                                    ->downloadableFormats([
                                        DownloadableFormat::PNG,
                                        DownloadableFormat::SVG,
                                    ])
                                    ->downloadActionDropdownPlacement('center-end'),
                            ]),
                        Tabs\Tab::make('Settings')
                            ->icon('heroicon-m-wrench-screwdriver')
                            ->schema([

                                Forms\Components\Toggle::make('is_system_user')
                                    ->default(false)
                                    ->label('System User'),
                                Forms\Components\Toggle::make('is_customer')
                                    ->default(true)
                                    ->label('Customer'),
                                Forms\Components\Select::make('roles')
                                    ->label(__('Roles'))
                                    ->relationship('roles', 'name')
                                    ->multiple(),

                            ]),
                        Tabs\Tab::make('Privacy & Security')
                            ->icon('heroicon-m-lock-closed')
                            ->schema([
                                TextInput::make('password')
                                    ->password()
                                    ->label('Password')
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->revealable(),
                                // password field and password confirmation field
                            ]),
                        Tabs\Tab::make('Organisation')
                            ->icon('heroicon-m-building-office-2')
                            ->schema([
                                Forms\Components\TextInput::make('job_title')
                                    ->label('Job Title'),
                                // password field and password confirmation field
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ImageColumn::make('profile_image')
                //     ->label('Profile Image')
                //     ->circular()
                //     ->size(40)
                //     ->defaultImageUrl(url('/images/avatars/placeholder.png')),
                // Tables\Columns\TextColumn::make('salutation')
                //     ->label('Salutation')
                //     ->searchable()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->weight(FontWeight::Bold)
                    ->label('Last Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->icon('heroicon-m-phone'),
                TextColumn::make('email')
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('birthday')
                    ->label('Birthday')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->color('lightgray'),
                Tables\Columns\TextColumn::make('job_title')
                    ->label('Job Title')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\Text::make('company_id')
                //     ->label('Company')
                //     ->searchable()
                //     ->sortable(),
                // Tables\Columns\Text::make('region_id')
                //     ->label('Region')
                //     ->searchable()
                //     ->sortable()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
