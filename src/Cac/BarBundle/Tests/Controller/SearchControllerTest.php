<?php

namespace Cac\BarBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{
    public function testAjaxsearch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'ajax-search');
    }

}
