<?php

/**
 * KrakenUpdateTradingPairsCommand.php - UTF-8
 * @author Allan IRDEL
 */

namespace Dr\ReaderBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class KrakenUpdateTradingPairsCommand extends ContainerAwareCommand{
    public function configure() {
        $this
                ->setName('kraken:tradingpairs:update')
                ->setDescription('Updates Trading pairs for Kraken' . PHP_EOL . 'Costs 1 point per call')
                ->addOption('dryrun', null, InputOption::VALUE_NONE, 'DONT KEEP NEW DATA')
        ;
    }
    
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        if($input->getOption('dryrun') && $input->getOption('dryrun') === true){
            $output->writeln('DRYRUN: DATA WONT BE FLUSHED');
        }
        
        $output->write('Updating Krakens trading pairs ... ');
        $krakenService  = $this->getContainer()->get('dr.kraken');
        $pairs = $krakenService->updateTradingPairs( $input->getOption('dryrun') );
        $output->writeln('DONE'.PHP_EOL);
        
        $output->writeln('New trading pairs:');
        foreach($pairs as $pair){
            $output->writeln(' - ' . $pair->getName());
        }
        

    }
}
