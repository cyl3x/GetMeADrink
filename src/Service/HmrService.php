<?php declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class HmrService
{
    public function __construct(
        #[Autowire(param: 'kernel.environment')]
        private ?string $environment,
        #[Autowire(env: 'int:VITE_PORT')]
        private ?int $vitePort,
    ) {
    }

    public function isHmr(): bool
    {
        if ($this->environment !== 'dev') {
            return false;
        }

        if (!$this->vitePort) {
            return false;
        }

        $connection = $this->getSock();

        if (!\is_resource($connection)) {
            return false;
        }

        \fclose($connection);

        return true;
    }

    /**
     * @codeCoverageIgnore
     *
     * @return resource|false
     */
    protected function getSock()
    {
        return @\fsockopen('localhost', $this->vitePort);
    }
}
