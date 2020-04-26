<?php

namespace modava\auth\controllers;

use yii\web\Controller;


/**
 * AffiliateCustomerController implements the CRUD actions for Clinic model.
 */
class AuthController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }
}
