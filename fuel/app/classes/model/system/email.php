<?php

    class Model_System_Email{
        
        static function find($id){
            $result = DB::select()->from('template_emails')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('template_emails')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $result = DB::insert('template_emails')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('template_emails')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('template_emails')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            $val->add('from', 'From')
                ->add_rule('required');

            $val->add('to', 'To')
                ->add_rule('required');

            $val->add('subject', 'Subject')
                ->add_rule('required');

            $val->add('message', 'Message')
                ->add_rule('required');

            return $val;
        }
        
    }