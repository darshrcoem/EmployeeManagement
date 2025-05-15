<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayslipTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayslipTable Test Case
 */
class PayslipTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayslipTable
     */
    public $Payslip;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Payslip',
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
        $config = TableRegistry::getTableLocator()->exists('Payslip') ? [] : ['className' => PayslipTable::class];
        $this->Payslip = TableRegistry::getTableLocator()->get('Payslip', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Payslip);

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
