<?php

declare(strict_types=1);

namespace Vural\E2ERoutes\Http\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use function response;

class ResetController
{
    public function __invoke(Request $request) : JsonResponse
    {
        $options = [];

        if ($request->has('seed')) {
            $options['--seed'] = true;
        }

        $exitCode = Artisan::call('migrate:refresh', $options);

        return response()->json('', $exitCode === 0 ? 200 : 500);
    }
}
