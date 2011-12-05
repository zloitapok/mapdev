<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
                $data = $this->getNodes();
                // renders the view file 'protected/views/site/index.php'
                // using the default layout 'protected/views/layouts/main.php'
                $this->render('index', $data);
	}
        
        public function actionSearchAjax()
        {
                $search_request = Yii::app()->request->getParam('search_request', '');
                $data = $this->getNodes($search_request);
                $this->renderPartial('_ajaxContent', array('data'=>$data), false, true);
        }
        
        private function getNodes($search_request = '')
        {
                $model = new Nodes;
                $nodes = $model->ajaxFullTextSearch($search_request);

                $categories = array();
                $points = array();
                foreach($nodes as $n)
                {
                        $model = new Categories;
                        $oCategories = $model->getNodeCategories($n);
                        foreach($oCategories as $oCategory)
                        {
                                if (isset($categories[$oCategory->id]['nodes']))
                                {
                                        $cNodes = $categories[$oCategory->id]['nodes'];
                                }
                                else
                                {
                                        $cNodes = array();
                                }
                                
                                $cNodes[$n->id] = $n->title;
                                
                                $categories[$oCategory->id] = array(
                                        'name' => $oCategory->name,
                                        'icon' => $oCategory->icon,
                                        'nodes' => $cNodes,
                                );
                        }
                        $points[] = array(
                                'lat' => $n->lat,
                                'lng' => $n->lng,
                                'id' => $n->id,
                                'title' => $n->title,
                                'address' => $n->address,
                        ); 
                }
                
                return array(
                        'points' => $points,
                        'categories' => $categories,
                );
        }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
        
        /**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}