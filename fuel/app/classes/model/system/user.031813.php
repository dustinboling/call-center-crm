<?php

    class Model_System_User extends Model{
        
        static function find($id){
            $result = DB::select()->from('users')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('users')->where('active', '=', 1)->execute();
            return $result->as_array();
            
        }
        
        static function findByType($type){
            
            $result = DB::select()->from('users')->where('type', '=', $type)->where('active', '=', 1)->order_by('first_name')->execute();
            return $result->as_array();
            
        }
        
        static function findByDepartment($dept){
            
            if(!is_array($dept)){
                $dept = array($dept);
            }
            
            $result = DB::select()->from('users')->where('department', 'in', $dept)->where('active', '=', 1)->order_by('first_name')->execute();
            return $result->as_array();
            
        }
        
        static function findByEmail($email){
            
            $result = DB::select()->from('users')->where('email', '=', $email)->execute();
            return current($result->as_array());
            
        }
        
        static function add($data){
            
            $data['passwd'] = sha1($data['passwd']);
            
            $result = DB::insert('users')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            
            if(!empty($data['passwd'])){
                $data['passwd'] = sha1($data['passwd']);
            }else{
                unset($data['passwd']);
            }
            
            $result = DB::update('users')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::update('users')->set(array('active' => 0))->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('first_name', 'Name')
                ->add_rule('required');

            $val->add('last_name', 'Name')
                ->add_rule('required');

            $val->add('email', 'email')
                ->add_rule('required');

            $val->add('type', 'User Type')
                ->add_rule('required');


            return $val;
        }
        
    }