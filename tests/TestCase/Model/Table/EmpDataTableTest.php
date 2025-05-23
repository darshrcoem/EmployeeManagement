<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmpDataTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmpDataTable Test Case
 */
class EmpDataTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmpDataTable
     */
    public $EmpData;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::getTableLocator()->exists('EmpData') ? [] : ['className' => EmpDataTable::class];
        $this->EmpData = TableRegistry::getTableLocator()->get('EmpData', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmpData);

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
