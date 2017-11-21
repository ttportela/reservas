<?php /**
    This file is part of Sistema de Reservas.
    Copyright (C) 2017  Tarlis Tortelli Portela <tarlis@tarlis.com.br>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/?>
<?php

class BookingController extends Controller
{
	
	public $modelName = "Reserva";
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update'),
				'users'=>array('*'),
			),*/
			array('allow', // Allow nothing to authenticated user, by default
				'actions'=>array('index','view','create','update','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('admin','approve','disapprove'),
				'expression'=>'Yii::app()->helper->isAdmin()',
				//'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Booking;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Booking']))
		{
			$model->attributes=$_POST['Booking'];
            $model->users_id = Yii::app()->user->id;
            $model->dateRange();
            
            if (Yii::app()->helper->set($model->repeat_days) && Yii::app()->helper->set($model->repeat_to)) {
                $itens_salvar = $this->bookingRepetition();
                
                $sucesso_salvando_tudo = true;
                $trans = Yii::app()->db->beginTransaction();				
				try {
                    foreach ($itens_salvar as $item) {
                        $item->approved = (Yii::app()->helper->isAdmin()? true : ($model->resource->approval? false : true));
                        
                        if ($item->validate())
                            $item->save(false);
                        else {
                            Yii::app()->user->setFlash('error', 'Reserva para: '.$item->toString().', não pode ser criada');
                            $sucesso_salvando_tudo = false;
                            $trans->rollback();
                            break;
                        }
                    }
                    if ($sucesso_salvando_tudo) $trans->commit();
                } catch (Exception $e) {
                    $trans->rollback();
					Yii::app()->helper->error('salvar reservas', $e);
                    $sucesso_salvando_tudo = false;
                }
                
                if ($sucesso_salvando_tudo) {
                    // Caminho feliz
                    Yii::app()->user->setFlash('success', 'Reservas efetuadas com sucesso!');
                    $this->redirect(array("index"));
                }
            } else if($model->save()) {
                Yii::app()->user->setFlash('success', 'Reserva efetuada com sucesso: ' . $model->toString());
				$this->redirect(array('view','id'=>$model->id));
            }
		} else {
            Yii::app()->user->setFlash('warning', 'Laboratório III (D 13) pode ser usado para reservas de outros colegiados.');
        }

		$this->render('create',array(
			'model'=>$model,
		));
	}
    
    private function bookingRepetition() {
        
        $model = $this->createBooking();
        
        $itens_salvar = array();
        
        $begin = new DateTime( $model->from_date );
        $end = new DateTime( $model->repeat_to );

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ( $period as $dt ) {
            $wd = date('w',$dt->getTimestamp());
            if (in_array($wd, $model->repeat_days)) {
                $item = $this->createBookingModel(date("Y-m-d",$dt->getTimestamp()));
                array_push($itens_salvar, $item);
            }
        }
        
        return $itens_salvar;
    }
    
    private function createBooking() {
        return $this->createBookingModel($_POST['Booking']['from_date']);
    }
    
    private function createBookingModel($from) {
        $model=new Booking;
        $model->attributes=$_POST['Booking'];
        $model->from_date = $from;
        $model->users_id = Yii::app()->user->id;
        $model->dateRange();
        return $model;
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Booking']))
		{
			$model->attributes=$_POST['Booking'];
			if($model->save()) {
                Yii::app()->user->setFlash('success', 'Reserva atualizada com sucesso: ' . $model->toString());
				$this->redirect(array('view','id'=>$model->id));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
            Yii::app()->user->setFlash('success', 'Reserva excluida com sucesso');

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Operação inválida. tente não repetí-la novamente.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*$dataProvider=new CActiveDataProvider('Booking');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		
		$model=new Booking('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Booking']))
			$model->attributes=$_GET['Booking'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        $model=new Booking('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Booking']))
			$model->attributes=$_GET['Booking'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionApprove()
	{
        if (isset($_POST['selectedIds'])){
            $trans = Yii::app()->db->beginTransaction();				
            try {
                $ct = 0;
                 foreach ($_POST['selectedIds'] as $id) {
                    $item = $this->loadModel($id);
                    if (!$model->approved) {
                        $item->approved = 1;
                        $item->update(array('approved'));
                        $ct++;
                    }
                }
                $trans->commit();
                Yii::app()->user->setFlash('success', $ct. ' reservas aprovadas!');
            } catch (Exception $e) {
                $trans->rollback();
                Yii::app()->helper->error('aprovar reservas', $e);
            }
        }
        
        if (isset($_GET['id'])){
            $trans = Yii::app()->db->beginTransaction();				
            try {
                $item = $this->loadModel($_GET['id']);
                if (!$model->approved) {
                    $item->approved = 1;
                    $item->update(array('approved'));
                }
                $trans->commit();
                Yii::app()->user->setFlash('success', $item->toString(). ', reserva aprovada!');
            } catch (Exception $e) {
                $trans->rollback();
                Yii::app()->helper->error('aprovar reserva', $e);
            }
        }
        
		$model=new Booking('search');
		$model->unsetAttributes();  // clear any default values
        $model->approved = 0;
		if(isset($_GET['Booking']))
			$model->attributes=$_GET['Booking'];

		$this->render('approve',array(
			'model'=>$model,
		));        
    }

	public function actionDisapprove($id)
	{
        if (isset($id)){
            $trans = Yii::app()->db->beginTransaction();				
            try {
                $item = $this->loadModel($id);
                $item->delete();
                $trans->commit();
                Yii::app()->user->setFlash('success', $item->toString(). ', reserva apagada!');
            } catch (Exception $e) {
                $trans->rollback();
                Yii::app()->helper->error('reprovar reserva', $e);
            }
        }
        
        $this->redirect(array('approve'));
        
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Booking::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Esta página não foi encontrada.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='booking-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
