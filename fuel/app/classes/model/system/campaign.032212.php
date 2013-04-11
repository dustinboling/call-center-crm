<?php   

    class Model_System_Campaign extends Model{
        
        static function find($id){
            $result = DB::select()->from('campaigns')->where('id', '=', $id)->execute();
            return current($result->as_array());
        }
        
        static function findAll(){
            
            $result = DB::select()->from('campaigns')->execute();
            return $result->as_array();
            
        }
        
        static function findByName($name){
            $result = DB::select()->from('campaigns')->where('name', '=', $name)->execute();
            if(count($result)){
                return current($result->as_array());
            }else{
                return array();
            }
        }
        
        static function add($data){
            $result = DB::insert('campaigns')->set($data)->execute();
            return current($result);
        }
        
        static function update($id, $data){
            $result = DB::update('campaigns')->set($data)->where('id', '=', $id)->execute();
        }
        
        static function delete($id){
            $result = DB::delete('campaignss')->where('id','=',$id)->execute();
        }
        
        static function validate($factory){
            
            $val = \Validation::factory($factory);

            $val->add('name', 'Name')
                ->add_rule('required');

            return $val;
        }
        
    }