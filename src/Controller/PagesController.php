<?php
namespace App\Controller;
use App\Controller\AppController;
class PagesController extends AppController
{
    public function display()
    {
        $this->render('add');
    }
}
?>