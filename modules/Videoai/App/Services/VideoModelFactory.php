<?php

namespace Modules\Videoai\App\Services;

use Modules\Videoai\App\Interface\VideoGeneratorInterface;

class VideoModelFactory
{
    public static function create(string $provider): VideoGeneratorInterface
    {
        switch ($provider) {
            case 'runwayml':
                if (config('videoai.runwayml.mock_enabled', true)) {
                    return new MockRunwayMl();
                }
                return new RunwayMl();
            default:
                throw new \InvalidArgumentException("Unsupported video provider: {$provider}");
        }
    }
}
