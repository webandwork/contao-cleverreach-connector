<?php
/**
 * bundle.cleverreach-connect for Contao Open Source CMS
 *
 * Copyright (C) 2020 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Webandwork\ContaoCleverreachConnectorBundle\Command;


use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\PageModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webandwork\ContaoCleverreachConnectorBundle\Service\GroupManager;

class ImportGroups extends Command
{
    /**
     * @var ContaoFramework
     */
    private $framework;
    /**
     * @var GroupManager
     */
    private $groupManager;

    public function __construct(ContaoFramework $framework, GroupManager $groupManager)
    {
        $this->framework = $framework;
        $this->groupManager = $groupManager;

        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        /** @var int $rootPageId */
        $rootPageId = $input->getArgument('rootPageId');

        /** @var PageModel $pageModel */
        $pageModel = PageModel::findById($rootPageId);

        if(null === $pageModel)
        {
            $io->error('Cant find given RootPageId, abort');
            return;
        }

        if('root' !== $pageModel->type)
        {
            $io->error('Given Page is not Root-Type, abort');
            return;
        }

        if('' === $pageModel->cleverreachConnectToken)
        {
            $io->error('No CleverreacgToken isset, abort');
            return;
        }

        $this->groupManager->setToken($pageModel->cleverreachConnectToken);
        $this->groupManager->importAll();
        $this->groupManager->importAllRecipients();

        $io->success('Finished Job Groups Import!');
    }

    public function configure()
    {
        $this
            ->setName('webandwork:import-groups')
            ->addArgument('rootPageId', InputArgument::REQUIRED, 'Fill in valide RootPageId')
            ->setDescription('Runs import groups job.');
    }
}
