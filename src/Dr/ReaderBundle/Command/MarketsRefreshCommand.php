<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 05/11/2015
 * Time: 23:47
 */

namespace Dr\ReaderBundle\Command;


use Dr\ReaderBundle\Service\RefresherService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MarketsRefreshCommand extends ContainerAwareCommand{

    protected function configure() {
        $this
            ->setName('markets:refresh')
            ->setDescription('Use this to update all active trading pairs across all markets')
            ->addOption('dryrun', null, InputOption::VALUE_NONE, 'DONT KEEP CHANGES')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        if($input->getOption('dryrun') && $input->getOption('dryrun') === true){
            $output->writeln('DRYRUN: DATA WONT BE FLUSHED');
        }

        $output->writeln('Refreshing trading data and orderbook across all active trading pairs ... ');

        /**
         * @var RefresherService
         */
        $refresherService  = $this->getContainer()->get('dr.refresher');
        $refreshData = $refresherService->refresh($input->getOption('dryrun'));
        $output->writeln(' DONE.');

        $output->writeln('Summary of new elements:');
        foreach($refreshData as $key => $data){
            $output->writeln('Market : ' .  $key );
            $output->writeln(' - Trading History: ' . count($data['tradehistory']) .' new element(s)');
            $output->writeln(' - Orderbook: ' . count($data['orderbook']) .' new element(s)');
            $output->writeln('');
        }

        return 0;
    }

}
