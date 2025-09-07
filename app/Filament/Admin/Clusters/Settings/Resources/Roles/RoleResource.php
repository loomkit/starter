<?php

namespace App\Filament\Admin\Clusters\Settings\Resources\Roles;

use App\Filament\Admin\Clusters\Settings\Resources\Roles\Pages\CreateRole;
use App\Filament\Admin\Clusters\Settings\Resources\Roles\Pages\EditRole;
use App\Filament\Admin\Clusters\Settings\Resources\Roles\Pages\ListRoles;
use App\Filament\Admin\Clusters\Settings\Resources\Roles\Schemas\RoleForm;
use App\Filament\Admin\Clusters\Settings\Resources\Roles\Tables\RolesTable;
use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\Role;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $cluster = SettingsCluster::class;

    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
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
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
