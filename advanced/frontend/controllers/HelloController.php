<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\User;


class HelloController extends Controller
{

	public $layout=false;
	public $enableCsrfValidation=false;


	public function actionIndex()
    {
        $list=User::find()->asArray()->all();
        // var_dump($list);
        
        return $this->render('index',array('list'=>$list));
    	
    }
    public function actionUpload()
    {
        // echo json_encode($_FILES['f']);
        $filePath="files/".$_FILES['f']['name'];
        // move_uploaded_file($_FILES['f']['tmp_name'], $filePath);
        echo json_encode($filePath);
        
    }
    public function actionUpfiles()
    {
        // echo json_encode($_FILES['f']);
        $filePath="files/".$_FILES['files']['name'];
        move_uploaded_file($_FILES['files']['tmp_name'], $filePath);
        echo json_encode($filePath);
        
    }
      public function actionInvisible()
    {
        $name=$_POST['name'];
        $res=\Yii::$app->db->createCommand('update user set type=1 where username="'.$name.'"')->execute();
        if($res){

            echo "1";

        }

    }
    public function actionGettype(){

        $name=$_GET['name'];
        $res=\Yii::$app->db->createCommand('select * from user where username="'.$name.'"')->queryOne();
        echo $res['type'];

    }
    public function actionLishi()
    {
    	

    	$rows = (new \yii\db\Query())
        ->select(['*'])
        ->from('lishi')
        ->all();
        // var_dump($rows);
        $data['arr']=$rows;

         return $this->render('lishi',$data);
    }
    public function actionZk(){
             return $this->render('zk');

      
    }
    public function actionUser(){

        
        $name=\Yii::$app->user->identity->username;
        $res=\Yii::$app->db->createCommand('select * from us where username="'.$name.'"')->queryOne();
        // if($res!=0){

        // }
        $rows = (new \yii\db\Query())
                    ->select(['*'])
                    ->from('us')
                    ->where(['`parentid`' => $res['username']])
                    ->all();


        // var_dump($row);
        return $this->render('user',array('data'=>$rows)); 
    }
    //周考
    public function actionZoukao(){

       return $this->render('zoukao');


    }
    public function actionDomsg(){

        $content=$_POST['content'];
        $time=date('Y-m-d H:i:s');
        $img=$_COOKIE['img'];
        $name=$_COOKIE['name'];
        $data=array('content'=>$content,'time'=>$time,'img'=>$img,'name'=>$name);
        echo json_encode($data);
    }

}