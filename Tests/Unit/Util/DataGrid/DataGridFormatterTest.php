<?php

namespace Lexik\Bundle\TranslationBundle\Tests\Unit\Util\DataGrid;

use Lexik\Bundle\TranslationBundle\Util\DataGrid\DataGridFormatter;
use Lexik\Bundle\TranslationBundle\Tests\Unit\BaseUnitTestCase;

/**
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class DataGridFormatterTest extends BaseUnitTestCase
{
    /**
     * @group util
     */
    public function testCreateListResponse()
    {
        $datas = array(
            array('id' => 2, 'key' => 'key.say_goodbye', 'domain' => 'messages', 'translations' => array(
                array('locale' => 'fr', 'content' => 'au revoir'),
                array('locale' => 'en', 'content' => 'good bye'),
            )),
            array('id' => 1, 'key' => 'key.say_hello', 'domain' => 'superTranslations', 'translations' => array(
                array('locale' => 'fr', 'content' => 'salut'),
                array('locale' => 'de', 'content' => 'heil'),
            )),
            array('id' => 3, 'key' => 'key.say_wtf', 'domain' => 'messages', 'translations' => array(
                array('locale' => 'fr', 'content' => 'c\'est quoi ce bordel !?!'),
                array('locale' => 'xx', 'content' => 'xxx xxx xxx'),
            )),
        );
        $total = 3;

        $expected = array(
            'translations' => array(
                array(
                    'id' => 2,
                    'domain' => 'messages',
                    'key' => 'key.say_goodbye',
                    'de' => '',
                    'en' => 'good bye',
                    'fr' => 'au revoir',
                ),
                array(
                    'id' => 1,
                    'domain' => 'superTranslations',
                    'key' => 'key.say_hello',
                    'de' => 'heil',
                    'en' => '',
                    'fr' => 'salut',
                ),
                array(
                    'id' => 3,
                    'domain' => 'messages',
                    'key' => 'key.say_wtf',
                    'de' => '',
                    'en' => '',
                    'fr' => 'c\'est quoi ce bordel !?!'
                ),
            ),
            'total' => 3,
        );

        $formatter = new DataGridFormatter(array('de', 'en', 'fr'));
        $this->assertEquals(json_encode($expected, JSON_HEX_APOS), $formatter->createListResponse($datas, $total)->getContent());
    }
}
