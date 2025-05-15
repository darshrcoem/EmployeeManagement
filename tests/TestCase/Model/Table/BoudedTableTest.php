<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BoudedTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BoudedTable Test Case
 */
class BoudedTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BoudedTable
     */
    public $Bouded;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Bouded',
        'app.EmpData',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Bouded') ? [] : ['className' => BoudedTable::class];
        $this->Bouded = TableRegistry::getTableLocator()->get('Bouded', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bouded);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
