<?php declare(strict_types=1);

namespace App\Command;

use App\Demodata\DemodataGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

#[AsCommand(name: 'demodata:generate')]
class DemodataGenerateCommand extends Command
{
    /**
     * @param iterable<DemodataGeneratorInterface> $demodataGenerators
     */
    public function __construct(
        #[Autowire(param: 'kernel.environment')]
        private readonly string $environment,
        #[AutowireIterator(tag: 'demodata.generator')]
        private readonly iterable $demodataGenerators,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->demodataGenerators as $generator) {
            $io->text(\sprintf('Generating with "%s"', $generator::class));

            $generator->generate($this->entityManager);
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generates demodata. If no shop given, generates data for all shops.');
    }

    public function isEnabled(): bool
    {
        return $this->environment === 'dev';
    }
}
