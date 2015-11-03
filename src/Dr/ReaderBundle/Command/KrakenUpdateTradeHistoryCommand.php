<?php

/**
 * KrakenUpdateTradeHistoryCommand.php - UTF-8
 * @author Allan IRDEL 
 */
namespace Dr\ReaderBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class KrakenUpdateTradeHistoryCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('kraken:tradehistory:update')
                ->setDescription('Kraken: Use this to update the trade history of Kraken' .PHP_EOL .'Costs 2 points per active tradingpair')
                ->addArgument('pair', InputArgument::OPTIONAL, 'Select only one trading pair', null)
                ->addOption('dryrun', null, InputOption::VALUE_NONE, 'DONT KEEP CHANGES ')
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
        
        $output->write('Updating Krakens trade history for all active trading pairs ... ');
        $krakenService  = $this->getContainer()->get('dr.kraken');
        
        $count = $krakenService->updateAllTradeHistory( $input->getOption('dryrun') );
        $output->writeln(' DONE.');
        
        $output->writeln('Summary of new elements:');
        foreach($count as $key => $line){
            $output->writeln('- '. $key . ': ' .$line . ' new Trades');
        }
        
    }
}
