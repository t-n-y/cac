<?php 
namespace Cac\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Cac\BarBundle\Entity\Restriction;

class AddPromotionOptionCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cac:restrictions:add')
            ->setDescription('Ajoute les restrictions de base')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $restrictions = $em->getRepository('CacBarBundle:Restriction')->findAll();

        if(count($restrictions) == 0) {
            $restrictions[0] = new Restriction();
            $restrictions[1] = new Restriction();
            $restrictions[2] = new Restriction();
            
            $restrictions[0]->setRestriction('Aucune');
            $restrictions[1]->setRestriction('Venir accompagné');
            $restrictions[2]->setRestriction('Hors champagne et alcool de luxe');
            
            foreach($restrictions as $restriction) {
                $em->persist($restriction);
            }

            $em->flush();

            $output->writeln('Conditions ajoutees : ');
            $output->writeln('- Aucune');
            $output->writeln('- Venir accompagne');
            $output->writeln('- Hors champagne et alcool de luxe');
        } else {
            $output->writeln('Vous avez deja des conditions.');
        }
    }
}