<?php 
namespace Cac\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Cac\BarBundle\Entity\Highlight;
use Cac\PaymentBundle\Entity\Payment;

class HighlightCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cac:highlightPayement')
            ->setDescription('test')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stripeApikey = $this->getContainer()->getParameter('stripe_api_key');

        $em = $this->getContainer()->get('doctrine')->getManager();
        $highlights = $em->getRepository('CacBarBundle:Highlight')->findAll();

        if (count($highlights) != 0) {
            \Stripe\Stripe::setApiKey($stripeApikey);
            foreach ($highlights as $highlight) {
                $customer = $highlight->getBar()->getAuthor();
                $payment = $em->getRepository('CacPaymentBundle:Payment')->findOneByUser($customer);
                $customerId = $payment->getCustomerId();

                \Stripe\InvoiceItem::create(array(
                    "customer" => $customerId,
                    "amount" => '$customer->getGlassPrice() * $nbPersonne',
                    "currency" => "eur",
                    "description" => "Mise en avant")
                );
            }
        }
    }
}