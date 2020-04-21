<?php

namespace modava\temp\controllers;

use yii\web\Controller;


/**
 * AffiliateCustomerController implements the CRUD actions for Clinic model.
 */
class TempController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }
}
