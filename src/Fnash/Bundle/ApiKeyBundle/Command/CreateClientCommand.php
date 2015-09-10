<?php

namespace Fnash\ApiKeyBundle\Command;

use Fnash\ApiKeyBundle\Entity\ApiClient;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('pushinfo:api-client:create')
            ->setDescription('Create an API client')
            ->addArgument('name',  InputArgument::REQUIRED, 'The client name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $apiClient = new ApiClient();
        $apiClient->setName($name);

        $this->getContainer()->get('doctrine.orm.entity_manager')->persist($apiClient);
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();

        $output->writeln(sprintf('The API client <info>%s</info> has been generated with the following API key:', $apiClient->getName()));
        $output->writeln('<info>'.$apiClient->getApiKey().'</info>');
        $output->writeln('');
    }
}
