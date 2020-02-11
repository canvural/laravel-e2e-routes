<?php

declare(strict_types=1);

namespace Vural\E2ERoutes\Http\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use function abort_unless;
use function class_exists;
use function config;
use function factory;
use function is_int;
use function is_string;
use function response;
use function sprintf;
use function ucfirst;

class FactoryController
{
    public function __invoke(string $factoryName, Request $request) : JsonResponse
    {
        abort_unless(class_exists($this->getModelName($factoryName)), 404, sprintf("Model '%s' not found", $factoryName));

        /** @var array<mixed> $overwriteAttributes */
        $overwriteAttributes = $request->post('attributes') ?? [];
        $times               = $this->getTimesValue($request);
        $states              = $request->post('states') ?? [];

        try {
            $models = factory($this->getModelName($factoryName), $times)->states($states)->create($overwriteAttributes);
        } catch (InvalidArgumentException $e) {
            return response()->json($e->getMessage(), 404);
        }

        return response()->json($models, 201);
    }

    private function getModelName(string $factoryName) : string
    {
        return config('e2e-routes.modelNamespace') . ucfirst($factoryName);
    }

    private function getTimesValue(Request $request) : ?int
    {
        return is_string($request->post('times')) ||
               is_int($request->post('times')) ? (int) $request->post('times') : null;
    }
}
