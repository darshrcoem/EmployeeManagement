<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

class ReportController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('EmpData');
        $this->loadModel('Bouded');
        $this->loadModel('Payslip');
        $this->loadModel('Attendence');
    }
    public function display($username = null)
    {
        if (!$username) {
            $username = $this->request->getSession()->read('Auth.admin.username');
        }
        $this->set('username', $username);
        $this->render('display');
    }

    // 📅 MONTHLY DEPARTMENT-WISE SALARY REPORT
    public function dept()
    {
        $monthList = $this->Payslip->find()
            ->select(['month'])
            ->distinct(['month'])
            ->order(['month' => 'ASC'])
            ->extract('month')
            ->toArray();
        $selectedMonth = $this->request->getQuery('selectedMonth');
        $report = [];
        if ($selectedMonth) {
            $report = $this->Payslip->find()
                ->select([
                    'department',
                    'total_base_pay' => $this->Payslip->find()->func()->sum('base_pay'),
                    'total_bonus' => $this->Payslip->find()->func()->sum('total_bonus'),
                    'total_deduction' => $this->Payslip->find()->func()->sum('total_deduction'),
                    'total_net_salary' => $this->Payslip->find()->func()->sum('net_pay')
                ])
                ->where(['month' => $selectedMonth])
                ->group(['department'])
                ->order(['department' => 'ASC'])
                ->toArray();
        }

        $this->set(compact('monthList', 'selectedMonth', 'report'));
        $this->render('dept');
    }
    public function empyear()
    {
        $yearList = $this->Payslip->find()
            ->select(['year'])
            ->distinct(['year'])
            ->order(['year' => 'ASC'])
            ->extract('year')
            ->toArray();

        $year = $this->request->getQuery('year');

        $data = [];
        if ($year) {
            $data = $this->Payslip->find()
                ->select([
                    'full_name',
                    'department',
                    'total_base_pay' => $this->Payslip->find()->func()->sum('base_pay'),
                    'total_bonus12' => $this->Payslip->find()->func()->sum('total_bonus'),
                    'total_deduction12' => $this->Payslip->find()->func()->sum('total_deduction'),
                    'total_net_salary' => $this->Payslip->find()->func()->sum('net_pay')
                ])
                ->where(['year' => $year])
                ->group(['full_name', 'department']) 
                ->order(['full_name' => 'ASC'])
                ->toArray();
        }

        $this->set(compact('yearList', 'year', 'data'));
        $this->render('empyear');
    }

    public function empmonth()
    {
        $monthList = $this->Payslip->find()
            ->select(['month'])
            ->distinct(['month'])
            ->order(['month' => 'ASC'])
            ->extract('month')
            ->toArray();

        $selectedMonth = $this->request->getQuery('selectedMonth');
        $data = [];
        if ($selectedMonth) {
            $data = $this->Payslip->find()
                ->select([
                    'full_name',
                    'year',
                    'base_pay',
                    'total_bonus',
                    'total_deduction',
                    'net_pay',
                    'department',
                ])
                ->where(['month' => $selectedMonth])
                ->order(['full_name' => 'ASC'])
                ->toArray();
        }
        $this->set(compact('monthList', 'selectedMonth', 'data'));
        $this->render('empmonth');
    }

}
