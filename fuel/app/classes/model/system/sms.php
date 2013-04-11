<?php

    class Model_System_SMS{
        
        static function find($id){
            
            $result = DB::select('t.*',array('n.number','from_number'))
                    ->from(array('template_sms','t'))
                    ->join(array('ct_numbers', 'n'), 'LEFT')->on('n.id', '=', 't.from')
                    ->where('t.id', '=', $id)
                    ->execute();
            
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('template_sms')->execute();
            return $result->as_array();
            
        }
        
        static function add($data){
            $result = DB::insert('template_sms')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('template_sms')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('template_sms')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            $val->add('from', 'From')
                ->add_rule('required');

            $val->add('to', 'To')
                ->add_rule('required');

            $val->add('message', 'Message')
                ->add_rule('required');

            return $val;
        }
        
    }