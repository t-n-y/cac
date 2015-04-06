<?php 
namespace Cac\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Cac\BarBundle\Entity\PromotionOption;
use Cac\BarBundle\Entity\PromotionOptionCategory;

class AddPromotionOptionsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cac:promotion:data:add')
            ->setDescription('Ajoute les categories des options et les options des promotions')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $categories = $em->getRepository('CacBarBundle:PromotionOptionCategory')->findAll();
        $options = $em->getRepository('CacBarBundle:PromotionOption')->findAll();
        $text = '';

        if(count($categories) == 0) {
            // Add categories
            for($i = 0; $i < 7; $i++) {
                $categories[$i] = new PromotionOptionCategory();
            }
            
            $categories[0]->setShortcode('restriction');
            $categories[1]->setShortcode('quantity');
            $categories[2]->setShortcode('value');
            $categories[3]->setShortcode('value-hh');
            $categories[4]->setShortcode('duration');
            $categories[5]->setShortcode('beginning');
            $categories[6]->setShortcode('ending');

            $categories[0]->setName('Conditions promo/HH');
            $categories[1]->setName('Quantité de verres');
            $categories[2]->setName('Valeur');
            $categories[3]->setName('Valeur HH');
            $categories[4]->setName('Durée de validité');
            $categories[5]->setName('Heure de début HH');
            $categories[6]->setName('Heure de fin HH');
            
            foreach($categories as $category) {
                $em->persist($category);
            }

            $em->flush();

            $output->writeln("Categories ajoutees\n");
        } else {
            $output->writeln("Vous avez deja des categories d'option\n");
        }

        if(count($options) == 0) {
            // Add basic options
            for($i = 0; $i < 10; $i++) {
                $options[$i] = new PromotionOption();
                $options[$i]->setCategory($categories[floor($i/2)]);
            }

            $options[0]->setValue('aucune');
            $options[1]->setValue('venir-accompagne');
            $options[2]->setValue('n');
            $options[3]->setValue('5');
            $options[4]->setValue('20');
            $options[5]->setValue('50');
            $options[6]->setValue('40');
            $options[7]->setValue('70');
            $options[8]->setValue('7');
            $options[9]->setValue('30');

            $options[0]->setName('Aucune');
            $options[1]->setName('Venir accompagné');
            $options[2]->setName('Illimité');
            $options[3]->setName('5');
            $options[4]->setName('20%');
            $options[5]->setName('50%');
            $options[6]->setName('40%');
            $options[7]->setName('70%');
            $options[8]->setName('1 semaine');
            $options[9]->setName('1 mois');
            
            foreach($options as $option) {
                $em->persist($option);
            }

            $em->flush();

            $output->writeln("Options ajoutees\n");
        } else {
            $output->writeln("Vous avez deja des options\n");
        }
    }
}