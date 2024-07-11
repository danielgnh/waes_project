<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProjectResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProjectResource\RelationManagers;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function getNavigationLabel(): string
    {
        /** @var User $user */
        $user = auth()->user();

        if (auth()->check() && $user->hasRole('admin')) {
            return __('All Projects');
        }

        return __('My Projects');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Prject Delails')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'pending' => 'Pending',
                                'blocked' => 'Blocked',
                            ])
                            ->label('Status')->required(),
                        Grid::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->required(),
                                Forms\Components\DatePicker::make('end_date')
                                    ->label('End Date')->required(),
                                Forms\Components\SpatieMediaLibraryFileUpload::make('project_logo')
                                    ->label(__('Logotype of the Project'))
                                    ->collection('logotype')->required(),
                                Forms\Components\Select::make('project_manager')
                                    ->options(User::query()
                                        ->pluck('email', 'id'))
                                    ->label('Project Manager')->required(),
                                Select::make('users')
                                    ->columnSpanFull()
                                    ->multiple()
                                    ->label('People')
                                    ->relationship('users', 'email')
                                    ->options(User::query()->pluck('email', 'id')),
                            ]),
                    ]),
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
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('manager.email')
                    ->label('Project Manager')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
