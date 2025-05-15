<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AttendenceTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AttendenceTable Test Case
 */
class AttendenceTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AttendenceTable
     */
    public $Attendence;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Attendence',
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
        $config = TableRegistry::getTableLocator()->exists('Attendence') ? [] : ['className' => AttendenceTable::class];
        $this->Attendence = TableRegistry::getTableLocator()->get('Attendence', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Attendence);

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
