<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Components\Component;

class Login extends BaseLogin
{
    protected string $view = 'filament.pages.auth.login';

    protected static string $layout = 'filament.layouts.auth';

    protected function getEmailFormComponent(): Component
    {
        return \Filament\Forms\Components\TextInput::make('email')
            ->label(__('اسم المستخدم أو البريد الإلكتروني'))
            ->placeholder(__('admin'))
            ->required()
            ->autocomplete('username')
            ->autofocus();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $user = \App\Models\Employee::where('email', $data['email'])
            ->orWhere('username', $data['email'])
            ->first();

        return [
            'id' => $user?->id,
            'password' => $data['password'],
        ];
    }
}
