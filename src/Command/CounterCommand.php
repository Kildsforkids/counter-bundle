<?php

namespace Kildsforkids\CounterBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class CounterCommand extends Command
{
    protected static $defaultName = 'kildsforkids:count';
    protected static $defaultDescription = 'Count numbers in all count files.';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dirs = $input->getArgument('dirs');

        $sum = 0;

        foreach ($dirs as $dir) {
            if (empty(glob($dir))) {
                $output->writeln("Directory '$dir' does not exist!");
                continue;
            }

            $output->writeln("You're ready to count in $dir");

            $finder = Finder::create()
                ->files()
                ->name('*count*')
                ->in($dir)
            ;

            $count = $finder->count();
            $output->writeln("Found $count files 'count':");

            foreach ($finder as $file) {
                $fileNameWithExtension = $file->getRelativePathname();
                $contents = $file->getContents();

                if (!empty($contents)) {
                    $number = filter_var($contents, FILTER_VALIDATE_FLOAT);
                    if ($number !== false) {
                        $sum += $number;
                        $output->writeln("- $fileNameWithExtension: $number");
                    }
                }
            }
        }

        $output->writeln("[RESULT] Sum = $sum");

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command just count sum in all count files...')
            ->addArgument('dirs', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'In which directories to count?')
        ;
    }
}