<?php

/**
 * ProtoCommand.php - UTF-8
 * @author Allan IRDEL
 */

namespace Dr\ReaderBundle\Command;

use Dr\MarketBundle\Entity\TradingPair;
use Dr\ReaderBundle\Service\BaseHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ProtoCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('proto:run')
                ->setDescription('TEST COMMAND')
                ->addOption('dryrun', null, InputOption::VALUE_NONE, 'DONT KEEP CHANGES || DONT SEND ANYTHING')
        ;
    }
    
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output) {

        /**
         * @var BaseHelper
         */
        $base = $this->getContainer()->get('dr.helper');

        if($base instanceof BaseHelper){
            $pair = $base->getTradingPairRepository()->find(23);

            if($pair instanceof TradingPair){
                $output->write('isStale: ');
                if( $pair->isStale() ){
                    $output->writeln('true');
                }else{
                    $output->writeln('false');

                }

                $output->writeln('delay ' . $pair->getLastRefreshInterval()->s . ' toto' );
            }

        }

    }
}
