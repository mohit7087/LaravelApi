<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use File;

class UserController extends Controller
{
    //

  public function userRegister(Request $request) {  
      try{
        $input=$request->all();
        if(isset($input) && $input['Username']!=""  && $input['Email']!="" && $input['FirstName']!=""  && $input['LastName']!="" ){
            $id = time();
            $useData = array(
                'id'=>$id,
                'Username'=> $input['Username'],
                'Email'=> $input['Email'],
                'FirstName'=> $input['FirstName'],
                'LastName'=> $input['LastName']
              );
 
                $filetxt = public_path()."/User_Data_file.txt";
                $arr_data = array();   
                if(file_exists($filetxt)) {
                    $jsondata = file_get_contents($filetxt);
                    $arr_data = json_decode($jsondata, true);
                }
                if(!empty($arr_data)){
                    foreach($arr_data as $ke=>$val){
                        if($val['Email']==$input['Email']){
                            return json_encode(['Status'=>'true','data'=>'user already exist']);
                        }
                      }
                }
               
                $arr_data[] = $useData;
                $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);

    if(file_put_contents($filetxt, $jsondata)) 
         $result ='Data successfully saved';
        else $result ='Unable to save data in file';
        return json_encode(['Status'=>'true','data'=>$result,'user_id'=>$id]);
      } else{
          return   json_encode(['Status'=>'false','data'=>'All fields are required']);
        }
      }catch (\Exception $e) {
          
        return   json_encode(['Status'=>'false','data'=>'somthing are missing','error'=>$e]);
    }
        
    }



  public function userList(Request $request){
     $filetxt = public_path()."/User_Data_file.txt";
     $arr_data = array();   
       if(file_exists($filetxt)) {
            $jsondata = file_get_contents($filetxt);
            $arr_data = json_decode($jsondata, true);
       }else{
        return   json_encode(['Status'=>'false','data'=>'data not found']);
       }

      return   json_encode(['Status'=>'false','data'=>$arr_data]);
     }




     public function userUpdate(Request $request){
         try {
            $input=$request->all();
            if(isset($input['id']) && $input['id']!=""){
                $filetxt = public_path()."/User_Data_file.txt";
                if(file_exists($filetxt)) {
                    $jsondata = file_get_contents($filetxt);
                    $arr1 = json_decode($jsondata, true);
                    foreach($arr1 as $ke=>$val){
                       if($val['id']== $input['id']){
                           if(isset($input['Email'])){
                              $arr1[$ke]['Email']=$input['Email'];
                           }if(isset($input['Username'])){
                            $arr1[$ke]['Username']=$input['Username'];
                           }if(isset($input['FirstName'])){
                            $arr1[$ke]['FirstName']=$input['FirstName'];
                           }if(isset($input['LastName'])){
                            $arr1[$ke]['LastName']=$input['LastName'];
                           }
                        }
                    }
                    $jsondata=json_encode($arr1, true);
                    if(file_put_contents($filetxt, $jsondata)) 
                    $result ='Data update successfully';
                   else $result ='Data not update successfully';
                   return json_encode(['Status'=>'true','data'=>$result,'user_id'=>$result]);
                 }else{
                    return   json_encode(['Status'=>'false','data'=>'user data not fount']);
                 }

            }else{
                return   json_encode(['Status'=>'false','data'=>'user id is missing']);
            }
          
          } catch (\Exception $e) {
          
              return   json_encode(['Status'=>'false','data'=>'somthing are missing','error'=>$e]);
          }

     }


     public function createUser(Request $request){ 

         return  view('userForm');
      }
}
