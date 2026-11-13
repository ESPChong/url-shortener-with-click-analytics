<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateApiToken extends Command
{
    protected $signature = 'api-token:create
                            {email : The e-mail address of the token owner}
                            {--name=api : The token name}';

    protected $description = 'Create a Sanctum personal access token for the given user';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if ($user === null) {
            $this->error('No user found with that e-mail address.');

            return self::FAILURE;
        }

        $token = $user->createToken((string) $this->option('name'));

        $this->info('Personal access token created. Copy it now, it will not be shown again:');
        $this->newLine();
        $this->line($token->plainTextToken);

        return self::SUCCESS;
    }
}
