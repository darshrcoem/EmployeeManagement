<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdminTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdminTable Test Case
 */
class AdminTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AdminTable
     */
    public $Admin;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Admin',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Admin') ? [] : ['className' => AdminTable::class];
        $this->Admin = TableRegistry::getTableLocator()->get('Admin', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Admin);

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
