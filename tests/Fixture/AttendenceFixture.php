<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AttendenceFixture
 */
class AttendenceFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'attendence';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'at_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'emp_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'at_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'status' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'remark' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['at_id'], 'length' => []],
            'emp_id' => ['type' => 'unique', 'columns' => ['emp_id', 'at_date'], 'length' => []],
            'attendence_ibfk_1' => ['type' => 'foreign', 'columns' => ['emp_id'], 'references' => ['emp_data', 'emp_id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'at_id' => 1,
                'emp_id' => 1,
                'at_date' => '2025-05-10',
                'status' => 'Lorem ipsum dolor sit amet',
                'remark' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
